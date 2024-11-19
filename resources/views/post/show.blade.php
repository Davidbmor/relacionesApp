@extends ('base')

@section('content')
{!! $post->texto !!}
@endsection

@section('titulo')
{!! $post->titulo !!}
@endsection

@section('entrada')
{!! $post->entrada !!}
@endsection

@section('by')
Publicado por
<a href="#">izvserver</a>
el {{ $post->created_at->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y') }}
@endsection