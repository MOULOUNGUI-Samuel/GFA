<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Role extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Les utilisateurs ayant ce rôle.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}