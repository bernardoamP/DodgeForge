<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theme;

class Category extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'label'
    ];

    /**
     * Obtient les thèmes associés à cette catégorie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function themes(){
        return $this->hasMany(Theme::class);
    }
}


