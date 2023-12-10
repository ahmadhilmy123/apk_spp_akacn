<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB, Storage, Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $message = ['name.required' => 'The nama field is required.'];

        if ($user->hasRole('petugas')) {
            $message['email.required'] = 'The NIP field is required.';
            $message['email.unique'] = 'The NIP is already in use.';
        }elseif($user->hasRole('mahasiswa')){
            $message['email.required'] = 'The NIM field is required.';
            $message['email.unique'] = 'The NIM is already in use.';
        }

        $request->validate([
            'name' => 'required',
            'email' =>  ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'profile' => 'file|mimes:png,jpg,jpeg|max:2048'
        ], $message);

        if ($request->file('profile')) {
            if ($user->profile) {
                Storage::delete($user->profile);
            }
            $profile = $request->file('profile')->store('profile');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile' => isset($profile) ? $profile : null
        ]);

        return redirect()->back()->with('success', 'Berhasil diupdate!');
    }
}
