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
            'images' => ['required','array','min:1'],
            'images.*' => ['file','image','max:5120'],
            'is_primary' => ['sometimes','boolean'],
        ]);

        [$modelClass, $ownerIdField] = $data['imageable_type'] === 'product'
            ? [Product::class, 'user_id']
            : [Equipment::class, 'user_id'];
        $model = $modelClass::findOrFail($data['imageable_id']);

        abort_unless($model->{$ownerIdField} === Auth::id(), 403);

        foreach ($request->file('images', []) as $uploaded) {
            $path = $uploaded->store('uploads', 'public');
            $model->images()->create([
                'path' => $path,
                'is_primary' => false,
                'sort_order' => (int)(($model->images()->max('sort_order') ?? 0) + 1),
            ]);
        }

        // Optionally set primary to the first uploaded
        if ($request->boolean('is_primary')) {
            $firstImage = $model->images()->latest('id')->first();
            if ($firstImage) {
                $model->images()->update(['is_primary' => false]);
                $firstImage->update(['is_primary' => true]);
            }
        }

        return back()->with('status', 'Images chargées');
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

		Storage::disk('public')->delete($image->path);
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
