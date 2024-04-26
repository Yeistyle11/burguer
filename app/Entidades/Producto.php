<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
      protected $table = 'productos';
      public $timestamps = false;

      protected $fillable = [ //Son los campos de la tabla productos de la BBDD
            'idproducto', 'titulo', 'precio', 'cantidad', 'descripcion', 'imagen', 'fk_idtipoproducto'
      ];

      protected $hidden = [];

      public function obtenerTodos()
      {
            $sql = "SELECT
                        idproducto,
                        titulo,
                        precio,
                        cantidad,
                        descripcion,
                        imagen,
                        fk_idtipoproducto
                  FROM productos ORDER BY titulo ASC";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idProducto)
      {
            $sql = "SELECT
                        idproducto,
                        titulo,
                        precio,
                        cantidad,
                        descripcion,
                        imagen,
                        fk_idtipoproducto
                  FROM productos WHERE idproducto = $idProducto";
            $lstRetorno = DB::select($sql);

            if (count($lstRetorno) > 0) {
                  $this->idproducto = $lstRetorno[0]->idproducto;
                  $this->titulo = $lstRetorno[0]->titulo;
                  $this->precio = $lstRetorno[0]->precio;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->descripcion = $lstRetorno[0]->descripcion;
                  $this->imagen = $lstRetorno[0]->imagen;
                  $this->fk_idtipoproducto = $lstRetorno[0]->fk_idtipoproducto;
                  return $this;
            }
            return null;
      }

      public function obtenerPorTipo($idTipoProducto)
      {
            $sql = "SELECT 
                        idproducto,
                        titulo,
                        precio,
                        cantidad,
                        descripcion,
                        imagen,
                        fk_idtipoproducto
                  FROM productos WHERE fk_idtipoproducto = $idTipoProducto";
            $lstRetorno = DB::select($sql);
      }

      public function guardar()
      {
            $sql = "UPDATE productos SET
                        titulo='$this->titulo',
                        precio=$this->precio,
                        cantidad=$this->cantidad,
                        descripcion='$this->descripcion',
                        imagen='$this->imagen',
                        fk_idtipoproducto=$this->fk_idtipoproducto
                  WHERE idproducto=?";
            $affected = DB::update($sql, [$this->idproducto]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM productos WHERE idproducto=?";
            $affected = DB::delete($sql, [$this->idproducto]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO productos (
                        titulo,
                        precio,
                        cantidad,
                        descripcion,
                        imagen,
                        fk_idtipoproducto
                  ) VALUES (?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->titulo,
                  $this->precio,
                  $this->cantidad,
                  $this->descripcion,
                  $this->imagen,
                  $this->fk_idtipoproducto,
            ]);
            return $this->idproducto = DB::getPdo()->lastInsertId();
      }
}
