<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nom',
        'prefixe_ticket',
        'temps_moyen_estime',
        'est_actif',
        'ordre_affichage',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];
    
    /**
     * La branche qui propose ce service.
     */
    public function branche(): BelongsTo
    {
        return $this->belongsTo(Branche::class);
    }
    
    /**
     * Les tickets générés pour ce service.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}