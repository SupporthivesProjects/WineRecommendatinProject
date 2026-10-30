<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireDebuggerController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return view(
                'admin.questionnaires.debugger',
                [
                    'steps' => []
                ]
            );
        }

        $lines = file($logFile);

        $steps = [];

        $sessions = [];
        
        $currentStep = [];
        
        $currentSession = [];
        
        $stepNo = 0;
        
        $sessionNo = 0;

        foreach ($lines as $line) {

            $line = trim($line);

            /*
            |--------------------------------------------------------------------------
            | New Question
            |--------------------------------------------------------------------------
            */

            if (preg_match('/Processing Answer Key:\s*(.*)/', $line, $match)) {

                if (!empty($currentStep)) {

                    $steps[] = $currentStep;

                }

                $stepNo++;

                $currentStep = [

                    'step' => $stepNo,

                    'question' => trim($match[1]),

                    'answer' => '',

                    'before' => '',

                    'after' => '',

                    'results' => '',

                    'sql' => '',

                    'status' => 'success'

                ];

            }

            /*
            |--------------------------------------------------------------------------
            | Selected Answer
            |--------------------------------------------------------------------------
            */

            if (preg_match('/Value:\s*(.*)/', $line, $match)) {

                $currentStep['answer'] = trim($match[1]);

            }

            /*
            |--------------------------------------------------------------------------
            | Pool Before
            |--------------------------------------------------------------------------
            */

            if (
                preg_match(
                    '/Current available product pool before filter:\s*(\d+)/',
                    $line,
                    $match
                )
            ) {

                $currentStep['before'] = $match[1];

            }

            /*
            |--------------------------------------------------------------------------
            | Results
            |--------------------------------------------------------------------------
            */

            if (
                preg_match(
                    '/Results for .*?:\s*(\d+)/',
                    $line,
                    $match
                )
            ) {

                $currentStep['results'] = $match[1];

            }

            /*
            |--------------------------------------------------------------------------
            | Pool After
            |--------------------------------------------------------------------------
            */

            if (
                preg_match(
                    '/Pool after filtering .*?:\s*(\d+)/',
                    $line,
                    $match
                )
            ) {

                $currentStep['after'] = $match[1];

            }

            /*
            |--------------------------------------------------------------------------
            | SQL
            |--------------------------------------------------------------------------
            */

            if (preg_match('/SQL:\s*(.*?)\s*(\[[\s\S]*\])$/', $line, $match)) {

                $currentStep['sql'] = trim($match[1]);
            
                $currentStep['bindings'] = json_decode($match[2], true);
            
            }

            /*
            |--------------------------------------------------------------------------
            | Skipped
            |--------------------------------------------------------------------------
            */

            if (
                str_contains(
                    strtolower($line),
                    'skipping this filter'
                )
            ) {

                $currentStep['status'] = 'skipped';

            }

        }

        if (!empty($currentStep)) {

            $steps[] = $currentStep;

        }

        return view(
            'admin.questionnaires.debugger',
            compact('steps')
        );
    }
    public function executeQuery(Request $request)
    {
        // Re-running matching queries is limited to full admins
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can run debugger queries.'
            ], 403);
        }

        $sql = trim((string) base64_decode((string) $request->sql, true));
        $bindings = json_decode((string) $request->bindings, true);

        if (!$this->isAllowedProductQuery($sql) || !is_array($bindings) || !$this->hasOnlyScalarValues($bindings)) {
            return response()->json([
                'success' => false,
                'message' => 'Only the logged product matching queries can be run here.'
            ], 422);
        }

        try{

            // Read-only transaction as a second safety net: any write fails at the database
            DB::statement('SET TRANSACTION READ ONLY');
            DB::beginTransaction();

            try {
                $products = DB::select($sql, array_values($bindings));
            } finally {
                DB::rollBack();
            }

            return response()->json([
                'success'=>true,
                'products'=>$products
            ]);

        }catch(\Exception $e){

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Allow only the shape the product matcher logs: one SELECT from `products`,
     * with no sub-queries, unions, other tables or statement separators.
     */
    private function isAllowedProductQuery(string $sql): bool
    {
        if ($sql === '' || !preg_match('/^select\s+.+\s+from\s+`products`(\s+where\s+.+)?$/is', $sql)) {
            return false;
        }

        $lower = strtolower($sql);

        if (substr_count($lower, 'select') !== 1 || preg_match('/;|--|\/\*|#|\b(union|into|join|outfile|dumpfile|load_file|sleep|benchmark|information_schema|for\s+update|lock\s+in)\b/', $lower)) {
            return false;
        }

        // Every backticked table reference must be `products`
        preg_match_all('/`(\w+)`\s*\./', $sql, $tables);
        foreach ($tables[1] as $table) {
            if ($table !== 'products') {
                return false;
            }
        }

        return true;
    }

    private function hasOnlyScalarValues(array $values): bool
    {
        foreach ($values as $value) {
            if (!is_scalar($value) && $value !== null) {
                return false;
            }
        }

        return true;
    }
    public function clearLog()
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {

            file_put_contents($logFile, '');

        }

        return response()->json([
            'success' => true
        ]);
    }
}