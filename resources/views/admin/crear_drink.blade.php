<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Crear Nuevo Drink</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="crear-drink-view">
<div class="container">
    <h1>Crear Nuevo Drink</h1>
    @if($errors->any())
        <div style="background:#fee;border:1px solid #f99;padding:10px;margin-bottom:20px;">
            <ul style="margin:0;padding-left:20px;color:#900;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST"
          action="{{ route('panel.registrarDrink') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- Datos básicos --}}
        <div class="form-section">
            <h2>Datos del Drink</h2>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control" required>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen principal</label>
                <input type="file" id="imagen" name="imagen"
                       class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción corta</label>
                <input type="text" id="descripcion" name="descripcion"
                       class="form-control" required>
            </div>

            <div class="form-group">
                <label for="texto">Texto completo</label>
                <textarea id="texto" name="texto"
                          class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="pasos">Pasos (JSON)</label>
                <textarea id="pasos" name="pasos"
                          class="form-control" rows="3"
                          placeholder='[{"paso":"..."}]' required></textarea>
            </div>

            <div class="form-group">
                <label for="producto_id">Producto asociado</label>
                <select id="producto_id" name="producto_id"
                        class="form-control" required>
                    <option value="">-- Selecciona producto --</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_coctel_id">Tipo de cóctel</label>
                <select id="tipo_coctel_id" name="tipo_coctel_id"
                        class="form-control" required>
                    <option value="">-- Selecciona tipo --</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="base_sabor_id">Base de sabor</label>
                <select id="base_sabor_id" name="base_sabor_id"
                        class="form-control" required>
                    <option value="">-- Selecciona base --</option>
                    @foreach($bases as $b)
                        <option value="{{ $b->id }}">{{ $b->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tiempo_preparacion_id">Tiempo de preparación</label>
                <select id="tiempo_preparacion_id"
                        name="tiempo_preparacion_id"
                        class="form-control" required>
                    <option value="">-- Selecciona tiempo --</option>
                    @foreach($tiempos as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Imágenes adicionales (mín. 4) --}}
        <div class="form-section">
            <h2>Imágenes adicionales</h2>
            @for($i=0; $i<4; $i++)
                <div class="form-group">
                    <label for="imagenes[{{ $i }}]">Imagen {{ $i+1 }}</label>
                    <input type="file" name="imagenes[]" class="form-control"
                           accept="image/*" @if($i<4) required @endif>
                </div>
            @endfor
        </div>

        {{-- Ingredientes dinámicos --}}
        <div class="form-section">
            <h2>Ingredientes</h2>
            <div id="ingredientes-list" class="ingredientes-list">
                <div class="ingrediente-entry">
                    <input list="ingredientesList"
                           name="ingredientes[0][nombre]"
                           class="form-control ingrediente-input"
                           placeholder="Nombre ingrediente"
                           required>
                    <datalist id="ingredientesList">
                        @foreach($ingredientes as $ing)
                            <option value="{{ $ing->nombre }}">
                        @endforeach
                    </datalist>

                    <input type="text"
                           name="ingredientes[0][cantidad]"
                           class="form-control cantidad-input"
                           min="1"
                           placeholder="Cantidad"
                           required>

                    <button type="button" class="btn-remove">✕</button>
                </div>
            </div>
            <button type="button" id="add-ingrediente">+ Añadir ingrediente</button>
        </div>

        <div class="form-section">
            <h2>Instrumentos</h2>
            <div id="instrumentos-list" class="ingredientes-list">
                <div class="ingrediente-entry">
                    <input list="instrumentosList"
                           name="instrumentos[0][nombre]"
                           class="form-control instrumento-input"
                           placeholder="Nombre instrumento"
                           required>
                    <datalist id="instrumentosList">
                        @foreach($instrumentos as $inst)
                            <option value="{{ $inst->nombre }}">
                        @endforeach
                    </datalist>
                    <button type="button" class="btn-remove">✕</button>
                </div>
            </div>
            <button type="button" id="add-instrumento">+ Añadir instrumento</button>
        </div>

        {{-- Acciones --}}
        <div class="form-actions">
            <a href="{{ route('panel') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Crear Drink</button>
        </div>
    </form>
</div>

<script>
    (function(){
        // INGREDIENTES
        let idxIng = 1;
        const listIng = document.getElementById('ingredientes-list');
        document.getElementById('add-ingrediente')
            .addEventListener('click', () => {
                const tpl = listIng.querySelector('.ingrediente-entry');
                const clone = tpl.cloneNode(true);
                clone.querySelector('.ingrediente-input').value = '';
                clone.querySelector('.cantidad-input').value = '';
                clone.querySelector('.ingrediente-input').name =
                    `ingredientes[${idxIng}][nombre]`;
                clone.querySelector('.cantidad-input').name =
                    `ingredientes[${idxIng}][cantidad]`;
                listIng.appendChild(clone);
                idxIng++;
            });
        listIng.addEventListener('click', e => {
            if (e.target.classList.contains('btn-remove')) {
                const all = listIng.querySelectorAll('.ingrediente-entry');
                if (all.length>1) e.target.closest('.ingrediente-entry').remove();
            }
        });

        // INSTRUMENTOS
        let idxInst = 1;
        const listInst = document.getElementById('instrumentos-list');
        document.getElementById('add-instrumento')
            .addEventListener('click', () => {
                const tpl = listInst.querySelector('.ingrediente-entry');
                const clone = tpl.cloneNode(true);
                clone.querySelector('.instrumento-input').value = '';
                clone.querySelector('.instrumento-input').name =
                    `instrumentos[${idxInst}][nombre]`;
                listInst.appendChild(clone);
                idxInst++;
            });
        listInst.addEventListener('click', e => {
            if (e.target.classList.contains('btn-remove')) {
                const all = listInst.querySelectorAll('.ingrediente-entry');
                if (all.length>1) e.target.closest('.ingrediente-entry').remove();
            }
        });
    })();
</script>
</body>
</html>
