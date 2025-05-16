<?php

use App\Models\Classroom;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Get all students
Route::get('/students', function() {
    $students = Classroom::getStudents();
    return response()->json($students);
});

// Get all teachers from DB
Route::get('/teachers', function() {
    $teachers = Classroom::getTeachers();
    return response()->json($teachers);
});

// Get a specific teacher by ID from DB
Route::get('/teachers/{id}', function($id){
    $teacher = Classroom::getTeachers()->firstWhere('id', $id);
    if ($teacher) {
        return response()->json($teacher);
    }
    return response()->json(['message' => 'Teacher not found'], 404);
});

// Create a new student
Route::post('/students', function() {
    $body = request()->all();

    if (!isset($body['name']) || !isset($body['age'])) {
        return response()->json(['message' => 'Name and age are required'], 400);
    }

    $student = Classroom::createStudent($body['name'], $body['age']);
    return response()->json(['message' => 'Student created', 'data' => $student]);
});

// Edit a teacher by ID (in DB)
Route::patch('/teachers/{id}', function($id) {
    $body = request()->only(['name', 'subject']);
    $updated = Classroom::editTeacherById($id, $body);

    if ($updated) {
        return response()->json(['message' => 'Teacher updated']);
    }
    return response()->json(['message' => 'Teacher not found or no changes made'], 404);
});