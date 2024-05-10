<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
      protected $table = 'proveedores';
      public $timestamp = false;

      protected $fillable = [ //Son los campos de la tabla proveedores en la BBDD
            'idproveedor', 'nombre', 'dni', 'telefono', 'correo', 'fk_idrubro'
      ];

      protected $hidden = [];

      public function cargarDesdeRequest($request)
      {
            $this->idproveedor = $request->input('id') != "0" ? $request->input('id') : $this->idproveedor;
            $this->nombre = $request->input('txtNombre');
            $this->dni = $request->input('txtDni');
            $this->telefono = $request->input('txtTelefono');
            $this->correo = $request->input('txtCorreo');
            $this->fk_idrubro = $request->input('lstRubro');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                        idproveedor,
                        nombre,
                        dni,
                        telefono,
                        correo,
                        fk_idrubro
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
                  correo,
                  fk_idrubro
                  FROM proveedores WHERE idproveedor = $idProveedor";
            $lstRetorno = DB::select($sql);

            if (count($lstRetorno) > 0) {
                  $this->idproveedor = $lstRetorno[0]->idproveedor;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->dni = $lstRetorno[0]->dni;
                  $this->telefono = $lstRetorno[0]->telefono;
                  $this->correo = $lstRetorno[0]->correo;
                  $this->fk_idrubro = $lstRetorno[0]->fk_idrubro;
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
                  fk_idrubro=$this->fk_idrubro
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
                  correo,
                  fk_idrubro
                  ) VALUES (?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->dni,
                  $this->telefono,
                  $this->correo,
                  $this->fk_idrubro,
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
                  4 => 'fk_idrubro'
            );
            $sql = "SELECT DISTINCT 
                        A.idproveedor,
                        A.nombre,
                        A.dni,
                        A.telefono,
                        A.correo,
                        A.fk_idrubro,
                        B.nombre AS rubros
                  FROM proveedores A
                  INNER JOIN rubros B ON A.fk_idrubro
                  WHERE 1=1
            ";

            //Realiza el filtrado
            if (!empty($request['search']['value'])) {
                  $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
                  $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
                  $sql .= " OR dni LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR correo LIKE '%" . $request['search']['value'] . "%' )";
                  $sql .= " OR fk_idrubro LIKE '%" . $request['search']['value'] . "%' )";
            }
            $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

            $lstRetorno = DB::select($sql);

            return $lstRetorno;
      }

      public function existeRubroPorProveedor($idProveedor)
      {
            $sql = "SELECT
                        idproveedor,
                        nombre,
                        dni,
                        telefono,
                        correo,
                        fk_idrubro
                  FROM proveedores WHERE fk_idrubro = $idProveedor";
            $lstRetorno = DB::select($sql);
            return (count($lstRetorno) > 0);
      }
}
