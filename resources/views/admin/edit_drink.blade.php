<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar Drink</title>
    <style>
        :root {
            --brand: #0651B4;
            --bg: #fff;
            --text: #333;
            --shadow: rgba(0,0,0,0.1);
        }
        * { box-sizing:border-box; margin:0; padding:0; }
        body {
            font-family: Arial,sans-serif;
            background:#f2f5f8;
            color:var(--text);
        }
        .container {
            max-width:800px;
            margin:40px auto;
            padding:20px;
            border-radius:6px;
            box-shadow:0 2px 8px var(--shadow);
        }
        h1 { text-align:center; color:var(--brand); margin-bottom:20px; }
        .form-group { margin-bottom:15px; }
        .form-group label {
            display:block;
            margin-bottom:6px;
            font-weight:bold;
        }
        .form-control, select, textarea {
            width:100%;
            padding:8px 10px;
            border:1px solid #ccc;
            border-radius:4px;
            font-size:14px;
            background:#fff;
        }
        .form-section { margin-bottom:30px; }
        .form-section h2 {
            margin-bottom:15px;
            color:var(--brand);
            border-bottom:2px solid var(--brand);
            display:inline-block;
            padding-bottom:4px;
        }
        .ingredientes-list .ingrediente-entry {
            display:flex;
            gap:10px;
            align-items:flex-end;
            margin-bottom:10px;
        }
        .ingredientes-list .ingrediente-entry > * {
            flex:1;
        }
        .ingredientes-list .ingrediente-entry .btn-remove {
            flex:0 0 auto;
            background:#e53e3e;
            color:#fff;
            border:none;
            padding:6px 12px;
            border-radius:4px;
            cursor:pointer;
        }
        #add-ingrediente {
            background:var(--brand);
            color:#fff;
            border:none;
            padding:8px 16px;
            border-radius:4px;
            cursor:pointer;
            font-size:14px;
        }
        .form-actions {
            text-align:right;
            margin-top:20px;
        }
        .btn-submit {
            background:var(--brand);
            color:#fff;
            border:none;
            padding:10px 20px;
            border-radius:4px;
            cursor:pointer;
            font-size:16px;
        }
        .btn-cancel {
            margin-right:10px;
            text-decoration:none;
            color:var(--brand);
            font-size:16px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Editar Drink</h1>
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
          action="{{ route('panel.updateDrink', $drink->id) }}"
          enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-section">
            <h2>Datos del Drink</h2>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control"
                       value="{{ old('nombre',$drink->nombre) }}" required>
            </div>
            <div class="form-group">
                <label>Imagen principal (sube para reemplazar)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label>Descripción corta</label>
                <input type="text" name="descripcion" class="form-control"
                       value="{{ old('descripcion',$drink->descripcion) }}" required>
            </div>
            <div class="form-group">
                <label>Texto completo</label>
                <textarea name="texto" class="form-control" rows="4"
                          required>{{ old('texto',$drink->texto) }}</textarea>
            </div>
            <div class="form-group">
                <label>Pasos (JSON)</label>
                <textarea name="pasos" class="form-control" rows="3"
                          required>{{ old('pasos',$drink->pasos) }}</textarea>
            </div>
            <div class="form-group">
                <label>Producto asociado</label>
                <select name="producto_id" class="form-control" required>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}"
                            {{ $p->id==$drink->producto_id?'selected':'' }}>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tipo de cóctel</label>
                <select name="tipo_coctel_id" class="form-control" required>
                    @foreach($tipos as $t)
                        <option value="{{ $t->id }}"
                            {{ $t->id==$drink->tipo_coctel_id?'selected':'' }}>
                            {{ $t->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Base de sabor</label>
                <select name="base_sabor_id" class="form-control" required>
                    @foreach($bases as $b)
                        <option value="{{ $b->id }}"
                            {{ $b->id==$drink->base_sabor_id?'selected':'' }}>
                            {{ $b->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tiempo de preparación</label>
                <select name="tiempo_preparacion_id" class="form-control" required>
                    @foreach($tiempos as $tp)
                        <option value="{{ $tp->id }}"
                            {{ $tp->id==$drink->tiempo_preparacion_id?'selected':'' }}>
                            {{ $tp->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Imágenes adicionales --}}
        <div class="form-section">
            <h2>Imágenes adicionales</h2>
            <p class="note">Sube ≥4 para reemplazar o añadir</p>
            @for($i=0;$i<4;$i++)
                <div class="form-group">
                    <label>Imagen {{ $i+1 }}</label>
                    <input type="file" name="imagenes[]" class="form-control" accept="image/*">
                </div>
            @endfor
        </div>

        {{-- Ingredientes --}}
        @php
            $ings = old('ingredientes')
                  ? old('ingredientes')
                  : $drink->ingredientes->map(fn($i)=>[
                      'nombre'=>$i->nombre,
                      'cantidad'=>$i->pivot->cantidad
                    ])->toArray();
        @endphp
        <div class="form-section">
            <h2>Ingredientes</h2>
            <div id="ingredientes-list">
                @foreach($ings as $idx=>$ing)
                    <div class="ingrediente-entry">
                        <input list="ingredientesList"
                               name="ingredientes[{{ $idx }}][nombre]"
                               class="form-control ingrediente-input"
                               value="{{ $ing['nombre'] }}" required>
                        <datalist id="ingredientesList">
                            @foreach($ingredientes as $i)
                                <option value="{{ $i->nombre }}">
                            @endforeach
                        </datalist>
                        <input type="text"
                               name="ingredientes[{{ $idx }}][cantidad]"
                               class="form-control cantidad-input"
                               value="{{ $ing['cantidad'] }}"
                               required>
                        <button type="button" class="btn-remove">✕</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-ingrediente">+ Añadir ingrediente</button>
        </div>

        {{-- Instrumentos --}}
        @php
            $insts = old('instrumentos')
                   ? old('instrumentos')
                   : $drink->instrumentos->map(fn($i)=>['nombre'=>$i->nombre])->toArray();
        @endphp
        <div class="form-section">
            <h2>Instrumentos</h2>
            <div id="instrumentos-list">
                @foreach($insts as $idx=>$itm)
                    <div class="ingrediente-entry">
                        <input list="instrumentosList"
                               name="instrumentos[{{ $idx }}][nombre]"
                               class="form-control instrumento-input"
                               value="{{ $itm['nombre'] }}" required>
                        <datalist id="instrumentosList">
                            @foreach($instrumentos as $i)
                                <option value="{{ $i->nombre }}">
                            @endforeach
                        </datalist>
                        <button type="button" class="btn-remove">✕</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-instrumento">+ Añadir instrumento</button>
        </div>

        <div class="form-actions">
            <a href="{{ route('panel') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Actualizar Drink</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Ingredientes
        const ingredientesList = document.getElementById('ingredientes-list');
        let idxIng = ingredientesList.querySelectorAll('.ingrediente-entry').length;

        document.getElementById('add-ingrediente')
            .addEventListener('click', () => {
                const tpl = ingredientesList.querySelector('.ingrediente-entry');
                const clone = tpl.cloneNode(true);
                clone.querySelector('.ingrediente-input').value = '';
                clone.querySelector('.cantidad-input').value = '';
                clone.querySelector('.ingrediente-input').name =
                    `ingredientes[${idxIng}][nombre]`;
                clone.querySelector('.cantidad-input').name =
                    `ingredientes[${idxIng}][cantidad]`;
                ingredientesList.appendChild(clone);
                idxIng++;
            });

        ingredientesList.addEventListener('click', e => {
            if (e.target.classList.contains('btn-remove')) {
                const items = ingredientesList.querySelectorAll('.ingrediente-entry');
                if (items.length > 1) {
                    e.target.closest('.ingrediente-entry').remove();
                }
            }
        });

        // Instrumentos
        const instrumentosList = document.getElementById('instrumentos-list');
        let idxInst = instrumentosList.querySelectorAll('.instrumento-entry').length;

        document.getElementById('add-instrumento')
            .addEventListener('click', () => {
                const tpl = instrumentosList.querySelector('.instrumento-entry');
                const clone = tpl.cloneNode(true);
                clone.querySelector('.instrumento-input').value = '';
                clone.querySelector('.instrumento-input').name =
                    `instrumentos[${idxInst}][nombre]`;
                instrumentosList.appendChild(clone);
                idxInst++;
            });

        instrumentosList.addEventListener('click', e => {
            if (e.target.classList.contains('btn-remove')) {
                const items = instrumentosList.querySelectorAll('.instrumento-entry');
                if (items.length > 1) {
                    e.target.closest('.instrumento-entry').remove();
                }
            }
        });
    });
</script>
</body>
</html>
