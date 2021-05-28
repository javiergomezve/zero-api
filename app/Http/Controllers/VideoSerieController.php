<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoPreview;
use App\Models\Serie;
use Illuminate\Http\Request;

class VideoSerieController extends Controller
{
    public function index(Serie $serie)
    {
        return VideoPreview::collection($serie->videos);
    }
}
