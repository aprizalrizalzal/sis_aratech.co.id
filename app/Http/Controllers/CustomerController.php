<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function show()
    {
        $customers = Customer::all();

        return Inertia::render('Customers', [
            'customers' => $customers
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customers,id',
        ]);

        $customer = Customer::find($request->input('id'));

        if ($customer) {
            $customer->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
