<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SemesterController extends Controller
{
    public function allSemester(Request $request)
    {      
      
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);
        
        try {
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
            $semester = Semester::all()->toArray();
            return response()->json(
                [
                'code' => 200,
                'status' => 'ok',
                'data' =>$semester
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

    public function findSemesterId(Request $request, $id)
    { 
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);
        try {
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));           
            $semester = Semester::find($id);
                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'data' =>$semester
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

    public function store(Request $request )
    {
       $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {          
           JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
            Semester::create($request->all());
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

    public function update(Request $request, $id)
    {
       $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
            $semester = Semester::find($id);     
            $semester->update($request->all());
                return response()->json(
                    [
                    'code' => 201,
                    'status' => 'ok',
                    'data' => $semester,
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

    public function destroy(Request $request, $id)
    {
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
            $semester = Semester::find($id);       
            $semester->delete();            
                return response()->json(
                    [
                    'code' => 204,
                    'status' => 'success'
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
