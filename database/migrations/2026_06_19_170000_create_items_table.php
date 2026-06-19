<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('nombre');
            $table->string('tipo');
            $table->string('categoria')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('estado')->default('disponible');
            $table->date('fecha_preparacion')->nullable();
            $table->date('consumir_antes')->nullable();
            $table->boolean('faltante')->default(false);
            $table->timestamps();

            $table->index(['team_id', 'tipo']);
            $table->index(['team_id', 'faltante']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
