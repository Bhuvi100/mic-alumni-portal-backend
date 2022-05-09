<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'mic_confidence',
        'hired_by_ministry',
        'hired_by_name',
        'helped_placement',
        'placement_country',
        'placement_name',
        'ministry_internship',
        'ministry_internship_name',
        'helped_internship',
        'helped_internship_name',
        'higher_studies',
        'higher_studies_degree',
        'higher_studies_stream',
        'higher_studies_country',
        'helped_higher_studies',
        'received_award',
        'award_name',
        'award_level',
        'award_state',
        'award_country',
        'ip_registration',
        'ip_type',
        'ip_country',
        'ip_status',
        'registered_startup',
        'registered_startups_count',
        'received_investment',
        'investment_level',
        'recommend_others',
        'participation_social_awareness',
        'comments',
        'improvements',
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