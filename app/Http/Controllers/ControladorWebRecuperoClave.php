<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ControladorWebRecuperoClave extends Controller
{
    public function mostrarFormulario()
    {
        return view('web.recupero-clave');
    }

    public function enviarRecupero(Request $request)
    {
        $correo = $request->input('correo');
        Mail::raw('Este es un correo de recuperación de contraseña.', function ($message) use ($correo) {
            $message->to($correo)
                    ->subject('Recuperación de contraseña');
        });

        return back()->with('mensaje', 'Si el correo existe, recibirás instrucciones para recuperar tu contraseña.');
    }
}