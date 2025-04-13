<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionnaireResponse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'questionnaire_id',
        'responses',
        'expertise_assessment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'responses' => 'array',
        'recommended_products' => 'array',
    ];

    /**
     * Get the user that owns the response.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the questionnaire template that owns the response.
     */
    public function questionnaire()
    {
        return $this->belongsTo(QuestionnaireTemplate::class, 'questionnaire_id');
    }

    /**
     * Get the recommended products for this response.
     */
    public function recommendedProducts()
    {
        return Product::whereIn('id', $this->recommended_products)->get();
    }
}
