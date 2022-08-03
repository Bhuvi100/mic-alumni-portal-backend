<?php

namespace App\Models;

use Grosv\LaravelPasswordlessLogin\Traits\PasswordlessLogin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
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
        'picture',
        'employment_status',
        'degree',
        'organization_name',
        'designation',
        'roles_and_expertise',
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
        return asset($value ? Storage::disk('public')->url($value) : 'assets/profile.png');
    }

    public function getRolesAndExpertiseAttribute($value)
    {
        if ($value == null || (($decoded = is_array($value) ? $value : json_decode($value, true)) && !count($decoded))) {
            return [];
        }

        return [
            'roles' => $decoded['roles'] ?? [],
            'expertise' => $decoded['expertise'] ?? [],
        ];
    }

    public function getRolesAttribute()
    {
        if ($this->roles_and_expertise && ($decoded = is_array($this->roles_and_expertise) ? $this->roles_and_expertise : json_decode($this->roles_and_expertise)) && isset($decoded['roles'])) {
            return $decoded['roles'];
        }

        return [];
    }

    public function getExpertiseAttribute()
    {
        if ($this->roles_and_expertise && ($decoded = is_array($this->roles_and_expertise) ? $this->roles_and_expertise : json_decode($this->roles_and_expertise)) && isset($decoded['expertise'])) {
            return $decoded['expertise'];
        }

        return [];
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function status()
    {
        return $this->hasOne(ParticipantStatus::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
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

    public static function filter(array $filter = [])
    {
        $filter = count($filter) ? $filter : request()->all();

        $query = self::query();
        $filter_registered = $filter['registered'] ?? null;

        if ($filter_registered) {
            $query->whereNotNull('signed_up_at');
        } else if ($filter_registered !== null) {
            $query->whereNull('signed_up_at');
        }

        $query->join('project_user', 'users.id', '=', 'project_user.user_id')
            ->join('projects', 'project_user.project_id', '=', 'projects.id')
            ->leftJoin('project_status', 'projects.id', '=', 'project_status.project_id');

        if ($filter['bootstrapped'] ?? false) {
            $query->where('project_status.startup_status', true);
        }

        if ($filter['funding'] ?? false == true) {
            $query->where('project_status.funding_support_needed', true);
        }

        if (($initiatives = ($filter['initiatives'] ?? [])) && is_array($initiatives) && (count($initiatives))) {
            $query->whereIn('projects.initiative_id', $initiatives);
        }

        return $query->distinct();
    }
}
