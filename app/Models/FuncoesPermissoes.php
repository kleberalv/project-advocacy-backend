<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Permissao;

class FuncoesPermissoes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tab_funcoes_permissoes';

    protected $fillable = [
        'id_perfil',
        'permissao_id',
    ];

    public function permissao()
    {
        return $this->belongsTo(Permissao::class, 'permissao_id');
    }
}
