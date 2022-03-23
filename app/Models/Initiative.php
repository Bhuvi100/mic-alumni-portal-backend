<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = [
        'hackathon',
        'edition',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'initiative_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::create($value)->toDateTimeString();
    }
}