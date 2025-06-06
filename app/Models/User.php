<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The dates for attributes that should be treated as dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
     * The appended attributes for the model.
     *
     * @var array
     */
    protected $appends = ['full_name', 'is_verified'];

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
     * Get the verification status of the user.
     *
     * @return string
     */
    public function getIsVerifiedAttribute()
    {
        if (!empty($this->email_verified_at)) {
            return true;
        }
        return false;
    }

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the company associated with the model
     */
    public function profile(): HasOne
    {
        $role = $this->role;
        if ($role == 'admin') {
            $profile = $this->hasOne(Admin::class);
        }
        if ($role == 'company') {
            $profile = $this->hasOne(Company::class);
        }
        if ($role == 'participant') {
            $profile = $this->hasOne(Participant::class);
        }

        return $profile;
    }
}
