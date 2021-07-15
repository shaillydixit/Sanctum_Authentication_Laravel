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
    public function login()
    {
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
