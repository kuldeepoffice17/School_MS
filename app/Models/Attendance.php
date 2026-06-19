<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'class_id', 'section_id', 'date', 'status', 'remarks'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    // Status badges
    public static function getStatusBadge($status)
    {
        switch($status) {
            case 'present':
                return '<span class="badge bg-success">Present</span>';
            case 'absent':
                return '<span class="badge bg-danger">Absent</span>';
            case 'late':
                return '<span class="badge bg-warning">Late</span>';
            case 'half_day':
                return '<span class="badge bg-info">Half Day</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }
}