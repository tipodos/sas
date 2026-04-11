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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('costo', 8, 2);
            $table->decimal('precio', 8, 2);
            $table->decimal('precio_mayoreo',8,2)->nullable();
            $table->integer('stock');
            $table->integer('visible')->default(1); // 1 para visible, 0 para no visible
            $table->foreignId('category_id')->constrained('categories'); // Relación con categorías
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
