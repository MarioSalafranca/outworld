<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Age Gate</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="ageGate">
    <div class="age-gate">
        <div id="error" class="error">
            @if($errors->has('age'))
                <div class="error-message">
                    {{ $errors->first('age') }}
                </div>
            @endif
        </div>
        <img src="image//logo/OUTWORLD-WHITE.png" alt="OUTWORLD logo" class="logo">
        <h2>Cuéntanos:<br><span>¿Cuándo naciste?</span></h2>
        <form action="{{ route('checkAge') }}" method="POST">
            @csrf
            <div class="inputs">
                <input type="text" id="day" name="day" placeholder="DD" maxlength="2" required>
                <input type="text" id="month" name="month" placeholder="MM" maxlength="2" required>
                <input type="text" id="year" name="year" placeholder="YYYY" maxlength="4" required>
                <button type="submit">ENTER</button>
            </div>
        </form>

        <div class="info-age">
            <p class="warning">No compartir contenidos de esta página con menores de 18 años.</p>
            <p class="legal">
                OUTWORLD®, en cumplimiento con el Código de Autorregulación Publicitaria del Sector de Bebidas Espirituosas,
                promueve el consumo responsable de vodka, 40% alc./vol. OUTWORLD S.A., con domicilio social en Avenida de
                la Libertad nº 25, 28001, Madrid (España) y C.I.F. A-12345678. OUTWORLD® es una marca registrada de
                OUTWORLD GROUP. <br>Todos los derechos reservados.
            </p>
        </div>
    </div>

    <script src="js/agegate.js"></script>
</body>
</html>
