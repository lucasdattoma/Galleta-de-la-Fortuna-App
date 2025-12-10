<?php

namespace App\Http\Controllers;

use App\Models\FortuneHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function userHistory()
    {
        $history = FortuneHistory::with('fortune')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($history);
    }

    public function globalHistory()
    {
        $history = FortuneHistory::with(['user', 'fortune'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($history);
    }
}
