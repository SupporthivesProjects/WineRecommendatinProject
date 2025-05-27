<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_id',
        'question_key',
        'answer',
        'user_id',
        'submission_id',
        'customerID', // 👈 add this line
    ];
    
}
