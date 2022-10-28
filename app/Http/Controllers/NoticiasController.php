<?php

namespace App\Http\Controllers;

use App\Models\Noticias;
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
        $noticias = Noticias::where('titulo','LIKE','%'.$request->input('busca').'%')->orwhere('autor','LIKE','%'.$request->input('busca').'%')->paginate(5);
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
            return view('contato.create');
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
                'autor' => 'required',
                'portal' => 'required',
                'dataHora' => 'required',
                'obs' => 'required',
            ]);
            $noticia = new Noticias();
            $noticia->titulo = $request->input('titulo');
            $noticia->autor = $request->input('autor');
            $noticia->portal = $request->input('portal');
            $noticia->dataHora = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->input('dataHora'));
            $noticia->obs = $request->input('obs');
            if($noticia->save()) {
                if($request->hasFile('foto')){
                    $imagem = $request->file('foto');
                    $nomearquivo = md5($noticia->id).".".$imagem->getClientOriginalExtension();
                    //dd($imagem, $nomearquivo,$contato->id);
                    $request->file('foto')->move(public_path('.\img\contatos'),$nomearquivo);
                }
                return redirect('contatos');
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
        $contato = Noticias::find($id);
        return view('contato.show',array('contato' => $contato));
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
            $contato = Noticias::find($id);
            return view('contato.edit',array('contato' => $contato));
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
                'nome' => 'required|min:3',
                'email' => 'required|e-mail|min:3',
                'telefone' => 'required',
                'cidade' => 'required',
                'estado' => 'required',
            ]);
            $contato = Noticias::find($id);
            if($request->hasFile('foto')){
                $imagem = $request->file('foto');
                $nomearquivo = md5($contato->id).".".$imagem->getClientOriginalExtension();
                $request->file('foto')->move(public_path('.\img\contatos'),$nomearquivo);
            }
            $contato->nome = $request->input('nome');
            $contato->email = $request->input('email');
            $contato->telefone = $request->input('telefone');
            $contato->cidade = $request->input('cidade');
            $contato->estado = $request->input('estado');
            if($contato->save()) {
                Session::flash('mensagem','Contato alterado com sucesso');
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
            $contato = Noticias::find($id);
            if (isset($request->foto)) {
            unlink($request->foto);
            }
            $contato->delete();
            Session::flash('mensagem','Contato Excluído com Sucesso Foto:');
            return redirect(url('contatos/'));
        } else {
            return redirect('login');
        }
    }
}
