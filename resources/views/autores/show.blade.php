@extends('layouts.app')
@section('title','Autor - '.$autor->nome)
@section('content')
    <div class="card w-50 m-auto">
        @php
            $nomeimagem = "";
            if(file_exists("./img/autores/".md5($autor->id).".jpg")) {
                $nomeimagem = "./img/autores/".md5($autor->id).".jpg";
            } elseif (file_exists("./img/autores/".md5($autor->id).".png")) {
                $nomeimagem = "./img/autores/".md5($autor->id).".png";
            } elseif (file_exists("./img/autores/".md5($autor->id).".gif")) {
                $nomeimagem =  "./img/autores/".md5($autor->id).".gif";
            } elseif (file_exists("./img/autores/".md5($autor->id).".webp")) {
                $nomeimagem = "./img/autores/".md5($autor->id).".webp";
            } elseif (file_exists("./img/autores/".md5($autor->id).".jpeg")) {
                $nomeimagem = "./img/autores/".md5($autor->id).".jpeg";
            } else {
                $nomeimagem = "./img/autores/semfoto.webp";
            }
            //echo $nomeimagem;
        @endphp

        {{Html::image(asset($nomeimagem),'Foto de '.$autor->nome,["class"=>"img-thumbnail"])}}

        <div class="card-header">
            <h1>Autor - {{$autor->nome}}</h1>
        </div>
        <div class="card-body">
                <h3 class="card-title">ID: {{$autor->id}}</h3>
                <p class="text">
                E-mail: <a href="mailto:{{$autor->email}}">{{$autor->email}}</a>
                <br/>
                Telefone: {{$autor->telefone}}
                <br/>
                Data e Hora: {{$autor->dataHora}}
            </p>
        </div>
        <div class="card-footer">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::open(['route' => ['autores.destroy',$autor->id],'method' => 'DELETE'])}}
                @if ($nomeimagem !== "./img/autores/semfoto.webp")
                {{Form::hidden('foto',$nomeimagem)}}
                @endif
                <a href="{{url('autores/'.$autor->id.'/edit')}}" class="btn btn-success">Alterar</a>
                {{Form::submit('Excluir',['class'=>'btn btn-danger','onclick'=>'return confirm("Confirma exclusão?")'])}}
            @endif
                <a href="{{url('autores/')}}" class="btn btn-secondary">Voltar</a>
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::close()}}
            @endif

        </div>
    </div>
@endsection