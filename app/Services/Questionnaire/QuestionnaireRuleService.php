<?php

namespace App\Services\Questionnaire;

class QuestionnaireRuleService
{
    /**
     * Get all rules for a questionnaire.
     */
    public function getRules(int $templateId): array
    {
        $rules = config('questionnaire_rules');

        return $rules[$templateId] ?? [];
    }

    /**
     * Evaluate rules.
     */
    public function evaluate(int $templateId, array $questions, array $responses): array
    {
        return [
            'rules' => $this->getRules($templateId),

            'questions' => $questions,

            'responses' => $responses,

            'hide_questions' => [],

            'show_questions' => [],

            'hide_options' => [],

            'show_options' => [],

            'skip_questions' => [],

            'clear_answers' => [],

            'set_answers' => [],
        ];
    }
}