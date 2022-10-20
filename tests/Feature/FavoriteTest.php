<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Favorite;


class FavoriteTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_visit_page_of_index_favorite()
    {
        $user = User::first();
        $response = $this->actingAs($user, 'sanctum')->getJson(route('favorite_index'));
        $response->assertStatus(200);
    }

    public function test_create_favorite()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $text = $this->faker->text;
        $response = $this->actingAs($user, 'sanctum')->post(route('favorite_store'), [
            '_token' => csrf_token(),
            'id_usuario' => $user->id,
            'ref_api' => $text,

        ])->assertStatus(200);

        $this->assertDatabaseHas('favorites', [
            'id_usuario' => $user->id,
            'ref_api' => $text
        ]);


    }

    public function test_edit_favorite()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $response = $this->actingAs($user, 'sanctum')->get(route('favorite_edit', 1))->assertStatus(200);

    }

    public function test_update_favorite()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $favorite_first = Favorite::first();
        $text = $this->faker->text;
        $response = $this->actingAs($user, 'sanctum')->patch(route('favorite_update', $favorite_first->id), [
            '_token' => csrf_token(),
            'id_usuario' => $user->id,
            'ref_api' => $text

        ])->assertStatus(200);

        $this->assertDatabaseHas('favorites', [
            'id_usuario' => $user->id,
            'ref_api' => $text
        ]);

    }

    public function test_delete_favorite()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $favorite = Favorite::first();
        $response = $this->actingAs($user, 'sanctum')->delete(route('favorite_delete', $favorite->id))->assertStatus(200);

        $this->assertSoftDeleted('favorites', [
            'id_usuario' => $user->id,
            'ref_api' => $favorite->ref_api
        ]);
    }
}
