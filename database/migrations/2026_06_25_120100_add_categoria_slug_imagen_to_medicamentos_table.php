<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddCategoriaSlugImagenToMedicamentosTable extends Migration
{
    public function up()
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->after('id');
            $table->string('slug')->nullable()->unique()->after('nombre');
            $table->string('imagen')->nullable()->after('descripcion');

            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('restrict');
        });

        $ahora = now();

        $categoriaGeneralId = DB::table('categorias')->insertGetId([
            'nombre' => 'General',
            'descripcion' => 'Categoría inicial para los medicamentos existentes.',
            'created_at' => $ahora,
            'updated_at' => $ahora,
        ]);

        $slugsUsados = [];

        DB::table('medicamentos')
            ->orderBy('id')
            ->get(['id', 'nombre'])
            ->each(function ($medicamento) use ($categoriaGeneralId, &$slugsUsados) {
                $base = Str::slug($medicamento->nombre) ?: 'medicamento';
                $slug = $base;
                $contador = 2;

                while (in_array($slug, $slugsUsados, true)) {
                    $slug = "{$base}-{$contador}";
                    $contador++;
                }

                $slugsUsados[] = $slug;

                DB::table('medicamentos')
                    ->where('id', $medicamento->id)
                    ->update([
                        'categoria_id' => $categoriaGeneralId,
                        'slug' => $slug,
                    ]);
            });
    }

    public function down()
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropUnique(['slug']);
            $table->dropColumn(['categoria_id', 'slug', 'imagen']);
        });
    }
}
