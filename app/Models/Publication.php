<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'link',
        'year',
        'type',
        'citation',
        'fund_source',
    ];

    public function users(): BelongsToMany
    {
       return $this->belongsToMany(User::class);
    }
}
