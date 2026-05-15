<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->enum('tipo_negocio', ['formal', 'informal'])->default('informal')->after('name');
            $table->string('razon_social')->nullable()->after('tipo_negocio');
            $table->string('nit')->nullable()->after('razon_social');
            $table->string('camara_comercio_file')->nullable()->after('nit');
            $table->string('rut_file')->nullable()->after('camara_comercio_file');
            $table->string('nombre_comercial')->nullable()->after('rut_file');
            $table->string('cedula_propietario')->nullable()->after('nombre_comercial');
            $table->string('rut_personal_file')->nullable()->after('cedula_propietario');
            $table->boolean('habeas_data_accepted')->default(false)->after('rut_personal_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_negocio',
                'razon_social',
                'nit',
                'camara_comercio_file',
                'rut_file',
                'nombre_comercial',
                'cedula_propietario',
                'rut_personal_file',
                'habeas_data_accepted',
            ]);
        });
    }
};
