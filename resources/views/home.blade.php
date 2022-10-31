@extends('layouts.app')
@section('title','Biblioteca')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11 bg-secondary text-light">
            <div class="fluid px-3 my-2 h4">{{ __('Principais Notícias') }}</div>
            <div class="row text-center">
                <div class="col m-3 bg-light text-black">
                    <div class="card-header p-2 h5">Notícias</div>
                    <div class="card-body ">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Id</th>
                                <th>Titulo</th>
                                <th>Autor</th>
                                <th>Portal de Notícia</th>
                                <th>Data e Hora</th>
                            </tr>
                            @foreach ($noticia as $noticia)
                            <tr>
                                <td>
                                   {{$noticia->id}}
                                </td>
                                <td>
                                    <a href="{{url('noticias/'.$noticia->id)}}">{{$noticia->titulo}}</a>
                                 </td>
                                <td>
                                    {{$noticia->idAutor}} - {{$noticia->autor->nome}}
                                </td>
                                <td>
                                    {{$noticia->portal}}
                                </td>
                                <td>
                                    {{\Carbon\Carbon::create($noticia->dataHora)->format('d/m/Y H:i:s')}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
        </div>
    </div>
@endsection