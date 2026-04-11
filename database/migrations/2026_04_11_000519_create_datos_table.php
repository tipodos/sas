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
        Schema::create('datos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa');
            $table->string('ruc_empresa',11)->unique();
            $table->string('direccion_empresa')->nullable();
            $table->string('telefono',9)->nullable();
            $table->string('correo',50)->nullable();
            $table->string('logo')->nullable(); // Ruta del logo de la empresa
            $table->string('mensaje_ticket')->nullable(); // Mensaje personalizado para el ticket
            $table->string('moneda')->default('S/'); // Moneda utilizada en el sistema
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos');
    }
};
