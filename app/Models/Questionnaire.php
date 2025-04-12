<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questionnaire';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5'
    ];

    /**
     * Get the product that this questionnaire belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
