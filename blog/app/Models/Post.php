<?php
namespace App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post
{
    public static function all(){
        $files = File::files(resource_path("posts/"));

        return array_map(function($file){
            return 'foo';
        }, $files);
    }

    public static function find($slug){
        base_path();
        if(!file_exists($path = resource_path("posts/{$slug}.html"))){
            // abort(404);
            throw new ModelNotFoundException();
        }

        return cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));
    }
}