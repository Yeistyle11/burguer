@extends("web.plantilla")
@section("contenido")

  <!-- food section -->

  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nuestro menú 
        </h2>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">Todos</li>
        @foreach($acategorias as $categoria)
            <li data-filter=".tipo{{ $categoria->idtipoproducto }}">{{ $categoria->nombre }}</li>
        @endforeach
      </ul>

      <div class="filters-content">
        <div class="row grid">
          @foreach($aproductos as $producto)
            @php
                $categoriaNombre = '';
                foreach($acategorias as $cat) {
                    if($cat->idtipoproducto == $producto->fk_idtipoproducto) {
                        $categoriaNombre = $cat->nombre;
                        break;
                    }
                }
            @endphp
            <div class="col-sm-6 col-lg-4 all tipo{{ $producto->fk_idtipoproducto }}">
                <div class="box">
                    <div>
                        <div class="img-box">
                            <img src="{{ asset('web/images/' . ($producto->imagen ?? 'default.png')) }}" alt="" class="img-fluid w-100" style="height:300px;object-fit:cover;">
                        </div>
                        <div class="detail-box">
                            <h5>
                                {{ $producto->titulo }}
                            </h5>
                            <p>
                                {{ $producto->descripcion }}
                            </p>
                            <span class="badge badge-info">{{ $categoriaNombre }}</span>
                            <div class="options">
                                <h6>
                                    ${{ $producto->precio }}
                                </h6>
                                <!-- Botón que abre el modal -->
                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#modalCarrito{{ $producto->idproducto }}">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="color:#ffc107; font-size: 1.5em;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalCarrito{{ $producto->idproducto }}" tabindex="-1" role="dialog" aria-labelledby="modalCarritoLabel{{ $producto->idproducto }}" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg">
                  <form action="{{ url('/carrito/agregar') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning text-dark border-0">
                      <h5 class="modal-title font-weight-bold" id="modalCarritoLabel{{ $producto->idproducto }}">
                        <i class="fa fa-shopping-cart mr-2"></i>Agregar al carrito
                      </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="font-size:2rem;">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="{{ asset('web/images/' . ($producto->imagen ?? 'default.png')) }}" alt="{{ $producto->titulo }}" class="img-fluid mb-3 rounded" style="max-height:150px;">
                      <h5 class="mb-1">{{ $producto->titulo }}</h5>
                      <span class="badge badge-info mb-2">{{ $categoriaNombre }}</span>
                      <p class="mb-2">{{ $producto->descripcion }}</p>
                      <h4 class="text-warning mb-3">${{ $producto->precio }}</h4>
                      <input type="hidden" name="id_producto" value="{{ $producto->idproducto }}">
                      <div class="form-group mb-3">
                        <label for="cantidad{{ $producto->idproducto }}" class="font-weight-bold">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad{{ $producto->idproducto }}" value="1" min="1" class="form-control w-50 mx-auto text-center" required>
                      </div>
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-between">
                      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                      </button>
                      <button type="submit" class="btn btn-warning text-white font-weight-bold">
                        <i class="fa fa-cart-plus"></i> Agregar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="btn-box">
        <a href="">
          Volver al inicio
        </a>
      </div>
    </div>
  </section>

  <!-- end food section -->

  <div id="alertas-flotantes" style="position:fixed; top:30px; left:50%; transform:translateX(-50%); z-index:2000; min-width:300px; max-width:90%;">
    @if(session('mensaje'))
      <div class="alert alert-success text-center mb-0">
        {{ session('mensaje') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger text-center mb-0">
        {{ session('error') }}
      </div>
    @endif
  </div>

  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alertas-flotantes');
      if(alerta) alerta.style.display = 'none';
    }, 3000); // 3 segundos
  </script>
@endsection
