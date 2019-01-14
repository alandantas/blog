<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
        $cont = Comment::all();
        $comments = Comment::latest()->paginate(5);
        return view('admin.comments', compact('comments','cont'));
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id)->delete();
        Toastr::success('Comentário excluido com Sucesso :)','Parabéns!');
        return redirect()->back();
    }
}
