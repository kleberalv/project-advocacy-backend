<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'tab_status';
    protected $primaryKey = 'id_status';

    protected $fillable = [
        'status',
        'descricao',
    ];
}
