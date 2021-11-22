<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'hackathon',
        'year',
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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function project_status()
    {
        return $this->hasOne(ProjectStatus::class);
    }
}