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
            $table->unsignedBigInteger("formulario_id");
            $table->string("etiqueta");
            $table->string("nombre_campo");
            $table->string("tipo");
            $table->string("requerido");
            $table->json("opciones");
            $table->integer("orden");
            $table->timestamps();

            $table->foreign('formulario_id')->references('id')->on('formularios');
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
