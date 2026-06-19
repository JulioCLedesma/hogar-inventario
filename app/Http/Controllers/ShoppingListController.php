<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShoppingListController extends Controller
{
    public function index(Request $request): View
    {
        $items = $request->user()->currentTeam->items()
            ->where('faltante', true)
            ->orderBy('categoria')
            ->orderBy('nombre')
            ->get()
            ->groupBy(fn (Item $item) => $item->categoria ?: 'otro');

        return view('shopping-list.index', [
            'groupedItems' => $items,
            'categories' => Item::CATEGORIES,
        ]);
    }

    public function markPurchased(Request $request, Item $item): RedirectResponse
    {
        abort_unless($item->team_id === $request->user()->currentTeam->id, 404);

        $item->update([
            'faltante' => false,
            'estado' => 'disponible',
        ]);

        return back()->with('status', 'Marcado como comprado.');
    }

    public function markAllPurchased(Request $request): RedirectResponse
    {
        $request->user()->currentTeam->items()
            ->where('faltante', true)
            ->update([
                'faltante' => false,
                'estado' => 'disponible',
            ]);

        return back()->with('status', 'Lista marcada como comprada.');
    }
}
