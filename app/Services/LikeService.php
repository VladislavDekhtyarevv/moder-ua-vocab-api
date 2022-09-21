<?php

namespace App\Services;


use App\Models\Word;
use Illuminate\Support\Facades\Auth;

final class LikeService
{
    public function toggle($id, $action)
    {
        $user = Auth::user();
        $word = Word::find($id);
        if($action == 'like') {
            return $this->toggleLike($user, $word);
        }else {
            return $this->toggleDislike($user, $word);
        }

    }

    public function toggleLike($user, $word) {
        try {
            if($user->hasVoted($word) && $user->attachVoteStatus($word)->has_upvoted){
                $user->cancelVote($word);
                return [
                    'likes' => $word->totalUpvotes(),
                    'dislikes' => $word->totalDownvotes(),
                    'hasLike' => false,
                    'hasDislike' => false,
                ];
            }
            $user->upvote($word);
            return [
                'likes' => $word->totalUpvotes(),
                'dislikes' => $word->totalDownvotes(),
                'hasLike' => true,
                'hasDislike' => false,
            ];
        }catch (\Throwable $e) {
            return false;
        }
    }

    public function toggleDislike($user, $word) {
        try {
            if($user->hasVoted($word) && $user->attachVoteStatus($word)->has_downvoted){
                $user->cancelVote($word);
                return [
                    'likes' => $word->totalUpvotes(),
                    'dislikes' => $word->totalDownvotes(),
                    'hasLike' => false,
                    'hasDislike' => false,
                ];
            }
            $user->downvote($word);
            return [
                'likes' => $word->totalUpvotes(),
                'dislikes' => +$word->totalDownvotes(),
                'hasLike' => false,
                'hasDislike' => true,
            ];
        }catch (\Throwable $e) {
            return false;
        }
    }
}
