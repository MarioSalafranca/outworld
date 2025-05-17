<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drinks</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="tienda2">
    @include('partials.header')
    <div class="negro"></div>
    <section class="banner-ADrink" data-aos="fade-up">
        <div class="imagen-publi">
            <a href="{{ route('absolutDrinks') }}"><img src="{{ asset('image/logo/AD_White.png') }}"></a>
        </div>
    </section>
    <section class="publi-especific-drink" data-aos="fade-up">
        <div class="publi">
            <img src="{{ asset('storage/' . $drink->imagenes->get(0)->ruta) }}" alt="{{ $drink->nombre }}">
        </div>
        <div class="publi">
            <img src="{{ asset('storage/' . $drink->imagenes->get(1)->ruta) }}" alt="{{ $drink->nombre }}">
        </div>
        <div class="publi">
            <img src="{{ asset('storage/' . $drink->imagenes->get(2)->ruta) }}" alt="{{ $drink->nombre }}">
        </div>
    </section>

    <section class="banner-ADrink" data-aos="fade-up" >
            <h2>{{ $drink->nombre }}</h2>
    </section>


    <section class="content-drink" data-aos="fade-up">
        <div class="info-drink">
            <p>{{ $drink->descripcion }}</p>
        </div>
    </section>
    <section class="ingre-drink" data-aos="fade-up">
        <div class="ingredientes-container">
            @foreach ($drink->ingredientes as $ingrediente)
                <div class="ingrediente">
                    <div class="cantidad">{{ $ingrediente->pivot->cantidad }}</div>
                    <div class="nombre">{{ $ingrediente->nombre }}</div>
                </div>
            @endforeach
        </div>
    </section>


    <section class="valoracion" data-aos="fade-up">
        <div class="stars2">
            @php
                $reseñasPrincipales = $drink->reseñas->where('parent_id', null);

                $valoracionMedia = $reseñasPrincipales->avg('valoracion');

                $valoracionEntera = floor($valoracionMedia);
                $mitad = $valoracionMedia - $valoracionEntera >= 0.5;
            @endphp

            @for ($i = 0; $i < $valoracionEntera; $i++)
                <div class="star2 filled"></div>
            @endfor

            @if ($mitad)
                <div class="star2 half"></div>
            @endif

            @for ($i = 0; $i < (5 - $valoracionEntera - ($mitad ? 1 : 0)); $i++)
                <div class="star2"></div>
            @endfor
        </div>
        <h3>{{ number_format($valoracionMedia, 1) }}/5</h3>
    </section>

    <section class="necesary-drink" data-aos="fade-up">
        <div class="necesary-content">
            <div class="necesary-content-text">
                <div class="text-drinks">
                    <h3>¿Qué instrumentos necesito?</h3>
                    <ul>
                        @foreach ($drink->instrumentos as $instrumento)
                            <li>{{ $instrumento->nombre }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="necesary-content-img">
                <img src="{{ asset('storage/' . $drink->imagenes->last()->ruta) }}" alt="{{ $drink->nombre }}">
            </div>
        </div>
    </section>

    <section class="banner-ad2" data-aos="fade-up" data-aos="fade-up">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('image/absolut-drinks/Absolut Vodka Spec Commercial.mp4') }}" type="video/mp4">
        </video>
        <div class="banner-absolut-drinks2">
            <h2>{{ $drink->nombre }}</h2>
        </div>
    </section>

    <section class="necesary-drink2" data-aos="fade-up">
        <div class="necesary-content">
            <div class="necesary-content-img">
                <img src="{{ asset('storage/' . $drink->imagen) }}" alt="{{ $drink->nombre }}">
            </div>
            <div class="necesary-content-text">
                <div class="text-drinks2">
                    <h3>¿Cómo mezclarlo con el toque Absolut?</h3>
                    <ul>
                        @foreach (json_decode($drink->pasos) as $index => $paso)
                            <li>{{ $paso }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <section class="history-drink" data-aos="fade-up">
        <div class="history-content">
            <h2>La historia de <span>{{ $drink->nombre }}</span></h2>
            <p>{{ $drink->texto }}</p>
        </div>
    </section>

    <section class="more-drinks" data-aos="fade-up">
        <div class="drinks-titulo2">
            <h2>Descubre más Absolut Drinks</h2>
          </div>
        <div class="drinks-cards">
            <div class="drink-card">
              <img src="{{ asset('image/tienda/drinks/AD-2.png') }}">
              <h4>Bloody Mary</h4>
            </div>
            <div class="drink-card">
              <img src="{{ asset('image/tienda/drinks/AD-1.png') }}">
              <div class="drink-card-title">
                <h4>Cosmopolitan</h4>
              </div>
            </div>
            <div class="drink-card">
              <img src="{{ asset('image/tienda/drinks/AD-3.png') }}">
              <h4>White Russian</h4>
            </div>
          </div>
          <div class="drinks-vermas">
            <a href="{{ route('absolutDrinks') }}" class="btn-ver-mas">VER MÁS</a>
          </div>
    </section>

    <section class="seccion-valoracion" data-aos="fade-up">
        <h2>¿Lo has probado?</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('usuario'))
            <form class="form-valoracion" action="{{ route('comentar', $drink->id) }}" method="POST">
                @csrf
                <div class="estrellas">
                    <input type="radio" id="estrella5" name="rating" value="5"><label for="estrella5">&#9733;</label>
                    <input type="radio" id="estrella4" name="rating" value="4"><label for="estrella4">&#9733;</label>
                    <input type="radio" id="estrella3" name="rating" value="3"><label for="estrella3">&#9733;</label>
                    <input type="radio" id="estrella2" name="rating" value="2"><label for="estrella2">&#9733;</label>
                    <input type="radio" id="estrella1" name="rating" value="1"><label for="estrella1">&#9733;</label>
                </div>

                <textarea placeholder="Escribe tu comentario aquí..." name="comentario" required></textarea>
                <button type="submit">Enviar valoración</button>
            </form>
        @else
            @php
                session(['url.intended' => route('drink', ['id' => $drink->id])]);
            @endphp
            <a href="{{ route('miCuenta') }}">Inicia sesion para valorar</a>
        @endif

        <div class="comentarios">
            <h3>Comentarios</h3>

            @forelse ($drink->reseñas->where('parent_id', null) as $reseña)
                {{-- Comentario principal --}}
                <div class="comentario">
                    <div class="info-comentario">
                        <span class="nombre">{{ $reseña->usuario }}</span>
                        <div class="valoracion">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $reseña->valoracion)
                                    &#9733;
                                @else
                                    &#9734;
                                @endif
                            @endfor
                        </div>
                        <span class="fecha">{{ $reseña->created_at->format('d M Y') }}</span>
                    </div>
                    <p class="texto">{{ $reseña->comentario }}</p>

                    {{-- Botón para responder --}}
                    <button class="responder-btn">Responder</button>

                    {{-- Formulario de respuesta (se oculta inicialmente) --}}
                    <form action="{{ route('responder', $reseña->id) }}" method="POST" class="form-respuesta">
                        @csrf
                        <textarea name="comentario" placeholder="Escribe tu respuesta..." required></textarea>
                        <button type="submit">Enviar respuesta</button>
                    </form>

                    {{-- Respuestas anidadas --}}
                    @foreach ($reseña->respuestas as $respuesta)
                        <div class="comentario respuesta">
                            <div class="info-comentario">
                                <span class="nombre">{{ $respuesta->usuario }}</span>
                                <span class="fecha">{{ $respuesta->created_at->format('d M Y') }}</span>
                            </div>
                            <p class="texto">{{ $respuesta->comentario }}</p>

                            <button class="responder-btn">Responder</button>

                            {{-- Formulario para responder a una respuesta --}}
                            <form action="{{ route('responder', $respuesta->id) }}" method="POST" class="form-respuesta">
                                @csrf
                                <textarea name="comentario" placeholder="Escribe tu respuesta..." required></textarea>
                                <button type="submit">Enviar respuesta</button>
                            </form>

                            {{-- Anidado de más respuestas --}}
                            @if ($respuesta->respuestas->count() > 0)
                                @foreach ($respuesta->respuestas as $subRespuesta)
                                    <div class="comentario respuesta" style="margin-left: 20px;">
                                        <div class="info-comentario">
                                            <span class="nombre">{{ $subRespuesta->usuario }}</span>
                                            <span class="fecha">{{ $subRespuesta->created_at->format('d M Y') }}</span>
                                        </div>
                                        <p class="texto">{{ $subRespuesta->comentario }}</p>

                                        <button class="responder-btn">Responder</button>

                                        {{-- Formulario para responder a una subrespuesta --}}
                                        <form action="{{ route('responder', $subRespuesta->id) }}" method="POST" class="form-respuesta">
                                            @csrf
                                            <textarea name="comentario" placeholder="Escribe tu respuesta..." required></textarea>
                                            <button type="submit">Enviar respuesta</button>
                                        </form>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>

            @empty
                <p>Aún no hay comentarios para este cóctel. ¡Sé el primero en comentar!</p>
            @endforelse
        </div>
    </section>

    <div class="separador"></div>

    <section class="newsletter" data-aos="fade-up">
        <div class="newsletter-tienda">
          <div class="newsletter-texto">
            <h2>Ahora formas parte de otro mundo.</h2>
            <p><strong>5% de descuento</strong> en tu primera compra.</p>
          </div>
          <form class="newsletter-form">
            <div class="input-wrapper">
              <input type="email" placeholder="Tu correo electrónico" required>
              <button type="submit">UNIRME</button>
            </div>
            <div class="checkbox-legal">
              <input type="checkbox" id="legal" required>
              <label for="legal">
                He leído y acepto el <a href="{{ route('avisoLegal') }}" target="_blank">aviso legal</a> y la <a href="{{ route('politicaPrivacidad') }}" target="_blank">política de privacidad</a>.
              </label>
            </div>
          </form>
        </div>
      </section>

    @include('partials.footer')

    <script>
      const hamburger = document.getElementById('hamburger');
      const nav = document.getElementById('nav');

      hamburger.addEventListener('click', () => {
        nav.classList.toggle('active');
      });
    </script>
        <script>
            const responderBtns = document.querySelectorAll('.responder-btn');

            responderBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const formRespuesta = btn.nextElementSibling;

                    if (formRespuesta.classList.contains('activo')) {
                        formRespuesta.classList.remove('activo');
                        formRespuesta.style.display = 'none';
                    } else {
                        formRespuesta.classList.add('activo');
                        formRespuesta.style.display = 'block';
                    }
                });
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/carrusel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>
</body>
</html>
