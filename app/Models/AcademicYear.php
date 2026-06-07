<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';

    protected $fillable = [
        'name', 'start_date', 'end_date', 'is_current'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Get current academic year
    public static function getCurrent()
    {
        return self::where('is_current', 1)->first();
    }
}