<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Pedido;
use App\Entidades\Categoria;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{

      public function nuevo()
      {
            $titulo = "Nuevo producto";
            $producto = new Producto();

            $categoria = new Categoria();
            $aCategorias = $categoria->obtenerTodos();
            return view("sistema.producto-nuevo", compact("titulo", "aCategorias", 'producto'));
      }

      public function index()
      {
            $titulo = "Listado de productos";
            return view("sistema.producto-listar", compact("titulo"));
      }

      public function cargarGrilla(Request $request)
      {
            $request = $_REQUEST;

            $entidad = new Producto();
            $aProductos = $entidad->obtenerFiltrado();

            $data = array();
            $cont = 0;

            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];


            for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = "<a href='/admin/producto/".$aProductos[$i]->idproducto ."'>" .$aProductos[$i]->titulo . "</a>";
                  $row[] = $aProductos[$i]->imagen;
                  $row[] = $aProductos[$i]->precio;
                  $row[] = $aProductos[$i]->cantidad;
                  $row[] = $aProductos[$i]->descripcion;
                  $row[] = $aProductos[$i]->fk_idtipoproducto;
                  $cont++;
                  $data[] = $row;
            }

            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
                  "data" => $data,
            );
            return json_encode($json_data);
      }

      public function editar($idProducto){
            $titulo = "Edicion de producto";
            $producto = new Producto();
            $producto->obtenerPorId($idProducto);
            
            $categoria = new Categoria();
            $aCategorias = $categoria->obtenerTodos();
            return view("sistema.producto-nuevo", compact("titulo", "producto", "aCategorias"));
      }

      public function guardar(Request $request)
      {
            try {
                  //Define la entidad producto
                  $titulo = "Modificar producto";
                  $entidad = new Producto();
                  $entidad->cargarDesdeRequest($request);

                  //validaciones
                  if ($entidad->titulo == "" || $entidad->precio == "" || $entidad->cantidad == "") {
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

                        $_POST["id"] = $entidad->idproducto;
                        return view('sistema.producto-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idproducto;
            $producto = new Producto();
            $producto->obtenerPorId($id);

            $categoria = new Categoria();
            $aCategorias = $categoria->obtenerTodos();

            return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo', 'aCategorias')) . '?id=' . $producto->idproducto;
      }

      public function eliminar(Request $request)
      {
            $idProducto = $request->input('id');
            $pedido = new Pedido();

            //Si el cliente tiene algun pedido asociado no puede eliminar
            if($pedido->existePedidosPorProducto($idProducto)){
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "No se puede eliminar un producto con pedidos asociados.";
            } else {
                  //Sino si
                  $producto = new Producto();
                  $producto->idproducto = $idProducto;
                  $producto->eliminar();
                  $resultado["err"] = EXIT_SUCCESS;
                  $resultado["mensaje"] = "Registro eliminado exitosamente.";
            }
            return json_encode($resultado);
      }
}
