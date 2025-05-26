<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tienda</title>
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

    <section class="promo-products" data-aos="fade-up">
        <div class="promo-slider">

          <!-- Slide 1 -->
          <div class="promo-contenido active">
            <div class="promo-texto">
              <h4>NOVEDAD</h4>
              <h2>Camiseta de Fútbol Retro</h2>
              <p>
                Una fusión entre espíritu deportivo y diseño atemporal. Inspirada en camisetas clásicas,
                esta pieza rinde homenaje a la cultura del fútbol y al estilo sin filtros de Absolut.
                Edición limitada.
              </p>
              <a href="{{ route('producto', ['id' => 31]) }}" class="btn-promo">CONSÍGUELA</a>
            </div>
            <div class="promo-imagen">
              <img src="{{ asset('image/tienda/promo/meteor.png') }}" alt="Absolut X Meteor">
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="promo-contenido">
            <div class="promo-texto">
              <h4>PROMOCIÓN</h4>
              <h2>Comparte Absolut</h2>
              <p>
                Nueva colección de vasos absolut, si tu pedido es superior a 50€ te regalamos 2 vasos
                absolut para que brindes en compañia.
              </p>
              <a href="{{ route('producto', ['id' => 31]) }}" class="btn-promo">DESCUBRIR</a>
            </div>
            <div class="promo-imagen">
              <img src="{{ asset('image/tienda/promo/vaso-absolut.png') }}" alt="Absolut Art">
            </div>
          </div>

        </div>
      </section>

      <section class="filter" >
        <div class="filter-options">
          <button class="filter-btn active" data-category="all">Todos</button>

          <div class="filter-dropdown">
            <button class="filter-btn" data-category="vodka">Vodka ▾</button>
            <div class="dropdown-content">
              <button class="filter-sub" data-subcategory="50% ABV">50%</button>
              <button class="filter-sub" data-subcategory="40% ABV">40%</button>
              <button class="filter-sub" data-subcategory="38% ABV">38%</button>
              <button class="filter-sub" data-subcategory="35% ABV">35%</button>
            </div>
          </div>

          <button class="filter-btn" data-category="experimental">Experimental</button>
          <button class="filter-btn" data-category="accesorios">Accesorios</button>
        </div>
      </section>

    <div class="cart-popup" id="cartPopup">
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-total">
            <strong>Subtotal:</strong> <span id="cartSubtotal">0€</span>
        </div>
        @if (session()->has('usuario'))
            <a href="{{ route('carrito') }}">
                <button class="view-cart">Ver carrito</button>
            </a>
        @else
            <a href="{{ route('cuenta', ['redirect' => route('carrito')]) }}">
                <button class="view-cart">Ver carrito</button>
            </a>
        @endif
    </div>

    <section class="products" data-aos="fade-up">
        <div class="products-content">
            @foreach($productos as $producto)
                <div class="product"  data-product-id="{{ $producto->id }}" data-product-price="{{ $producto->precio }}" data-product-stock="{{ $producto->stock }}">
                    <a href="{{ route('producto', ['id' => $producto->id]) }}">
                        <div class="product-img">
                            @php
                                $categoriaPrincipal = $producto->categorias->firstWhere('nombre', 'Experimental');

                                if (!$categoriaPrincipal && $producto->categorias->isNotEmpty()) {
                                    $categoriaPrincipal = $producto->categorias->first();
                                }
                            @endphp
                            @if ($categoriaPrincipal)
                                <div class="badge">{{ $categoriaPrincipal->nombre }}</div>
                            @endif

                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                            @if($producto->imagenes->isNotEmpty())
                                <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}" class="img-hover" alt="Hover image">
                            @endif
                        </div>
                        <div class="product-titulo">
                            <h3>{{ $producto->nombre }}</h3>
                        </div>
                        <div class="accion">
                            <button class="btn-compra">
                                <span>Añadir al carrito</span>
                                <img src="{{ asset('image/iconos/carrito-black.png') }}" alt="Carrito" class="icon-cart">
                            </button>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Paginación personalizada -->
    <div class="pagination-containerTienda">
        <!-- Botón de página anterior -->
        @if ($productos->onFirstPage())
            <button class="pagination-btn prev" disabled>←</button>
        @else
            <a href="{{ $productos->previousPageUrl() }}">
                <button class="pagination-btn prev">←</button>
            </a>
        @endif

        <!-- Botones de página -->
        @for ($i = 1; $i <= $productos->lastPage(); $i++)
            <a href="{{ $productos->url($i) }}">
                <button class="pagination-btn {{ $productos->currentPage() == $i ? 'active' : '' }}">
                    {{ $i }}
                </button>
            </a>
        @endfor

        <!-- Botón de página siguiente -->
        @if ($productos->hasMorePages())
            <a href="{{ $productos->nextPageUrl() }}">
                <button class="pagination-btn next">→</button>
            </a>
        @else
            <button class="pagination-btn next" disabled>→</button>
        @endif
    </div>

    <section class="product-absolut-drinks" data-aos="fade-up">
        <div class="drinks-content">
          <div class="drinks-titulo">
            <h2>Absolut drinks</h2>
            <p>¿Ya tienes tu botella? Ahora viene lo mejor.
              Explora nuestra selección de cócteles y combinaciones con Absolut: fáciles, rápidos y con un toque único.
              Desde clásicos reinventados hasta creaciones experimentales, aquí empieza tu próxima mezcla favorita.
              Porque Absolut no solo se bebe. Se mezcla, se comparte, se celebra.</p>
          </div>
        </div>

        <div class="drinks-cards">
          <a href="{{ route('drink', ['id' => 2]) }}">
          <div class="drink-card">
            <img src="{{ asset('image/tienda/drinks/AD-2.png') }}">
            <h4>Bloody Mary</h4>
          </div>
          </a>
          <a href="{{ route('drink', ['id' => 10]) }}">
          <div class="drink-card">
            <img src="{{ asset('image/tienda/drinks/AD-1.png') }}">
            <div class="drink-card-title">
              <h4>Cosmopolitan</h4>
            </div>
          </div>
          </a>
          <a href="{{ route('drink', ['id' => 11]) }}">
          <div class="drink-card">
            <img src="{{ asset('image/tienda/drinks/AD-3.png') }}">
            <h4>White Russian</h4>
          </div>
          </a>
        </div>
        <div class="drinks-vermas">
          <a href="absolutDrinks.html" class="btn-ver-mas">VER MÁS</a>
        </div>
      </section>

      <section class="shop-info" data-aos="fade-up">
        <div class="info-content">
          <div class="info-shop">
            <div class="content-img">
              <img src="{{ asset('image/iconos/envio.png') }}">
            </div>
            <div class="content-text">
              <h4>Entrega Rápida</h4>
              <p>Recibe tu pedido en 48/72 horas dentro de la peninsula</p>
            </div>
          </div>
          <div class="info-shop">
            <div class="content-img">
              <img src="{{ asset('image/iconos/exclusivo.png') }}">
            </div>
            <div class="content-text">
              <h4>Exclusividad al alcance.</h4>
              <p>Descubre lanzamientos únicos y productos de colección que no volverán.</p>
            </div>
          </div>
          <div class="info-shop">
            <div class="content-img">
              <img src="{{ asset('image/iconos/sostenible.png') }}">
            </div>
            <div class="content-text">
              <h4>Cuidamos cada detalle.</h4>
              <p>Nuestros envíos usan materiales reciclables y respetuosos con el medio ambiente.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="banner-ad" data-aos="fade-up">
        <div class="banner-absolut-drinks3">
            <h2>Mezclar es un <span class="ad">arte...</span><br>y aquí empieza tu próxima <br> <span class="ad">obra maestra.</span></h2>
        </div>
      </section>

      <section class="newsletter" data-aos="fade-up" id="newsletter">
        <div class="newsletter-tienda">
          <div class="newsletter-texto">
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
                He leído y acepto el <a href="AvisoLegal.html" target="_blank">aviso legal</a> y la <a href="PoliticaPrivacidad.html" target="_blank">política de privacidad</a>.
              </label>
            </div>
          </form>
          <div id="newsletter-confirm" class="newsletter-confirm2">
              ¡Bienvenido al universo OUTWORLD.! Revisa tu email.
          </div>
        </div>
      </section>

    @include('partials.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.newsletter-form');
            const confirmBox = document.getElementById('newsletter-confirm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                form.style.display = 'none';
                confirmBox.style.display = 'block';
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/generico.js"></script>
    <script src="js/tienda.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
      <script>
      AOS.init({
          duration: 1000,
          once: true
      });
      </script>


</body>
</html>
