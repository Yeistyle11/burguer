<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Producto;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);
        $productos = [];
        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto) {
                $producto->cantidad = $cantidad;
                $productos[] = $producto;
            }
        }
        return view('web.carrito', compact('productos'));
    }

    public function agregar(Request $request)
    {
        $idProducto = $request->input('id_producto');
        $cantidad = (int) $request->input('cantidad', 1);

        $producto = Producto::find($idProducto);
        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        $carrito = session('carrito', []);
        $cantidadActual = isset($carrito[$idProducto]) ? (int)$carrito[$idProducto] : 0;
        $disponible = (int)$producto->cantidad;
        $nuevaCantidad = $cantidadActual + $cantidad;

        if ($cantidad < 1) {
            return back()->with('error', 'La cantidad debe ser mayor a cero.');
        }

        if ($nuevaCantidad > $disponible) {
            return back()->with('error', 'No hay suficiente stock disponible. Cantidad actual: ' . $disponible);
        }

        $carrito[$idProducto] = $nuevaCantidad;
        session(['carrito' => $carrito]);
        return back()->with('mensaje', 'Producto agregado al carrito');
    }

    public function quitar($idProducto)
    {
        $carrito = session('carrito', []);
        unset($carrito[$idProducto]);
        session(['carrito' => $carrito]);
        return redirect('/carrito')->with('mensaje', 'Producto eliminado del carrito');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect('/carrito')->with('mensaje', 'Carrito vaciado');
    }

    public function actualizar(Request $request)
    {
        $idProducto = $request->input('id_producto');
        $cantidad = (int) $request->input('cantidad', 1);

        $producto = Producto::find($idProducto);
        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($cantidad < 1) {
            return back()->with('error', 'La cantidad debe ser mayor a cero.');
        }

        if ($cantidad > $producto->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible. Stock actual: ' . $producto->cantidad);
        }

        $carrito = session('carrito', []);
        $carrito[$idProducto] = $cantidad;
        session(['carrito' => $carrito]);
        return back()->with('mensaje', 'Cantidad actualizada');
    }
}