<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Postulacion;

class ControladorWebPostulacion extends Controller
{
    public function index()
    {
        return view('web.postulacion');
    }

    public function guardar(Request $request)
    {
        $postulacion = new Postulacion();
        $postulacion->nombre = $request->input('txtNombre');
        $postulacion->apellido = $request->input('txtApellido');
        $postulacion->whatsapp = $request->input('txtWhatsapp');
        $postulacion->correo = $request->input('txtCorreo');

        // Manejo de archivo o link
        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $archivo = $request->file('cv');
            $nombre = time() . '-' . $archivo->getClientOriginalName();
            $archivo->move(public_path('cv'), $nombre);
            $postulacion->linkcv = url('cv/' . $nombre);
        } elseif ($request->filled('txtLinkCV')) {
            $postulacion->linkcv = $request->input('txtLinkCV');
        } else {
            return back()->with('error', 'Debes adjuntar tu hoja de vida o un enlace.');
        }

        $postulacion->insertar();

        return redirect('/postulacion-gracias');
    }
}