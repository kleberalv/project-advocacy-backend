<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPerfil extends Model
{
    use HasFactory;

    protected $table = 'tab_tipo_perfil';
    protected $primaryKey = 'id_tipo_perfil';

    protected $fillable = [
        'nome_perfil'
    ];
}
