<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['me', 'update', 'destroy']]);
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Create an user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $user = User::create(request()->input());
        $user->load(['personnages']);
        $token = $user->createToken(env("APP_NAME"))->accessToken;

        return response()->json([
            "user" => $user,
            "token" => $token
        ]);
    }

    /**
     * Get an user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user->load(['personnages']));
    }

    /**
     * Get current user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(request()->user());
    }

    /**
     * Update an user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user)
    {
        $user->update(request()->input());
        return response()->json($user);
    }

    /**
     * Delete an user
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        return ($user->delete()) ? response(null, 200) : response(null, 500);
    }
}
