<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SubjectController extends Controller
{
    public function allSubject(Request $request)
    { 

       $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $subjects = Subject::all()->toArray();

            if($subjects){

                $subjectData = [];
            
                foreach($subjects as $subject){
                    $semesterName = Semester::find($subject['semester_id'])->name;
                    $userName = User::find($subject['user_id'])->name;
                    $newData = [
                        "id"=> $subject["id"],
                        "name"=> $subject["name"],
                        "credits"=> $subject["credits"],
                        "subject_prerequisite"=> $subject["subject_prerequisite"],
                        "autonomous_hours"=> $subject["autonomous_hours"],
                        "directed_hours"=> $subject["directed_hours"],
                        "semester_id"=> $subject["semester_id"],
                        "user_id"=> $subject["user_id"],
                        "created_at"=> $subject["created_at"],
                        "updated_at"=> $subject["updated_at"],
                        "semesterName"=> $semesterName,
                        "userName"=> $userName
                    ];
                    array_push($subjectData, $newData);
                };
                    return response()->json(
                        [
                        'code' => 200,
                        'status' => 'ok',
                        'data' =>$subjectData
                        ]
                        );

            }else{
                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'message' => 'Sin asignaturas'
                    ]
                    );
            }

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

    public function findSubjectId(Request $request, $id)
    { 

        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $subject = Subject::find($id);
            
                $semesterName = Semester::find($subject['semester_id'])->name;
                $userName = User::find($subject['user_id'])->name;
                $newData = [
                    "id"=> $subject["id"],
                    "name"=> $subject["name"],
                    "credits"=> $subject["credits"],
                    "subject_prerequisite"=> $subject["subject_prerequisite"],
                    "autonomous_hours"=> $subject["autonomous_hours"],
                    "directed_hours"=> $subject["directed_hours"],
                    "semester_id"=> $subject["semester_id"],
                    "user_id"=> $subject["user_id"],
                    "created_at"=> $subject["created_at"],
                    "updated_at"=> $subject["updated_at"],
                    "semesterName"=> $semesterName,
                    "userName"=> $userName
                ];

                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'data' =>$newData
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

        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            Subject::create($request->all());

            $subject = $request->all();

                return response()->json(
                    [
                    'code' => 201,
                    'status' => 'ok',
                    'data' => $subject
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
            
            $subject = Subject::find($id);

            $subject->update($request->all());

                return response()->json(
                    [
                    'code' => 201,
                    'status' => 'ok',
                    'data' => $subject,
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

    public function findSubjectSemesterId(Request $request, $id)
    { 
        
        $jwt = substr($request->header('Authorization', 'token <token>'), 6);

        try {
            
            JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $subjects = Subject::where('semester_id', $id)->get();
        
            if($subjects){

                $subjectData = [];
            
                foreach($subjects as $subject){
                    $semesterName = Semester::find($subject['semester_id'])->name;
                    $userName = User::find($subject['user_id'])->name;
                    $newData = [
                        "id"=> $subject["id"],
                        "name"=> $subject["name"],
                        "credits"=> $subject["credits"],
                        "subject_prerequisite"=> $subject["subject_prerequisite"],
                        "autonomous_hours"=> $subject["autonomous_hours"],
                        "directed_hours"=> $subject["directed_hours"],
                        "semester_id"=> $subject["semester_id"],
                        "user_id"=> $subject["user_id"],
                        "created_at"=> $subject["created_at"],
                        "updated_at"=> $subject["updated_at"],
                        "semesterName"=> $semesterName,
                        "userName"=> $userName
                    ];
                    array_push($subjectData, $newData);
                };
                    return response()->json(
                        [
                        'code' => 200,
                        'status' => 'ok',
                        'data' =>$subjectData
                        ]
                        );

            }else{
                return response()->json(
                    [
                    'code' => 200,
                    'status' => 'ok',
                    'message' => 'Sin asignaturas'
                    ]
                    );
            }

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

            $subject = Subject::find($id);
        
            $subject->delete();
            
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
