<?php

namespace Tests\Feature;

use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShouldGetVideosOfSerieTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_get_videos_of_serie()
    {
        Video::factory()->create();

        $serie = Serie::factory()->create();
        $serie->videos()->attach(
            Video::factory(2)->create()->pluck('id')->toArray()
        );

        $this->getJson('/api/series/'.$serie->id.'/videos')
            ->assertOk()
            ->assertJsonCount(2);
    }

    /**
     * @test
     */
    public function should_get_the_correct_vide_content()
    {
        $video = Video::factory()->create();

        $serie = Serie::factory()->create();
        $serie->videos()->attach($video->id);

        $this->getJson('/api/series/'.$serie->id.'/videos')
            ->assertOk()
            ->assertExactJson([
                [
                    'id' => $video->id,
                    'thumbnail' => $video->thumbnail,
                ]
            ]);
    }
}
