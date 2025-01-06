<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // validasi
        $credentials=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(!auth::attempt($credentials))
        {
            return response()->json(['message'=>"Credential are not valid"],401);
        }

        $user=auth()->user();

        // kembalikan nilai berhasil login dan berikan bareer token
        return response()->json([
            'token'=>$user->createToken('api-task-management-app')->plainTextToken
        ]);
    }
}
