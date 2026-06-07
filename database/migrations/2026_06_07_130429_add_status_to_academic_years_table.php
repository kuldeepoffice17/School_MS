<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            if (!Schema::hasColumn('academic_years', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_current');
            }
        });
    }

    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};