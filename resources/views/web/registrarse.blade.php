@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container" style="text-align:center; width:100%;">
      <h2>Registro de Cliente</h2>
      <p>Completa el formulario para crear tu cuenta</p>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form_container">
          <form action="{{ url('/registrarse') }}" method="POST">
            @csrf
            <div>
              <input type="text" name="txtNombre" class="form-control" placeholder="Nombre *" required />
            </div>
            <div>
              <input type="text" name="txtTelefono" class="form-control" placeholder="Teléfono *" required />
            </div>
            <div>
              <input type="text" name="txtDireccion" class="form-control" placeholder="Dirección *" required />
            </div>
            <div>
              <input type="text" name="txtDni" class="form-control" placeholder="DNI *" required />
            </div>
            <div>
              <input type="email" name="txtCorreo" class="form-control" placeholder="Correo *" required />
            </div>
            <div>
              <input type="password" name="txtClave" class="form-control" placeholder="Contraseña *" required />
            </div>
            <div class="btn_box d-flex flex-column gap-2">
              <button type="submit" class="btn1 w-100">
                Registrarse
              </button>
              <a href="{{ url('/login') }}" class="btn1 w-100 text-center" style="text-decoration:none;">
                Volver al login
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection