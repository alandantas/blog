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
            ->withCount('posts')
            ->withCount('comments')
            ->withCount('favorite_posts')
            ->paginate(5);
        return view('admin.authors', compact('authors'));
    }

    public function destroy($id)
    {
        $author = User::findOrFail($id)->delete();
        Toastr::success('Autor deletado com sucesso :)', 'Parabéns!');
        return redirect()->back();
    }
}
