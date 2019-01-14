<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use App\Post;
use App\Subscriber;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //Função que que chama a view Index, e lista os POSTs cadastrados no DB.
        $cont = Post::all();
        $posts = Post::latest()->paginate(5); //Busca os POSTs em ordem do mais recente, e faz uma paginação na view de 10 em 10.
        return view('admin.post.index',compact('posts', 'cont'));//Retorna a view com os POSTs paginados.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Função onde retorna a tela para criação de POST, nela é retornada todas as categorias e TAGs
        $categories = Category::all(); //Retorna todas categorias cadastradas no banco.
        $tags = Tag::all(); // Retorna todas as TAGs cadastradas no banco.
        return view('admin.post.create', compact('categories','tags')); //Retorna a view com as Categorias e TAGs
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Faz a validação dos dados enviados para cadastro no DB, onde required = campo obrigatório
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if (isset($image))
        {
            //Cria um nome único para a imagem
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
            $postImage = Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName, $postImage);
        } else {
            $imageName = "default.png";
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if (isset($request->status))
        {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber)
        {
            Notification::route('mail', $subscriber->email)
                ->notify(new  NewPostNotify($post));
        }

        Toastr::success('Você fez uma nova postagem :)','Parabéns');
        //toastr()->success('Você fez uma nova postagem :)','Parabéns');
        return redirect()->route('admin.post.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //Retorna a view de Edição de POSTs
        $categories = Category::all(); //Retorna todas categorias associadas ao POST.
        $tags = Tag::all(); //Retorna todas TAGs associadas ao POST.
        return view('admin.post.edit', compact('post','categories','tags')); //Retorna a view, mostrando o POST, TAG, e Categoria.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if (isset($image))
        {
            //Cria um nome único para a imagem
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }

            // Deletar imagem antiga do POST
            if (Storage::disk('public')->exists('post/'.$post->image))
            {
                Storage::disk('public')->delete('post/'.$post->image);
            }
            $postImage = Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName, $postImage);

        } else {
            $imageName = $post->image;
        }

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if (isset($request->status))
        {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('POST Alterado com Sucesso :)','Parabéns');
        //toastr()->success('POST Alterado com Sucesso :)','Parabéns');
        return redirect()->route('admin.post.index');
    }

    public function pending()
    {
        $posts = Post::where('is_approved', false)->get();
        return view('admin.post.pending', compact('posts'));
    }

    public function approval($id)
    {
        //Função onde o Admin faz a aprovação do POST postado pelo autor.
        $post = Post::find($id);
        if ($post->is_approved == false)
        {
            $post->is_approved = true;
            $post->save();
            $post->user->notify(new AuthorPostApproved($post));

            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber)
            {
                Notification::route('mail', $subscriber->email)
                    ->notify(new  NewPostNotify($post));
            }

            Toastr::success('POST Aprovado com Sucesso :)','Parabéns');
            //toastr()->success('POST Aprovado com Sucesso :)','Parabéns');
        } else {
            Toastr::info('Este POST já está Aprovado :)','Atenção!');
            //toastr()->info('Este POST já está Aprovado :)','Atenção!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Storage::disk('public')->exists('post/'.$post->image))
        {
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->categories()->detach();
        $post->delete();
        Toastr::success('POST Deletado com Sucesso :)','Parabéns');
        //toastr()->success('POST Deletado com Sucesso :)','Parabéns');
        return redirect()->back();
    }
}
