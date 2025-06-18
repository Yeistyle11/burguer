<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Pedido;
use App\Entidades\Producto;
use App\Entidades\Estado_pedido;
use Illuminate\Support\Facades\DB;

class ControladorWebPedido extends Controller
{
    public function hacerPedido()
    {
        $sucursales = (new Sucursal())->obtenerTodos();
        return view('web.pedido', compact('sucursales'));
    }

    public function guardarPedido(Request $request)
    {
        $request->validate([
            'idsucursal' => 'required|numeric|exists:sucursales,idsucursal',
        ]);

        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect('/carrito')->with('error', 'El carrito está vacío.');
        }

        $pedido = new Pedido();
        $pedido->fk_idcliente = session('id_cliente_logueado');
        $pedido->fk_idsucursal = $request->input('idsucursal');
        $pedido->fk_idestadopedido = 3; // Estado "En proceso"
        $pedido->fecha = date('Y-m-d H:i:s');
        $pedido->total = 0;
        $pedido->save();

        $total = 0;
        foreach ($carrito as $idProducto => $cantidad) {
            $producto = Producto::find($idProducto);
            if ($producto) {
                DB::table('pedido_productos')->insert([
                    'fk_idpedido' => $pedido->idpedido,
                    'fk_idproducto' => $producto->idproducto,
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                ]);
                $total += $producto->precio * $cantidad;
                $producto->cantidad -= $cantidad;
                $producto->save();
            }
        }

        $pedido->total = $total;
        $pedido->save();

        session()->forget('carrito');
        return redirect('/carrito')->with('mensaje', '¡Pedido registrado con éxito! Retirá tu compra en la sucursal seleccionada y pagá en efectivo.');
    }

    public function verPedido($idPedido)
    {
        $pedido = Pedido::find($idPedido);
        $sucursal = Sucursal::find($pedido->fk_idsucursal);
        $productos = DB::table('pedido_productos')
            ->join('productos', 'pedido_productos.fk_idproducto', '=', 'productos.idproducto')
            ->where('fk_idpedido', $pedido->idpedido)
            ->select('productos.titulo as nombre', 'pedido_productos.cantidad', 'pedido_productos.precio')
            ->get();

        return view('web.pedido_detalle', compact('pedido', 'sucursal', 'productos'));
    }

    public function misPedidos()
    {
        $idCliente = session('id_cliente_logueado');
        $pedidos = Pedido::where('fk_idcliente', $idCliente)
            ->orderBy('fecha', 'asc')
            ->get();

        return view('web.mis_pedidos', compact('pedidos'));
    }
}