<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function add($post)
    {
        $user = Auth::user();
        $isFavorite = $user->favorite_posts()->where('post_id',$post)->count();

        if ($isFavorite == 0)
        {
            $user->favorite_posts()->attach($post);
            Toastr::success('Post adicionado à sua lista de favoritos com sucesso :)','Parabéns');
            return redirect()->back();
        } else {
            $user->favorite_posts()->detach($post);
            Toastr::success('Post removido da sua lista de favoritos com sucesso :)','Parabéns');
            return redirect()->back();
        }
    }
}
