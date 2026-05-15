<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class ProfileController extends Controller
{
    public function edit() { return view('user.profile.edit', ['user' => Auth::user()]); }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,'.$user->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar'  => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'email', 'phone', 'address', 'document');
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Perfil actualizado.');
    }
}
