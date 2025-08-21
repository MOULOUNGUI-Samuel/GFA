<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Structure extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'slug',
        'adresse',
        'telephone',
        'ville',
        'pays',
        'type',
        'logo_url',
        'est_active',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'est_active' => 'boolean',
    ];

    /**
     * Obtenir les branches associées à la structure.
     */
    public function branches(): HasMany
    {
        return $this->hasMany(Branche::class);
    }

    /**
     * Obtenir les questions de satisfaction pour cette structure.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Les utilisateurs qui sont assignés à cette structure.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_structure');
    }
    public function caisses(): HasManyThrough
    {
        return $this->hasManyThrough(Caisse::class, Branche::class);
    }
}