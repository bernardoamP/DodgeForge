<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\RessourcePost;

class Theme extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'label',
        'category_id'
    ];


    /**
     * Obtient la catégorie à laquelle ce thème appartient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtient les messages du forum associés à ce thème.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forum_post(){
        return $this->hasMany(ForumPost::class);
    }

    /**
     * Obtient les messages de ressource associés à ce thème.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ressource_post(){
        return $this->hasMany(RessourcePost::class);
    }

}


