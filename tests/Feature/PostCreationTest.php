<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_pode_criar_postagem_imediata()
    {
        // Cria um usuário usando uma factory ou cria manualmente
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('posts.store'), [
            'title'     => 'Teste de Postagem',
            'content'   => 'Conteúdo do teste de postagem',
            'published' => 'immediate'
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('posts', [
            'title'     => 'Teste de Postagem',
            'status'    => 'published'
        ]);
    }

    public function test_usuario_autenticado_pode_criar_postagem_agendada()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $scheduled_at = Carbon::now()->addHour()->format('Y-m-d\TH:i');
        $response = $this->post(route('posts.store'), [
            'title'         => 'Post Agendado',
            'content'       => 'Conteúdo agendado',
            'published'     => 'scheduled',
            'scheduled_at'  => $scheduled_at,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('posts', [
            'title'     => 'Post Agendado',
            'status'    => 'scheduled'
        ]);
    }
}