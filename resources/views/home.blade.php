<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUTWORLD</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
@include('partials.header')
    <!-- Carrusel Hero -->
<section class="general-slider" data-aos="fade-up">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide">
            <img src="image/main-slider/ABSOLUT_X_MADRID.png" class="hero-image" alt="Campaña Absolut">
            <div class="hero-content">
                <h1>OUT OF <br> THIS. <br>OUTWORLD.</h1>
                <h2>OUTWORLD X MADRID</h2>
                <p>Absolut by Outworld ha sido medalla de oro<br>en el World Vodka Challenge de 2025 <br>
                    con una puntuacion perfecta: 100/100<br><br>Palacio de Liria – Madrid.</p>
                <a href="#" class="hero-btn">COMPARTE</a>
            </div>
        </div>

        <!-- Slide 2 (puedes cambiar imagen y texto) -->
        <div class="swiper-slide">
            <img src="image/main-slider/BARSA_X_OUTWORLD.png" class="hero-image" alt="Slide 2">
            <div class="hero-content">
                <h1>LIDERES <br>EN EL CAMPO.</h1>
                <h2>OUTWORLD X BARÇA</h2>
                <p>Desde hoy, Outworld es nuevo patrocinador<BR> oficial del FC Barcelona.<br>
                    Porque las grandes historias merecen grandes aliados.<br><br> Camp Nou – Barcelona</p>
                <a href="#" class="hero-btn">DESCUBRE</a>
            </div>
        </div>

        <div class="swiper-slide">
            <img src="image/main-slider/WARHOL.png" class="hero-image" alt="Slide 2">
            <div class="hero-content">
                <h1>ABSOLUT EXPERIMENTAL</h1>
                <h2>WARHOL</h2>
                <p>Arte, vodka y actitud. Solo para los que <br> se atreven a mezclarlo todo. <br>
                Inspirada en Andy Warhol. Born to mix.</p>
                <a href="#" class="hero-btn">CONSÍGUELO</a>
            </div>
        </div>

        </div>
        <div class="custom-pagination"></div>
    </div>
 </section>

  <section class="productos-slider" data-aos="fade-up" data-aos-offset="200">
    <div class="encabezado-productos">
        <h2>La colección Absolut: más que vodka, una actitud.</h2>
    </div>
    <div class="general-slider-productos">
      <div class="infoProductos-promo">

        <p>
          <span>Absolut</span> no es solo una marca de vodka.
          Es una declaración de intenciones. Desde 1979, ha roto las reglas del
          mercado global con un espíritu libre, creativo e innovador.
          Cada botella encapsula una forma distinta de ver la vida:
          <strong>auténtica, atrevida y con estilo</strong>.<br><br>

          Hoy, bajo el universo de <strong>OUTWORLD</strong>, Absolut alcanza una nueva dimensión:
          una propuesta que trasciende el sabor para convertirse en cultura, en arte, en actitud.
          OUTWORLD no solo distribuye productos premium, sino que crea experiencias que conectan con
          quienes se atreven a ir más allá.<br><br>

          En esta selección descubrirás sabores emblemáticos que han hecho historia:
          desde cítricos vibrantes hasta toques exóticos como mango, frambuesa o vainilla.
          Ediciones limitadas, colaboraciones icónicas y una estética reconocible en cualquier parte del mundo.
          Absolut transforma lo cotidiano en algo extraordinario, y convierte cualquier mezcla en una
          <strong>experiencia de alto nivel</strong>.<br><br>

          Porque no se trata solo de beber vodka. Se trata de celebrar momentos, compartir historias
          y elegir lo que verdaderamente representa tu estilo.
        </p>
        <span class="span2">¿Con cuál vas a brindar?</span><br><br><br>
         <a href="{{ route('tienda') }}" class="btn-shop">GAMA COMPLETA</a>

      </div>
      <div class="swiper productSwiper">
        <div class="swiper-wrapper">
            @foreach ($productos as $producto)
            <div class="swiper-slide">
                <img src="{{ asset('/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                <div class="product-buttons">
                    <a href="{{ route('tienda') }}" class="btn-outline">MÁS INFO</a>
                    <a href="{{ route('producto', $producto->id) }}" class="btn-filled">COMPRA</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Flechas -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </section>

  <section class="noticias-home" data-aos="fade-up">
    <h2>Reporte Outworld. Noticias de la semana.</h2>
    <div class="noticias">
      <div class="noticia noticia1" data-texto="Camiseta Meteor"></div>
      <div class="noticia noticia2" data-texto="Absolut X Outworld"></div>
      <div class="noticia noticia3" data-texto="Dia de partido. J35"></div>
    </div>
  </section>

  <section class="outworld-historia" data-aos="fade-up">
    <div class="historia-contenedor">
      <div class="historia-texto">
        <h2>Nuestra Historia</h2>
        <h3 id="historia-year">1979</h3>
        <p id="historia-text">
          Absolut nació en Suecia con una idea y mision clara: redefinir el vodka.
          Desde ese primer destello en 1979, no solo revolucionamos la forma de destilar,
          sino también la manera de expresarnos. Lo que empezó como una botella icónica y una pequeña
          fabrica al norte se Suecia, hoy es un símbolo de actitud globlamente reconocido.
        </p>

      </div>
      <div class="historia-imagen">
        <img id="historia-img" src="image/historia/fabrica.jpg" alt="Historia de Absolut">
      </div>
    </div>
  </section>

  <section class="timeline-full" data-aos="fade-up">
    <div class="timeline-wrapper">
      <div  class="timeline-year active-year" data-year="1979">1979</div>
      <div class="timeline-year" data-year="1990">1990</div>
      <div class="timeline-year" data-year="2007">2007</div>
      <div class="timeline-year" data-year="2024">2024</div>
      <div class="timeline-year" data-year="2025">2025</div>
    </div>
    <a href="{{ route('historia') }}" class="btn-ver-mas">VER MÁS</a>
  </section>

  <section class="absolut-experimental" data-aos="fade-up">
    <div class="experimental-contenido">
      <div class="experimental-texto">
        <h2>Absolut Experimental</h2>
        <h3>Ediciones que rompen la fórmula.</h3>
        <p>
          Nacida de la visión de OUTWORLD, Absolut Experimental es una colección de ediciones limitadas que desafían lo establecido.
          Nuevos sabores, colaboraciones inesperadas y mezclas impensables se reúnen bajo una misma idea: <strong>crear lo que aún no existe.</strong>
          Cada botella es una declaración de innovación, arte y actitud.
        </p>
        <a href="{{ route('home') }}" class="btn-experimental">DESCÚBRELO</a>
      </div>
      <div class="experimental-imagen">
        <img src="image/recursos/experimental.png" alt="Absolut Experimental">
      </div>
    </div>
  </section>

  <section class="banner-ad" data-aos="fade-up">
    <div class="banner-absolut-drinks4">
        <h2>Made with<span class="ad"> swedish <br> water</span> and winter <br> wheat.</h2>
        <div class="mediaimg">
            <img src="image/logo/AD.png">
        </div>
    </div>
  </section>

  <section class="absolut-drinks" data-aos="fade-up">
    <div class="drinks-contenido">
      <div class="experimental-imagen">
        <img src="image/recursos/drinks.jpg" alt="Absolut Experimental">
      </div>
      <div class="drinks-texto">
        <h2>Absolut Drinks</h2>
        <h3>Del vodka al arte en un solo shake.</h3>
        <p>
          ¿Te apetece un Cosmopolitan? ¿Bloody Mary? ¿O tal vez un White Russian con mucho estilo?
          En Absolut Drinks te damos las claves para preparar cocteles icónicos y atrevidos con el sello Absolut.
          Descubre combinaciones clásicas, creaciones experimentales y todo lo que necesitas para convertir tu casa en
          el bar más creativo del planeta.<strong> Porque mezclar es un arte... y aquí empieza tu próxima obra maestra. </strong></p>
        </p>
        <a href="{{ route('absolutDrinks') }}" class="btn-drinks">EMPIEZA</a>
      </div>
    </div>
  </section>

  <section class="newsletter" data-aos="fade-up">
    <div class="newsletter-general">
      <div class="newsletter-texto">
        <h2>Ahora formas parte de otro mundo.</h2>
        <p>Bienvenido: <strong>5% de descuento</strong> en tu primera compra.</p>
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
