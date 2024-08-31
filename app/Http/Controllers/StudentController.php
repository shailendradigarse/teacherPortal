<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        try {
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
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database query error'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'subject' => 'required|string|max:255',
                'marks' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            // Find the student by ID
            $student = Student::findOrFail($id);

            // Check for an existing student with the same name and subject (excluding the current student)
            $existingStudent = Student::where('name', $request->input('name'))
                                    ->where('subject', $request->input('subject'))
                                    ->where('id', '!=', $id)
                                    ->first();

            if ($existingStudent) {
                return response()->json(['error' => 'A student with the same name and subject already exists'], 409);
            }

            // Update student details
            $student->subject = $request->input('subject');
            $student->name = $request->input('name');
            $student->marks = $request->input('marks');
            $student->save();

            return response()->json(['success' => 'Student updated successfully']);
        } catch (ModelNotFoundException $e) {
            // Handle case where the student is not found
            return response()->json(['error' => 'Student not found'], 404);
        } catch (QueryException $e) {
            // Handle database query errors
            return response()->json(['error' => 'Database query error', 'details' => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Handle any other unexpected errors
            return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return response()->json(['success' => 'Student deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database query error'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
