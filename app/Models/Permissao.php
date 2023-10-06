<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FuncoesPermissoes;

class Permissao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tab_permissoes';

    protected $fillable = [
        'resource',
        'action',
    ];

    public function funcoesPermissoes()
    {
        return $this->belongsToMany(FuncoesPermissoes::class, 'tab_funcoes_permissoes', 'permissao_id', 'id_perfil');
    }
}
