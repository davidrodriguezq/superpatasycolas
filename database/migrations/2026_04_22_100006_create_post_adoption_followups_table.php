<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_adoption_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adoption_request_id')->constrained()->cascadeOnDelete();
            $table->date('visit_date');
            $table->string('animal_condition');
            $table->string('home_condition');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_adoption_followups');
    }
};
