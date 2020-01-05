<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
         $authors = User::authors()
            ->withcount('posts')
            ->withcount('favorite_posts')
            ->withcount('comments')
            ->get();

        return view('admin.authors',compact('authors'));

    }

    public function destroy($id)
    {

       return $author = User::findOrFail($id);

        $author->delete();

        Toastr::success('Author Successfully Deleted','Success');

        return redirect()->back();

    }

}
