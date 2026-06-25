<div class="mb-3">
    <label for="nombre" class="form-label">Nombre de la categoría</label>
    <input
        type="text"
        id="nombre"
        name="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre', optional($categoria ?? null)->nombre) }}"
        maxlength="255"
        required>

    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea
        id="descripcion"
        name="descripcion"
        rows="4"
        class="form-control @error('descripcion') is-invalid @enderror"
        required>{{ old('descripcion', optional($categoria ?? null)->descripcion) }}</textarea>

    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>
        Guardar
    </button>

    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
        Cancelar
    </a>
</div>
