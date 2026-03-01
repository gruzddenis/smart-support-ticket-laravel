<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title','description','status',
        'category','sentiment','urgency','suggested_reply',
        'ai_processed_at','ai_error',
    ];

    protected $casts = [
        'ai_processed_at' => 'datetime',
    ];
}
