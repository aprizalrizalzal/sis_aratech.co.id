<?php

namespace App\Http\Controllers;

use App\Models\ImageSparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ImageSparePartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'spare_part_id' => 'required|exists:spare_parts,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:512',
        ]);

        // Cek jumlah gambar yang ada untuk spare part ini
        $existingImagesCount = ImageSparePart::where('spare_part_id', $request->spare_part_id)->count();
        if ($existingImagesCount >= 6) {
            return Redirect::back()->withErrors(['image' => 'Maksimal 6 gambar per spare part.']);
        }

        $originalName = $request->file('image')->getClientOriginalName();
        $uniqueName = time() . '_' . $originalName;
        $path = $request->file('image')->storeAs('images/spareParts/images', $uniqueName, 'public');

        ImageSparePart::create([
            'image_path' => 'storage/' . $path,
            'spare_part_id' => $request->spare_part_id,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:image_spare_parts,id',
        ]);

        $imageSparePart = ImageSparePart::findOrFail($request->id);

        $path = str_replace('storage/', '', $imageSparePart->image_path);
        Storage::disk('public')->delete($path);

        $imageSparePart->delete();

        return Redirect::back();
    }
}
