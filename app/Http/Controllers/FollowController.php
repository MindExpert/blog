<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user)
    {
        // you cannot follow yourself
        if ($user->id == auth()->user()->id) {
            return back()->with('failure', 'You cannot follow yourself.');
        }

        // you cannot follow someone you're already following
        $existCheck = Follow::query()
            ->where('user_id', auth()->user()->id)
            ->where('followed_user_id', '=', $user->id)
            ->count();

        if ($existCheck) {
            return back()->with('failure', 'You are already following that user.');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followed_user_id = $user->id;
        $newFollow->save();

        return back()->with('success', 'User successfully followed.');
    }

    public function removeFollow(User $user)
    {
        Follow::query()
            ->where('user_id', auth()->user()->id)
            ->where('followed_user_id', '=', $user->id)
            ->delete();

        return back()->with('success', 'User succesfully unfollowed.');
    }
}
