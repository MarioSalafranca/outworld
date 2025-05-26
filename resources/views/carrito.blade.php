<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
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

    <div class="carrito__contenedor">
        <a href="{{ route('tienda') }}" class="seguir-comprando"><p>Seguir comprando</p></a>
        <h1 class="carrito__titulo">TU CESTA</h1>

        <div class="carrito__contenido">

          <div class="carrito__productos">
            <div class="carrito__entrega">ENTREGA: 05 MAY – 06 MAY</div>

          </div>

          <div class="carrito__resumen">

            <div class="carrito__precio-desglose">
              <div class="carrito__fila">
                <span>Subtotal (IVA incl.)</span><span>15,40 €</span>
              </div>
              <div class="carrito__fila">
                <span>Envío (IVA incl.)</span><span>5,00 €</span>
              </div>
              <div class="carrito__fila-total">
                <strong>TOTAL (IVA incl.)</strong><strong>20,40 €</strong>
              </div>
            </div>

            <form id="checkoutForm" action="{{ route('procesarPedido') }}" method="POST" target="_blank">
              @csrf
              <input type="hidden" name="carrito" id="carritoData">
              <button type="submit" class="carrito__tramitar">Tramitar pedido</button>
            </form>
          </div>

        </div>
      </div>

      <section class="newsletter" data-aos="fade-up" id="newsletter">
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
          <div id="newsletter-confirm" class="newsletter-confirm2">
             ¡Bienvenido al universo OUTWORLD.! Revisa tu email.
          </div>
        </div>
    </section>
    @include('partials.footer')
    <script>
        (function(){
            const form = document.getElementById('checkoutForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const carritoJson = localStorage.getItem('carrito');
                document.getElementById('carritoData').value = carritoJson;

                localStorage.removeItem('carrito');

                if (typeof actualizarCarritoFlotante === 'function') {
                    actualizarCarritoFlotante();
                }
                if (typeof actualizarContadorCarrito === 'function') {
                    actualizarContadorCarrito();
                }
                if (typeof cargarCarrito === 'function') {
                    cargarCarrito();
                }

                form.submit();
            });
        })();

        // NEWSLETTER
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
    <script src="js/carrito.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>

</body>
</html>
