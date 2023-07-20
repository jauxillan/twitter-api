<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow($userToFollow)
    {

        $follower = Follower::where('user_id', $userToFollow)->get();

        if (!$follower->contains('follower_id', Auth::user()->id)) {
            $newFollow = new Follower;
            $newFollow->user_id = $userToFollow;
            $newFollow->follower_id = Auth::user()->id;
            $newFollow->save();

            return response()->json(['message' => 'You are now following ' . $userToFollow]);
        }


        return response()->json(['message' => 'You are already following ' . $userToFollow]);
    }

    public function unfollow(User $userToUnfollow)
    {
        $follower = auth()->user();
        $follower->load('following');

        if ($follower->following && $follower->following->contains($userToUnfollow->id)) {
            $follower->following()->detach($userToUnfollow->id);
            return response()->json(['message' => 'You have unfollowed ' . $userToUnfollow->name]);
        }

        return response()->json(['message' => 'You are not following ' . $userToUnfollow->name]);
    }
}
