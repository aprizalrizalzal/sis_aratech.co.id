<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function assignRoles(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $roleName = $validatedData['role'];
        $email = $validatedData['email'];

        // Cari role berdasarkan nama
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return Redirect::back()->with('error', 'Role not found');
        }

        // Cari user berdasarkan email
        $users = User::where('email', $email)->get();

        if ($users->isEmpty()) {
            return Redirect::back()->with('error', 'User not found');
        }

        // Assign role to users
        foreach ($users as $user) {
            $user->roles()->syncWithoutDetaching([$role->id => ['created_at' => now(), 'updated_at' => now()]]);
        }

        return Redirect::back()->with('success', 'Role assigned successfully');
    }

    public function removeRoles(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $roleName = $validatedData['role'];
        $email = $validatedData['email'];

        // Cari role berdasarkan nama
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return Redirect::back()->with('error', 'Role not found');
        }

        // Cari user berdasarkan email
        $users = User::where('email', $email)->get();

        if ($users->isEmpty()) {
            return Redirect::back()->with('error', 'User not found');
        }

        // Remove role from users
        foreach ($users as $user) {
            $user->roles()->detach($role->id);
        }

        return Redirect::back()->with('success', 'Role removed successfully');
    }
}
