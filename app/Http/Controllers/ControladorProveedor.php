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

      public function index()
      {
            $titulo = "Listado de proveedores";
            return view("sistema.proveedor-listar", compact("titulo"));
      }

      public function cargarGrilla(Request $request)
      {
            $request = $_REQUEST;

            $entidad = new Proveedor();
            $aProveedores = $entidad->obtenerFiltrado();

            $data = array();
            $cont = 0;

            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];


            for ($i = $inicio; $i < count($aProveedores) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = "<a href='".$aProveedores[$i]->idproveedor ."'>" .$aProveedores[$i]->nombre . "</a>";
                  $row[] = $aProveedores[$i]->dni;
                  $row[] = $aProveedores[$i]->telefono;
                  $row[] = $aProveedores[$i]->correo;
                  $cont++;
                  $data[] = $row;
            }

            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aProveedores), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aProveedores), //cantidad total de registros en la paginacion
                  "data" => $data,
            );
            return json_encode($json_data);
      }


      public function guardar(Request $request)
      {
            try {
                  //Define la entidad proveedor
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
