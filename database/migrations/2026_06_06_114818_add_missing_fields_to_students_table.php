<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Check if column exists before adding
            if (!Schema::hasColumn('students', 'roll_no')) {
                $table->integer('roll_no')->nullable()->after('admission_no');
            }
            
            if (!Schema::hasColumn('students', 'city')) {
                $table->string('city', 100)->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('students', 'state')) {
                $table->string('state', 100)->nullable()->after('city');
            }
            
            if (!Schema::hasColumn('students', 'pincode')) {
                $table->string('pincode', 10)->nullable()->after('state');
            }
            
            if (!Schema::hasColumn('students', 'parent_name')) {
                $table->string('parent_name')->after('section_id');
            }
            
            if (!Schema::hasColumn('students', 'parent_phone')) {
                $table->string('parent_phone', 20)->after('parent_name');
            }
            
            if (!Schema::hasColumn('students', 'parent_email')) {
                $table->string('parent_email')->nullable()->after('parent_phone');
            }
            
            if (!Schema::hasColumn('students', 'blood_group')) {
                $table->string('blood_group', 5)->nullable()->after('admission_date');
            }
            
            // Copy data from dob to date_of_birth if needed
            if (!Schema::hasColumn('students', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('dob');
            }
        });
        
        // Copy existing dob data to date_of_birth
        DB::statement('UPDATE students SET date_of_birth = dob WHERE date_of_birth IS NULL AND dob IS NOT NULL');
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'roll_no', 'city', 'state', 'pincode', 
                'parent_name', 'parent_phone', 'parent_email', 
                'blood_group', 'date_of_birth'
            ]);
        });
    }
}