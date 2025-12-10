<?php

namespace App\Http\Controllers;

use App\Models\Fortune;
use App\Models\FortuneHistory;
use Illuminate\Http\Request;

class GalletaController extends Controller
{
    public function obtenerMensaje()
    {
        $fortune = Fortune::inRandomOrder()->first();

        FortuneHistory::create([
            'user_id' => auth()->id(),
            'fortune_id' => $fortune->id
        ]);

        return response()->json([
            'mensaje' => $fortune->message
        ]);
    }
}
