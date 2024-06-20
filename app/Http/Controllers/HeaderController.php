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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048', 
            'company' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $fileName = 'favicon.ico'; 
        $request->file('image')->move(public_path(''), $fileName);

        Header::create([
            'image_path' => $fileName,
            'company' => $request->company,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:headers,id',
        ]);

        $header = Header::findOrFail($request->id);

        $filePath = public_path($header->image_path);
        if (file_exists($filePath) && is_writable($filePath)) {
            unlink($filePath);
        } else {
            return Redirect::back()->withErrors(['error' => 'File tidak dapat dihapus.']);
        }

        $header->delete();

        return Redirect::back();
    }
}
