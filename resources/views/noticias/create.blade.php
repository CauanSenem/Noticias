@extends('layouts.app')
@section('title','Realizar empréstimo')
@section('content')
<br>
    <h1>Adiocnar Notícia</h1>
<br>
    {{Form::open(['route' => 'noticias.store', 'method' => 'POST',
        'enctype'=>'multipart/form-data'])}}
        {{Form::label('nome', 'Autor')}}
        {{Form::text('nome', '', ['class'=>'form-control', 'required', 
        'placeholder' =>'selecione um autor',
         'list'=>'listautores'])}} 
         <datalist id='listcontatos'>
            @foreach($autores as $autor)  
            <option value="{{$autor->id}}">{{$autor->nome}}</option>
            @endforeach
        </datalist>
        {{Form::label('idLivro', 'Livro')}}
        {{Form::text('idLivro', '', ['class'=>'form-control', 'required', 
        'placeholder' =>'selecione um livro', 'list'=>'listlivros'])}}
        <datalist id="listlivros">
            @foreach($livros as $livro)
            <option value="{{$livro->id}}">{{$livro->titulo}}</option>
            @endforeach
        </datalist>   

        {{Form::label('dataHora', 'Data')}}
        {{Form::text('dataHora', \Carbon\Carbon::now()
        ->format('d/m/Y H:i:s'),
        ['class'=>'form-control', 'required', 
        'placeholder' =>'data', 'rows'=>'8'])}}
        {{Form::label('obs', 'Obs')}}
        {{Form::text('obs', '', ['class'=>'form-control',
        'placeholder' =>'observação'])}}
        <br>
        {{Form::submit('Salvar', ['class'=>'btn btn-success'])}}
        {!!Form::button('Cancelar', ['onclick'=>'javascript:history.go(-1)',
            'class'=> 'btn btn-danger'])!!}
        {{Form::close()}}
        @endsection