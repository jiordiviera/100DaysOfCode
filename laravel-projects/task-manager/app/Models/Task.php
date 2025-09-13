<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $casts = [
        'is_completed' => 'boolean',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
