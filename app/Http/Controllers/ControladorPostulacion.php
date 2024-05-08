<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller
{

      public function nuevo()
      {
            $titulo = "Nueva postulacion";
            $postulacion = new Postulacion();
            return view("sistema.postulacion-nuevo", compact("titulo", 'postulacion'));
      }

      public function index()
      {
            $titulo = "Listado de postulaciones";
            return view("sistema.postulacion-listar", compact("titulo"));
      }

      public function cargarGrilla(Request $request)
      {
            $request = $_REQUEST;

            $entidad = new Postulacion();
            $aPostulaciones = $entidad->obtenerFiltrado();

            $data = array();
            $cont = 0;

            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];


            for ($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = "<a href='/admin/postulacion/".$aPostulaciones[$i]->idpostulacion ."'>" .$aPostulaciones[$i]->nombre . "</a>";
                  $row[] = $aPostulaciones[$i]->apellido;
                  $row[] = $aPostulaciones[$i]->whatsapp;
                  $row[] = $aPostulaciones[$i]->correo;
                  $row[] = "<a href=''> Descargar </a>";
                  $cont++;
                  $data[] = $row;
            }

            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aPostulaciones), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aPostulaciones), //cantidad total de registros en la paginacion
                  "data" => $data,
            );
            return json_encode($json_data);

      }

      public function editar($idPostulacion){
            $titulo = "Edicion de postulacion";
            $postulacion = new Postulacion();
            $postulacion->obtenerPorId($idPostulacion);
            return view("sistema.postulacion-nuevo", compact("titulo", "postulacion"));
      }


      public function guardar(Request $request)
      {
            try {
                  //Define la entidad postulacion
                  $titulo = "Modificar postulacion";
                  $entidad = new Postulacion();
                  $entidad->cargarDesdeRequest($request);

                  //validaciones
                  if ($entidad->nombre == "" || $entidad->linkcv == "") {
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

                        $_POST["id"] = $entidad->idpostulacion;
                        return view('sistema.postulacion-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idpostulacion;
            $postulacion = new Postulacion();
            $postulacion->obtenerPorId($id);

            return view('sistema.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) . '?id=' . $postulacion->idpostulacion;
      }

      public function eliminar(Request $request)
      {
            $postulacion = new Postulacion();
            $postulacion->idpostulacion = $request->input("id");
            $postulacion->eliminar();
            $resultado["err"] = EXIT_SUCCESS;
            $resultado["mensaje"] = "Registro eliminado exitosamente.";
            return json_encode($resultado);
      }
}
