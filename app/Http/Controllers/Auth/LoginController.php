<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'checkAuth');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $api_token = Str::random(60);
            $user->api_token = $api_token;

            /** @var \App\Models\User $user **/
            $user->save();
            return response()->json([
                'user' => $user->toArray(),
            ]);
        }
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user) {
            $user->api_token = null;

            /** @var \App\Models\User $user **/
            $user->save();
            return response()->json(['data' => 'User logged out.'], 200);
        }
        return response()->json(['state' => 0, 'message' => 'Unauthenticated'], 401);
    }
    public function checkAuth(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user && $user->is_admin) {
            return response()->json(['state' => 1], 200);
        }
        return response()->json(['state' => 0], 401);
    }
}
