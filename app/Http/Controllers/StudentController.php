<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'marks' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Check for existing student
        $existingStudent = Student::where('name', $request->input('name'))
                                  ->where('subject', $request->input('subject'))
                                  ->first();

        if ($existingStudent) {
            // Update marks if the student already exists
            $existingStudent->marks += $request->input('marks');
            $existingStudent->save();
        } else {
            // Create a new student record
            Student::create($request->all());
        }

        return response()->json(['success' => 'Student added successfully']);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->marks = $request->input('marks');
        $student->save();
        return response()->json(['success' => 'Student updated successfully']);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['success' => 'Student deleted successfully']);
    }

}
