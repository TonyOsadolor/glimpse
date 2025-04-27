<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProfileService;
use App\Enums\VerificationTypeEnum;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendVerificationCodeJob;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Inject Service Class
     * @param UserService $userService
     * @param ProfileService $profileService
     */
    public function __construct(public UserService $userService, public ProfileService $profileService)
    {
        $this->userService = $userService;
        $this->profileService = $profileService;
    }

    /**
     * Authenticate a user and generate a token for them.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $userData = $request->validated();

        if (Auth::attempt($userData)) {
            // Get the authenticated user
            $user = Auth::user();

            // Create the token
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('Auth Token')->plainTextToken;

            return Response::success(200, 'Login successful', $data);
        }

        return Response::error(400, 'Invalid Login credentials');
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // Validationg Request Data for Profile Creation
        $userData = $request->validated();
        $userData['password'] = Hash::make($request->password);
        
        $newUser = $this->userService->create($userData);
        $data = new UserResource($newUser);
        $company = isset($userData['company_name']);

        $profileData = [
            'user_id' => $newUser->id,
            'role' => $newUser->role,
            'company_name' => $company ? $userData['company_name'] : null,
        ];

        $this->profileService->create($profileData);

        SendVerificationCodeJob::dispatch($data['email'], VerificationTypeEnum::EMAIL);

        return Response::success(200, 'Registration Successful! Check your Email for Verification Code', $data);
    }
}
