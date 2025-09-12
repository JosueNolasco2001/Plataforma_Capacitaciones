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
        Schema::create('examenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('curso_id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->json('configuracion'); // tiempo_limite, intentos_permitidos, puntaje_minimo, etc.
            $table->json('preguntas'); // array de preguntas con opciones y respuestas
            $table->boolean('estado')->default(1); // activo/inactivo
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            
            // Index (sin foreign key por ahora)
            $table->index('curso_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examenes');
    }
};