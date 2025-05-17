<header>
        <div class="general-header">
            <div class="logo-wrapper">
              <a href="{{ route('home') }}"><img src="{{ asset('image/logo/OUTWORLD-WHITE.png') }}" class="logoHeader" alt="Logo OUTWORLD"></a>
            </div>

            <button class="hamburger" id="hamburger">
    ☰
            </button>

            <nav class="nav" id="nav">
                <ul class="nav-links">
                    <li><a href="{{ route('tienda') }}">PRODUCTOS</a></li>
                    <li><a href="{{ route('historia') }}">HISTORIA</a></li>
                    <li><a href="{{ route('home') }}">EXPERIMENTAL</a></li>
                    <li><a href="{{ route('absolutDrinks') }}">DRINKS</a></li>
                    <li><a href="{{ route('contacto') }}">CONTACTO</a></li>
                </ul>
            </nav>
        </div>
</header>
