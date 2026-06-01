<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        // Lógica para registrar um novo usuário
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try {
            $user = User::create($data);

            return response()->json(['user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        // Lógica para autenticar um usuário e gerar um token

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        
        return response()->json(['mensagem' => 'Login successful'])->header('Authorization', $token);
    }

    public function logout()
    {
        // Lógica para invalidar o token do usuário
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile(Request $request)
    {
        // Lógica para retornar os dados do usuário autenticado
        return response()->json(Auth::guard('api')->user());
    }


}
