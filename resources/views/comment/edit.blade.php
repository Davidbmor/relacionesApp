@extends('base')

@section('content')
<form action="{{ route('comment.update', $comment->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
    </div>

    <div class="mb-3">
        <label for="texto" class="form-label">Texto</label>
        <textarea class="form-control" id="texto" name="texto" required minlength="10">{{ old('texto', $comment->texto) }}</textarea>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-secondary">Actualizar</button>
    </div>
</form>
@endsection
