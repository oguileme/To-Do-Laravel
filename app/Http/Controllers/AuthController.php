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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        return response()->json(['user' => $user], 201);
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

        // Retorna o token para o cliente. TROCAR ISSO DEPOIS PELO AMOR DE DEUS
        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
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
