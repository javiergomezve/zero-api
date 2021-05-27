<?php

namespace App\Http\Controllers;

use App\Dtos\VideoPreview;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get()->mapInto(VideoPreview::class);

        return $videos;
    }

    public function show(Video $video)
    {
        return $video;
    }
}
