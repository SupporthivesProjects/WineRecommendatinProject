<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'questionnaire_type',
    ];

    /**
     * Get the admin user that this log belongs to.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
