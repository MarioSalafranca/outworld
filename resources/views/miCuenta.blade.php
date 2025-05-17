<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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

    <div class="perfil__contenedor">
        <!-- Navegación de pestañas -->
        <div class="perfil__tabs">
          <button class="perfil__tab perfil__tab--activo" data-tab="perfil">Mi Perfil</button>
          <button class="perfil__tab" data-tab="pedidos">Mis Pedidos</button>
        </div>

        <div class="perfil__contenido">

          <!-- TAB 1: Mi Perfil -->
          <div class="perfil__panel perfil__panel--activo" id="perfil">
            <h2 class="perfil__titulo">Información del Usuario</h2>
            <p><strong>Nombre:</strong> {{ $datosUsuario->nombre }}  {{ $datosUsuario->apellido }}</p>
            <p><strong>Email:</strong> {{ $datosUsuario->email }}</p>
            <p><strong>Dirección:</strong> {{ $datosUsuario->calle }} {{ $datosUsuario->numero }}, {{ $datosUsuario->cp }}, {{ $datosUsuario->ciudad }}, {{ $datosUsuario->pais }}</p>
            <p><strong>Teléfono:</strong> {{ $datosUsuario->telefono }}</p>

            <div class="perfil__interactivo">

                <!-- Formulario: Cambiar Contraseña -->
                <div class="perfil__bloque perfil__bloque--activo" id="perfil__bloque-contrasena">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="perfil__subtitulo">Cambiar Contraseña</h3>

                  <form class="perfil__formulario" action="{{ route('actualizarPassword') }}" method="POST">
                      @csrf

                      <label>Contraseña actual</label>
                    <input type="password" name="oldPassword" class="perfil__input" placeholder="Dejar en blanco si no se desea cambiar" />

                    <label>Nueva contraseña</label>
                    <input type="password" name="password" class="perfil__input" placeholder="Dejar en blanco si no se desea cambiar" />

                    <label>Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="perfil__input" placeholder="Dejar en blanco si no se desea cambiar" />
                      <button type="submit" class="perfil__boton">Actualizar contraseña</button>
                  </form>

                    <div class="perfil__acciones">

                        <button type="button" class="perfil__toggle-btn" data-target="perfil__bloque-perfil">Modificar perfil</button>


                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="perfil__boton">Cerrar sesión</button>
                        </form>

                        <a href="{{ route('eliminarCuenta') }}"><button type="submit" class="perfil__boton">Eliminar cuenta</button></a>
                    </div>
                </div>

                <!-- Formulario: Modificar Perfil -->
                <div class="perfil__bloque" id="perfil__bloque-perfil">
                  <h3 class="perfil__subtitulo">Modificar Perfil</h3>
                  <form class="perfil__formulario" action="{{ route('modificarCuenta') }}" method="POST">
                      @csrf
                      @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif

                    <label>Nombre</label>
                    <input type="text" name="nombre" class="perfil__input" value="{{ $datosUsuario->nombre }}" />

                    <label>Apellido</label>
                    <input type="text" name="apellido" class="perfil__input" value="{{ $datosUsuario->apellido }}" />

                    <label>Usuario</label>
                    <input type="text" name="usuario_user" class="perfil__input" value="{{ $datosUsuario->usuario_user }}">

                    <label>Email</label>
                    <input type="email" name="email" class="perfil__input" value="{{ $datosUsuario->email }}" />

                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="perfil__input" value="{{ $datosUsuario->telefono }}" />

                      <div class="direccion">
                          <button type="button" id="mostrarDireccionBtn" class="btn-direccion">Dirección</button>
                          <div class="direccion-campos">
                              <input type="text" class="perfil__input" placeholder="Calle" name="calle" value="{{ $datosUsuario->calle }}" required>
                              <input type="text" class="perfil__input" placeholder="Ciudad" name="ciudad" value="{{ $datosUsuario->ciudad }}" required>
                              <input type="text" class="perfil__input" placeholder="Código Postal" name="cp" value="{{ $datosUsuario->cp }}" required>
                              <input type="text" class="perfil__input" placeholder="País" name="pais" value="{{ $datosUsuario->pais }}" required>
                              <input type="text" class="perfil__input" placeholder="Número" name="numero" value="{{ $datosUsuario->numero }}" required>
                          </div>
                      </div>

                    <button type="submit" class="perfil__boton">Guardar cambios</button>

                  </form>

                    <div class="perfil__acciones">
                        <button type="button" class="perfil__toggle-btn" data-target="perfil__bloque-contrasena">Cambiar contraseña</button>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="perfil__boton">Cerrar sesión</button>
                        </form>
                        <a href="{{ route('eliminarCuenta') }}"><button type="submit" class="perfil__boton">Eliminar cuenta</button></a>
                    </div>
                </div>

              </div>
          </div>

            <!-- TAB 2: Pedidos -->
            <div class="perfil__panel" id="pedidos">
                <h2 class="perfil__titulo">Historial de Pedidos</h2>

                @forelse($datosUsuario->compras as $compra)
                    <div class="perfil__pedido">
                        <div class="perfil__pedido-info">
                            <span>
                              <strong>Pedido #{{ $compra->id }}</strong>
                              – {{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}
                              – Total: {{ number_format($compra->total, 2, ',', '.') }} €
                            </span>
                            <button class="perfil__detalle-btn" onclick="toggleDetalle({{ $compra->id }})">
                                Ver detalles
                            </button>
                        </div>
                        <div class="perfil__detalle-productos" id="detalle-{{ $compra->id }}" style="display:none;">
                            <ul>
                                @foreach($compra->productos as $prod)
                                    <li>
                                        {{ $prod->nombre }}
                                        x {{ $prod->pivot->cantidad }}
                                        – {{ number_format($prod->pivot->precio_unitario * $prod->pivot->cantidad, 2, ',', '.') }} €
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('descargarFactura', $compra->id) }}" target="_blank">
                                <button class="perfil__factura-btn">Descargar factura</button>
                            </a>
                        </div>
                    </div>
                @empty
                    <p>No tienes ningún pedido todavía.</p>
                @endforelse
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
        </div>
    </section>
    @include('partials.footer')


    <script>
        // Cambiar pestañas
        const tabs = document.querySelectorAll('.perfil__tab');
        const panels = document.querySelectorAll('.perfil__panel');

        tabs.forEach(tab => {
          tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('perfil__tab--activo'));
            panels.forEach(p => p.classList.remove('perfil__panel--activo'));

            tab.classList.add('perfil__tab--activo');
            document.getElementById(tab.dataset.tab).classList.add('perfil__panel--activo');
          });
        });

        function toggleDetalle(id) {
            const el = document.getElementById('detalle-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }

        // Alternar entre cambiar contraseña y modificar perfil
        const toggleBtns = document.querySelectorAll('.perfil__toggle-btn');
        const bloquesPerfil = document.querySelectorAll('.perfil__bloque');

        toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            bloquesPerfil.forEach(b => b.classList.remove('perfil__bloque--activo'));
            document.getElementById(targetId).classList.add('perfil__bloque--activo');
        });
        });

    </script>

    <script>
        // DIRECCION
        const mostrarDireccionBtn = document.getElementById('mostrarDireccionBtn');
        const direccionCampos = document.querySelector('.direccion-campos');

        mostrarDireccionBtn.addEventListener('click', () => {
            direccionCampos.classList.toggle('mostrar');
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
