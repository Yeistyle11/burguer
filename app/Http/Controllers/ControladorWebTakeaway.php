<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Categoria;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        $productoModel = new Producto();
        $aProductos = $productoModel->obtenerTodos();

        $categoriaModel = new Categoria();
        $aCategorias = $categoriaModel->obtenerTodos();

        return view("web.takeaway", [
            'aproductos' => $aProductos,
            'acategorias' => $aCategorias
        ]);
    }
}