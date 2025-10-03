<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Challenge;
use Illuminate\Support\Facades\DB;

class AwardWeeklyXp extends Command
{
    protected $signature = 'challenges:award-weekly-xp';
    protected $description = 'Award 50 XP to the top voted submission for expired challenges';

    public function handle()
    {
        $expired = Challenge::whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->whereNull('awarded_at') 
            ->get();

        foreach ($expired as $challenge) {
            DB::transaction(function () use ($challenge) {
                $top = $challenge->submissions()
                    ->with('user')
                    ->withCount('votes')
                    ->orderByDesc('votes_count')
                    ->orderBy('created_at')
                    ->first();

                if ($top && $top->user) {
                    $top->user->increment('xp', 50);
                    $this->info("Awarded 50 XP to {$top->user->name} for challenge {$challenge->title}");
                    
                    $challenge->winner_submission_id = $top->id;
                    $challenge->awarded_at = now();
                    $challenge->save();
                }
            });
        }

        return Command::SUCCESS;
    }
}