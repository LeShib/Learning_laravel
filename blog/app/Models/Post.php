<?php
namespace App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    /* VARIABLES */
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    /* FUNCTIONS */
    // Constructor
    public function __construct($title, $excerpt, $date, $body, $slug){
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    // Get all posts
    public static function all(){
        return collect(File::files(resource_path("posts")))->map(fn ($file) => YamlFrontMatter::parseFile($file))->map(fn($document) => new Post(
            $document->title, 
            $document->excerpt, 
            $document->date, 
            $document->body(), 
            $document->slug
        ));
    }

    // find a post with its slug
    public static function find($slug){
        $posts = static::all();

        return $posts->firstWhere('slug', $slug);
    }
}