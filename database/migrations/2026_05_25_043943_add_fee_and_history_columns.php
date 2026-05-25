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
        // persentase fee campaigner
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedTinyInteger('campaigner_fee_percentage')->default(0)->after('target_amount');
        });

        // rincian dana
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('app_fee')->default(0)->after('amount'); // 1% buat aplikasi
            $table->integer('campaigner_fee')->default(0)->after('app_fee'); // X% buat operasional mereka
            $table->integer('total_paid')->default(0)->after('campaigner_fee'); // Total yang didebit dari donatur
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('campaigner_fee_percentage');
        });
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['app_fee', 'campaigner_fee', 'total_paid']);
        });
    }
};
