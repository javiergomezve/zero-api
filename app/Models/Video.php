<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $visible = [
        'id', 'title', 'description', 'url', 'thumbnail',
    ];


    public function scopeLast($query, int $limit, int $page)
    {
        $offset = ($page - 1) * $limit;

        return $query->limit($limit)
        ->offset($offset)
        ->latest();
    }
}
