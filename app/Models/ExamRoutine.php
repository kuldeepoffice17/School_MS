<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $table = 'exam_results';

    protected $fillable = [
        'exam_id', 
        'student_id', 
        'subject_id', 
        'theory_marks', 
        'practical_marks', 
        'total_marks', 
        'grade', 
        'remarks'
    ];

    protected $casts = [
        'theory_marks' => 'integer',
        'practical_marks' => 'integer',
        'total_marks' => 'integer',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Calculate grade based on percentage
    public static function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 40) return 'C';
        if ($percentage >= 33) return 'D';
        return 'F';
    }

    // Get percentage
    public function getPercentageAttribute()
    {
        if ($this->subject && $this->subject->theory_marks + $this->subject->practical_marks > 0) {
            $totalMaxMarks = $this->subject->theory_marks + $this->subject->practical_marks;
            return ($this->total_marks / $totalMaxMarks) * 100;
        }
        return 0;
    }

    // Get result status
    public function getResultStatusAttribute()
    {
        if ($this->subject) {
            $passingPercentage = ($this->subject->passing_percentage ?? 33);
            return $this->percentage >= $passingPercentage ? 'Pass' : 'Fail';
        }
        return 'Pending';
    }
}