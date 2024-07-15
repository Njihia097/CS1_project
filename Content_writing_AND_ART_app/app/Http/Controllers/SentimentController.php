<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SentimentController extends Controller
{
    public function analyzeSentiment(Request $request)
    {
        // Simulate sentiment analysis with random values
        $sentiment = [
            'polarity' => rand(-100, 100) / 100,
            'subjectivity' => rand(0, 100) / 100,
        ];

        return response()->json($sentiment);
    }
}
