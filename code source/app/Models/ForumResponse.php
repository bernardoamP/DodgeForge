<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ForumPost;

class ForumResponse extends Model
{
    use HasFactory;


    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'content',
        'forum_post_id',
        'user_id'
    ];


    /**
     * Obtient le message du forum auquel cette réponse est associée.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forum_post(){
        return $this->belongsTo(ForumPost::class);
    }


    /**
     * Obtient l'utilisateur qui a créé cette réponse.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
