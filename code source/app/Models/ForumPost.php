<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ForumResponse;
use App\Models\User;
use App\Models\Theme;

class ForumPost extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<string>
     */
    protected $fillable=[
        'title',
        'content',
        'user_id',
        'theme_id'
    ];


    /**
     * Obtient les réponses de forum associées à ce message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public Function forum_responses(){
        return $this->hasMany(ForumResponse::class);
    }


    /**
     * Obtient l'utilisateur qui a publié ce message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Obtient le thème auquel ce message est associé.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme(){
        return $this->belongsTo(Theme::class);
    }
}
