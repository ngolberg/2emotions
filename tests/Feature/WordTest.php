<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Word;
use App\Like;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WordTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
      parent::setUp();

      $this->user = factory(User::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/?api_token=' . $this->user->api_token);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanLike()
    {
      $this->withoutExceptionHandling();

      $response = $this->post('/api/likes', [
        'word_id' => 100,
        'api_token' => $this->user->api_token,
      ]);
      $response->assertStatus(201);

      //dd($response);
    }
}
