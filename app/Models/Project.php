<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'initiative_id',
        'team_name',
        'title',
        'idea_id/team_id',
        'description',
        'leader_id',
        'ps_id',
        'ps_code',
        'ps_title',
        'ps_description',
        'type',
        'theme',
        'ministry/organisation',
        'college',
        'college_state',
    ];

    protected $with = ['initiative'];

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function project_status()
    {
        return $this->hasOne(ProjectStatus::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function feedbackOfAuthUser()
    {
        return $this->feedbacks()->firstWhere('user_id', auth()->id());
    }

    public function feedbackOfUser(User $user)
    {
        return $this->feedbacks()->firstWhere('user_id', $user->id);
    }

    public function is_permitted(User $user)
    {
        return in_array($user->id, $this->users()->pluck('users.id')->toArray(),false);
    }
}