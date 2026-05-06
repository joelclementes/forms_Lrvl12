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
        Schema::create('formulario_campos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('formulario_id')->constrained('formularios')->cascadeOnDelete();
            $table->string("etiqueta");
            $table->string("nombre_campo");
            $table->string("tipo");
            $table->boolean("requerido")->default(false);
            $table->boolean('es_unico')->default(false);
            $table->json("opciones")->nullable();
            $table->integer("orden")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_campos');
    }
};
