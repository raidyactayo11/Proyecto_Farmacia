<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Medicamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CrudFasesUnoCuatroTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_registrar_una_categoria()
    {
        $response = $this->post(route('categorias.store'), [
            'nombre' => 'Analgésicos',
            'descripcion' => 'Medicamentos utilizados para aliviar el dolor.',
        ]);

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', [
            'nombre' => 'Analgésicos',
        ]);
    }

    public function test_puede_actualizar_y_eliminar_una_categoria_sin_medicamentos()
    {
        $categoria = Categoria::create([
            'nombre' => 'Temporal',
            'descripcion' => 'Categoría temporal.',
        ]);

        $respuestaActualizacion = $this->put(route('categorias.update', $categoria), [
            'nombre' => 'Actualizada',
            'descripcion' => 'Descripción actualizada.',
        ]);

        $respuestaActualizacion->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', [
            'id' => $categoria->id,
            'nombre' => 'Actualizada',
        ]);

        $respuestaEliminacion = $this->delete(route('categorias.destroy', $categoria));

        $respuestaEliminacion->assertRedirect(route('categorias.index'));
        $this->assertDatabaseMissing('categorias', [
            'id' => $categoria->id,
        ]);
    }

    public function test_no_permite_eliminar_una_categoria_con_medicamentos()
    {
        $categoria = Categoria::create([
            'nombre' => 'Con medicamentos',
            'descripcion' => 'Categoría protegida.',
        ]);

        Medicamento::create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Medicamento protegido',
            'slug' => 'medicamento-protegido',
            'precio' => 1.50,
            'stock' => 10,
        ]);

        $respuesta = $this->delete(route('categorias.destroy', $categoria));

        $respuesta->assertRedirect(route('categorias.index'));
        $respuesta->assertSessionHas('error');
        $this->assertDatabaseHas('categorias', [
            'id' => $categoria->id,
        ]);
    }

    public function test_medicamento_exige_precio_positivo_categoria_y_stock_valido()
    {
        $categoria = Categoria::create([
            'nombre' => 'Antibióticos',
            'descripcion' => 'Medicamentos contra infecciones bacterianas.',
        ]);

        $response = $this->from(route('medicamentos.create'))
            ->post(route('medicamentos.store'), [
                'categoria_id' => $categoria->id,
                'nombre' => 'Amoxicilina',
                'precio' => 0,
                'stock' => -1,
            ]);

        $response->assertRedirect(route('medicamentos.create'));
        $response->assertSessionHasErrors(['precio', 'stock']);
        $this->assertDatabaseMissing('medicamentos', [
            'nombre' => 'Amoxicilina',
        ]);
    }

    public function test_medicamento_genera_slug_y_guarda_imagen()
    {
        Storage::fake('public');

        $categoria = Categoria::create([
            'nombre' => 'Antialérgicos',
            'descripcion' => 'Medicamentos para tratar alergias.',
        ]);

        $imagen = UploadedFile::fake()->createWithContent(
            'loratadina.png',
            base64_decode(
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9Z3Z0AAAAASUVORK5CYII='
            )
        );

        $response = $this->post(route('medicamentos.store'), [
            'categoria_id' => $categoria->id,
            'nombre' => 'Loratadina 10 mg',
            'precio' => 4.50,
            'stock' => 20,
            'descripcion' => 'Antihistamínico.',
            'imagen' => $imagen,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('medicamentos.index'));

        $medicamento = Medicamento::where('nombre', 'Loratadina 10 mg')->firstOrFail();

        $this->assertSame('loratadina-10-mg', $medicamento->slug);
        $this->assertSame($categoria->id, $medicamento->categoria_id);
        Storage::disk('public')->assertExists($medicamento->imagen);
    }

    public function test_dni_debe_tener_ocho_digitos_y_ser_unico()
    {
        $respuestaInvalida = $this->from(route('clientes.create'))
            ->post(route('clientes.store'), [
                'nombre' => 'Cliente inválido',
                'dni' => '1234',
            ]);

        $respuestaInvalida->assertRedirect(route('clientes.create'));
        $respuestaInvalida->assertSessionHasErrors('dni');

        $cliente = Cliente::create([
            'nombre' => 'Cliente válido',
            'dni' => '12345678',
        ]);

        $respuestaDuplicada = $this->from(route('clientes.create'))
            ->post(route('clientes.store'), [
                'nombre' => 'Otro cliente',
                'dni' => '12345678',
            ]);

        $respuestaDuplicada->assertRedirect(route('clientes.create'));
        $respuestaDuplicada->assertSessionHasErrors('dni');

        $respuestaEdicion = $this->put(route('clientes.update', $cliente), [
            'nombre' => 'Cliente actualizado',
            'dni' => '12345678',
        ]);

        $respuestaEdicion->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nombre' => 'Cliente actualizado',
            'dni' => '12345678',
        ]);
    }
}
