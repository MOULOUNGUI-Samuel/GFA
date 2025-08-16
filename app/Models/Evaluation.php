<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ticket_id',
        'note_globale',
        'commentaire_general',
        'ip_address_client',
    ];
    
    /**
     * Le ticket qui est évalué.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
    
    /**
     * Les réponses détaillées de cette évaluation.
     */
    public function reponses(): HasMany
    {
        return $this->hasMany(Reponse::class);
    }
}