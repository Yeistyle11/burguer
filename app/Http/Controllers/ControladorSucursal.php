<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorSucursal extends Controller
{

      public function nuevo()
      {
            $titulo = "Nueva sucursal";
            return view("sistema.sucursal-nuevo", compact("titulo"));
      }

      public function index()
      {
            $titulo = "Listado de sucursales";
            return view("sistema.sucursal-listar", compact("titulo"));
      }

      public function cargarGrilla(Request $request)
      {
            $request = $_REQUEST;

            $entidad = new Sucursal();
            $aSucursales = $entidad->obtenerFiltrado();

            $data = array();
            $cont = 0;

            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];


            for ($i = $inicio; $i < count($aSucursales) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = "<a href='".$aSucursales[$i]->idsucursal ."'>" .$aSucursales[$i]->nombre . "</a>";
                  $row[] = $aSucursales[$i]->direccion;
                  $row[] = $aSucursales[$i]->telefono;
                  $row[] = $aSucursales[$i]->linkmapa;
                  $row[] = $aSucursales[$i]->horario;
                  $cont++;
                  $data[] = $row;
            }

            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aSucursales), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aSucursales), //cantidad total de registros en la paginacion
                  "data" => $data,
            );
            return json_encode($json_data);
      }


      public function guardar(Request $request)
      {
            try {
                  //Define la entidad sucursal
                  $titulo = "Modificar sucursal";
                  $entidad = new Sucursal();
                  $entidad->cargarDesdeRequest($request);

                  //validaciones
                  if ($entidad->nombre == "" || $entidad->linkmapa == "") {
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

                        $_POST["id"] = $entidad->idsucursal;
                        return view('sistema.sucursal-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idsucursal;
            $sucursal = new Sucursal();
            $sucursal->obtenerPorId($id);

            return view('sistema.sucursal-nuevo', compact('msg', 'sucursal', 'titulo')) . '?id=' . $sucursal->idsucursal;
      }
}
