<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FuncoesPermissoes;

/**
 * Classe que representa o modelo de Permissao.
 */
class Permissao extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_permissoes';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'resource',
        'action',
    ];

    /**
     * Define o relacionamento muitos para muitos (belongsToMany) com a tabela de FuncoesPermissoes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function funcoesPermissoes()
    {
        return $this->belongsToMany(FuncoesPermissoes::class, 'tab_funcoes_permissoes', 'permissao_id', 'id_perfil');
    }
}
