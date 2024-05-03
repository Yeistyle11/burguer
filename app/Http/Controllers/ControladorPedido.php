<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Estado_pedido;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{

      public function nuevo()
      {
            $titulo = "Nuevo pedido";
            $cliente = new Cliente();
            $aClientes = $cliente->obtenerTodos();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $estado_pedido = new Estado_Pedido();
            $aEstadoPedidos = $estado_pedido->obtenerTodos();
            return view("sistema.pedido-nuevo", compact("titulo", "aClientes", "aSucursales", "aEstadoPedidos"));
      }

      public function index()
      {
            $titulo = "Listado de pedidos";
            return view("sistema.pedido-listar", compact("titulo"));
      }

      public function guardar(Request $request)
      {
            try {
                  //Define la entidad pedido
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
}
