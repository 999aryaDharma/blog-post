<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show()
    {
        $title = 'Profile';
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('profile.show', compact('user'))->with('title', $title);
    }


    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $title = 'Edit Profile';
        $user = Auth::user();
        return view('profile.edit', compact('user'))->with('title', $title);
    }

    public function update(Request $request)
    {

    $request->validate([
        'name' => 'required|string|max:255',
        'profile_photo' => 'nullable|image', // Validasi untuk file foto
    ]);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Cek apakah ada file yang di-upload
        if ($request->hasFile('profile_photo')) {
            // Ambil file
            $file = $request->file('profile_photo');
            
            // Buat nama file dari username dan ekstensi asli
            $filename = $user->username . '.' . $file->getClientOriginalExtension();
            
            // Simpan file di folder 'profile_photos' di disk 'public' dengan nama sesuai username
            $path = $file->storeAs('profile_photo', $filename, 'public');
            
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Update foto profil di database
            $user->profile_photo = $path;
        }

        // Update nama atau informasi lainnya
        $user->name = $request->name;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');

    }




    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
