<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->string('breed')->nullable();
            $table->string('sex');
            $table->string('approximate_age')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('health_status')->nullable();
            $table->text('description')->nullable();
            // string en lugar de enum nativo de MySQL para compatibilidad con PHP Enums y portabilidad
            $table->string('status')->default('available');
            $table->date('entry_date');
            $table->string('entry_type');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
