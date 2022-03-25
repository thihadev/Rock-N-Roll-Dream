<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "department_id",
        "first_name",
        "last_name",
        "email",
        "date_of_birth",
        "gender",
        'password',
        "mobile_no",
        "staff_type",
        "role",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function gender()
    {
        if ($this->gender == 1) { return 'Male';} 
        if ($this->gender == 2) { return 'Female';} 
        if ($this->gender == 3) { return 'Other';} 
    }      

    public function role()
    {
        if ($this->role == 1) { return 'Quality Assurance Manager';} 
        if ($this->role == 2) { return 'QA coordinator';} 
        if ($this->role == 3) { return 'Staff';} 
        if ($this->role == 4) { return 'Sysadmin';} 
    }    

    public function staffType()
    {
        if ($this->staff_type == 1) { return 'Academic';} 
        if ($this->staff_type == 2) { return 'Support';} 
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }
}
