<footer class="footer">
    <div class="footer-content">

        <div class="footer-columns">
            <div class="footer-col">
                <img src="{{ asset('image/logo/OUTWORLD-BLACK.png') }}" alt="OUTWORLD logo" class="logofooter">
            </div>
            <!-- LEGAL -->
            <div class="footer-col">
                <h4>LEGAL</h4>
                <ul>
                    <li><a href="{{ route('politicaPrivacidad') }}">Política de privacidad</a></li>
                    <li><a href="{{ route('politicaCookies') }}">Política de cookies</a></li>
                    <li><a href="{{ route('avisoLegal') }}">Aviso legal</a></li>
                </ul>
            </div>

            <!-- INFORMACIÓN GENERAL -->
            <div class="footer-col">
                <h4>INFORMACIÓN GENERAL</h4>
                <ul>
                    <li><a href="{{ route('home') }}">OUTWORLD</a></li>
                    <li><a href="{{ route('absolutDrinks') }}">Absolut Drinks</a></li>
                    <li><a href="{{ route('contacto') }}">Contacto</a></li>
                    <li><a href="{{ route('tienda') }}">Experimental</a></li>
                </ul>
            </div>

            <!-- REDES Y MÉTODOS DE PAGO -->
            <div class="footer-col">
                <h4>SÍGUENOS</h4>
                <div class="footer-social">
                    <a href="https://www.facebook.com/groups/285987221415455/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/the-absolut-group/?originalSubdomain=se" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/absolutvodka/?hl=es" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://x.com/absolutvodka?lang=es" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
                <p><strong>Leading the edge.</strong><br>
                    Outworld recomienda el consumo responsable. +18.</p>

                <div class="footer-pagos">
                    <img src="{{ asset('image/payments/mastercard.png') }}" alt="Mastercard" class="mastercard">
                    <img src="{{ asset('image/payments/visa.png') }}" alt="Visa">
                    <img src="{{ asset('image/payments/applepay.png') }}" alt="Apple Pay">
                    <img src="{{ asset('image/payments/paypal.png') }}" alt="PayPal">
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copy">
        <p>2025 Copyright © OUTWORLD</p>
    </div>
</footer>
