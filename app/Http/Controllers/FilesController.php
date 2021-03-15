<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
        $posts = Files::all()->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        return response()->json($posts);
    }

    public function getWallpapers()
    {
        $posts = Files::where('types', 'image')->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        return response()->json($posts);
    }

    public function findWallpapers($term)
    {
        $posts = DB::select("SELECT * FROM files WHERE types = 'image' AND MATCH(fileTags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$term]);
        return response()->json($posts);
    }

    public function getRingtones()
    {
        $posts = Files::where('types', 'music')->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        return response()->json($posts);
    }

    public function findRingtones($term)
    {
        $posts = DB::select("SELECT * FROM files WHERE types = 'music' AND MATCH(fileTags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$term]);
        return response()->json($posts);
    }

    public function updateDownloads(Request $request, $id)
    {
        $payload = json_decode($request->getContent(), true);
        echo $payload;
        // $id = $payload['id'];
        $post = DB::table('files')->where('id', $id)->increment('downloads', Config::get('value.ENV_DOWNLOAD_INC'));
        return response()->json($post);
    }
}
