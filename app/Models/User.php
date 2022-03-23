<?php

namespace App\Models;

use Grosv\LaravelPasswordlessLogin\Traits\PasswordlessLogin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, PasswordlessLogin;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'alternate_email',
        'phone',
        'gender',
        'role',
        'signed_up_at',
        'picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getLoginRouteExpiresInAttribute(): int
    {
        return $this->signed_up_at ? config('laravel-passwordless-login.login_route_expires') : 4320;
    }

    public function getPictureAttribute($value)
    {
        return asset($value ? 'storage/' . $value : 'storage/images/profile.png');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function status()
    {
        return $this->hasOne(ParticipantStatus::class);
    }

    public function story()
    {
        return $this->hasOne(Story::class);
    }

    public function projects_as_leader()
    {
        return $this->hasMany(Project::class, 'leader_id');
    }

    public function imports()
    {
        return $this->hasMany(Import::class, 'imported_by');
    }

    public function is_admin()
    {
        return $this->role === 'admin';
    }

    public function is_permitted(User $user)
    {
        return $this->id == $user->id;
    }
}
