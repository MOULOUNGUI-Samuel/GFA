<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reponse extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'evaluation_id',
        'question_id',
        'valeur_reponse',
    ];

    /**
     * L'évaluation à laquelle cette réponse appartient.
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    /**
     * La question à laquelle cette réponse est associée.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}