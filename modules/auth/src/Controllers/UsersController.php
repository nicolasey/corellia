<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['update', 'destroy']]);
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
        $input = request()->only(['email', 'password']);
        $rules = [
            "email" => "email",
            "password" => "string|min:6"
        ];
        request()->validate($rules, $input);

        $user = User::create($input);
        $token = Auth::login($user);

        return response()->json(['user' => $user, 'token' => $token], 200);
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
     * Update an user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user)
    {
        $input = request()->only(['email', 'password']);
        $rules = [
            "email" => "email",
            "password" => "string|min:6"
        ];

        $user->update($input);
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
