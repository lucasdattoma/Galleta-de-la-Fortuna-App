<?php

namespace App\Http\Controllers;

use App\Models\Fortune;
use App\Models\FortuneHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $totalShown = FortuneHistory::count();

        $topMessages = FortuneHistory::select('fortune_id', DB::raw('count(*) as total'))
            ->groupBy('fortune_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('fortune')
            ->get();

        $totalUsers = User::count();

        return response()->json([
            'total_shown' => $totalShown,
            'top_messages' => $topMessages,
            'total_users' => $totalUsers
        ]);
    }
}
