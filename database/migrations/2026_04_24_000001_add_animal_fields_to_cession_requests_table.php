<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cession_requests', function (Blueprint $table) {
            $table->string('animal_name')->nullable()->after('animal_id');
            $table->string('animal_species')->nullable()->after('animal_name');
            $table->string('animal_breed')->nullable()->after('animal_species');
            $table->string('animal_sex')->nullable()->after('animal_breed');
            $table->string('animal_approximate_age')->nullable()->after('animal_sex');
            $table->decimal('animal_weight', 5, 2)->nullable()->after('animal_approximate_age');
            $table->text('animal_description')->nullable()->after('animal_weight');
            $table->string('urgency')->default('normal')->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table('cession_requests', function (Blueprint $table) {
            $table->dropColumn([
                'animal_name',
                'animal_species',
                'animal_breed',
                'animal_sex',
                'animal_approximate_age',
                'animal_weight',
                'animal_description',
                'urgency',
            ]);
        });
    }
};
