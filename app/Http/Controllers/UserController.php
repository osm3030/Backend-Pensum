<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            
            $email = $request->email;
            
            $pass = $request->password;

            $user = User::firstWhere('email', $email);

            $passBD = $user->password;

            $rol = $user->rol_id;

            if(Hash::check($pass, $passBD)){

                $jwt = JWT::encode([$user], env('JWT_SECRET'), 'HS256');

                return response()->json(
                    [
                    'code'=> 200,
                    'status'=> 'Ok',
                    'data'=> $user,
                    'rol'=> $rol,
                    'token'=> $jwt
                    ]
                );

            }else{
                return response()->json(
                    [
                    'code'=> 401,
                    'message' => 'usuario o contraseña incorrectos'
                    ]
                );
            };

        } catch (\Exception $th) {
            
            $error = $th->getMessage();

            return response()->json(
                [
                'code' => 500,
                'status' => 'error',
                'data' => $error
                ]
                ); 
        }
    }

    public function allUser(Request $request)
    { 
        
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $user = User::all()->toArray();

                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'data' =>$user
                    ]
                    );

        } catch (\Exception $th) {

            $error = $th->getMessage();

            return response()->json(
                [
                'code' => 500,
                'status' => 'error',
                'data' => $error
                ]
                );
        }
    }
    
    public function findUserRolId(Request $request)
    { 
        
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $user = User::where('rol_id', 2)->get();
        
                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'data' =>$user
                    ]
                    );

        } catch (\Exception $th) {

            $error = $th->getMessage();

            return response()->json(
                [
                'code' => 500,
                'status' => 'error',
                'data' => $error
                ]
                );
        }
    }


    public function store(Request $request )
    {
        try {
            
            $request->request->add([
                'password' => Hash::make($request->input('password'))
            ]);

            User::create($request->all());

            return response()->json(
                [
                'code' => 201,
                'status' => 'ok',
                'data' => $request->all(),
                ]
                );

        } catch (\Exception $th) {

            $error = $th->getMessage();

            return response()->json(
                [
                'code' => 500,
                'status' => 'error',
                'data' => $error
                ]
                ); 
        }
    }
}
