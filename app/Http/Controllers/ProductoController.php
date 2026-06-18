<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

 public function store(Request $request)
{
    Producto::create([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'stock' => $request->stock,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('productos.index');
}

    public function edit(Producto $producto)
{
    return view('productos.edit', compact('producto'));
}

public function update(Request $request, Producto $producto)
{
    $producto->update([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'stock' => $request->stock,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('productos.index');
}

public function destroy($id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return redirect()->route('productos.index');
}

}