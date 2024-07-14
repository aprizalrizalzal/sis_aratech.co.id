<?php

namespace App\Http\Controllers;

use App\Models\PlatformFooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PlatformFooterController extends Controller
{
    public function show()
    {
        $platformFooters = PlatformFooter::all();

        return Inertia::render('Setting/Footer/Platform/PlatformFooters', [
            'platformFooters' => $platformFooters
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:255|unique:' . PlatformFooter::class,
            'description' => 'required|string',
        ]);

        PlatformFooter::create([
            'platform' => $request->platform,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:platform_footers,id',
            'platform' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $platformFooter = PlatformFooter::findOrFail($request->id);

        $platformFooter->update([
            'platform' => $request->platform,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:platform_footers,id',
        ]);

        $platformFooter = PlatformFooter::findOrFail($request->id);
        $platformFooter->delete();

        return Redirect::back();
    }
}
