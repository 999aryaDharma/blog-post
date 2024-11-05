<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request, Post $post)
    {
        $request->validate(['vote' => 'required|in:up,down']);

        if (!Auth::check()) {
            return response()->json(['error' => 'You need to login to vote.'], 403);
        }

        $user = Auth::user();
        $voteType = $request->input('vote');

        // Mencari vote yang sudah ada
        $vote = Vote::where('user_id', $user->id)
                    ->where('post_id', $post->id)
                    ->first();

        if ($vote) {
            // Jika ada, periksa jenis vote
            if ($vote->vote !== $voteType) {
                // Jika vote sebelumnya berbeda, update
                $vote->vote = $voteType;
                $vote->save();
            }
        } else {
            // Jika belum ada vote, buat yang baru
            Vote::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'vote' => $voteType
            ]);
        }

        // Response dengan jumlah upvote dan downvote terbaru
        return response()->json([
            'upvotes' => $post->upvotes(),
            'downvotes' => $post->downvotes()
        ]);
    }

}

