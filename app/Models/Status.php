<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Classe que representa o modelo de Status.
 */
class Status extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_status';

    /**
     * Nome da chave primária do modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_status';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'descricao',
    ];

    /**
     * Define o relacionamento com a tabela de processos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processos()
    {
        return $this->hasMany(Processo::class, 'id_status');
    }
}
