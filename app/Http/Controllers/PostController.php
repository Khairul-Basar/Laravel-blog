<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function index(){

        $posts = Post::latest()->approved()->publish()->paginate(6);
        return view('posts',compact('posts'));

    }

    public function details($slug){

        $post = Post::where('slug',$slug)->approved()->publish()->first();

        $blogkey = 'blog_'.$post->id;

        if (!Session::has($blogkey)){

            $post->increment('view_count');

            Session::put($blogkey,1);
        }

        $randomPosts = Post::approved()->publish()->take(3)->inRandomOrder()->get();

        return view('post',compact('post','randomPosts'));

    }


    public function postByCategory($slug){

        $category = Category::where('slug',$slug)->first();

        $posts = $category->posts()->approved()->publish()->get();

        return view('category_posts',compact('category','posts'));

    }

    public function postByTag($slug){

        $tag = Tag::where('slug',$slug)->first();

        $posts = $tag->posts()->approved()->publish()->get();

        return view('tag_posts',compact('tag','posts'));

    }


}
