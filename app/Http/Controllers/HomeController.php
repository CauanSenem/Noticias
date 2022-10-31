<?php

namespace App\Http\Controllers;

use App\Models\Noticias;
use App\Models\Autores;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $noticia = Noticias::all();
        return view('home',array('noticia'=>$noticia));
    }
}
