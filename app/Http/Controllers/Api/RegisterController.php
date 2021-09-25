<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    // Crear método para guardar los datos del usuario a registrar y validarlos
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // guardar el usuario en la base de tados
        $user = User::create($request->all());

        // Retornar respuesta al cliente
        return response($user, 200);

    }
}
