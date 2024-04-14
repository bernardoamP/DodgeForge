<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Ressources;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'email',
        'password',
        'formation_id',
        'role_id'
    ];

    /**
     * Les attributs à cacher lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à caster.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Obtient la formation à laquelle cet utilisateur appartient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * Obtient la formation à laquelle cet utilisateur appartient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formation(){
        return $this->belongsTo(Formation::class);
    }

    /**
     * Obtient les ForumPost par cet utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forum_posts(){
        return $this->hasMany(ForumPost::class);
    }

    /**
     * Obtient les ressourcePost par cet utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ressources(){
        return $this->hasMany(RessourcePost::class);
    }

    /**
     * Détermine si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->label === 'administrateur';
    }

    /**
     * Détermine si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    public function isJohnDoe(){
        return $this->email === 'john@doe.com';
    }

    /**
     * renvoie l'utilisateur john Doe
     * utiliser pour mettre un user par default pour un element
     * @return User|null
     */
    public function getJohn(){
        $existingJohn = User::where('email', 'john@doe.com')->first();
        if(!$existingJohn){
            return null;
        }else{
            return $existingJohn;
        }
    }
}

