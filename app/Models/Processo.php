<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Response;

/**
 * Classe que representa o modelo de Processo.
 */
class Processo extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'tab_processo';

    /**
     * Nome da chave primária do modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_processo';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'id_advogado',
        'id_cliente',
        'num_processo_sei',
        'id_status',
        'observacao',
    ];

    /**
     * Define um evento que é acionado antes de salvar um registro.
     *
     * Verifica se o perfil do advogado e do cliente associados ao processo é válido.
     *
     * @throws \Exception Em caso de restrição de chave estrangeira violada.
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($processo) {
            $perfilAdvogado = $processo->advogado->id_perfil ?? null;
            $perfilCliente = $processo->cliente->id_perfil ?? null;
            if ($perfilAdvogado !== 2 || $perfilCliente !== 3) {
                throw new \Exception('Restrição de chave estrangeira violada', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });
    }

    /**
     * Define o relacionamento com a tabela de advogados (Usuários).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function advogado()
    {
        return $this->belongsTo(User::class, 'id_advogado');
    }

    /**
     * Define o relacionamento com a tabela de clientes (Usuários).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente');
    }

    /**
     * Define o relacionamento com a tabela de status de processos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
}
