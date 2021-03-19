<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Validator;

class FilesController extends Controller
{
    //
    public function show($id)
    {
        return Files::find($id);
    }

    public function index(Request $request)
    {
        $posts = DB::table("files")->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        return response()->json($posts);
    }

    public function getWallpapers(Request $request)
    {
        if ($request->has('term')) {
            $posts = DB::select("SELECT * FROM files WHERE types = 'image' AND MATCH(fileTags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$request->query('term')]);
            $posts = $this->arrayPaginator($posts, $request);
        } else {
            $posts = DB::table('files')->where('types', 'image')->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        }
        return response()->json($posts);
    }


    public function featureWallpapers(Request $request, $count)
    {
        $posts = DB::select("SELECT * FROM files where types='image' ORDER BY RAND() LIMIT ?", [$count]);
        // $posts = new Paginator($posts, Config::get('value.ENV_PAGINATION_COUNT'));
        return response()->json($posts);
    }

    public function getRingtones(Request $request)
    {
        if ($request->has('term')) {
            $posts = DB::select("SELECT * FROM files WHERE types = 'music' AND MATCH(fileTags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$request->query('term')]);
            $posts = $this->arrayPaginator($posts, $request);
        } else {
            $posts = DB::table('files')->where('types', 'music')->simplePaginate(Config::get('value.ENV_PAGINATION_COUNT'));
        }
        return response()->json($posts);
    }


    public function featureRingtones(Request $request, $count)
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

    public function getCategory()
    {
        $cat = Files::all('fileTags');
        return response()->json($cat);
    }

    public function arrayPaginator($array, $request)
    {
        $page = $request->query('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}
