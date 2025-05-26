<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Outworld</title>
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
            <a href="#" class="btn-newsletter">Haz click aquí</a>
        </div>
      </div>
      @include('partials.header-secundario')

      <section class="inicio-registro">
        <div class="inic-registro">
            <div class="login-img">
                <img src="image/historia/2017-port.png">
            </div>
            <div class="login-content">
                <h2>Iniciar sesión</h2>

                <form class="login-form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="log-form">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <input type="email" placeholder="Tu correo electrónico" name="email" required>
                        <input type="password" placeholder="Contraseña" name="password" required>
                        <button type="submit" class="btn-login-iniciar">INICIAR SESIÓN</button>
                    </div>
                </form>
            </div>
        </div>
          <div class="inic-registro">
              <div class="login-content">
                  <h2>Registro</h2>

                  <form class="register-form" action="{{ route('register') }}"  method="POST">
                      @csrf
                      <div class="reg-form">

                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif

                          <input type="text" placeholder="Nombre" name="nombre" required>
                          <input type="text" placeholder="Apellido" name="apellido" required>
                          <input type="text" placeholder="Usuario" name="usuario_user" required>
                          <input type="text" placeholder="Telefono" name="telefono" required>
                          <div class="direccion">
                              <button type="button" id="mostrarDireccionBtn" class="btn-direccion">Añadir dirección</button>
                              <div class="direccion-campos">
                                  <input type="text" placeholder="Calle" name="calle" required>
                                  <input type="text" placeholder="Ciudad" name="ciudad" required>
                                  <input type="text" placeholder="Código Postal" name="cp" required>
                                  <input type="text" placeholder="País" name="pais" required>
                                  <input type="text" placeholder="Número" name="numero" required>
                              </div>
                          </div>

                          <input type="email" placeholder="Tu correo electrónico" name="email" required>
                          <input type="password" placeholder="Contraseña" name="password" required>

                          <div class="checkbox-legal">
                              <input type="checkbox" id="legal" required>
                              <label for="legal">
                                  He leído y acepto el <a href="{{ route('avisoLegal') }}" target="_blank">aviso legal</a> y la <a href="{{ route('politicaPrivacidad') }}" target="_blank">política de privacidad</a>.
                              </label>
                          </div>
                          <button type="submit" class="btn-register-unirme">UNIRME</button>
                      </div>

                  </form>
              </div>
          </div>
      </section>

      @include('partials.footer')

      <script>
        const mostrarDireccionBtn = document.getElementById('mostrarDireccionBtn');
        const direccionCampos = document.querySelector('.direccion-campos');

        mostrarDireccionBtn.addEventListener('click', () => {
            direccionCampos.classList.toggle('mostrar');
        });
       </script>
</body>
</html>
