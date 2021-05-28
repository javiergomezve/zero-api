<?php

namespace Tests\Feature;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShouldGetAListOfSeriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_get_a_lis_of_series()
    {
        $this->withoutExceptionHandling();
        Serie::factory(2)->create();

        $this->getJson('/api/series')
            ->assertOk()
            ->assertJsonCount(2);
    }

    /**
     * @test
     */
    public function series_preview_should_have_the_correct_format()
    {
        $attributes = [
            'id' => 1,
            'title' => 'Serie title',
            'resume' => 'Serie resume',
            'thumbnail' => 'http://asd.com/asd.png',
        ];

        Serie::factory()->create($attributes);

        $this->getJson('/api/series')
            ->assertOk()
            ->assertExactJson([$attributes]);
    }
}
