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
        Schema::create('intentos_examen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('examen_id');
            $table->json('respuestas'); // respuestas del usuario
            $table->decimal('puntaje_obtenido', 5, 2)->nullable();
            $table->boolean('aprobado')->default(false);
            $table->integer('tiempo_empleado')->nullable(); // en segundos
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_finalizacion')->nullable();
            $table->integer('intento_numero')->default(1);
            $table->enum('estado', ['iniciado', 'completado', 'abandonado'])->default('iniciado');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('examen_id')->references('id')->on('examenes')->onDelete('cascade');
            
            // Indexes
            $table->index(['usuario_id', 'examen_id']);
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intentos_examen');
    }
};