<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
      protected $table = 'proveedores';
      public $timestamp = false;

      protected $fillable = [ //Son los campos de la tabla proveedores en la BBDD
            'idproveedor', 'nombre', 'dni', 'telefono', 'correo'
      ];

      protected $hidden = [];

      public function cargarDesdeRequest($request)
      {
            $this->idproveedor = $request->input('id') != "0" ? $request->input('id') : $this->idproveedor;
            $this->nombre = $request->input('txtNombre');
            $this->dni = $request->input('txtDni');
            $this->telefono = $request->input('txtTelefono');
            $this->correo = $request->input('txtCorreo');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                        idproveedor,
                        nombre,
                        dni,
                        telefono,
                        correo
                  FROM proveedores ORDER BY nombre";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idProveedor)
      {
            $sql = "SELECT 
                  idproveedor,
                  nombre,
                  dni,
                  telefono,
                  correo
                  FROM proveedores WHERE idproveedor = $idProveedor";
            $lstRetorno = DB::select($sql);

            if (count($lstRetorno) > 0) {
                  $this->idproveedor = $lstRetorno[0]->idproveedor;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->dni = $lstRetorno[0]->dni;
                  $this->telefono = $lstRetorno[0]->telefono;
                  $this->correo = $lstRetorno[0]->correo;
                  return $this;
            }
            return null;
      }

      public function guardar()
      {
            $sql = "UPDATE proveedores SET
                  nombre='$this->nombre',
                  dni='$this->dni',
                  telefono='$this->telefono',
                  correo='$this->correo',
                  WHERE idproveedor=?";
            $affected = DB::update($sql, [$this->idproveedor]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM proveedores WHERE
                  idproveedor=?";
            $affected = DB::delete($sql, [$this->idproveedor]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO proveedores (
                  nombre,
                  dni,
                  telefono,
                  correo
                  ) VALUES (?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->dni,
                  $this->telefono,
                  $this->correo,
            ]);
            return $this->idproveedor = DB::getPdo()->lastInsertId();
      }

      public function obtenerFiltrado()
      {
            $request = $_REQUEST;
            $columns = array(
                  0 => 'nombre',
                  1 => 'dni',
                  2 => 'telefono',
                  3 => 'correo',
            );
            $sql = "SELECT
                        idproveedor,
                        nombre,
                        dni,
                        telefono,
                        correo
                  FROM proveedores
                  WHERE 1=1
            ";

            //Realiza el filtrado
            if (!empty($request['search']['value'])) {
                  $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
                  $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
                  $sql .= " OR dni LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR correo LIKE '%" . $request['search']['value'] . "%' )";
            }
            $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

            $lstRetorno = DB::select($sql);

            return $lstRetorno;
      }
}
