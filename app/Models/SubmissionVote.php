<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionVote extends Model
{
    protected $fillable = ['submission_id', 'user_id'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
