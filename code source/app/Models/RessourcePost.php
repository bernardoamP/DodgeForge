<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RessourcePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'theme_id',
        'file_path',
    ];

    public function getDownloadLinkAttribute()
    {
        /* // Encoder le nom du fichier avant de générer l'URL
        $encodedFileName = urlencode(str_replace(' ', '_', $this->attributes['file_path']));

        // Utiliser asset() pour générer le lien
        return asset('storage/' . $encodedFileName); */
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
