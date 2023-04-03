<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChangeMaker extends Model
{
    protected $fillable = [
        'title',
        'description',
        'attachment',
        'url',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::create($value)->toDateTimeString();
    }
}
