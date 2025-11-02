<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
	use HasFactory;

	protected $fillable = ['path','is_primary','sort_order','source_type'];
	
	protected $casts = [
		'is_primary' => 'boolean',
	];

	public function imageable()
	{
		return $this->morphTo();
	}

	/**
	 * Retourne l'URL de l'image (locale via Storage ou URL externe)
	 */
	public function getUrlAttribute(): string
	{
		// Si c'est une URL externe
		if ($this->source_type === 'url' || filter_var($this->path, FILTER_VALIDATE_URL)) {
			return $this->path;
		}
		
		// Pour les images locales, vérifier que le fichier existe
		if ($this->path) {
			$fullPath = storage_path('app/public/' . $this->path);
			if (!file_exists($fullPath)) {
				// Retourner une image placeholder si le fichier n'existe pas
				// Utiliser un SVG inline pour éviter les erreurs 404
				return 'data:image/svg+xml;base64,' . base64_encode(
					'<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">' .
					'<rect width="400" height="300" fill="#f0f0f0"/>' .
					'<text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="#999" font-family="Arial, sans-serif" font-size="16">Image non disponible</text>' .
					'</svg>'
				);
			}
		}
		
		return Storage::url($this->path);
	}
	
	/**
	 * Vérifie si l'image existe physiquement
	 */
	public function exists(): bool
	{
		if ($this->source_type === 'url' || filter_var($this->path, FILTER_VALIDATE_URL)) {
			// Pour les URLs, on ne vérifie pas (peut être lent)
			return true;
		}
		
		return file_exists(storage_path('app/public/' . $this->path));
	}
}
