<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Cliente;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {
        $nombre = session('cliente_logueado');
        $cliente = null;

        if ($nombre) {
            $cliente = Cliente::where('nombre', $nombre)->first();
        }

        return view('web.mi-cuenta', compact('cliente'));
    }

    public function actualizar(Request $request)
    {
        $nombre = session('cliente_logueado');
        $cliente = Cliente::where('nombre', $nombre)->first();

        if ($cliente) {
            $cliente->nombre = $request->input('nombre');
            $cliente->telefono = $request->input('telefono');
            $cliente->direccion = $request->input('direccion');
            $cliente->dni = $request->input('dni');
            $cliente->correo = $request->input('correo');

            // Validar y actualizar contraseña solo si se envió
            $password = $request->input('password');
            $password_confirmation = $request->input('password_confirmation');
            if ($password || $password_confirmation) {
                if ($password !== $password_confirmation) {
                    return redirect('/mi-cuenta')->with('error', 'Las contraseñas no coinciden.');
                }
                $cliente->clave = password_hash($password, PASSWORD_DEFAULT);
            }

            $cliente->save();

            // Actualiza el nombre en sesión si fue cambiado
            session(['cliente_logueado' => $cliente->nombre]);

            return redirect('/mi-cuenta')->with('mensaje', 'Datos actualizados correctamente.');
        } else {
            return redirect('/mi-cuenta')->with('error', 'No se pudo actualizar la información.');
        }
    }
}