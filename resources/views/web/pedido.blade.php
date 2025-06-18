@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container" style="max-width:430px;">
    <div class="heading_container mb-4" style="text-align:center;">
      <h2>Elegí tu sucursal</h2>
      <p>Y confirmá tu pedido</p>
    </div>
    <div class="card shadow border-0" style="border-radius:18px;">
      <div class="card-body px-4 py-4">
        <form action="{{ url('pedido') }}" method="POST">
          @csrf
          <div class="mb-4 w-100">
            <label for="idsucursal" class="form-label" style="font-weight:600; display:block; margin-bottom:6px;">Sucursal</label>
            <select name="idsucursal" id="idsucursal" class="form-select w-100" required style="border-radius:8px; min-height:45px;">
              <option value="">Seleccione una sucursal</option>
              @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->idsucursal }}">{{ $sucursal->nombre }} - {{ $sucursal->direccion }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-4 w-100">
            <label class="form-label" style="font-weight:600; display:block; margin-bottom:6px;">Método de pago</label>
            <input type="text" class="form-control w-100" value="Efectivo (retiro en sucursal)" readonly style="border-radius:8px; background:#f5f5f5; min-height:45px;">
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-lg" style="border-radius:8px; font-weight:600;">Confirmar Pedido</button>
            <a href="{{ url('/carrito') }}" class="btn btn-outline-secondary btn-lg" style="border-radius:8px; font-weight:600;">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection