<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processo;

class ProcessoController extends Controller
{
    public function index(){
        return Processo::all();
    }
}
