<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Processo extends Model
{
    use HasFactory;
    protected $table = 'tab_processo';
    protected $primaryKey = 'id_processo';
    protected $fillable = [
        'id_usuario',
        'num_processo_sei',
        'id_status',
        'observacao',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($processo) {
            if ($processo->id_advogado !== 2 || $processo->id_cliente !== 3) {
                throw new \Exception('Restrição de chave estrangeira violada.');
            }
        });
    }
}

