<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function show()
    {
        $customers = Customer::all();

        return Inertia::render('Customer/Customers', [
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . Customer::class,
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
        ]);

        Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $customer = Customer::find($request->input('id'));

        if ($request->email !== $customer->email) {
            $user = User::where('email', $customer->email)->first();
            if ($user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
            }
        }

        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customers,id',
        ]);

        $customer = Customer::find($request->input('id'));

        if ($request->email !== $customer->email) {
            $user = User::where('email', $customer->email)->first();
            if ($user) {
                $user->delete();
                $customer->delete();

                return Redirect::back();
            }
        }

        return Redirect::back();
    }
}
