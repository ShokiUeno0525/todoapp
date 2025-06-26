<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private LoginService $loginService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        // ログイン処理
        $token = $this->loginService->login($credentials);

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // トークンを返却
        return response()->json(['token' => $token], 200);
    }
}