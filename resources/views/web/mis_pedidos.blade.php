@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container" style="max-width:700px;">
    <div class="heading_container mb-4" style="text-align:center;">
      <h2>Mis pedidos</h2>
    </div>
    <div class="card shadow border-0">
      <div class="card-body">
        @if(count($pedidos))
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($pedidos as $pedido)
                @php
                  $estado = (new \App\Entidades\Estado_pedido())->obtenerPorId($pedido->fk_idestadopedido);
                  $numero = $loop->iteration; // 1 para el más reciente
                @endphp
                <tr>
                  <td>{{ $numero }}</td>
                  <td>{{ date('d/m/Y H:i', strtotime($pedido->fecha)) }}</td>
                  <td>{{ $estado ? $estado->nombre : '' }}</td>
                  <td>${{ number_format($pedido->total, 2) }}</td>
                  <td>
                    <a href="{{ url('pedido-detalle/'.$pedido->idpedido) }}" class="btn btn-sm btn-primary">Ver detalle</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p>No tienes pedidos realizados.</p>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection