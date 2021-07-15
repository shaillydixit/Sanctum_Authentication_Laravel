<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //Create Project API
    public function createProject(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required'
        ]);

        //student id + create data
        $student_id = auth()->user()->id;

        $project = new Project();

        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;
        $project->save();

        //send response
        return response()->json([
            'status' => 1,
            'message' => 'project has been created successfully'
        ]);
    }

    //List Project API
    public function listProject()
    {
        $student_id = auth()->user()->id;

        $projects = Project::where('student_id', $student_id)->get();

        return response()->json([
            'status' => 1,
            'message' => "Projects",
            'data' => $projects
        ]);
    }

    //Single Project API
    public function singleProject($id)
    {
        $student_id = auth()->user()->id;
        if (Project::where(['id' => $id, 'student_id' => $student_id])->exists()) {
            $details = Project::where(['id' => $id, 'student_id' => $student_id])->first();
            return response()->json([
                'status' => 1,
                'message' => 'Project Details',
                'data' => $details
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Project not found',
            ]);
        }
    }

    //Delete Project API
    public function deleteProject($id)
    {
        $student_id = auth()->user()->id;
        if (Project::where(['id' => $id, 'student_id' => $student_id])->exists()) {
            $project = Project::where([
                'id' => $id,
                'student_id' => $student_id
            ])->first();
            $project->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Project has been deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Project not found'
            ]);
        }
    }
}
