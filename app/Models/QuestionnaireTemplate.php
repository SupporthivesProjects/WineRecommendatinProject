<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'level',
        'description',
        'questions',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the responses for this questionnaire template.
     */
    public function responses()
    {
        return $this->hasMany(UserQuestionnaireResponse::class);
    }

    public function getQuestionsArrayAttribute()
    {
        if (is_array($this->questions)) {
            return $this->questions;
        }
        return json_decode($this->questions, true) ?? [];
    }
}
