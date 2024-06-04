<?php

namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ServiceDetailController extends Controller
{
    public function show()
    {
        $serviceDetails = ServiceDetail::with('user', 'service')->get();

        return Inertia::render('ServiceDetails', [
            'serviceDetails' => $serviceDetails
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:service_details,id',
        ]);

        $serviceDetail = ServiceDetail::find($request->input('id'));

        if ($serviceDetail) {
            $serviceDetail->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
