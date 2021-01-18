<?php
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Events\UserLoggedIn;
use Modules\Auth\Events\UserLoggedOut;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {
            $rules = [
                "email" => "email|required",
                "password" => "string|min:6|required"
            ];
            request()->validate($rules);
    
            $credentials = request(['email', 'password']);
    
            if(!Auth::attempt($credentials)) {
                return response()->json(["message" => "Login Failed"], 401);
            }
    
            $user = User::where('email', $credentials['email'])->find();
    
            if(!Hash::check($credentials['password'], $user->password)) {
                return response()->json(["message" => "Login Failed"], 401);
            }
    
            $token = $user->createToken(`authToken`)->plainTextToken;
            $user->load('personnages', 'activePersonnage');
    
            event(new UserLoggedIn($user));
            return response()->json(compact($user, $token), 200);
        } catch(Exception $e) {
            return response()->json(["message" => "Login Failed"], 401);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = request()->user();
        $user->load(['personnages', 'activePersonnage']);
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $tokens = request()->user()->tokens;
        foreach ($tokens as $token) $token->delete();
        event(new UserLoggedOut(request()->user()->id));

        return response()->json(['message' => 'Successfully logged out']);
    }
}
