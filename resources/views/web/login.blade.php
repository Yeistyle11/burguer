@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container" style="text-align:center; width:100%;">
      <h2>Iniciar Sesión</h2>
      <p>Ingresa tus datos para acceder</p>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form_container">
          <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div>
              <input type="email" name="txtCorreo" class="form-control" placeholder="Correo *" required />
            </div>
            <div>
              <input type="password" name="txtClave" class="form-control" placeholder="Contraseña *" required />
            </div>
            <div class="btn_box d-flex flex-column gap-2">
              <button type="submit" class="btn1 w-100">
                INGRESAR
              </button>
              <a href="{{ url('/registrarse') }}" class="btn1 w-100 text-center" style="text-decoration:none;">
                REGISTRARSE
              </a>
              <a href="{{ url('/olvide-contrasena') }}" class="btn1 w-100 text-center text-warning" style="background:transparent; border:none; box-shadow:none; text-decoration:underline;">
                ¿Olvidaste tu contraseña?
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@if(session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
@endif
@if(session('mensaje'))
  <div class="alert alert-success">
    {{ session('mensaje') }}
  </div>
@endif
@endsection