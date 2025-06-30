<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\LogoutService;

class LogoutController extends Controller
{
    public function __construct(private LogoutService $logoutService) {}

    public function logout(Request $request): JsonResponse
    {
        $this->logoutService->logout($request);
        return response()->json(['message' => 'Logged out']);
    }
}