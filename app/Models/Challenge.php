<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = ['title', 'description'];

    public function submissions()
    {
        return $this->hasMany(\App\Models\Submission::class);
    }
}
