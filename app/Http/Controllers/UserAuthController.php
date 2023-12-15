<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Services\UserAuthService;
use Illuminate\Http\Response;

class UserAuthController extends Controller
{
    protected $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function index(UserAuthRequest $request)
    {
        $validatedData = $request->validated();
        $result = $this->userAuthService->handle($validatedData);

        if (isset($result['error'])) {
            return response()->json($result, 401);
        }

        return response()->json($result);
    }
}
