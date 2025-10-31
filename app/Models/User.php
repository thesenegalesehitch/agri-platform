<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_verified',
        'phone_verification_code',
        'phone_verification_code_expires_at',
        'cni_number',
        'cni_recto_path',
        'cni_verso_path',
        'cni_verified',
        'cni_verified_at',
        'cni_verification_notes',
        'region',
        'ville',
        'address_line1',
        'address_line2',
        'postal_code',
        'country',
        'billing_vat_number',
        'farm_name',
        'farm_type',
        'company_name',
        'siret',
        'fleet_size',
        'is_suspended',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'phone_verified' => 'boolean',
            'phone_verification_code_expires_at' => 'datetime',
            'cni_verified' => 'boolean',
            'cni_verified_at' => 'datetime',
            'is_suspended' => 'boolean',
        ];
    }
}
