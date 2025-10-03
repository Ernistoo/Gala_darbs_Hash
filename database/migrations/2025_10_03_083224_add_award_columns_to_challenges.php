<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('challenges', function (Blueprint $table) {
            $table->foreignId('winner_submission_id')
                  ->nullable()->constrained('submissions')->nullOnDelete();
            $table->timestamp('awarded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropConstrainedForeignId('winner_submission_id');
            $table->dropColumn('awarded_at');
        });
    }
};
