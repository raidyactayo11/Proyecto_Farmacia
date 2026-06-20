<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicamento;

class MedicamentoController extends Controller
{
    /**
     * Mostrar listado de medicamentos.
     */
    public function index()
    {
        $medicamentos = Medicamento::all();

        return view('medicamentos.index', compact('medicamentos'));
    }

    /**
     * Registrar un nuevo medicamento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
        ]);

        Medicamento::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('medicamentos.index')
            ->with('success', 'Medicamento registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Medicamento $medicamento)
    {
        return view('medicamentos.edit', compact('medicamento'));
    }

    /**
     * Actualizar medicamento.
     */
    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
        ]);

        $medicamento->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('medicamentos.index')
            ->with('success', 'Medicamento actualizado correctamente.');
    }

    /**
     * Eliminar medicamento.
     */
    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete();

        return redirect()
            ->route('medicamentos.index')
            ->with('success', 'Medicamento eliminado correctamente.');
    }
}