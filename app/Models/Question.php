<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'structure_id',
        'texte_question',
        'type_question',
        'est_active',
        'ordre_affichage',
    ];

    protected $casts = [
        'est_active' => 'boolean',
    ];

    /**
     * La structure qui a défini cette question.
     */
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Structure::class);
    }
}