<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png|max:1024',
            'company' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'company_logo.' . $extension;
            $path = $request->file('image')->storeAs('images/header', $fileName, 'public');
            $imagePath = 'storage/' . $path;
        } else {
            $imagePath = null;
        }

        Header::create([
            'image_path' => $imagePath,
            'company' => $request->company,
            'url' => $request->url,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update_image(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:headers,id',
            'image' => 'nullable|image|mimes:png|max:1024',
        ]);

        $header = Header::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $oldPath = str_replace('storage/', '', $header->image_path);
            Storage::disk('public')->delete($oldPath);

            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'company_logo.' . $extension;
            $path = $request->file('image')->storeAs('images/header', $fileName, 'public');

            $header->image_path = 'storage/' . $path;
            $header->save();
        }

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:headers,id',
            'company' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $header = Header::findOrFail($request->id);

        $header->update([
            'company' => $request->company,
            'url' => $request->url,
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

        $path = str_replace('storage/', '', $header->image_path);
        Storage::disk('public')->delete($path);

        $header->delete();

        return Redirect::back();
    }
}
