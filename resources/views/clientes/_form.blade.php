<div class="mb-3">
    <label for="nombre" class="form-label">Nombre completo</label>
    <input
        type="text"
        id="nombre"
        name="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre', optional($cliente ?? null)->nombre) }}"
        maxlength="255"
        required>

    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dni" class="form-label">DNI</label>
    <input
        type="text"
        id="dni"
        name="dni"
        class="form-control @error('dni') is-invalid @enderror"
        value="{{ old('dni', optional($cliente ?? null)->dni) }}"
        inputmode="numeric"
        pattern="[0-9]{8}"
        maxlength="8"
        required>

    <div class="form-text">Ingresa exactamente 8 dígitos.</div>

    @error('dni')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono <span class="text-muted">(opcional)</span></label>
    <input
        type="text"
        id="telefono"
        name="telefono"
        class="form-control @error('telefono') is-invalid @enderror"
        value="{{ old('telefono', optional($cliente ?? null)->telefono) }}"
        maxlength="20">

    @error('telefono')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección <span class="text-muted">(opcional)</span></label>
    <input
        type="text"
        id="direccion"
        name="direccion"
        class="form-control @error('direccion') is-invalid @enderror"
        value="{{ old('direccion', optional($cliente ?? null)->direccion) }}"
        maxlength="255">

    @error('direccion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>
        Guardar
    </button>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
        Cancelar
    </a>
</div>
