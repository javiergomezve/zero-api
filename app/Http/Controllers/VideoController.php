<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return Video::latest()->get();
    }

    public function show(Video $video)
    {
        return $video;
    }
}
