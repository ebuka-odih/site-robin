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
        if (!Schema::hasTable('balance_histories')) {
            return;
        }

        Schema::table('balance_histories', function (Blueprint $table) {
            if (Schema::hasColumn('balance_histories', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropIndex('balance_histories_user_id_type_index');
                $table->dropColumn('user_id');
            }
        });

        Schema::table('balance_histories', function (Blueprint $table) {
            $table->uuid('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('balance_histories')) {
            return;
        }

        Schema::table('balance_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('balance_histories_user_id_type_index');
            $table->dropColumn('user_id');
        });

        Schema::table('balance_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['user_id', 'type']);
        });
    }
};
