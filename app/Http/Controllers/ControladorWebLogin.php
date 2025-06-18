<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Cliente;

class ControladorWebLogin extends Controller
{
    public function index()
    {
        return view('web.login');
    }

    public function ingresar(Request $request)
    {
        $correo = trim(strtolower($request->input('txtCorreo')));
        $clave = $request->input('txtClave');

        $cliente = Cliente::where('correo', $correo)->first();

        if ($cliente && password_verify($clave, $cliente->clave)) {
            session(['cliente_logueado' => $cliente->nombre, 'id_cliente_logueado' => $cliente->idcliente]);
            return redirect('/')->with('mensaje', '¡Bienvenido, ' . $cliente->nombre . '!');
        } else {
            // Error: vuelve al login con mensaje de error
            return back()->with('error', 'Correo o contraseña incorrectos.');
        }
    }

    public function salir()
    {
        session()->forget('cliente_logueado');
        // Si guardas más datos en sesión, puedes usar session()->flush();
        return redirect('/')->with('mensaje', 'Sesión cerrada correctamente.');
    }
}