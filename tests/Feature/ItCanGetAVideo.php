<?php

namespace Tests\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItCanGetAVideo extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    public function it_can_get_a_video_by_id()
    {
        $attributes = [
            'id' => 1,
            'title' => 'Video title',
            'description' => 'Video description',
            'url' => 'http://asd.com/video.mp4',
            'thumbnail' => 'http://asd.com/video.png',
        ];

        Video::factory()->create($attributes);

        $response = $this->get('/api/videos/'.$attributes['id']);

        $response->assertExactJson($attributes);
    }
}
