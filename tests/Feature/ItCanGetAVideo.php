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
        $video = Video::factory()->create();

        $response = $this->get('/api/videos/'.$video->id);

        $response->assertJsonFragment($video->toArray());
    }
}
