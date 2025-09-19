<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'user_id',
        'challenge_date',
        'description',
        'projects_worked_on',
        'hours_coded',
        'learnings',
        'challenges_faced',
        'completed',
    ];

    protected $casts = [
        'projects_worked_on' => 'array'
    ];
}
