<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'challenge_run_id',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(
            User::class,
            'project_user',
        )->withTimestamps();
    }

    public function challengeRun()
    {
        return $this->belongsTo(ChallengeRun::class);
    }
}
