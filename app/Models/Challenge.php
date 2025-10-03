<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'deadline',
        'image',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'deadline'   => 'datetime',
    ];

    public function submissions()
    {
        return $this->hasMany(\App\Models\Submission::class);
    }

    public function winnerSubmission() {
        return $this->belongsTo(\App\Models\Submission::class, 'winner_submission_id');
    }
}
