<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Crear Producto</title>
    <style>
        :root {
            --brand: #0651B4;
            --bg-card: #fff;
            --text: #333;
            --shadow: rgba(0,0,0,0.1);
        }
        * { box-sizing: border-box; margin:0; padding:0; }
        body {
            font-family: Arial, sans-serif;
            background: #f2f5f8;
            color: var(--text);
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: var(--bg-card);
            border-radius: 6px;
            box-shadow: 0 2px 8px var(--shadow);
        }
        h1 { text-align: center; color: var(--brand); margin-bottom: 20px; }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        .form-control, select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background: #fff;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h2 {
            margin-bottom: 15px;
            color: var(--brand);
            border-bottom: 2px solid var(--brand);
            display: inline-block;
            padding-bottom: 4px;
        }
        .form-actions {
            text-align: right;
            margin-top: 30px;
        }
        .btn-submit {
            background: var(--brand);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-cancel {
            margin-right: 10px;
            text-decoration: none;
            color: var(--brand);
            font-size: 16px;
        }
        .categorias-checkboxes label {
            cursor: pointer;
            user-select: none;
        }
        .categorias-checkboxes input {
            margin-right: 8px;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Crear Nuevo Producto</h1>
    <form method="POST" action="{{ route('panel.registrarProductoAdmin') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h2>Datos Básicos</h2>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción corta</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="texto">Texto completo</label>
                <textarea id="texto" name="texto" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio (€)</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" required>
            </div>
        </div>

        <div class="form-section">
            <h2>Imágenes del Producto</h2>

            <div class="form-group">
                <label for="imagen1">Imagen 1</label>
                <input type="file" id="imagen1" name="imagenes[]" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="imagen2">Imagen 2</label>
                <input type="file" id="imagen2" name="imagenes[]" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label for="imagen3">Imagen 3</label>
                <input type="file" id="imagen3" name="imagenes[]" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="form-section">
            <h2>Categorías</h2>
            <div class="form-group categorias-checkboxes">
                @foreach($categorias as $cat)
                    <label style="display: block; margin-bottom: 6px;">
                        <input type="checkbox" name="categorias[]" value="{{ $cat->id }}">
                        {{ $cat->nombre }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('panel') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Crear Producto</button>
        </div>
    </form>
</div>
</body>
</html>
