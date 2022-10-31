@extends('layouts.app')
@section('title',''.$noticia->titulo)
@section('content')
    <div class="card w-50 m-auto">
        @php
            $nomeimagem = "";
            if(file_exists("./img/noticias/".md5($noticia->id).".jpg")) {
                $nomeimagem = "./img/noticias/".md5($noticia->id).".jpg";
            } elseif (file_exists("./img/noticias/".md5($noticia->id).".png")) {
                $nomeimagem = "./img/noticias/".md5($noticia->id).".png";
            } elseif (file_exists("./img/noticias/".md5($noticia->id).".gif")) {
                $nomeimagem =  "./img/noticias/".md5($noticia->id).".gif";
            } elseif (file_exists("./img/noticias/".md5($noticia->id).".webp")) {
                $nomeimagem = "./img/noticias/".md5($noticia->id).".webp";
            } elseif (file_exists("./img/noticias/".md5($noticia->id).".jpeg")) {
                $nomeimagem = "./img/noticias/".md5($noticia->id).".jpeg";
            } else {
                $nomeimagem = "./img/noticias/semfoto.webp";
            }
            //echo $nomeimagem;
        @endphp

        {{Html::image(asset($nomeimagem),'Foto de '.$noticia->nome,["class"=>"img-thumbnail"])}}

        <div class="card-header">
            <h1>{{$noticia->titulo}}</h1>
        </div>
        <div class="card-body">
                <h3 class="card-title">{{$noticia->obs}}</h3>
                <p class="text">
                Autor: <a href="mailto:{{$noticia->idAutor}}">{{$noticia->autor->nome}}</a>
                <br/>
                Portal de notícia: {{$noticia->portal}}
                <br/>
                Data e Hora: {{$noticia->dataHora}}
            </p>
        </div>
        <div class="card-footer">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::open(['route' => ['noticias.destroy',$noticia->id],'method' => 'DELETE'])}}
                @if ($nomeimagem !== "./img/noticias/semfoto.webp")
                {{Form::hidden('foto',$nomeimagem)}}
                @endif
                <a href="{{url('noticias/'.$noticia->id.'/edit')}}" class="btn btn-success">Alterar</a>
                {{Form::submit('Excluir',['class'=>'btn btn-danger','onclick'=>'return confirm("Confirma exclusão?")'])}}
            @endif
                <a href="{{url('noticias/')}}" class="btn btn-secondary">Voltar</a>
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::close()}}
            @endif

        </div>
    </div>
@endsection