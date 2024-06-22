<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FooterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:512',
            'type' => 'required|string|max:255',
            'platform' => 'nullable|string',
            'url' => 'nullable|string',
            'username' => 'nullable|string',
            'value' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $path = $request->file('image')->storeAs('images/footers', $uniqueName, 'public');
            $imagePath = 'storage/' . $path;
        } else {
            $imagePath = null;
        }

        Footer::create([
            'image_path' => $imagePath,
            'type' => $request->type,
            'platform' => $request->platform,
            'url' => $request->url,
            'username' => $request->username,
            'value' => $request->value,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:footers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:512',
            'type' => 'required|string|max:255',
            'platform' => 'nullable|string',
            'url' => 'nullable|string',
            'username' => 'nullable|string',
            'value' => 'nullable|string',
        ]);

        $footer = Footer::findOrFail($request->id);

        if ($request->hasFile('image')) {
            if ($footer->image_path) {
                $oldPath = str_replace('storage/', '', $footer->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $originalName = $request->file('image')->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $path = $request->file('image')->storeAs('images/footers', $uniqueName, 'public');

            $footer->image_path = 'storage/' . $path;
        }

        $footer->update([
            'type' => $request->type,
            'platform' => $request->platform,
            'url' => $request->url,
            'username' => $request->username,
            'value' => $request->value,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:footers,id',
        ]);

        $footer = Footer::findOrFail($request->id);

        $path = str_replace('storage/', '', $footer->image_path);
        Storage::disk('public')->delete($path);

        $footer->delete();

        return Redirect::back();
    }
}
