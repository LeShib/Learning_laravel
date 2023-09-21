<?php

use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $files = File::files(resource_path("posts/"));

    $posts = collect($files)->map(function ($file){
        $document = YamlFrontMatter::parseFile($file);

        return new Post($document->title, $document->excerpt, $document->date, $document->body(), $document->slug);
    });

    // ddd($posts);
    return view('posts', [
        'posts' => $posts
    ]);
});

Route::get('posts/{post}', function ($slug) {

    return view('post', [
        'post' => Post::find($slug)
    ]);
    
})->where('post', '[A-z_\-]+');
// ->whereAlpha('post');