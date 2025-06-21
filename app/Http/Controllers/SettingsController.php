<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user()->settings ?? []);

    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'notifications' => 'boolean',
            'theme'         => 'in:light,dark',
        ]);

        $request->user()->update(['settings' => $data]);

        return response()->json($data);
    }
}
