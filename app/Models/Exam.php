<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'term', 'academic_year_id', 'start_date', 'end_date', 'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // Get exam status
    public function getExamStatusAttribute()
    {
        $today = now();
        if ($today < $this->start_date) {
            return 'upcoming';
        } elseif ($today >= $this->start_date && $today <= $this->end_date) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }
}