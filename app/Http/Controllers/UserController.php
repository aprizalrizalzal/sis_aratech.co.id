<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show()
    {
        $users = User::all();

        return Inertia::render('User/Users', [
            'users' => $users
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->id);
        $user->delete();

        return Redirect::back();
    }
}
