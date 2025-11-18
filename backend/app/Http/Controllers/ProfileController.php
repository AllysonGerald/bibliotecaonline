<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        $user->load(['rentals', 'reservations', 'reviews', 'wishlists']);

        return view('user.perfil', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('perfil')
            ->with('success', 'Perfil atualizado com sucesso!')
        ;
    }
}
