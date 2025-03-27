<?php
/**
 * SHS Portal - Laravel API Implementation
 * 
 * This file contains the complete code structure for models, controllers, migrations, and routes.
 */

/*
 * MODELS
 */

// app/Models/Student.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'student_name',
        'email',
        'password',
        'set_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sets()
    {
        return $this->belongsToMany(Set::class, 'set_student');
    }
    
}
