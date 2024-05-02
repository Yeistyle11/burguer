<?php

namespace App\Http\Controllers;

class ControladorCategoria extends Controller
{

      public function nuevo()
      {
            $titulo = "Nueva categoria";
            return view("sistema.categoria-nuevo", compact("titulo"));
      }
}
