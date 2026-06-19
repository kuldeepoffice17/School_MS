<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table exists and modify
        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                if (!Schema::hasColumn('payments', 'receipt_no')) {
                    $table->string('receipt_no')->unique()->after('transaction_id');
                }
                if (!Schema::hasColumn('payments', 'remarks')) {
                    $table->text('remarks')->nullable()->after('receipt_no');
                }
            });
        } else {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('fee_id')->constrained()->onDelete('cascade');
                $table->foreignId('student_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->date('payment_date');
                $table->enum('payment_method', ['cash', 'card', 'cheque', 'online', 'bank_transfer']);
                $table->string('transaction_id')->nullable();
                $table->string('receipt_no')->unique();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};