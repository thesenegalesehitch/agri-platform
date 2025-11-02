<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Equipment;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
	public function store(Request $request)
	{
        $data = $request->validate([
            'imageable_type' => ['required','in:product,equipment'],
            'imageable_id' => ['required','integer'],
            'images' => ['sometimes','array','max:10'], // Fichiers uploadés
            'images.*' => ['file','image','max:5120'],
            'image_urls' => ['sometimes','array','max:10'], // URLs
            'image_urls.*' => ['url','max:500'],
            'is_primary' => ['sometimes','boolean'],
            'primary_image_index' => ['sometimes','integer','min:0'],
        ]);

        [$modelClass, $ownerIdField] = $data['imageable_type'] === 'product'
            ? [Product::class, 'user_id']
            : [Equipment::class, 'user_id'];
        $model = $modelClass::findOrFail($data['imageable_id']);

        abort_unless($model->{$ownerIdField} === Auth::id(), 403);

        // Vérifier la limite de 10 images au total
        $currentImageCount = $model->images()->count();
        $newImageCount = count($request->file('images', [])) + count($request->input('image_urls', []));
        
        if ($currentImageCount + $newImageCount > 10) {
            return back()->withErrors([
                'images' => 'Vous ne pouvez pas avoir plus de 10 images. Actuellement: ' . $currentImageCount . ', nouvelles: ' . $newImageCount . '. Maximum autorisé: 10.'
            ]);
        }

        $addedImages = [];

        // Traiter les fichiers uploadés
        foreach ($request->file('images', []) as $uploaded) {
            $path = $uploaded->store('uploads', 'public');
            $image = $model->images()->create([
                'path' => $path,
                'source_type' => 'local',
                'is_primary' => false,
                'sort_order' => (int)(($model->images()->max('sort_order') ?? 0) + 1),
            ]);
            $addedImages[] = $image;
        }

        // Traiter les URLs
        foreach ($request->input('image_urls', []) as $url) {
            if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                // Vérifier que c'est une URL d'image valide (avec timeout pour éviter les blocages)
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 5, // 5 secondes max
                        'method' => 'HEAD',
                    ],
                ]);
                
                $headers = @get_headers($url, 1, $context);
                if ($headers && (strpos($headers[0], '200') !== false || strpos($headers[0], '301') !== false || strpos($headers[0], '302') !== false)) {
                    $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : ($headers['Content-Type'] ?? '');
                    if (strpos(strtolower($contentType), 'image') !== false || 
                        preg_match('/\.(jpg|jpeg|png|gif|webp|svg)(\?|$)/i', $url)) {
                        $image = $model->images()->create([
                            'path' => $url,
                            'source_type' => 'url',
                            'is_primary' => false,
                            'sort_order' => (int)(($model->images()->max('sort_order') ?? 0) + 1),
                        ]);
                        $addedImages[] = $image;
                    } else {
                        return back()->withErrors(['image_urls' => 'L\'URL "' . $url . '" ne pointe pas vers une image valide. Type détecté: ' . $contentType]);
                    }
                } else {
                    // Si la vérification échoue, on accepte quand même si l'URL ressemble à une image
                    if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg)(\?|$)/i', $url)) {
                        $image = $model->images()->create([
                            'path' => $url,
                            'source_type' => 'url',
                            'is_primary' => false,
                            'sort_order' => (int)(($model->images()->max('sort_order') ?? 0) + 1),
                        ]);
                        $addedImages[] = $image;
                    } else {
                        return back()->withErrors(['image_urls' => 'L\'URL "' . $url . '" n\'est pas accessible ou ne semble pas être une image.']);
                    }
                }
            }
        }

        // Définir l'image principale si spécifiée
        if ($request->filled('primary_image_index') && count($addedImages) > 0) {
            $primaryIndex = (int)$request->input('primary_image_index');
            if ($primaryIndex >= 0 && $primaryIndex < count($addedImages)) {
                $model->images()->update(['is_primary' => false]);
                $addedImages[$primaryIndex]->update(['is_primary' => true]);
            }
        } elseif ($request->boolean('is_primary') && count($addedImages) > 0) {
            // Par défaut, la première image ajoutée devient principale
            $model->images()->update(['is_primary' => false]);
            $addedImages[0]->update(['is_primary' => true]);
        }

        $message = count($addedImages) > 0 
            ? count($addedImages) . ' image(s) ajoutée(s) avec succès'
            : 'Aucune image ajoutée';

        return back()->with('status', $message);
	}

	public function destroy(Image $image)
	{
		$imageable = $image->imageable;
		if (!$imageable) {
			$image->delete();
			return back()->with('status', 'Image supprimée');
		}
		$ownerId = $imageable->user_id ?? null;
		abort_unless($ownerId === Auth::id(), 403);

		// Supprimer du storage uniquement si c'est une image locale
		if ($image->source_type === 'local' || ($image->source_type === null && !filter_var($image->path, FILTER_VALIDATE_URL))) {
			Storage::disk('public')->delete($image->path);
		}
		
		$image->delete();
		return back()->with('status', 'Image supprimée');
	}

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'imageable_type' => ['required','in:product,equipment'],
            'imageable_id' => ['required','integer'],
            'orders' => ['required','array'], // image_id => sort_order
            'primary_id' => ['nullable','integer'],
        ]);

        [$modelClass, $ownerIdField] = $data['imageable_type'] === 'product'
            ? [Product::class, 'user_id']
            : [Equipment::class, 'user_id'];
        $model = $modelClass::with('images')->findOrFail($data['imageable_id']);
        abort_unless($model->{$ownerIdField} === Auth::id(), 403);

        foreach ($data['orders'] as $imageId => $order) {
            $img = $model->images->firstWhere('id', (int)$imageId);
            if ($img) {
                $img->update(['sort_order' => (int)$order]);
            }
        }

        if (!empty($data['primary_id'])) {
            $model->images()->update(['is_primary' => false]);
            $model->images()->where('id', (int)$data['primary_id'])->update(['is_primary' => true]);
        }

        return back()->with('status', 'Ordre mis à jour');
    }
}
