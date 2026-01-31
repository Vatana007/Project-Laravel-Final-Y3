<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Link to positions table. If position is deleted, set this to NULL (don't delete the user)
            if (!Schema::hasColumn('users', 'position_id')) {
                $table->foreignId('position_id')->nullable()->constrained('positions')->nullOnDelete();
            }
            // Ensure phone column exists
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });
    }
};
