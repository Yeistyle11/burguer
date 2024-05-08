<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
      protected $table = 'pedidos';
      public $timestamps = false;

      protected $fillable = [ //Son los campos de la tabla pedidos en la BBDD
            'idpedido', 'fk_idcliente', 'fk_idsucursal', 'fk_idestadopedido', 'fecha', 'total'
      ];

      protected $hidden = [];

      public function cargarDesdeRequest($request)
      {
            $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
            $this->fk_idcliente = $request->input('lstCliente');
            $this->fk_idsucursal = $request->input('lstSucursal');
            $this->fk_idestadopedido = $request->input('lstEstadoPedido');
            $this->fecha = $request->input('txtFecha');
            $this->total = $request->input('txtTotal');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                        idpedido,
                        fk_idcliente,
                        fk_idsucursal,
                        fk_idestadopedido,
                        fecha,
                        total
                  FROM pedidos ORDER BY fecha DESC";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idPedido)
      {
            $sql = "SELECT 
                        idpedido,
                        fk_idcliente,
                        fk_idsucursal,
                        fk_idestadopedido,
                        fecha,
                        total
                  FROM pedidos WHERE idpedido = $idPedido";
            $lstRetorno = DB::select($sql);

            if (count($lstRetorno) > 0) {
                  $this->idpedido = $lstRetorno[0]->idpedido;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
                  $this->fk_idestadopedido = $lstRetorno[0]->fk_idestadopedido;
                  $this->fecha = $lstRetorno[0]->fecha;
                  $this->total = $lstRetorno[0]->total;
                  return $this;
            }
            return null;
      }

      public function guardar()
      {
            $sql = "UPDATE pedidos SET
                        fk_idcliente=$this->fk_idcliente,
                        fk_idsucursal=$this->fk_idsucursal,
                        fk_idestadopedido=$this->fk_idestadopedido,
                        =$this->fecha,
                        total=$this->total
                  WHERE idpedido=?";
            $affected = DB::update($sql, [$this->idpedido]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM pedidos WHERE idpedido=?";
            $affected = DB::delete($sql, [$this->idpedido]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO pedidos (
                        fk_idcliente,
                        fk_idsucursal,
                        fk_idestadopedido,
                        fecha,
                        total
                  ) VALUES (?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->fk_idcliente,
                  $this->fk_idsucursal,
                  $this->fk_idestadopedido,
                  $this->fecha,
                  $this->total,
            ]);
            return $this->idpedido = DB::getPdo()->lastInsertId();
      }

      public function obtenerFiltrado()
      {
            $request = $_REQUEST;
            $columns = array(
                  0 => 'fk_idcliente',
                  1 => 'fk_idsucursal',
                  2 => 'fk_idestadopedido',
                  3 => 'fecha',
                  4 => 'total'
            );
            $sql = "SELECT DISTINCT
                        A.idpedido,
                        A.fk_idcliente,
                        A.fk_idsucursal,
                        A.fk_idestadopedido,
                        A.fecha,
                        A.total,
                        C.nombre AS cliente,
                        B.nombre AS sucursal,
                        D.nombre AS estado_del_pedido
                  FROM pedidos A
                  INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
                  INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                  INNER JOIN estado_pedidos D ON A.fk_idestadopedido = D.idestadopedido
                  WHERE 1=1";

            //Realiza el filtrado
            if (!empty($request['search']['value'])) {
                  $sql .= " AND ( fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
                  $sql .= " OR fk_idsucursal LIKE '%" . $request['search']['value'] . "%' ";
                  $sql .= " OR fk_idestadopedido LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR fecha LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR total LIKE '%" . $request['search']['value'] . "%' )";
            }
            $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

            $lstRetorno = DB::select($sql);

            return $lstRetorno;
      }

      public function existePedidosPorCliente($idCliente)
      {
            $sql = "SELECT
                        idpedido,
                        fk_idcliente,
                        fk_idsucursal,
                        fk_idestadopedido,
                        fecha,
                        total
                  FROM pedidos WHERE fk_idcliente = $idCliente";
            $lstRetorno = DB::select($sql);
            return (count($lstRetorno) > 0);
      }

      public function existePedidosPorProducto($idProducto)
      {
            $sql = "SELECT
                        idpedidoproducto,
                        fk_idproducto,
                        fk_idpedido
                  FROM pedido_productos WHERE fk_idproducto = $idProducto";
            $lstRetorno = DB::select($sql);
            return (count($lstRetorno) > 0);
      }

      public function existeSucursalPorPedido($idSucursal)
      {
            $sql = "SELECT
                        fk_idcliente,
                        fk_idsucursal,
                        fk_idestadopedido,
                        fecha,
                        total
                  FROM pedidos WHERE fk_idsucursal = $idSucursal";
            $lstRetorno = DB::select($sql);
            return (count($lstRetorno) > 0);
      }
}
