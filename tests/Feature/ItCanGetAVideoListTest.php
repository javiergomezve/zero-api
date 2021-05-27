<?php

namespace Tests\Feature;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
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
    public function video_preview_has_id_and_thumbnail()
    {
        $attribuetes = [
            'id' => 123,
            'thumbnail' => 'http://asd.com',
        ];

        Video::factory()->create($attribuetes);

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

    /**
     * @test
     */
    public function video_list_can_be_limited()
    {
        $limit = 3;

        Video::factory(4)->create();

        $this->getJson('/api/videos?limit='.$limit)->assertJsonCount($limit);
    }

    /**
     * @test
     */
    public function should_return_30_videos_by_default()
    {
        $limit = 30;

        Video::factory(40)->create();

        $this->getJson('/api/videos')->assertJsonCount($limit);
    }

    public function providerInvalidLimits(): array
    {
        return [
            'should_return_a_minimum_of_1_videos' => [3, '-1'],
            'should_return_a_maximum_of_50_videos' => [51, '51'],
            'it_should_return_unprocessable_when_limit_is_string' => [4, 'asd'],
        ];
    }

    /**
     * @dataProvider providerInvalidLimits
     */
    public function returnUnprocessableEntityEnErrorByLimit(int $videosCount, string $limit)
    {
        Video::factory($videosCount)->create();

        $this->getJson('/api/videos?limit='.$limit)->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
