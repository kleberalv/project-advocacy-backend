<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe que representa o modelo de TipoPerfil.
 */
class TipoPerfil extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_tipo_perfil';

    /**
     * Nome da chave primária do modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_tipo_perfil';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'nome_perfil'
    ];
}
