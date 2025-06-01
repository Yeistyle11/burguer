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
                                <a href="">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
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
@endsection
