<?php

namespace App\Http\Controllers;

use App\Models\Noticias;
use App\Models\Autores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class NoticiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Noticias::paginate(5);
        return view('noticias.index',array('noticias' => $noticias,'busca'=>null));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request) {
        $noticias = Noticias::where('titulo','LIKE','%'.$request->input('busca').'%')->orwhere('idAutor','LIKE','%'.$request->input('busca').'%')->paginate(5);
        return view('noticias.index',array('noticias' => $noticias,'busca'=>$request->input('busca')));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $autores = Autores::all();
            return view('noticias.create',['autores'=>$autores]);
        }
        else {
            return redirect('login');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $this->validate($request,[
                'titulo' => 'required',
                'idAutor' => 'required',
                'portal' => 'required',
                'dataHora' => 'required',
                'obs' => 'required',
            ]);
            $noticia = new Noticias();
            $noticia->titulo = $request->input('titulo');
            $noticia->idAutor = $request->input('idAutor');
            $noticia->portal = $request->input('portal');
            $noticia->dataHora = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->input('dataHora'));
            $noticia->obs = $request->input('obs');
            if($noticia->save()) {
                if($request->hasFile('foto')){
                    $imagem = $request->file('foto');
                    $nomearquivo = md5($noticia->id).".".$imagem->getClientOriginalExtension();
                    //dd($imagem, $nomearquivo,$contato->id);
                    $request->file('foto')->move(public_path('.\img\noticias'),$nomearquivo);
                }
                return redirect('noticias');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noticia = Noticias::find($id);
        return view('noticias.show',array('noticia' => $noticia));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $noticia = Noticias::find($id);
            $autores = Autores::all();
            return view('noticias.edit',array('noticia' => $noticia,'autores'=>$autores));
        } else {
            return redirect('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $this->validate($request,[
                'titulo' => 'required',
                'idAutor' => 'required',
                'portal' => 'required',
                'dataHora' => 'required',
                'obs' => 'required',
            ]);
            $noticia = Noticias::find($id);
            if($request->hasFile('foto')){
                $imagem = $request->file('foto');
                $nomearquivo = md5($noticia->id).".".$imagem->getClientOriginalExtension();
                $request->file('foto')->move(public_path('.\img\noticias'),$nomearquivo);
            }
            $noticia->titulo = $request->input('titulo');
            $noticia->idAutor = $request->input('idAutor');
            $noticia->portal = $request->input('portal');
            $noticia->dataHora = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->input('dataHora'));
            $noticia->obs = $request->input('obs');
            if($noticia->save()) {
                Session::flash('mensagem','Noticia alterado com sucesso');
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $noticia = Noticias::find($id);
            if (isset($request->foto)) {
            unlink($request->foto);
            }
            $noticia->delete();
            Session::flash('mensagem','Notícia Excluído com Sucesso Foto:');
            return redirect(url('noticias/'));
        } else {
            return redirect('login');
        }
    }
}
