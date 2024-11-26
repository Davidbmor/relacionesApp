<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            '_token',
            'entrada'   =>  'required|min:60|max:250|unique:post',
            'texto'     =>  'required|min:100',
            'titulo'    => 'required|min:25|max:60|unique:post',
        ]);
        $post = new Post();
        $post->fill($request->all());
        $post->texto = strip_tags($request->texto, env('PERMITTED_TAGS'));
        try {
            $post->save();
            return redirect('/')->with('message', 'Post created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Post could not be created.']);
        }
    }



    function storeComment(Request $request , Post $post) {
        
        $request->validate([
            'apodo' => 'required|min:5|max:40',
            'correo' => 'required|min:5|max:100',
            'texto' => 'required|max:100',
            
            
        ]);


         $comment = new Comment($request->all());
         $comment->post_id = $post->id;
         try{
            $comment->save();
            return back()->with('message', 'Comentario creado exitosamente');
         }catch(\Exception $e){
            return back()->withInput()->withErrors(['message' => 'Comentario no creado']);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $permittedTags = env('PERMITTED_TAGS');
        return view('post.show', ['post' => $post, 'permittedTags' => $permittedTags]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        try {
            $post->update($validatedData);
            return redirect()->route('posts.index')
                             ->with('success', 'Post actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo actualizar el post.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return redirect()->route('posts.index')
                             ->with('success', 'Post eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo eliminar el post.']);
        }
    }
}
