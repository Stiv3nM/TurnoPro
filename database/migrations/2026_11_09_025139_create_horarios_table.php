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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained()->cascadeOnDelete();
            $table->foreignId('turno_id')->nullable()->constrained()->restrictOnDelete();
            $table->date('fecha');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->unique(['empleado_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
