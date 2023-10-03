<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FinalProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'status',
        'submitted_at',
    ];

    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(Lecturer::class)->withPivot('role');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
