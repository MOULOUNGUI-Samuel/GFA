<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'service_id',
        'numero_ticket',
        'position_attente',
        'statut',
        'cle_secrete',
        'agent_id',
        'caisse_id',
    ];

    protected $casts = [
        'date_appel' => 'datetime',
        'date_debut_service' => 'datetime',
        'date_fin_service' => 'datetime',
    ];

    /**
     * Le service demandé par le ticket.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    
    /**
     * L'agent qui a traité le ticket.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * La caisse où le ticket a été traité.
     */
    public function caisse(): BelongsTo
    {
        return $this->belongsTo(Caisse::class);
    }
    
    /**
     * L'évaluation associée à ce ticket.
     */
    public function evaluation(): HasOne
    {
        return $this->hasOne(Evaluation::class);
    }
}