<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Proveedor;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorProveedor extends Controller
{

      public function nuevo()
      {
            $titulo = "Nuevo proveedor";
            return view("sistema.proveedor-nuevo", compact("titulo"));
      }

      public function guardar(Request $request)
      {
            try {
                  //Define la entidad cliente
                  $titulo = "Modificar proveedor";
                  $entidad = new Proveedor();
                  $entidad->cargarDesdeRequest($request);
      
                  //validaciones
                  if ($entidad->nombre == "" || $entidad->dni == "") {
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

                      $_POST["id"] = $entidad->idproveedor;
                      return view('sistema.proveedor-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idproveedor;
            $proveedor = new Proveedor();
            $proveedor->obtenerPorId($id);

            return view('sistema.proveedor-nuevo', compact('msg', 'proveedor', 'titulo')) . '?id=' . $proveedor->idproveedor;
      }
}

?>
