<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit($id)
    {
        if(User::where('id',$id)->exists()){
            $user = User::where('id',$id)->first();
            return response()->json([
                    'status' => true,
                    'data' => $user,
                ], 200);
        }else{

            return response()->json([
                    'status' => false,
                    'message' => "Usuario no encontrado",
                    'data' => null,
                ], 404);

        }
    }
    public function update(Request $request,$id)
    {
        try {
            //verify if users exist
        if(User::where('id',$id)->exists()){
            $user = User::where('id',$id)->first();
        }else{

            return response()->json([
                    'status' => false,
                    'message' => "Usuario no encontrado",
                    'data' => null,
                ], 404);
        }

            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'required|min:8',
                'address' => 'max:500',
                'birthdate' => 'date',
                 'city' => 'max:255',
            ]);


            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error en la validación',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //update users
            $user = User::updated([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'birthdate' => $request->birthdate,
                'city' => $request->city
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Usuario editado con exito',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
