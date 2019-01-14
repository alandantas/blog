<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $myComments = Auth::User()->comments();
        $comments = Auth::User()->comments()->latest()->paginate(5);
        return view('author.comments', compact('comments','myComments'));
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->post->user->id == Auth::id())
        {
            $comment->delete();
            Toastr::success('Comentário excluido com Sucesso :)','Parabéns!');
        } else {
            Toastr::error('Você não tem permissão para efetuar essa ação :)','Acesso Negado!');
        }
        return redirect()->back();

    }
}
