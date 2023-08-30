<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'submitted_at',
        'title',
        'supervisor',
        'evaluator'
    ];
}
