<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
@include('partials.header')

<div class="negro"></div>
    <section class="contacto-seccion">
        <div class="seccion-contacto">
            <h2>Contáctanos</h2>

            <form class="form-contacto">
            <div class="fila">
                <div class="campo">
                <label for="motivo">Motivo de la consulta*</label>
                <select id="motivo" required>
                    <option value="">Selecciona una opción</option>
                    <option value="dudas">Dudas</option>
                    <option value="sugerencias">Incidencias</option>
                    <option value="otros">Otros</option>
                </select>
                </div>

                <div class="campo">
                <label for="nombre">Nombre*</label>
                <input type="text" id="nombre" required>
                </div>
            </div>

            <div class="fila">
                <div class="campo">
                <label for="email">Correo electrónico*</label>
                <input type="email" id="email" required>
                </div>

                <div class="campo">
                <label for="telefono">Teléfono*</label>
                <input type="tel" id="telefono" required>
                </div>
            </div>

            <div class="fila">
                <div class="campo">
                <label for="ciudad">Localidad/Ciudad*</label>
                <input type="text" id="ciudad" required>
                </div>

                <div class="campo">
                <label for="provincia">Provincia*</label>
                <select id="provincia" required>
                    <option value="">Selecciona una provincia</option>
                    <option value="a_coruna">A Coruña</option>
                    <option value="madrid">Madrid</option>
                    <option value="barcelona">Barcelona</option>
                    <!-- más provincias -->
                </select>
                </div>
            </div>

            <div class="campo">
                <label for="mensaje">Tu mensaje*</label>
                <textarea id="mensaje" rows="5" required></textarea>
            </div>

            <div class="checkboxes">
                <label class="checkbox-personalizado">
                <input type="checkbox" required>
                <span class="checkmark"></span>
                He leído y acepto el <a href="#">aviso legal</a> y la <a href="#">política de privacidad</a>
                </label>

                <label class="checkbox-personalizado">
                <input type="checkbox">
                <span class="checkmark"></span>
                Sí, consiento recibir información comercial, noticias y promociones.
                </label>
            </div>

            <button type="submit" class="btn-enviar">Enviar mensaje</button>
            </form>

            <div class="redes-contacto">
                <h3>También puedes contactarnos a través de redes</h3>
                <div class="iconos-redes">
                  <a href="https://www.facebook.com/groups/285987221415455/" target="_blank" class="icono-red">
                    <i class="fa-brands fa-facebook-f"></i>
                  </a>
                  <a href="https://www.linkedin.com/company/the-absolut-group/?originalSubdomain=se" target="_blank" class="icono-red">
                    <i class="fa-brands fa-linkedin-in"></i>
                  </a>
                  <a href="https://www.instagram.com/absolutvodka/?hl=es" target="_blank" class="icono-red">
                    <i class="fa-brands fa-instagram"></i>
                  </a>
                  <a href="https://x.com/absolutvodka?lang=es" target="_blank" class="icono-red">
                    <i class="fa-brands fa-x-twitter"></i>
                  </a>
                </div>
            </div>
        </div>
    </section>

    <section class="seccion-logos">
        <div class="contenedor-logos">
            <div class="logo-item">
                <img src="image/logo/OUTWORLD-BLACK.png" alt="Logo 4">
            </div>
            <div class="logo-item">
                <img src="image/logo/A.png" alt="Logo 1">
            </div>
            <div class="logo-item">
                <img src="image/logo/AD.png" alt="Logo 2">
            </div>
            <div class="logo-item">
                <img src="image/logo/AE.png" alt="Logo 3">
            </div>
        </div>
    </section>

    @include('partials.footer');

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script src="js/generico.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
      <script>
      AOS.init({
          duration: 1000,
          once: true
      });
      </script>
</body>
</html>
