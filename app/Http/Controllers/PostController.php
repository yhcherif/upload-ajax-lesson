<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasfile("cover")) {
            $data['cover'] = $request->cover->store("posts");
            // sleep(10);
        }

        $post = Post::create($data);

        if($request->wantsJson()){
            return response()->json($post);
        }

        return back();
    }
}
