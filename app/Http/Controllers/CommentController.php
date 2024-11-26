<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'apodo' => 'required|min:5|max:40',
            'correo' => 'required|min:6|max:100',
            'texto' => 'required|min:10',
            
            
        ]);

         $post_id = $request->post_id;
         $post= Post::find($post_id);
         if ($post == null) {
             abort(404);
         }

         $comment = new Comment($request->all());
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
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        // Verificar si está dentro de los primeros 10 minutos
        if ($comment->created_at->diffInMinutes(Carbon::now()) > 10) {
            return back()->withErrors(['error' => 'El comentario ya no se puede editar porque han pasado más de 10 minutos.']);
        }

        return view('comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        
         // Validar el correo proporcionado
    $request->validate([
        'correo' => 'required|email',
        'texto' => 'required|min:10|max:1000',
    ]);

        if ($request->correo !== $comment->correo) {
            return back()->withErrors(['message' => 'El correo proporcionado no coincide con el del comentario.']);
        }

        try {
            $comment->texto = $request->texto;
            $comment->save();

            return redirect()->route('post.show', $comment->post_id)->with('message', 'Comentario actualizado con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'No se pudo actualizar el comentario.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
