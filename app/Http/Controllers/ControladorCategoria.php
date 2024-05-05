<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller
{

      public function nuevo()
      {
            $titulo = "Nueva categoria";
            return view("sistema.categoria-nuevo", compact("titulo"));
      }

      public function index()
      {
            $titulo = "Listado de categorias";
            return view("sistema.categoria-listar", compact("titulo"));
      }

      public function cargarGrilla(Request $request)
      {
            $request = $_REQUEST;

            $entidad = new Categoria();
            $aCategoria = $entidad->obtenerFiltrado();

            $data = array();
            $cont = 0;

            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];


            for ($i = $inicio; $i < count($aCategoria) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = "<a href='".$aCategoria[$i]->idtipoproducto ."'>" .$aCategoria[$i]->nombre . "</a>";
                  $cont++;
                  $data[] = $row;
            }

            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aCategoria), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aCategoria), //cantidad total de registros en la paginacion
                  "data" => $data,
            );
            return json_encode($json_data);
      }


      public function guardar(Request $request)
      {
            try {
                  //Define la entidad categoria
                  $titulo = "Modificar categoria";
                  $entidad = new Categoria();
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

                        $_POST["id"] = $entidad->idtipoproducto;
                        return view('sistema.categoria-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idtipoproducto;
            $categoria = new Categoria();
            $categoria->obtenerPorId($id);

            return view('sistema.categoria-nuevo', compact('msg', 'categoria', 'titulo')) . '?id=' . $categoria->idtipoproducto;
      }
}
