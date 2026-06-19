<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_are_created_for_the_current_team_and_flow_to_shopping_list(): void
    {
        $user = User::factory()->withPersonalTeam()->create();

        $this->actingAs($user)
            ->post(route('items.store'), [
                'nombre' => 'Papel higienico',
                'tipo' => 'articulo_general',
                'categoria' => 'higiene',
                'ubicacion' => 'otro',
                'estado' => 'terminado',
                'faltante' => '1',
            ])
            ->assertRedirect(route('items.index'));

        $item = Item::query()->firstOrFail();

        $this->assertTrue($item->faltante);
        $this->assertSame($user->currentTeam->id, $item->team_id);

        $this->actingAs($user)
            ->get(route('shopping-list.index'))
            ->assertOk()
            ->assertSee('Papel higienico');

        $this->actingAs($user)
            ->patch(route('shopping-list.purchased', $item))
            ->assertRedirect();

        $this->assertFalse($item->fresh()->faltante);
        $this->assertSame('disponible', $item->fresh()->estado);
    }

    public function test_users_cannot_update_items_from_another_team(): void
    {
        $owner = User::factory()->withPersonalTeam()->create();
        $otherUser = User::factory()->withPersonalTeam()->create();

        $item = $owner->currentTeam->items()->create([
            'nombre' => 'Cafe',
            'tipo' => 'articulo_general',
            'categoria' => 'alimento',
            'ubicacion' => 'alacena',
            'estado' => 'disponible',
        ]);

        $this->actingAs($otherUser)
            ->put(route('items.update', $item), [
                'nombre' => 'Cafe editado',
                'tipo' => 'articulo_general',
                'categoria' => 'alimento',
                'ubicacion' => 'alacena',
                'estado' => 'terminado',
            ])
            ->assertNotFound();

        $this->assertSame('Cafe', $item->fresh()->nombre);
    }
}
