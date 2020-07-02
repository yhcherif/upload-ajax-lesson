<?php

use App\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome')->withPosts(Post::latest()->get());
});

Route::get('/recently', function () {
    return view('posts')->withPosts(Post::latest()->get());
});

Route::resource("posts", "PostController");
