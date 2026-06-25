<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::with('categoria')
            ->latest()
            ->get();

        return view('medicamentos.index', compact('medicamentos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('medicamentos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        $datos['slug'] = $this->generarSlugUnico($datos['nombre']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('medicamentos', 'public');
        }

        Medicamento::create($datos);

        return redirect()
            ->route('medicamentos.index')
            ->with('success', 'Medicamento registrado correctamente.');
    }

    public function edit(Medicamento $medicamento)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('medicamentos.edit', compact('medicamento', 'categorias'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $datos = $this->validar($request);
        $datos['slug'] = $this->generarSlugUnico($datos['nombre'], $medicamento->id);

        if ($request->hasFile('imagen')) {
            $imagenAnterior = $medicamento->imagen;
            $datos['imagen'] = $request->file('imagen')->store('medicamentos', 'public');

            if ($imagenAnterior) {
                Storage::disk('public')->delete($imagenAnterior);
            }
        }

        $medicamento->update($datos);

        return redirect()
            ->route('medicamentos.index')
            ->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy(Medicamento $medicamento)
    {
        if ($medicamento->detallesVenta()->exists()) {
            return redirect()
                ->route('medicamentos.index')
                ->with('error', 'No puedes eliminar un medicamento que aparece en ventas registradas.');
        }

        if ($medicamento->imagen) {
            Storage::disk('public')->delete($medicamento->imagen);
        }

        $medicamento->delete();

        return redirect()
            ->route('medicamentos.index')
            ->with('success', 'Medicamento eliminado correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'categoria_id' => 'required|integer|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'nombre.required' => 'El nombre es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio debe ser mayor que cero.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar los 2 MB.',
        ]);
    }

    private function generarSlugUnico(string $nombre, ?int $ignorarId = null): string
    {
        $base = Str::slug($nombre) ?: 'medicamento';
        $slug = $base;
        $contador = 2;

        while (
            Medicamento::where('slug', $slug)
                ->when($ignorarId, fn ($consulta) => $consulta->where('id', '!=', $ignorarId))
                ->exists()
        ) {
            $slug = "{$base}-{$contador}";
            $contador++;
        }

        return $slug;
    }
}
