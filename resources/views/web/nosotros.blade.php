@extends("web.plantilla")
@section("contenido")

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="web/images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Sobre Nosotros
              </h2>
            </div>
            <p>
              En <b>Burguer</b> nos apasiona crear experiencias únicas a través de la mejor comida rápida. Desde nuestros inicios, nos hemos dedicado a ofrecer hamburguesas artesanales, papas crujientes y productos frescos, preparados al momento y con ingredientes de primera calidad.<br><br>
              Nuestro compromiso es brindar un ambiente cálido y familiar, donde cada cliente se sienta como en casa. Creemos en la innovación constante, por eso nuestro menú se renueva para sorprenderte siempre con nuevos sabores.<br><br>
              Gracias por elegirnos y ser parte de nuestra historia. ¡Te esperamos para compartir juntos el mejor sabor!
            </p>
            <a href="{{ url('/contacto') }}" class="btn btn-primary mb-2">
              Contáctanos
            </a>
            <a href="{{ url('/postulacion') }}" class="btn btn-success">
              Enviar hoja de vida
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- client section -->

  <section class="client_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
        <h2>
          Lo que dicen nuestros clientes
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  ¡Las mejores hamburguesas de la ciudad! El ambiente es excelente y la atención siempre es de primera.
                </p>
                <h6>
                  Moana Michell
                </h6>
                <p>
                  Cliente frecuente
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client1.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Me encanta la variedad del menú y la calidad de los ingredientes. ¡Siempre vuelvo por más!
                </p>
                <h6>
                  Mike Hamell
                </h6>
                <p>
                  Amante de las burgers
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client2.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->
@endsection