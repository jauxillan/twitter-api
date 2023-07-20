<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function index()
    // {
    //     return User::orderBy('id', 'desc')->get();
    // }

    public function index()
    {
        $users = User::whereHas('tweets')
            ->whereHas('followers')
            ->with('tweets', 'followers')
            ->get();

        return response()->json($users);
    }
}
