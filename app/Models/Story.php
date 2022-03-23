<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'display',
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
