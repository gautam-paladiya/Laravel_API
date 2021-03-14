<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
    //
    public function show($id)
    {
        return Files::find($id);
    }

    public function index()
    {
        $posts = Files::paginate(10);
        return response()->json($posts);
    }

    public function getWallpapers()
    {
        $posts = Files::where('types', 'image')->paginate(10);
        return response()->json($posts);
    }

    public function findWallpapers($term)
    {
        $posts = Files::where('types', 'image')->whereJsonContains('fileTags', $term)->paginate(10);
        return response()->json($posts);
    }

    public function getRingtones()
    {
        $posts = Files::where('types', 'music')->paginate(10);
        return response()->json($posts);
    }

    public function findRingtones($term)
    {
        $posts = Files::where('types', 'music')->whereJsonContains('fileTags', $term)->paginate(10);
        return response()->json($posts);
    }
}
