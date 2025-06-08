<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Cliente;

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
        return view('web.registrarse');
    }

    public function registrarse(Request $request)
    {
        $cliente = new Cliente();
        $cliente->cargarDesdeRequest($request);
        $cliente->clave = password_hash($request->input('txtClave'), PASSWORD_DEFAULT);
        $cliente->insertar();
        
        $correo = trim(strtolower($request->input('txtCorreo')));

        return redirect('/login')->with('mensaje', '¡Registro exitoso! Ahora puedes iniciar sesión.');
    }
}