<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\SubmissionVote;

class SubmissionVoteController extends Controller
{
    public function toggle(Request $request, Submission $submission)
    {
        $user = $request->user();

        if ($submission->votes()->where('user_id', $user->id)->exists()) {
            // User already voted -> remove vote
            $submission->votes()->where('user_id', $user->id)->delete();
            $status = 'removed';
        } else {
            // Add vote
            $submission->votes()->create(['user_id' => $user->id]);
            $status = 'upvoted';
        }

        return response()->json([
            'status' => $status,
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
