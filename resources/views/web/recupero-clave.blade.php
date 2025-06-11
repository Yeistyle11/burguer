@extends('web.plantilla')
@section('contenido')
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container text-center">
      <h2>Recuperar contraseña</h2>
      <p>Ingresa tu correo para recibir instrucciones de recuperación.</p>
    </div>
    <form action="#" method="POST">
      @csrf
      <div class="form-group">
        <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
      </div>
      <button type="submit" class="btn btn-warning mt-2">Enviar</button>
    </form>
  </div>
</section>
@endsection