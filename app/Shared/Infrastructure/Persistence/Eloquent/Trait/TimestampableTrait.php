<?php

namespace App\Shared\Infrastructure\Persistence\Eloquent\Trait;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

trait TimestampableTrait
{
    use SoftDeletes;

    /**
     * Colonnes utilisées par Eloquent
     */
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    /**
     * On caste les dates (Carbon immutable)
     */
    protected $casts = [
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
        'deleted_at' => 'immutable_datetime',
    ];

    /**
     * Initialisation les timestamps lors de la création d'une entité
     */
    protected static function bootTimestampableTrait(): void
    {
        static::creating(function ($model) {
            $now = Carbon::now();

            $model->created_at = $model->created_at ?? $now;
            $model->updated_at = $now;
        });

        static::updating(function ($model) {
            $model->updated_at = Carbon::now();
        });
    }


    /**
     * une methode pour vérifier si l'entité est supprimé (soft Delete)
     */
    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }
}
