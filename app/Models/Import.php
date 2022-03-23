<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'file_name',
        'initiative_id',
        'projects',
        'users',
        'imported_by',
        'status',
        'file',
    ];

    public function initiative()
    {
        return $this->belongsTo(Initiative::class);
    }

    public function importer()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}