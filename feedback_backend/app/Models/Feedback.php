<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'feedback_text'
    ];

    static $rules = [
        'name' => 'required|string|min:2|max:30',
        'phone_number' => 'required|string|min:8|max:30',
        'feedback_text' => 'required|string|min:5'
    ];
}
