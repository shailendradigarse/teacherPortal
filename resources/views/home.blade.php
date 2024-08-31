@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="">
                        {{ __('Student') }}
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            Add New Student
                            </button>
                        </div>
                    </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject Name</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr data-student-id="{{ $student->id }}">
                                    <td>
                                        <span class="name-text">{{ $student->name }}</span>
                                        <input type="text" value="{{ $student->name }}" class="form-control name-input d-none">
                                    </td>
                                    <td>
                                        <span class="subject-text">{{ $student->subject }}</span>
                                        <input type="text" value="{{ $student->subject }}" class="form-control subject-input d-none">
                                    </td>
                                    <td>
                                        <span class="marks-text">{{ $student->marks }}</span>
                                        <input type="number" value="{{ $student->marks }}" class="form-control marks-input d-none">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary edit-button" data-student-id="{{ $student->id }}">Edit</button>
                                        <button class="btn btn-danger delete-button" data-student-id="{{ $student->id }}">Delete</button>
                                        <button class="btn btn-success save-button d-none" data-student-id="{{ $student->id }}">Save</button>
                                        <button class="btn btn-secondary cancel-button d-none" data-student-id="{{ $student->id }}">Cancel</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
