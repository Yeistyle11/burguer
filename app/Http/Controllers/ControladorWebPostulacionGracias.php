<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Postulacion;

class ControladorWebPostulacionGracias extends Controller
{
    public function index()
    {
        return view('web.postulacion-gracias');
    }
}