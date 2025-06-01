@extends("web.plantilla")
@section("contenido")

<!-- postulacion section -->
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container" style="text-align:center; width:100%;">
      <h2>
        Postulación
      </h2>
      <p>Completa el formulario para enviar tu hoja de vida</p>
    </div>
    <div class="row justify">
      <div class="col-md-6">
        <div class="form_container">
          <form action="{{ url('/postulacion') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
              <input type="text" name="txtNombre" class="form-control" placeholder="Nombre *" required />
            </div>
            <div>
              <input type="text" name="txtApellido" class="form-control" placeholder="Apellido *" required />
            </div>
            <div>
              <input type="text" name="txtWhatsapp" class="form-control" placeholder="Whatsapp *" required />
            </div>
            <div>
              <input type="email" name="txtCorreo" class="form-control" placeholder="Correo *" required />
            </div>
            <div>
              <label class="mb-1" for="cv">Hoja de vida (PDF, DOC, DOCX) *</label>
              <input type="file" name="cv" id="cv" class="form-control" accept=".pdf,.doc,.docx">
            </div>
            <div>
              <input type="url" name="txtLinkCV" class="form-control" placeholder="O enlace a tu CV (Drive, Dropbox, etc.)">
            </div>
            <div class="btn_box">
              <button type="submit">
                Enviar postulación
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end postulacion section -->
@endsection