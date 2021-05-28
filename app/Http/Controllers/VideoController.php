<?php

namespace App\Http\Controllers;

use App\Dtos\VideoPreview;
use App\Http\Requests\VideoIndexRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function index(VideoIndexRequest $request)
    {
        $videos = Video::last($request->getLimit(), $request->getPage())
            ->get()
            ->mapInto(VideoPreview::class);

        return $videos;
    }

    public function show(Video $video)
    {
        return $video;
    }
}
