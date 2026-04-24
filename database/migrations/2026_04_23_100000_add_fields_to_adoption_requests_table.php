<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->text('other_pets_description')->nullable()->after('previous_pets');
            $table->boolean('has_outdoor_space')->default(false)->after('other_pets_description');
            $table->timestamp('approved_at')->nullable()->after('tracking_code');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
            $table->timestamp('rejected_at')->nullable()->after('approved_by');
        });
    }

    public function down(): void
    {
        Schema::table('adoption_requests', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'other_pets_description',
                'has_outdoor_space',
                'approved_at',
                'approved_by',
                'rejected_at',
            ]);
        });
    }
};
