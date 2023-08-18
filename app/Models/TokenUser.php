<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe que representa o modelo de tokens de usuários.
 *
 */
class TokenUser extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_tokens_users';

    /**
     * Nome da chave primária na tabela.
     *
     * @var string
     */
    protected $primaryKey = 'id_token';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'tokenable_type',
        'tokenable_id_usuario',
        'name_token',
        'token',
        'id_perfil_permissions',
        'expires_at',
    ];

    /**
     * Os atributos que devem ser tratados como datas.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
