<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validasi file gambar
        $request->validate(['file' => 'required|image']);

        // Simpan gambar di direktori public/uploads
        $imagePath = $request->file('file')->store('uploads', 'public');

        // Kembalikan URL gambar
        return response()->json(['url' => asset('storage/' . $imagePath)]);
    }

}
