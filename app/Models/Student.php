<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no', 
        'roll_no',
        'first_name', 
        'last_name', 
        'email', 
        'phone',
        'date_of_birth',  // Change from 'dob' to 'date_of_birth' for consistency
        'gender', 
        'address',
        'city',
        'state', 
        'pincode',
        'photo', 
        'class_id', 
        'section_id',
        'parent_name',    // Add parent_name instead of parent_id
        'parent_phone',
        'parent_email',
        'admission_date', 
        'blood_group',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    // Add accessor for age
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}