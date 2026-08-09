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
        $sql = base64_decode($request->sql);
        $bindings = json_decode($request->bindings,true);

        try{

            $products = DB::select($sql,$bindings);

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