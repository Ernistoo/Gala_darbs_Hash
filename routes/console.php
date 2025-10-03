<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use App\Models\Challenge;

Schedule::call(function () {
    $expired = Challenge::whereNotNull('deadline')
        ->where('deadline', '<=', now())
        ->whereNull('awarded_at')
        ->get();

    foreach ($expired as $challenge) {
        DB::transaction(function () use ($challenge) {
            
            $challenge->refresh();
            if ($challenge->awarded_at) return;

            $top = $challenge->submissions()
                ->with('user')
                ->withCount('votes')
                ->orderByDesc('votes_count')
                ->orderBy('created_at') 
                ->first();

            if ($top && $top->user) {
                $top->user->increment('xp', 50);
                $challenge->winner_submission_id = $top->id;
            }

            $challenge->awarded_at = now();
            $challenge->save();
        });
    }
})
->timezone('Europe/Riga')
->everyMinute();        