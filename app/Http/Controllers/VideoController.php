<?php

namespace App\Http\Controllers;

use App\Dtos\VideoPreview;
use App\Http\Requests\VideoIndexRequest;
use App\Http\Resources\VideoPreview as ResourcesVideoPreview;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function index(VideoIndexRequest $request)
    {
        $videos = Video::last($request->getLimit(), $request->getPage())->get();

        return ResourcesVideoPreview::collection($videos);
    }

    public function show(Video $video)
    {
        return $video;
    }
}
