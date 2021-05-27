<?php

namespace Tests\Feature;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItCanGetAVideoListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_get_a_video_list()
    {
        $videosCount = 2;

        Video::factory()->times($videosCount)->create();

        $this->getJson('/api/videos')
            ->assertOk()
            ->assertJsonCount($videosCount);
    }

    /**
     * @test
     */
    public function payload_contains_videos_of_db()
    {
        $attribuetes = [
            'id' => 123,
            'thumbnail' => 'http://asd.com',
        ];

        $videos = Video::factory()->create($attribuetes);

        $this->getJson('/api/videos')
            ->assertExactJson([$attribuetes]);
    }

    /**
     * @test
     */
    public function videos_are_ordered_from_newer_to_older()
    {
        $videoOneMonthOlder = Video::factory()->create([
            'created_at' => Carbon::now()->subDays(30),
        ]);

        $videoToDay = Video::factory()->create([
            'created_at' => Carbon::now(),
        ]);

        $videoYesterdey = Video::factory()->create([
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $response = $this->getJson('/api/videos')
            ->assertJsonPath('0.id', $videoToDay->id)
            ->assertJsonPath('1.id', $videoYesterdey->id)
            ->assertJsonPath('2.id', $videoOneMonthOlder->id)
        ;

        [$first, $second, $third] = $response->json();

        $this->assertEquals($videoToDay->id, $first['id']);
        $this->assertEquals($videoYesterdey->id, $second['id']);
        $this->assertEquals($videoOneMonthOlder->id, $third['id']);
    }
}
