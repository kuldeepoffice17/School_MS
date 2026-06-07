<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';
    
    protected $fillable = ['name', 'numeric_name', 'description'];

     public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

     public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // public function teachers()
    // {
    //     return $this->belongsToMany(Teacher::class, 'class_teacher');
    // }

    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class, 'class_subjects');
    // }
      public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id');
    }

    // For class_subjects pivot table
     public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subjects', 'class_id', 'subject_id');
    }
}