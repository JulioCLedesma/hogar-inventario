<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        return $this->list($request, null, 'Articulos', 'Todos los articulos de la casa.');
    }

    public function cooked(Request $request): View
    {
        return $this->list($request, 'cocinado', 'Cocinado', 'Comida preparada pendiente de consumir.');
    }

    public function unprepared(Request $request): View
    {
        return $this->list($request, 'sin_preparar', 'Alimentos sin preparar', 'Ingredientes y alimentos disponibles.');
    }

    public function general(Request $request): View
    {
        return $this->list($request, 'articulo_general', 'Articulos generales', 'Limpieza, higiene, mascotas y otros.');
    }

    public function create(): View
    {
        return view('items.create', [
            'item' => new Item([
                'tipo' => 'articulo_general',
                'categoria' => 'otro',
                'ubicacion' => 'otro',
                'estado' => 'disponible',
            ]),
            'types' => Item::TYPES,
            'categories' => Item::CATEGORIES,
            'locations' => Item::LOCATIONS,
            'statuses' => Item::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['team_id'] = $request->user()->currentTeam->id;
        $data['faltante'] = $request->boolean('faltante');

        $request->user()->currentTeam->items()->create($data);

        return redirect()->route('items.index')->with('status', 'Articulo creado.');
    }

    public function edit(Request $request, Item $item): View
    {
        $this->authorizeCurrentTeam($request, $item);

        return view('items.edit', [
            'item' => $item,
            'types' => Item::TYPES,
            'categories' => Item::CATEGORIES,
            'locations' => Item::LOCATIONS,
            'statuses' => Item::STATUSES,
        ]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $this->authorizeCurrentTeam($request, $item);

        $data = $this->validated($request);
        $data['faltante'] = $request->boolean('faltante');

        $item->update($data);

        return redirect()->route('items.index')->with('status', 'Articulo actualizado.');
    }

    public function destroy(Request $request, Item $item): RedirectResponse
    {
        $this->authorizeCurrentTeam($request, $item);

        $item->delete();

        return back()->with('status', 'Articulo eliminado.');
    }

    private function list(Request $request, ?string $type, string $title, string $description): View
    {
        $search = trim((string) $request->query('buscar', ''));

        $query = $request->user()->currentTeam->items()
            ->when($type, fn ($query) => $query->where('tipo', $type))
            ->when(! $type && $request->filled('tipo'), fn ($query) => $query->where('tipo', $request->query('tipo')))
            ->when($request->filled('categoria'), fn ($query) => $query->where('categoria', $request->query('categoria')))
            ->when($request->filled('ubicacion'), fn ($query) => $query->where('ubicacion', $request->query('ubicacion')))
            ->when($request->filled('estado'), fn ($query) => $query->where('estado', $request->query('estado')))
            ->when($request->filled('faltante'), fn ($query) => $query->where('faltante', $request->boolean('faltante')))
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nombre', 'like', '%'.addcslashes($search, '%_\\').'%');
            })
            ->orderBy('nombre');

        return view('items.index', [
            'items' => $query->paginate(10)->withQueryString(),
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'types' => Item::TYPES,
            'categories' => Item::CATEGORIES,
            'locations' => Item::LOCATIONS,
            'statuses' => Item::STATUSES,
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', Rule::in(array_keys(Item::TYPES))],
            'categoria' => ['nullable', Rule::in(array_keys(Item::CATEGORIES))],
            'ubicacion' => ['nullable', Rule::in(array_keys(Item::LOCATIONS))],
            'estado' => ['required', Rule::in(array_keys(Item::STATUSES))],
            'fecha_preparacion' => ['nullable', 'date'],
            'consumir_antes' => ['nullable', 'date', 'after_or_equal:fecha_preparacion'],
            'faltante' => ['nullable', 'boolean'],
        ]);
    }

    private function authorizeCurrentTeam(Request $request, Item $item): void
    {
        abort_unless($item->team_id === $request->user()->currentTeam->id, 404);
    }
}
