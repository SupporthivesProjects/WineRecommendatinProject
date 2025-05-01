<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';  // If the table name differs from the default
    protected $fillable = [
        'template_id',
        'question',
        'type',
        'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 
        'option_6', 'option_7', 'option_8', 'option_9', 'option_10', 
        'option_11', 'option_12', 'option_13', 'option_14', 'option_15',
        'min_value', 'max_value', 'step', 'default',
    ];

    protected $casts = [
        'options' => 'array',
        'min_value' => 'integer',
        'max_value' => 'integer',
        'step' => 'integer',
        'default' => 'integer',
    ];

    public function template()
    {
        return $this->belongsTo(QuestionnaireTemplate::class, 'template_id');
    }
}
