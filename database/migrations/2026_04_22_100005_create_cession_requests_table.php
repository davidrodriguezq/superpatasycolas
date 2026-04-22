<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cession_requests', function (Blueprint $table) {
            $table->id();
            // usuario cedente; nullable para permitir solicitudes sin cuenta registrada (flujo futuro)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            // animal_id se llena cuando el admin acepta la cesión y crea el registro del animal
            $table->foreignId('animal_id')->nullable()->constrained()->nullOnDelete();
            $table->text('reason');
            $table->string('animal_condition')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cession_requests');
    }
};
