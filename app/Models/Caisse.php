<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caisse extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nom',
        'numero_poste',
        'statut',
    ];

    /**
     * La branche à laquelle cette caisse appartient.
     */
    public function branche(): BelongsTo
    {
        return $this->belongsTo(Branche::class);
    }
    
    /**
     * Les tickets traités par cette caisse.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}