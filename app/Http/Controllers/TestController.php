<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        return view('test');
    }

    public function anagramCheck(Request $request)
    {
        $str1 = strtolower(str_replace(' ', '', $request->input('str1')));
        $str2 = strtolower(str_replace(' ', '', $request->input('str2')));

        if (strlen($str1) !== strlen($str2)) {
            return response()->json(['result' => "false"], 200);
        }

        $arrStr = str_split($str1);
        $arrStr2 = str_split($str2);

        sort($arrStr);
        sort($arrStr2);

        return response()->json(['result' => "true"], 200);
    }

    public function frequencyLetter(Request $request)
    {
        $sentence = strtolower(str_replace(' ', '',$request->input('sentence')));
        $frequency = array_count_values(str_split($sentence));
        $maxFrequency = max($frequency);
        $mostFrequent = array_keys($frequency, $maxFrequency);

        return response()->json(['result' => $mostFrequent, 'count' => $maxFrequency], 200);
    }

    public function matrixGenerator(Request $request    )
    {
        $rows = $request->input('row');
        $cols = $request->input('col');

        $matrix = [];
        for ($i = 0; $i < $rows; $i++) {
            $matrixRow = [];

            for ($j = 0; $j < $cols; $j++) {
                $matrixRow[] = $i == $j ? $cols : 0;
            }

            $matrix[] = $matrixRow;
        }

        return response()->json(['result' => $matrix], 200);
    }

}
