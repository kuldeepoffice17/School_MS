<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('father_name');
            $table->string('father_phone');
            $table->string('father_email')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name');
            $table->string('mother_phone');
            $table->string('mother_email')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parents');
    }
};