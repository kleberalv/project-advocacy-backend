<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Classe que representa o modelo de usuário.
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_usuarios';

    /**
     * Nome da chave primária do modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'id_perfil',
        'id_sexo',
        'nome',
        'cpf',
        'senha',
        'email',
        'dat_nasc',
        'endereco',
    ];

    protected $hidden = ['senha'];

    /**
     * Obtém o identificador que será armazenado no token JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id_usuario;
    }

    /**
     * Define quais reivindicações personalizadas serão adicionadas ao token JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Obtém a senha do usuário para autenticação.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    /**
     * Define a senha do usuário, aplicando a função bcrypt para criptografia.
     *
     * @param string $value A senha do usuário.
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    /**
     * Define o relacionamento com a tabela de processos como advogado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processos()
    {
        return $this->hasMany(Processo::class, 'id_advogado');
    }
}
