<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followup_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('followup_id')
                ->constrained('post_adoption_followups')
                ->cascadeOnDelete();
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followup_photos');
    }
};
