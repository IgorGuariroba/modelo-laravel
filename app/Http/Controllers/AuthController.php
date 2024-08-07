<?php

namespace App\Http\Controllers;

//use App\Models\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validação dos dados de entrada com regras de senha avançadas
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                Password::min(8) // Mínimo de 8 caracteres
                ->letters() // Deve conter letras
                ->mixedCase() // Deve conter maiúsculas e minúsculas
                ->numbers() // Deve conter números
                ->symbols() // Deve conter símbolos
                ->uncompromised(), // Não deve estar comprometida em vazamentos conhecidos
            ],
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        $token = $user->createToken('userToken')->plainTextToken;
//
//        return response()->json([
//            'user' => $user,
//            'token' => $token
//        ], 201);
    }
}
