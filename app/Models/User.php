<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // On utilise les deux traits
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'username',
        'email',
        'phone_number',
        'photo_profil_path',
        'statut_actuel',
        'caisse_actuelle_id',
        'google_id',
        'facebook_id', // Ajout de l'ID Facebook
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
    /**
     * Le rôle de l'utilisateur.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * La caisse actuellement assignée à l'utilisateur.
     */
    public function caisseActuelle(): BelongsTo
    {
        return $this->belongsTo(Caisse::class, 'caisse_actuelle_id');
    }

    /**
     * Les structures auxquelles l'utilisateur est assigné.
     */
    public function structures(): BelongsToMany
    {
        return $this->belongsToMany(Structure::class, 'user_structure');
    }
}