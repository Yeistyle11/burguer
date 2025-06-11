@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container" style="text-align:center; width:100%;">
      <h2>Carrito de compras</h2>
    </div>
    @if(session('mensaje'))
      <div class="alert alert-success text-center">{{ session('mensaje') }}</div>
    @endif
    @if(empty($productos))
      <p class="text-center">No hay productos en el carrito.</p>
    @else
      <table class="table table-bordered mt-4">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($productos as $producto)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ asset('web/images/' . ($producto->imagen ?? 'default.png')) }}" alt="{{ $producto->nombre }}" style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                  <span>{{ $producto->nombre }}</span>
                </div>
              </td>
              <td>{{ $producto->cantidad }}</td>
              <td>${{ number_format($producto->precio, 2) }}</td>
              <td>${{ number_format($producto->precio * $producto->cantidad, 2) }}</td>
              <td>
                <a href="{{ url('/carrito/quitar/'.$producto->idproducto) }}" class="btn btn-danger btn-sm">Quitar</a>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalActualizar{{ $producto->idproducto }}">
                  Actualizar
                </button>
              </td>
            </tr>
            @php $total += $producto->precio * $producto->cantidad; @endphp

            <!-- Modal para actualizar cantidad -->
            <div class="modal fade" id="modalActualizar{{ $producto->idproducto }}" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel{{ $producto->idproducto }}" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg">
                  <form action="{{ url('/carrito/actualizar') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning text-dark border-0">
                      <h5 class="modal-title font-weight-bold" id="modalActualizarLabel{{ $producto->idproducto }}">
                        <i class="fa fa-edit mr-2"></i>Actualizar cantidad
                      </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="font-size:2rem;">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="{{ asset('web/images/' . ($producto->imagen ?? 'default.png')) }}" alt="{{ $producto->nombre }}" class="img-fluid mb-3 rounded" style="max-height:100px;">
                      <h5 class="mb-1">{{ $producto->nombre }}</h5>
                      <p class="mb-2 text-muted">Precio: ${{ number_format($producto->precio, 2) }}</p>
                      <input type="hidden" name="id_producto" value="{{ $producto->idproducto }}">
                      <div class="form-group mb-3">
                        <label for="cantidad{{ $producto->idproducto }}" class="font-weight-bold">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad{{ $producto->idproducto }}" value="{{ $producto->cantidad }}" min="1" max="{{ $producto->cantidad_disponible ?? 99 }}" class="form-control w-50 mx-auto text-center" required>
                      </div>
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-between">
                      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                      </button>
                      <button type="submit" class="btn btn-warning text-white font-weight-bold">
                        <i class="fa fa-save"></i> Guardar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
      </table>
      <div class="text-end">
        <h4>Total: ${{ number_format($total, 2) }}</h4>
      </div>
      <div class="d-flex justify-content-between mt-3">
        <a href="{{ url('/carrito/vaciar') }}" class="btn btn-warning">Vaciar carrito</a>
        <!-- Aquí puedes agregar el botón para confirmar pedido -->
      </div>
    @endif
  </div>
</section>
@endsection