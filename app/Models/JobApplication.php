<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'user_id',
        'company',
        'role',
        'status',
        'applied_date',
        'job_url',
        'location',
        'salary',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}