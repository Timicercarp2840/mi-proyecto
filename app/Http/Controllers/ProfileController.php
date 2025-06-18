<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $request->user()->id],
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'telefono' => $request->telefono,
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Si viene del perfil de gamificación, redirigir allí
        if ($request->header('referer') && str_contains($request->header('referer'), 'mi-perfil-gamer')) {
            return redirect()->route('gamificacion.perfil')->with('success', 'Perfil actualizado correctamente.');
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
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
