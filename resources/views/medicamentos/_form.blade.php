<div class="row">
    <div class="col-md-6 mb-3">
        <label for="categoria_id" class="form-label">Categoría</label>
        <select
            id="categoria_id"
            name="categoria_id"
            class="form-select @error('categoria_id') is-invalid @enderror"
            required>
            <option value="">Seleccione una categoría</option>

            @foreach($categorias as $categoria)
                <option
                    value="{{ $categoria->id }}"
                    {{ (string) old('categoria_id', optional($medicamento ?? null)->categoria_id) === (string) $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>

        @error('categoria_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', optional($medicamento ?? null)->nombre) }}"
            maxlength="255"
            required>

        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="precio" class="form-label">Precio</label>
        <div class="input-group">
            <span class="input-group-text">S/</span>
            <input
                type="number"
                id="precio"
                name="precio"
                class="form-control @error('precio') is-invalid @enderror"
                value="{{ old('precio', optional($medicamento ?? null)->precio) }}"
                min="0.01"
                step="0.01"
                required>

            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input
            type="number"
            id="stock"
            name="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock', optional($medicamento ?? null)->stock) }}"
            min="0"
            required>

        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea
        id="descripcion"
        name="descripcion"
        rows="4"
        class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', optional($medicamento ?? null)->descripcion) }}</textarea>

    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">
        Imagen referencial
        @isset($medicamento)
            <span class="text-muted">(opcional, deja vacío para conservar la actual)</span>
        @endisset
    </label>

    <input
        type="file"
        id="imagen"
        name="imagen"
        class="form-control @error('imagen') is-invalid @enderror"
        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

    <div class="form-text">Formatos permitidos: JPG, PNG y WEBP. Tamaño máximo: 2 MB.</div>

    @error('imagen')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(optional($medicamento ?? null)->imagen)
        <div class="mt-3">
            <p class="small text-muted mb-2">Imagen actual:</p>
            <img
                src="{{ asset('storage/' . $medicamento->imagen) }}"
                alt="Imagen de {{ $medicamento->nombre }}"
                class="img-thumbnail"
                style="max-width: 180px; max-height: 180px; object-fit: cover;">
        </div>
    @endif
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>
        Guardar
    </button>

    <a href="{{ route('medicamentos.index') }}" class="btn btn-secondary">
        Cancelar
    </a>
</div>
