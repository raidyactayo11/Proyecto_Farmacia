<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RequireCategoriaAndSlugOnMedicamentos extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE medicamentos
                 MODIFY categoria_id BIGINT UNSIGNED NOT NULL,
                 MODIFY slug VARCHAR(255) NOT NULL'
            );
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE medicamentos
                 MODIFY categoria_id BIGINT UNSIGNED NULL,
                 MODIFY slug VARCHAR(255) NULL'
            );
        }
    }
}
