<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorFeedback extends Model
{
    protected $fillable = [
        'mentor_id',
        'confirm_attended',
        'days_attended',
        'nodal_center',
        'role',
        'video_link',
        'image',
        'feedback',
    ];

    public function willingness()
    {
        return $this->hasOne(MentorWillingness::class, 'mentor_id');
    }
}
