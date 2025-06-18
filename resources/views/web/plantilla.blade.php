<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="Deléitate con la mejor hamburguesa en Medellín en nuestro acogedor restaurante donde los sueños gastronómicos se hacen realidad. ¡Entra ya!" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="web/web/images/favicon.png" type="">

  <title> Feane </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('web/css/bootstrap.css') }}" />

  <!-- owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" crossorigin="anonymous" />

  <!-- font awesome style -->
  <link href="{{ asset('web/css/font-awesome.min.css') }}" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="{{ asset('web/css/style.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ asset('web/css/responsive.css') }}" rel="stylesheet" />

</head>

<body class="sub_page">

  <div class="hero_area">
    <div class="bg-box">
      <img src="{{ asset('web/images/hero-bg.jpg') }}" alt="">
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="/">
            <span>
              Feane
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="/">Inicio <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item {{ Request::is('takeaway') ? 'active' : '' }}">
                <a class="nav-link" href="/takeaway">Takeaway</a>
              </li>
              <li class="nav-item {{ Request::is('nosotros') ? 'active' : '' }}">
                <a class="nav-link" href="/nosotros">Nosotros</a>
              </li>
              <li class="nav-item {{ Request::is('contacto') ? 'active' : '' }}">
                <a class="nav-link" href="/contacto">Contacto</a>
              </li>
            </ul>
            <div class="user_option">
              <a href="/mi-cuenta" class="user_link">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              @php
                $carrito = session('carrito', []);
                $cantidadCarrito = array_sum($carrito);
              @endphp
              <a class="cart_link position-relative" href="/carrito">
                @if($cantidadCarrito > 0)
                  <span class="badge badge-warning position-absolute"
                        style="top:-6px; right:-10px; font-size:0.7em; border-radius:50%; min-width:18px; min-height:18px; padding:0; display:flex; align-items:center; justify-content:center; z-index:2;">
                    {{ $cantidadCarrito }}
                  </span>
                @endif
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                  <g>
                    <g>
                      <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                   c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                   C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                   c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                   C457.728,97.71,450.56,86.958,439.296,84.91z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                   c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                    </g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                </svg>
              </a>
              @if(session('cliente_logueado'))
                <a href="{{ url('mis-pedidos') }}" class="order_online" style="background:#17a2b8;">
                  <i class="fa fa-list"></i> Mis pedidos
                </a>
                <a href="/salir" class="order_online" style="background:#dc3545;">
                  Salir
                </a>
              @else
                <a href="/login" class="order_online">
                  Ingresar
                </a>
              @endif
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    @yield("banner")
  </div>

@yield("contenido")

  <!-- footer section -->
  <footer class="footer_section">
  <div class="container">
    <div class="row">
      <!-- Columna 1: Sucursales (Nombre y Dirección y link mapa) -->
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>Sucursales</h4>
          <div class="contact_link_box">
            @if(isset($aSucursales) && count($aSucursales))
              @foreach($aSucursales as $sucursal)
                <div class="mb-2">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  <span>{{ $sucursal->nombre ?? '' }}</span><br>
                  <small>{{ $sucursal->direccion ?? '' }}</small><br>
                  @if(!empty($sucursal->linkmapa))
                    <a href="{{ $sucursal->linkmapa }}" target="_blank" style="color:#007bff;">
                      <i class="fa fa-location-arrow" aria-hidden="true"></i> Ver en mapa
                    </a>
                  @endif
                </div>
              @endforeach
            @else
              <span>No hay sucursales registradas.</span>
            @endif
          </div>
        </div>
      </div>
      <!-- Columna 2: Contacto (Teléfonos y email si existe) -->
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>Contacto</h4>
          <div class="contact_link_box">
            @if(isset($aSucursales) && count($aSucursales))
              @foreach($aSucursales as $sucursal)
                <div class="mb-2">
                  <i class="fa fa-phone" aria-hidden="true"></i>
                  <span>{{ $sucursal->telefono ?? '' }}</span>
                  @if(!empty($sucursal->email))
                    <br>
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <span>{{ $sucursal->email }}</span>
                  @endif
                </div>
              @endforeach
            @else
              <span>No hay teléfonos registrados.</span>
            @endif
          </div>
        </div>
      </div>
      <!-- Columna 3: Horarios -->
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>Horarios</h4>
          <div class="contact_link_box">
            @if(isset($aSucursales) && count($aSucursales))
              @foreach($aSucursales as $sucursal)
                <div class="mb-2">
                  <i class="fa fa-clock-o" aria-hidden="true"></i>
                  <span>{{ $sucursal->nombre ?? '' }}</span><br>
                  <small>{{ $sucursal->horario ?? '' }}</small>
                </div>
              @endforeach
            @else
              <span>No hay horarios registrados.</span>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="footer-info">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a><br><br>
        &copy; <span id="displayYear"></span> Distributed By
        <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
      </p>
    </div>
  </div>
</footer>
<!-- end footer section -->

<!-- jQuery -->
<script src="{{ asset('web/js/jquery-3.4.1.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('web/js/bootstrap.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('web/js/custom.js') }}"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>

<!-- Isotope JS -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<script>
  $(document).ready(function() {
    // Inicializar Isotope
    var $grid = $('.grid').isotope({
      itemSelector: '.all',
      layoutMode: 'fitRows'
    });

    // Filtrado al hacer clic en categorías
    $('.filters_menu li').on('click', function() {
      $('.filters_menu li').removeClass('active');
      $(this).addClass('active');

      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });
    });
  });
</script>

</body>
</html>