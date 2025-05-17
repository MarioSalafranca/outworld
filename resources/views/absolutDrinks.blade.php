<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absolut Drinks</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="tienda2">
@include('partials.header')
<div class="negro"></div>
    <div class="beige" data-aos="fade-up"></div>
    <section class="banner-ad" data-aos="fade-up">
        <div class="banner-absolut-drinks">
            <h2>De absolut a la <span class="ad">perfección,</span><br>un cóctel que convierte cada momento <br> en una obra de <span class="ad">arte.</span></h2>
            <div class="mediaimg">
                <img src="image/logo/AD.png">
            </div>
        </div>
    </section>

    <section class="search-and-filters" data-aos="fade-up">
        <div class="search-bar-inline">
            <div class="search-input">
              <input type="text" placeholder="Del vodka al arte en un solo shake..." id="productSearch" />
              <button id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
          </div>

          <div class="filter-options">

            <!-- Botón de reset -->
            <button class="filter-btn" id="reset-filters">Resetear filtros</button>
            <div class="filter-dropdown">
              <button class="filter-btn" data-category="tipo-coctel">Tipo de cóctel ▾</button>
              <div class="dropdown-content">
                <button class="filter-sub" data-subcategory="clasico">Clásico</button>
                <button class="filter-sub" data-subcategory="innovador">Innovador</button>
                <button class="filter-sub" data-subcategory="refrescante">Refrescante</button>
              </div>
            </div>

            <div class="filter-dropdown">
                <button class="filter-btn" data-category="base-sabor">Base de sabor ▾</button>
                <div class="dropdown-content">
                  <button class="filter-sub" data-subcategory="dulce">Dulce</button>
                  <button class="filter-sub" data-subcategory="amargo">Amargo</button>
                  <button class="filter-sub" data-subcategory="acido">Ácido</button>
                  <button class="filter-sub" data-subcategory="suave">Suave</button>
                  <button class="filter-sub" data-subcategory="picante">Picante</button>
                </div>
            </div>

            <div class="filter-dropdown">
                <button class="filter-btn" data-category="tiempo-preparacion">Tiempo de preparación ▾</button>
                <div class="dropdown-content">
                  <button class="filter-sub" data-subcategory="rapido">Rápido</button>
                  <button class="filter-sub" data-subcategory="medio">Medio</button>
                  <button class="filter-sub" data-subcategory="lento">Lento</button>
                </div>
            </div>
            <button id="apply-filters" class="filter-btn">Aplicar Filtros</button>
          </div>
          <div class="dropdown-spacer"></div>
    </section>

    <section class="absolut-drinks-content" data-aos="fade-up">
        <div class="products-content">

            @foreach ($drinks as $drink)
                <div class="product">
                    <a href="{{ route('drink', ['id' => $drink->id]) }}">
                        <div class="product-img">
                            <img src="{{ asset('storage/' . $drink->imagen) }}" alt="{{ $drink->nombre }}">
                        </div>

                        <div class="product-titulo">
                            <h3>{{ $drink->nombre }}</h3>

                            <!-- Listado de ingredientes en formato resumido -->
                            <p>
                                @foreach ($drink->ingredientes->take(3) as $ingrediente)
                                    {{ $ingrediente->nombre }}@if(!$loop->last),@endif
                                @endforeach
                            </p>

                            <!-- Valoración -->
                            <div class="stars">
                                @php
                                    $reseñasPrincipales = $drink->reseñas->where('parent_id', null);

                                     $valoracionMedia = $reseñasPrincipales->avg('valoracion');

                                     $valoracionEntera = floor($valoracionMedia);
                                     $mitad = $valoracionMedia - $valoracionEntera >= 0.5;
                                @endphp

                                    <!-- Estrellas llenas -->
                                @for ($i = 0; $i < $valoracionEntera; $i++)
                                    <div class="star filled"></div>
                                @endfor

                                <!-- Estrella a la mitad -->
                                @if ($mitad)
                                    <div class="star half"></div>
                                @endif

                                <!-- Estrellas vacías -->
                                @for ($i = 0; $i < (5 - $valoracionEntera - ($mitad ? 1 : 0)); $i++)
                                    <div class="star"></div>
                                @endfor
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </section>

    <div class="pagination-containerTienda">
        <button class="pagination-btn prev">←</button>
        <button class="pagination-btn active">1</button>
        <button class="pagination-btn">2</button>
        <button class="pagination-btn">3</button>
        <button class="pagination-btn">4</button>
        <button class="pagination-btn next">→</button>
    </div>

    <section class="house-of-coctel" data-aos="fade-up">
        <div class="house-of-coctel-title">
            <h2>El Hogar de la Cultura del Cóctel.</h2>
            <h3>Absolut Drinks.</h3>
        </div>

        <div class="house-cuadricula">
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/8.jpeg" alt="Foto 1">
                    <div class="photo-info">
                        <span>Oliver Smith</span>
                        <p>London, UK</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/1.jpeg" alt="Foto 2">
                    <div class="photo-info">
                        <span>Lukas Müller</span>
                        <p>Zurich, CH</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/2.jpeg" alt="Foto 3">
                    <div class="photo-info">
                        <span>Sofía González</span>
                        <p>Buenos Aires, ARG</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/3.jpeg" alt="Foto 4">
                    <div class="photo-info">
                        <span>Emma MacDonald</span>
                        <p>Edimburgo, UK</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/4.jpeg" alt="Foto 5">
                    <div class="photo-info">
                        <span>Lucas Dupont</span>
                        <p>París, FR</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/5.jpeg" alt="Foto 6">
                    <div class="photo-info">
                        <span>Alberto Cortés</span>
                        <p>Ibiza, ES</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/3.jpeg" alt="Foto 7">
                    <div class="photo-info">
                        <span>Adrián Oller</span>
                        <p>Madrid, ES</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/11.jpeg" alt="Foto 8">
                    <div class="photo-info">
                        <span>Louis Dupuis</span>
                        <p>Bruselas, BE</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/8.jpeg" alt="Foto 9">
                    <div class="photo-info">
                        <span>Olivia Smith</span>
                        <p>Washington, US</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/9.jpeg" alt="Foto 10">
                    <div class="photo-info">
                        <span>Isabella Brown</span>
                        <p>Nueva York, US</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/14.jpeg" alt="Foto 11">
                    <div class="photo-info">
                        <span>Hiroshi Tanaka</span>
                        <p>Nagoya, JP</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/11.jpeg" alt="Foto 12">
                    <div class="photo-info">
                        <span>Wei Zhang</span>
                        <p>Shangai, CH</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/12.jpeg" alt="Foto 13">
                    <div class="photo-info">
                        <span>David Nus</span>
                        <p>Marbella, ES</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/13.jpeg" alt="Foto 14">
                    <div class="photo-info">
                        <span>Luca Rossi</span>
                        <p>Milán, IT</p>
                    </div>
                </a>
            </div>
            <div class="house-cuadro">
                <a href="https://www.instagram.com/nombreusuario" target="_blank">
                    <img src="image/absolut-drinks/house-of-coctel/14.jpeg" alt="Foto 15">
                    <div class="photo-info">
                        <span>Maria Ferreira</span>
                        <p>Algarve, PT</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="explain-text">
            <div class="explain">
                <p>¿Te gustaría formar parte de <span class="hashtag">House of Coctel</span>? ¡Es tu oportunidad de brillar!</p>
                <p>Solo tienes que subir una foto creativa de tu cóctel a tu feed, etiquetarnos en la publicación <strong>(@absolutvodka)</strong> y no olvides incluir el hashtag <span class="hashtag2">#HouseOfCoctel</span> para unirte a la experiencia.
                ¡Queremos ver cómo disfrutas de tus momentos con Absolut! Cada publicación es una oportunidad para ser parte de una comunidad única, donde los cócteles y la creatividad se encuentran.
                ¡Anímate, participa y quién sabe! Tu foto podría ser la próxima en destacar en nuestra <span class="hashtag">House of Coctel</span>.
            </div>
        </div>
    </section>

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
