<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'email'
    ];

    public function finalProject(): HasOne
    {
        return $this->hasOne(FinalProject::class);
    }
}
