<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autores extends Model
{
    use HasFactory;
    public function noticia() {
        return $this->belongsTo(Noticias::class,'idAutor','id');
    }
}
