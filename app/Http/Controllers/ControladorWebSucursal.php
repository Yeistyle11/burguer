<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;

class ControladorWebSucursal extends Controller
{
    public function index()
    {
        $sucursalModel = new Sucursal();
        $aSucursales = $sucursalModel->obtenerTodos();

        return view("web.sucursales", [
            'aSucursales' => $aSucursales
        ]);
    }
}