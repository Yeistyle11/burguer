<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado_pedido extends Model
{
      protected $table = 'estado_pedidos';
      public $timestamps = false;

      protected $fillable = [ //Son los campos de la tabla estado_pedidos en la BBDD
            'idestadopedido', 'nombre'
      ];

      protected $hidden = [];

      public function obtenerTodos()
      {
            $sql = "SELECT
                        idestadopedido,
                        nombre
                  FROM estado_pedidos ORDER BY nombre ASC";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idEstadoPedido)
      {
            $sql = "SELECT
                        idestadopedido,
                        nombre
                  FROM estado_pedidos WHERE idestadopedido = $idEstadoPedido";
            $lstRetorno = DB::select($sql);

            if (count($lstRetorno) > 0) {
                  $this->idestadopedido = $lstRetorno[0]->idestadopedido;
                  $this->nombre = $lstRetorno[0]->nombre;
                  return $this;
            }
            return null;
      }

      public function guardar()
      {
            $sql = "UPDATE estado_pedidos SET
                        nombre='$this->nombre'
                  WHERE idestadopedido=?";
            $affected = DB::update($sql, [$this->idestadopedido]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM estado_pedidos WHERE idestadopedido=?";
            $affected = DB::delete($sql, [$this->idestadopedido]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO estado_pedidos (
                        nombre
                  ) VALUES (?);";
            $result = DB::query($sql, [
                  $this->nombre,
            ]);
            return $this->idestadopedido = DB::getPdo()->lastInsertId();
      }
}
