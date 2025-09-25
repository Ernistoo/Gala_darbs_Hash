<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\SubmissionVote;

class SubmissionVoteController extends Controller
{
    public function toggle(Submission $submission)
    {
        $userId = auth()->id();
        $existing = $submission->votes()->where('user_id', $userId)->first();
    
        if ($existing) {
            $existing->delete();
            return response()->json([
                'status' => 'removed',
                'votes_count' => $submission->votes()->count(),
            ]);
        }
    
        $submission->votes()->create(['user_id' => $userId]);
    
        return response()->json([
            'status' => 'upvoted',
            'votes_count' => $submission->votes()->count(),
        ]);
    }

    

    public function vote(Submission $submission)
{
    $user = auth()->user();

    if($submission->hasUpvoted($user)){
        $submission->votes()->where('user_id', $user->id)->delete();
        $status = 'removed';
    } else {
        $submission->votes()->create(['user_id' => $user->id]);
        $status = 'upvoted';
    }

    return response()->json([
        'status' => $status,
        'votes_count' => $submission->votes()->count()
    ]);
}
}
