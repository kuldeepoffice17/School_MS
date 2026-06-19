<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_id', 'student_id', 'amount', 'payment_date', 
        'payment_method', 'transaction_id', 'receipt_no', 'remarks'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Auto generate receipt number
    public static function generateReceiptNo()
    {
        $last = self::orderBy('id', 'desc')->first();
        if ($last) {
            $lastNumber = intval(substr($last->receipt_no, -6));
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }
        return 'RCPT' . date('Y') . $newNumber;
    }
}