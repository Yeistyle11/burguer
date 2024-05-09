<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Estado_pedido;
use App\Entidades\Sucursal;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{

      public function nuevo()
      {
            $titulo = "Nuevo pedido";
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                        $codigo = "CLIENTEALTA";
                        $mensaje = "No tiene permisos para la operacion.";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  } else {
                        $cliente = new Cliente();
                        $aClientes = $cliente->obtenerTodos();

                        $sucursal = new Sucursal();
                        $aSucursales = $sucursal->obtenerTodos();

                        $estado_pedido = new Estado_Pedido();
                        $aEstadoPedidos = $estado_pedido->obtenerTodos();

                        $pedido = new Pedido();
                        return view("sistema.pedido-nuevo", compact("titulo", "aClientes", "aSucursales", "aEstadoPedidos", 'pedido'));
                  }
            } else {
                  return redirect('admin/login');
            }
      }

      public function index()
      {
            $titulo = "Listado de pedidos";
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                        $codigo = "MENUCONSULTA";
                        $mensaje = "No tiene permisos para la operacion.";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  } else {
                        return view("sistema.pedido-listar", compact("titulo"));
                  }
            } else {
                  return redirect('admin/login');
            }
      }

      public function cargarGrilla(Request $request)
      {
            $request = $_REQUEST;

            $entidad = new Pedido();
            $aPedidos = $entidad->obtenerFiltrado();

            $data = array();
            $cont = 0;

            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];


            for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = "<a href='/admin/pedido/" . $aPedidos[$i]->idpedido . "'>" . $aPedidos[$i]->cliente . "</a>";
                  $row[] = $aPedidos[$i]->sucursal;
                  $row[] = $aPedidos[$i]->estado_del_pedido;
                  $row[] = $aPedidos[$i]->fecha;
                  $row[] = $aPedidos[$i]->total;
                  $cont++;
                  $data[] = $row;
            }

            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
                  "data" => $data,
            );
            return json_encode($json_data);
      }

      public function editar($idPedido)
      {
            $titulo = "Edicion de cliente";

            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                        $codigo = "CLIENTEEDITAR";
                        $mensaje = "No tiene permisos para la operacion.";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  } else {
                        $pedido = new Pedido();
                        $pedido->obtenerPorId($idPedido);

                        $cliente = new Cliente();
                        $aClientes = $cliente->obtenerTodos();

                        $sucursal = new Sucursal();
                        $aSucursales = $sucursal->obtenerTodos();

                        $estado_pedido = new Estado_Pedido();
                        $aEstadoPedidos = $estado_pedido->obtenerTodos();
                        return view("sistema.pedido-nuevo", compact("titulo", "pedido", "aClientes", "aSucursales", "aEstadoPedidos"));
                  }
            } else {
                  return redirect('admin/login');
            }
      }


      public function guardar(Request $request)
      {
            try {
                  //Define la entidad cliente
                  $titulo = "Modificar pedido";
                  $entidad = new Pedido();
                  $entidad->cargarDesdeRequest($request);

                  //validaciones
                  if ($entidad->fk_idcliente == "" || $entidad->fk_idsucursal == "" || $entidad->fk_idestadopedido == "" || $entidad->fecha == "" || $entidad->total == "") {
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

                        $_POST["id"] = $entidad->idpedido;
                        return view('sistema.pedido-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idpedido;
            $pedido = new Pedido();
            $pedido->obtenerPorId($id);

            return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo')) . '?id=' . $pedido->idpedido;
      }

      public function eliminar(Request $request)
      {
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTEELIMINAR")) {
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No tiene permisos para la operacion.";
                  } else {
                        $pedido = new Pedido();
                        $pedido->idpedido = $request->input("id");
                        $pedido->eliminar();
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Registro eliminado exitosamente.";
                  }
            } else {
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "Usuario no autenticado.";
            }
            return json_encode($resultado);
      }
}
