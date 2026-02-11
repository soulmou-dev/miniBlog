<?php

namespace App\Identity\Infrastructure\Persistence\Eloquent;

use App\Shared\Infrastructure\Persistence\Eloquent\Trait\TimestampableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ArticleModel extends Model
{
    use TimestampableTrait;

      /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $cats = [
        'user_id' => 'string'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
    ];

    /**
     *  Relation: un article apartien à un utilisateur
     * @return mixed
     */
    public function user(): mixed
    {
        return $this->belongsToUser(UserModel::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // on merge avec les cats déclarés dansle Trait TimestampableTrait
        return array_merge( $this->getTimestampCasts(), $this->casts);
    }
}

