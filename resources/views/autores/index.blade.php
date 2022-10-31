@extends('layouts.app')
@section('title','Listagem de Autores')
@section('content')
    <h1>Listagem de Autores</h1>
    @if(Session::has('mensagem'))
        <div class="alert alert-info">
            {{Session::get('mensagem')}}
        </div>
    @endif
    {{Form::open(['url'=>'autores/buscar','method'=>'GET'])}}
        <div class="row">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                <div class="col-sm-3">
                    <a class="btn btn-success" href="{{url('autores/create')}}">Adicionar</a>
                </div>
            @endif
            <div class="col-sm-9">
                <div class="input-group ml-5">
                    @if($busca !== null)
                        &nbsp;<a class="btn btn-info" href="{{url('autores/')}}">Todos</a>&nbsp;
                    @endif
                    {{Form::text('busca',$busca,['class'=>'form-control','required','placeholder'=>'buscar'])}}
                    &nbsp;
                    <span class="input-group-btn">
                        {{Form::submit('Buscar',['class'=>'btn btn-secondary'])}}
                    </span>
                </div>
            </div>
        </div>
    {{Form::close()}}
    <br />
    <table class="table table-striped">
        @foreach ($autores as $autor)
            <tr>
                <td>
                    <a href="{{url('autores/'.$autor->id)}}">{{$autor->nome}}</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $autores->links() }}
@endsection