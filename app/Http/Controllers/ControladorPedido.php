<?php

namespace App\Http\Controllers;

class ControladorPedido extends Controller
{

      public function nuevo()
      {
            $titulo = "Nuevo pedido";
            return view("sistema.pedido-nuevo", compact("titulo"));
      }
}
