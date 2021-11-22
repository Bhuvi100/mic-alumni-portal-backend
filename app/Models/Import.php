<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'file_name',
        'projects',
        'users',
        'imported_by',
        'status',
    ];

    public function importer()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}