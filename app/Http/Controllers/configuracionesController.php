<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class configuracionesController extends Controller
{
    public function index()
    {
        return view('PRINCIPAL.configuraciones');
    }
}
