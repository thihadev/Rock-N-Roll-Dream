<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        "academic_year",
        "start_date",
        "end_date",
        "final_closure_date",
        "closure_date",
        "created_by",
        "last_modified_by",
    ];
}
