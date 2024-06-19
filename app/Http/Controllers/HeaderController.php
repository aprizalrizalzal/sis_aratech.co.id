<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HeaderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|image|mimes:ico|max:512',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $fileName = 'favicon.ico';
        $request->icon->move(public_path(''), $fileName);

        Header::create([
            'icon' => $fileName,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }
}
