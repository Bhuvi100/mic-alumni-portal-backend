<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantStatus extends Model
{
    protected $table = 'participant_status';

    protected $fillable = [
        'user_id',
        'current_status',
        'project_prototype',
//        'project_details',
        'project_elaborate',
        'project_title',
        'project_theme',
        'project_status',
        'project_ip_generated',
        'project_ip_type',
        'project_ip_status',
        'project_hackathon_related',
        'project_funding_support',
        'project_trl_level',
        'project_video_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function is_permitted(User $user)
    {
        return $this->user_id == $user->id;
    }
}