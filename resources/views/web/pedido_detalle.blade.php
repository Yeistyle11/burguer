@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container" style="max-width:600px;">
    <div class="heading_container mb-4" style="text-align:center;">
      <h2>Detalle de tu pedido</h2>
    </div>
    <div class="card shadow border-0" style="border-radius:18px;">
      <div class="card-body px-4 py-4">
        <p><strong>N° Pedido:</strong> {{ $pedido->idpedido }}</p>
        <p><strong>Fecha:</strong> {{ date('d/m/Y H:i', strtotime($pedido->fecha)) }}</p>
        <p>
          <strong>Estado:</strong>
          @php
            $estado = (new \App\Entidades\Estado_pedido())->obtenerPorId($pedido->fk_idestadopedido);
          @endphp
          {{ $estado ? $estado->nombre : '' }}
        </p>
        <p><strong>Sucursal:</strong> {{ $sucursal->nombre ?? '' }} - {{ $sucursal->direccion ?? '' }}</p>
        <hr>
        <h5>Productos</h5>
        <ul class="list-group mb-3">
          @foreach($productos as $prod)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ $prod->nombre }} x {{ $prod->cantidad }}
              <span>${{ number_format($prod->precio * $prod->cantidad, 2) }}</span>
            </li>
          @endforeach
        </ul>
        <div class="text-end">
          <h4>Total: ${{ number_format($pedido->total, 2) }}</h4>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection