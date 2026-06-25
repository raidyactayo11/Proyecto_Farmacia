<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest()->get();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        Cliente::create($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $datos = $this->validar($request, $cliente);

        $cliente->update($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->ventas()->exists()) {
            return redirect()
                ->route('clientes.index')
                ->with('error', 'No puedes eliminar un cliente que tiene ventas registradas.');
        }

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }

    private function validar(Request $request, ?Cliente $cliente = null): array
    {
        return $request->validate([
            'nombre' => 'required|string|max:255',
            'dni' => [
                'required',
                'digits:8',
                Rule::unique('clientes', 'dni')->ignore(optional($cliente)->id),
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe contener exactamente 8 dígitos.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
        ]);
    }
}
