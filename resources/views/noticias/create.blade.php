@extends('layouts.app')
@section('title','Realizar empréstimo')
@section('content')
<br>
    <h1>Adicionar Notícia</h1>
<br>
{{Form::open(['route' => 'noticias.store', 'method' => 'POST', 'enctype'=>'multipart/form-data'])}}  

{{Form::label('titulo', 'Titulo')}}
{{Form::text('titulo', '', ['class'=>'form-control', 'required', 'placeholder' =>'Titulo da Notícia'])}}

{{Form::label('idAutor', 'Autor')}}
{{Form::text('idAutor', '', ['class'=>'form-control', 'required', 'placeholder' =>'Selecione um Autor','list'=>'listautores'])}} 
    <datalist id='listautores'>
        @foreach($autores as $autor)  
            <option value="{{$autor->id}}">{{$autor->nome}}</option>
        @endforeach
    </datalist>

{{Form::label('portal', 'Portal de Notícia')}}
{{Form::text('portal', '', ['class'=>'form-control', 'required', 'placeholder' =>'Portal de Notícia'])}}

{{Form::label('dataHora', 'Data')}}
{{Form::text('dataHora', \Carbon\Carbon::now()->format('d/m/Y H:i:s'),['class'=>'form-control', 'required', 'placeholder' =>'data', 'rows'=>'8'])}}

{{Form::label('obs', 'obs')}}
{{Form::text('obs', '', ['class'=>'form-control', 'required', 'placeholder' =>'Observações'])}}

{{Form::label('foto', 'Foto')}}
{{Form::file('foto',['class'=>'form-control','id'=>'foto'])}}

<br>
{{Form::submit('Salvar', ['class'=>'btn btn-success'])}}
{!!Form::button('Cancelar', ['onclick'=>'javascript:history.go(-1)','class'=> 'btn btn-danger'])!!}
{{Form::close()}}
@endsection