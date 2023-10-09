<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Permissao;

/**
 * Classe que representa o modelo de FuncoesPermissoes.
 */
class FuncoesPermissoes extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_funcoes_permissoes';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'id_perfil',
        'permissao_id',
    ];

    /**
     * Define o relacionamento com a tabela de permissões.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permissao()
    {
        return $this->belongsTo(Permissao::class, 'permissao_id');
    }
}
