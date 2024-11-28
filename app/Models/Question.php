<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question'];
    protected $visible = ['id', 'question'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('response')->withTimestamps();
    }
}
