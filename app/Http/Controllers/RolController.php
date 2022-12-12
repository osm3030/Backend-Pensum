<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class RolController extends Controller
{
    public function allRol(Request $request)
    {      
      
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);
        
        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $rol = Rol::all()->toArray();

            return response()->json(
                [
                'code' => 200,
                'status' => 'ok',
                'data' =>$rol
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

    public function findRolId(Request $request, $id)
    { 

        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {

            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
            
            $rol = Rol::find($id);

            $rolName = $rol->name;

                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'data' =>$rolName
                    ]
                    );   

        } catch (\Exception $th) {

            $error =  $th->getMessage();

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
