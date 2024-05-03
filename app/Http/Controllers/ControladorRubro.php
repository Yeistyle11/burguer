<?php

namespace App\Http\Controllers;

use App\Entidades\Rubro;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorRubro extends Controller
{

      public function nuevo()
      {
            $titulo = "Nuevo rubro";
            return view("sistema.rubro-nuevo", compact("titulo"));
      }

      public function guardar(Request $request)
      {
            try {
                  //Define la entidad cliente
                  $titulo = "Modificar rubro";
                  $entidad = new Rubro();
                  $entidad->cargarDesdeRequest($request);
      
                  //validaciones
                  if ($entidad->nombre == "") {
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";
                  } else {
                      if ($_POST["id"] > 0) {
                          //Es actualizacion
                          $entidad->guardar();
      
                          $msg["ESTADO"] = MSG_SUCCESS;
                          $msg["MSG"] = OKINSERT;
                      } else {
                          //Es nuevo
                          $entidad->insertar();
      
                          $msg["ESTADO"] = MSG_SUCCESS;
                          $msg["MSG"] = OKINSERT;
                      }

                      $_POST["id"] = $entidad->idrubro;
                      return view('sistema.rubro-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idrubro;
            $rubro = new Rubro();
            $rubro->obtenerPorId($id);

            return view('sistema.rubro-nuevo', compact('msg', 'rubro', 'titulo')) . '?id=' . $rubro->idrubro;
      }
}

?>
