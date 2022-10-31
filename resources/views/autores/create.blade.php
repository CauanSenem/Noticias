@extends('layouts.app')
@section('title','Criar novo Contato')
@section('content')
<br>
    <h1>Criar novo contato</h1>
<br>
    {{Form::open(['route' => 'autores.store', 'method' => 'POST', 'enctype'=>'multipart/form-data'])}}
        {{Form::label('nome', 'Nome')}}
        {{Form::text('nome', '', ['class'=>'form-control', 'required', 'placeholder' =>'Nome completo'])}}

        {{Form::label('telefone', 'Telefone')}}
        {{Form::text('telefone', '', ['class'=>'form-control', 'required', 'placeholder' =>'(xx) xxxxx-xxxx'])}}

        {{Form::label('email', 'e-mail')}}
        {{Form::email('email', '', ['class'=>'form-control', 'required', 'placeholder' =>'E-mail'])}}

        {{Form::label('dataHora', 'Data')}}
        {{Form::text('dataHora', \Carbon\Carbon::now()->format('d/m/Y H:i:s'),['class'=>'form-control', 'required', 'placeholder' =>'data', 'rows'=>'8'])}}
        
        {{Form::label('foto', 'Foto')}}
        {{Form::file('foto',['class'=>'form-control','id'=>'foto'])}}
        <br>
        {{Form::submit('Salvar', ['class'=>'btn btn-success'])}}
        {!!Form::button('Cancelar', ['onclick'=>'javascript:history.go(-1)',
            'class'=> 'btn btn-danger'])!!}
        {{Form::close()}}
        @endsection