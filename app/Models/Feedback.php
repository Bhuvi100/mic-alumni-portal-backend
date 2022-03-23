<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'project_id',
        'hired_by_ministry',
        'hired_by_ministry_elaborate',
        'opportunity_status',
        'opportunity_details',
        'recommendation_status',
        'recommendation_details',
        'mic_help',
        'recommend_to_student',
        'mic_participation',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function is_permitted(User $user)
    {
        return $this->user_id == $user->id;
    }
}