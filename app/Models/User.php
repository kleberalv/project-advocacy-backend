<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    // nome da tabela no banco de dados
    protected $table = 'tab_usuarios';

    protected $fillable = [
        'nome',
        'cpf',
        'senha',
        'email',
        'dat_nasc',
        'id_perfil',
        'endereco'
    ];
}
