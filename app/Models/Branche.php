<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branche extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'structure_id',
        'nom',
        'code_branche',
        'description',
        'adresse',
        'horaires_ouverture',
        'est_ouverte',
    ];

    protected $casts = [
        'horaires_ouverture' => 'array', // Cast le JSON en tableau PHP
        'est_ouverte' => 'boolean',
    ];

    /**
     * La structure parente de cette branche.
     */
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Structure::class);
    }

    /**
     * Les caisses de cette branche.
     */
    public function caisses(): HasMany
    {
        return $this->hasMany(Caisse::class);
    }

    /**
     * Les services offerts par cette branche.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}