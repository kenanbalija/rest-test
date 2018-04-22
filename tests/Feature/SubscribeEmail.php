<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeEmail extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', '/api/subscribe',
            [
                'listId' => 0,
                'apiKey' => 'sed',
                'email' => 'kenan@balija.com',
                'name' => 'Kenan',
                'surname' => 'Balija'
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
}
