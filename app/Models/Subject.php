<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'type', 'theory_marks', 'practical_marks'
    ];

    // public function classes()
    // {
    //     return $this->belongsToMany(Classes::class, 'class_subjects');
    // }

    // public function teachers()
    // {
    //     return $this->belongsToMany(Teacher::class, 'teacher_subjects');
    // }
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_subjects', 'subject_id', 'class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subjects');
    }
}