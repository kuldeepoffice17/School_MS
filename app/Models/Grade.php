<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'grade_point', 'min_percentage', 'max_percentage', 'remark', 'is_active'
    ];

    // Get grade by percentage
    public static function getGradeByPercentage($percentage)
    {
        return self::where('min_percentage', '<=', $percentage)
            ->where('max_percentage', '>=', $percentage)
            ->where('is_active', true)
            ->first();
    }
}