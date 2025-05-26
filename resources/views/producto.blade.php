<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="tienda">
    <div class="banner-marquee">
        <div class="banner-content">
          Outworld Newsletter · 5% de descuento en tu primera compra
        </div>
        <div class="banner-button">
            <a href="#newsletter" class="btn-newsletter">Haz click aquí</a>
        </div>
      </div>
      @include('partials.header-secundario')

      <section class="publi-especific-product" data-aos="fade-up">
        <div class="publi p1"></div>
        <div class="publi p2"></div>
        <div class="publi p3"></div>
      </section>
      <section class="especific-product" data-aos="fade-up">
          <div class="containerProducto"
               data-product-id="{{ $producto->id }}"
               data-product-price="{{ $producto->precio }}"
               data-product-stock="{{ $producto->stock }}">
            <div class="left">

              <div class="swiper especificProduct">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    </div>

                    <!-- Otras imágenes de la relación -->
                    @foreach ($producto->imagenes as $imagen)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="{{ $producto->nombre }}">
                        </div>
                    @endforeach
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

              </div>
            </div>
            <div class="right">
              <h2>{{ $producto->nombre }}</h2>
              <p>{{ $producto->descripcion }}</p>
              <ul>
                <li>Sabor: {{ $producto->atributos->sabor }}</li>
                <li>Tamaño: {{ $producto->atributos->tamanio }}</li>
                <li>% Alcohol: {{ $producto->atributos->porcentaje_alcohol }}%</li>
                <li>Metodo de Destilacion: {{ $producto->atributos->metodo_destilacion }}</li>
                <li>Color: {{ $producto->atributos->color }}</li>
              </ul>
              <div class="product-details">
                  <div class="price">
                      <h3>{{ $producto->precio }} €</h3>
                  </div>

                  <div class="quantity-selector">
                    <select id="quantity" class="quantity-dropdown">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                  <div class="add-to-cart">
                      <button class="btn-add-to-cart">Añadir al carrito</button>
                  </div>
              </div>
          </div>
          </div>
      </section>

      <section class="especific-product-info" data-aos="fade-up">
        <div class="especific-product-info-content">
          <p>{{ $producto ->texto }}
          </p>
        </div>
        <div class="especific-product-info-media">
            <video autoplay muted loop>
                <source src="{{ asset('image/recursos/Absolut Vodka Spot _Born To Mix_.mp4') }}" type="video/mp4">
            </video>
        </div>
      </section>

      <section class="opiniones" data-aos="fade-up">
        <h2 style="text-transform: uppercase">¿A QUÉ SABE {{ $producto->nombre }}?</h2>
        <div class="container-opinion-swiper">
            <div class="swiper opinionSwiper">
                <div class="swiper-wrapper">

                    <!-- Opinion 1 -->
                    <div class="swiper-slide">
                        <div class="opinion-card">
                            <div class="personal-info">
                                <img src="{{ asset('image/tienda/opiniones/AV/daniel.jpg') }}" alt="Daniel, Sensory Manager, Absolut">
                                <div class="name-and-position">
                                  <h5 class="name">Daniel</h5>
                                  <h6 class="position">Sensory Manager, Absolut</h6>
                                </div>
                            </div>
                            <div class="personal-content">
                                <p>"La sensación en boca es excepcionalmente suave, se asienta con tranquilidad y desciende lentamente
                                    de manera muy armoniosa. El sabor presenta ligeras notas de caramelo y vainilla, con un final fresco
                                    y afrutado. Absolut vodka es la verdadera definición de equilibrio y armonía."
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Opinion 2 -->
                    <div class="swiper-slide">
                        <div class="opinion-card">
                            <div class="personal-info">
                                <img src="{{ asset('image/tienda/opiniones/AV/rico.jpg') }}" alt="Rico, Global Brand Ambassador, Absolut">
                                <div class="name-and-position">
                                  <h5 class="name">Rico</h5>
                                  <h6 class="position">Global Brand Ambassador, Absolut</h6>
                                </div>
                            </div>
                            <div class="personal-content">
                                <p>"Absolut Vodka tiene una capacidad única para envolver tu boca en una sensación duradera que permanece mucho después de cada sorbo.
                                  Desde el primer contacto con el paladar, se nota la suavidad y la perfección de su sabor."</p>
                            </div>
                        </div>
                    </div>

                      <!-- Opinion 3 -->
                      <div class="swiper-slide">
                        <div class="opinion-card">
                            <div class="personal-info">
                                <img src="{{ asset('image/tienda/opiniones/AV/camila.jpg') }}" alt="Camila, Absolut Brand Ambassador, USA">
                                <div class="name-and-position">
                                  <h5 class="name">Camila</h5>
                                  <h6 class="position">Absolut Brand Ambassador, USA</h6>
                                </div>
                            </div>
                            <div class="personal-content">
                                <p>"Absolut Vodka es la esencia de la perfección en una botella. Desde el primer trago, se siente su calidad inconfundible: suave,
                                  pero con un sabor robusto y lleno de carácter. Es una bebida que sabe equilibrar la intensidad con la sutileza,
                                  ofreciendo una experiencia completa que no deja de sorprender."</p>
                            </div>
                        </div>
                    </div>

                    <!-- Opinion 4 -->
                    <div class="swiper-slide">
                        <div class="opinion-card">
                            <div class="personal-info">
                                <img src="{{ asset('image/tienda/opiniones/AV/dudah.jpg') }}" alt="Dudah, Absolut Brand Ambassador, Brazil">
                                <div class="name-and-position">
                                  <h5 class="name">Dudah</h5>
                                  <h6 class="position">Absolut Brand Ambassador, Brazil</h6>
                                </div>
                            </div>
                            <div class="personal-content">
                                <p>"Con original nunca te equivocas, tiene ese equilibrio y versatilidad que buscas en un vodka. Va bien
                                    con cualquier cosa que lo quieras mezclar. Por eso es perfecto para acompañar diferentes platos y experiencias
                                    únicas"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-pagination2"></div>
        </div>
    </section>

    <section class="ficha-tecnica-section" data-aos="fade-up">
      <div class="tit"><h2>{{ $producto->nombre }}, {{ $producto->atributos->porcentaje_alcohol }} ABV</h2></div>
      <div class="ficha-tecnica">

        <div class="ficha-tecnica-content">
          <div class="acordeon">
            <div class="acordeon-item active">
              <div class="acordeon-titulo">

                <span>Alcohol y Salud</span>
                <i class="toggle">+</i>
              </div>
              <div class="acordeon-contenido">
                <p>Beber alcohol puede causar problemas de salud. Beber en exceso de forma regular ha sido asociado con diferentes enfermedades, incluyendo enfermedades hepáticas, presión arterial alta y ciertos tipos de cáncer.</p>
                <p>Alguna investigación científica ha encontrado una relación entre el consumo de leve a moderado de alcohol y un aumento en el riesgo de padecer cáncer de mama en las mujeres. El cáncer es una enfermedad compleja influenciada por muchos factores, y el consumo de alcohol es uno de ellos. Para más información general:
                  <a href="#">Alcohol y salud</a> ;
                  <a href="#">Factores de Riesgo de Cáncer</a>.
                </p>
                <p>Si tiene dudas sobre su propio consumo de alcohol y cómo puede afectar su salud, debería consultar a su médico. Además, no deberían beber alcohol los menores de edad, las mujeres embarazadas, y las personas a quienes su médico les ha recomendado no beber alcohol.</p>
                <p>El contenido de esta sección se ofrece solamente con carácter informativo, y no debe ser considerado como consejo médico, diagnóstico o tratamiento.</p>
              </div>
            </div>

            <div class="acordeon-item">
              <div class="acordeon-titulo"><span>Consumo Responsable</span><i class="toggle">+</i></div>
              <div class="acordeon-contenido">Este es un extracto de las directrices oficiales de su país sobre el consumo de bajo riesgo.
                Según el Ministerio de Sanidad español, un consumo de bajo riesgo es:
                   <ul>
                    <li>Mujeres: hasta 10g de alcohol/día; </li>
                    <li>Hombres: hasta 20g de alcohol/día. </li>
                   </ul>
                Y un consumo de riesgo es:
                <ul>
                  <li>Mujeres: más de 20g de alcohol puro/día.</li>
                  <li>Hombres: más de 40g de alcohol puro/día.</li>
                </ul>
                El Ministerio de Sanidad recomienda 2 días sin alcohol/semana. </div>
            </div>

            <div class="acordeon-item">
              <div class="acordeon-titulo"><span>Ingredientes</span><i class="toggle">+</i></div>
              <div class="acordeon-contenido">
                  <ul>
                  @foreach ($producto->ingredientes as $ingrediente)
                          <li> {{ $ingrediente->nombre }} </li>
                  @endforeach</div>
                  </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="a-drinks" data-aos="fade-up">
      <div class="drinks-info">
        <h2>¿Lo combinamos?</h2>
        <p>Hay tantas formas de deleitarse con {{ $producto->nombre }} como veces se destila: innumerables.
          Solo o con amigos. Puedes combinarlo o tomarlo puro. Añade agua con gas, zumo y un par de rodajas de
          lima para elaborar el Absolut Vodka Soda perfecto o escoge entre las bebidas que te presentamos a continuación.
          Un vodka de primera categoría.</p>
      </div>
      <div class="drinks-especific">
        <a href="{{ route('drink', ['id' => 16]) }}">
        <div class="drink d1" data-name="Vodka Martini">
          <div class="drink-name">Vodka Mojito</div>
        </div>
        </a>
        <a href="{{ route('drink', ['id' => 2]) }}">
        <div class="drink d2" data-name="Bloody Mary">
          <div class="drink-name">Bloody Mary</div>
        </div>
        </a>
        <a href="{{ route('drink', ['id' => 14]) }}">
        <div class="drink d3" data-name="Espresso Martini">
          <div class="drink-name">Espresso Martini</div>
        </div>
        </a>
      </div>
    </section>

    @include('partials.footer')


    <script>
      document.querySelectorAll('.acordeon-titulo').forEach(titulo => {
        titulo.addEventListener('click', () => {
          const item = titulo.parentElement;
          const isActive = item.classList.contains('active');

          document.querySelectorAll('.acordeon-item').forEach(i => {
            i.classList.remove('active');
            i.querySelector('.toggle').textContent = '+';
          });

          if (!isActive) {
            item.classList.add('active');
            item.querySelector('.toggle').textContent = '−';
          }
        });
      });

    </script>

    {{-- Carga la lógica del carrito --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/generico.js') }}"></script>
    <script src="{{ asset('js/tienda.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>

</body>
</html>
