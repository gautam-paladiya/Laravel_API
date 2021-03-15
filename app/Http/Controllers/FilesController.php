<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Validator;

class FilesController extends Controller
{
    //
    public function show($id)
    {
        return Files::find($id);
    }

    public function index()
    {
        $posts = DB::table("files")->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        return response()->json($posts);
    }

    public function getWallpapers(Request $request)
    {
        if ($request->has('term')) {
            $posts = DB::select("SELECT * FROM files WHERE types = 'image' AND MATCH(fileTags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$request->query('term')]);
        } else {
            $posts = DB::table('files')->where('types', 'image')->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        }
        return response()->json($posts);
    }


    public function featureWallpapers($count)
    {
        $posts = DB::select("SELECT * FROM files where types='image' ORDER BY RAND() LIMIT ?", [$count]);
        return response()->json($posts);
    }

    public function getRingtones(Request $request)
    {
        if ($request->has('term')) {
            $posts = DB::select("SELECT * FROM files WHERE types = 'music' AND MATCH(fileTags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$request->query('term')]);
        } else {
            $posts = DB::table('files')->where('types', 'music')->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        }
        return response()->json($posts);
    }


    public function featureRingtones($count)
    {
        $posts = DB::select("SELECT * FROM files where types='music' ORDER BY RAND() LIMIT ?", [$count]);
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

    public function uploadFiles(Request $request)
    {

        // $validater = Validator::make($request->all(), ['file' => 'required|mimes:doc,docx,pdf,txt|max:2048']);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }
    }
}
