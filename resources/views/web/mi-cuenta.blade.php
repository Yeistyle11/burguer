@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container d-flex flex-column align-items-center" style="text-align:center; width:100%;">
      <h2 class="w-100 text-center">Mi Cuenta</h2>
      <p class="w-100 text-center">Consulta y edita tus datos personales.</p>
    </div>
    @if(session('mensaje'))
      <div class="alert alert-success">{{ session('mensaje') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form_container">
          <form action="{{ url('/mi-cuenta') }}" method="POST">
            @csrf
            <div>
              <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $cliente->nombre ?? '' }}" required />
            </div>
            <div>
              <input type="text" name="telefono" class="form-control" placeholder="Teléfono" value="{{ $cliente->telefono ?? '' }}" required />
            </div>
            <div>
              <input type="text" name="direccion" class="form-control" placeholder="Dirección" value="{{ $cliente->direccion ?? '' }}" required />
            </div>
            <div>
              <input type="text" name="dni" class="form-control" placeholder="DNI" value="{{ $cliente->dni ?? '' }}" required />
            </div>
            <div>
              <input type="email" name="correo" class="form-control" placeholder="Correo" value="{{ $cliente->correo ?? '' }}" required />
            </div>
            <div class="btn_box mt-3">
              <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
            </div>
            <div class="btn_box mt-2">
              <a href="{{ url('/') }}" class="btn btn-secondary w-100">Volver al inicio</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection