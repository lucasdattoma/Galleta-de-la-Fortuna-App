<?php

namespace App\Http\Controllers;

use App\Models\Fortune;
use Illuminate\Http\Request;

class FortuneController extends Controller
{
    public function index()
    {
        $fortunes = Fortune::all();
        return response()->json($fortunes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $fortune = Fortune::create([
            'message' => $request->message
        ]);

        return response()->json($fortune, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $fortune = Fortune::findOrFail($id);
        $fortune->update([
            'message' => $request->message
        ]);

        return response()->json($fortune);
    }

    public function destroy($id)
    {
        $fortune = Fortune::findOrFail($id);
        $fortune->delete();

        return response()->json(['message' => 'Mensaje eliminado']);
    }
}
