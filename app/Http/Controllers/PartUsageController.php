<?php

namespace App\Http\Controllers;

use App\Models\PartUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PartUsageController extends Controller
{
    public function show()
    {
        $partUsages = PartUsage::with('serviceDetail', 'sparePart')->get();

        return Inertia::render('PartUsages', [
            'partUsages' => $partUsages
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:part_usages,id',
        ]);

        $partUsage = PartUsage::find($request->input('id'));

        if ($partUsage) {
            $partUsage->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
