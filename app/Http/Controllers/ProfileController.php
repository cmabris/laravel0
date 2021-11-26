<?php

namespace App\Http\Controllers;

use App\Profession;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::first();  // $user = auth()->user();

        return view('profile.edit', [
            'user' => $user,
            'professions' => Profession::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $user = User::first();  // $user = auth()->user();

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        $user->profile->update([
            'bio' => $request->bio,
            'twitter' => $request->twitter,
            'profession_id' => $request->profession_id
        ]);

        return back();
    }
}
