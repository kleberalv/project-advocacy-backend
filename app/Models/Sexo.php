<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Classe que representa o modelo de Sexo.
 */
class Sexo extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_sexo';

    /**
     * Nome da chave primária do modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_sexo';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'nome_sexo',
    ];

    /**
     * Define o relacionamento com a tabela de processos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sexos()
    {
        return $this->hasMany(Processo::class, 'id_sexo');
    }
}
