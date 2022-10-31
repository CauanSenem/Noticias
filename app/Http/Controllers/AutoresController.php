<?php

namespace App\Http\Controllers;

use App\Models\Autores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AutoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autores = Autores::paginate(5);
        return view('autores.index',array('autores' => $autores,'busca'=>null));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request) {
        $autores = Autores::where('nome','LIKE','%'.$request->input('busca').'%')->orwhere('email','LIKE','%'.$request->input('busca').'%')->paginate(5);
        return view('autores.index',array('autores' => $autores,'busca'=>$request->input('busca')));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            return view('autores.create');
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
                'nome' => 'required',
                'telefone' => 'required',
                'email' => 'required',
                'dataHora' => 'required',
            ]);
            $autor = new Autores();
            $autor->nome = $request->input('nome');
            $autor->telefone = $request->input('telefone');
            $autor->email = $request->input('email');
            $autor->dataHora = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->input('dataHora'));
            if($autor->save()) {
                if($request->hasFile('foto')){
                    $imagem = $request->file('foto');
                    $nomearquivo = md5($autor->id).".".$imagem->getClientOriginalExtension();
                    //dd($imagem, $nomearquivo,$contato->id);
                    $request->file('foto')->move(public_path('.\img\autores'),$nomearquivo);
                }
                return redirect('autores');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Autores  $autores
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $autor = Autores::find($id);
        return view('autores.show',array('autor' => $autor));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Autores  $autores
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $autor = Autores::find($id);
            return view('autores.edit',array('autor' => $autor));
        } else {
            return redirect('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autores  $autores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $this->validate($request,[
                'nome' => 'required',
                'telefone' => 'required',
                'email' => 'required',
                'dataHora' => 'required',
            ]);
            $autor = Autores::find($id);
            if($request->hasFile('foto')){
                $imagem = $request->file('foto');
                $nomearquivo = md5($autor->id).".".$imagem->getClientOriginalExtension();
                $request->file('foto')->move(public_path('.\img\autores'),$nomearquivo);
            }
            $autor->nome = $request->input('nome');
            $autor->telefone = $request->input('telefone');
            $autor->email = $request->input('email');
            $autor->dataHora = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->input('dataHora'));
            if($autor->save()) {
                Session::flash('mensagem','Autor alterado com sucesso');
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Autores  $autores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $autor = Autores::find($id);
            if (isset($request->foto)) {
            unlink($request->foto);
            }
            $autor->delete();
            Session::flash('mensagem','Autor excluído com Sucesso Foto:');
            return redirect(url('autores/'));
        } else {
            return redirect('login');
        }
    }
}
