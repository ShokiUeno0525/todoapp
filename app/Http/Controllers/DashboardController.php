<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function data(Request $request)
    {
        $user = $request->user();
        $total     = $user->todos()->count();
        $completed = $user->todos()->where('status', 'done')->count();
        $inProgress = $total - $completed;

        return response()->json([
            'total'      => $total,
            'completed'  => $completed,
            'inProgress' => $inProgress,
            'completionrate' => $total ? round($completed / $total * 100,1) : 0, 
        ]);
    }
}
