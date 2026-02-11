<?php

namespace App\Identity\Infrastructure\Persistence\Eloquent;

use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use App\Shared\Infrastructure\Persistence\Eloquent\Trait\TimestampableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

final class UserModel extends Authenticatable
{
    use TimestampableTrait;

      /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(){
        return $this->role === 'ROLE_ADMIN';
    }

    public function isDeleted(){
        return $this->deleted_at !== null;
    }
    
    public function status(){
        return $this->deleted_at ? 'supprimé' : 'actif' ;
    }

    public function articles(): HasMany
    {
        return $this->hasMany(ArticleModel::class, 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // on merge avec les cats déclarés dansle Trait TimestampableTrait
        return array_merge( $this->getTimestampCasts(),[ 'password' => 'hashed']);
    }
}

