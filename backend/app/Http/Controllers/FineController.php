<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $fines = Fine::with(['rental.book', 'rental.book.author'])
            ->where('usuario_id', $user->id)
            ->latest()
            ->get()
        ;

        // Filtrar por status se fornecido
        if ($request->filled('status')) {
            if ($request->status === 'pendente') {
                $fines = $fines->where('paga', false)->values();
            } elseif ($request->status === 'paga') {
                $fines = $fines->where('paga', true)->values();
            }
        }

        // Separar em grupos
        $unpaidFines = $fines->where('paga', false)->values();
        $paidFines = $fines->where('paga', true)->values();

        return view('user.multas', compact('fines', 'unpaidFines', 'paidFines'));
    }
}
