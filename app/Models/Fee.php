<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'fee_type', 'amount', 'paid_amount', 'due_amount', 
        'due_date', 'status', 'description'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Update status based on paid amount
    public function updateStatus()
    {
        if ($this->paid_amount >= $this->amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'unpaid';
        }
        $this->due_amount = $this->amount - $this->paid_amount;
        $this->save();
    }

    // Get status badge
    public function getStatusBadgeAttribute()
    {
        switch($this->status) {
            case 'paid':
                return '<span class="badge bg-success">Paid</span>';
            case 'partial':
                return '<span class="badge bg-warning">Partial</span>';
            default:
                return '<span class="badge bg-danger">Unpaid</span>';
        }
    }

    // Get fee type badge
    public function getFeeTypeBadgeAttribute()
    {
        $types = [
            'tuition' => 'primary',
            'admission' => 'info',
            'exam' => 'warning',
            'library' => 'secondary',
            'sports' => 'success',
            'transport' => 'dark',
            'other' => 'light'
        ];
        $color = $types[$this->fee_type] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->fee_type) . '</span>';
    }
}