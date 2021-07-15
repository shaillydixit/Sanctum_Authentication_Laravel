<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //Register API
    public function register(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed'
        ]);

        //create data
        $student = new Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone_no = isset($request->phone_no) ? $request->phone_no : "";
        $student->save();

        //send response
        return response()->json([
            'status' => 1,
            'message' => 'student resgistered successfully!',
        ]);
    }

    //Login API
    public function login(Request $request)
    {
        //validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        //check student
        $student = Student::where('email', '=', $request->email)->first();
        if (isset($student->id)) {
            if (Hash::check($request->password, $student->password)) {
                //create a token
                $token = $student->createToken('auth_token')->plainTextToken;

                //send response
                return response()->json([
                    'status' => 1,
                    'message' => ' Student loged in successfully',
                    'access_token' => $token
                ]);
            } else {

                return response()->json([
                    'status' => 0,
                    'message' => 'password did not match'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'student not found'
            ], 404);
        }
    }

    //Profile API
    public function profile()
    {
    }

    //Logout API
    public function logout()
    {
    }
}
