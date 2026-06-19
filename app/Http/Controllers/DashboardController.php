<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $items = $request->user()->currentTeam->items();

        return view('dashboard', [
            'totalItems' => (clone $items)->count(),
            'missingItems' => (clone $items)->where('faltante', true)->count(),
            'pendingCookedItems' => (clone $items)
                ->where('tipo', 'cocinado')
                ->whereNotIn('estado', ['consumido', 'desechar'])
                ->count(),
            'soonCookedItems' => (clone $items)
                ->where('tipo', 'cocinado')
                ->whereDate('consumir_antes', '>=', now()->toDateString())
                ->whereDate('consumir_antes', '<=', now()->addDays(2)->toDateString())
                ->count(),
            'expiredCookedItems' => (clone $items)
                ->where('tipo', 'cocinado')
                ->where(function ($query) {
                    $query->where('estado', 'desechar')
                        ->orWhereDate('consumir_antes', '<', now()->toDateString());
                })
                ->count(),
        ]);
    }
}
