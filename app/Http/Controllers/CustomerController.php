<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function show()
    {
        $customers = Customer::with('user')->get();

        return Inertia::render('Customer/Customers', [
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'phone' => 'required|string|max:255|unique:' . Customer::class,
            'address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);

        Customer::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $customer = Customer::findOrFail($request->id);
        $user = User::findOrFail($customer->user_id);

        if ($request->email !== $user->email) {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);
            $user->email_verified_at = null;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customers,id',
        ]);

        $customer = Customer::findOrFail($request->id);
        $user = User::findOrFail($customer->user_id);

        $customer->delete();
        $user->delete();

        return Redirect::back();
    }
}
