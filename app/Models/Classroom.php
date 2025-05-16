<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Classroom
{
    // Fake database
    protected static $data = [
        'students' => [
            ['name' => 'John Doe', 'age' => 20, 'id' => 1],
            ['name' => 'Jane Smith', 'age' => 22, 'id' => 2],
            ['name' => 'Sam Brown', 'age' => 19, 'id' => 3],
        ],
        'teachers' => [
            ['name' => 'KSDsfsf', 'subject' => 'Math', 'id' => 1],
            ['name' => 'Ms. Johnson', 'subject' => 'Science', 'id' => 2],
            ['name' => 'Mrs. Brown', 'subject' => 'English', 'id' => 3]
        ]
    ];

    public static function getStudents()
    {
        return self::$data['students'];
    }

    public static function getTeachers()
    {
        return DB::table('teacher')->get('*');
    }

    // Get student by ID
    public static function getStudentById($id)
    {
        foreach (self::$data['students'] as $student) {
            if ($student['id'] == $id) {
                return $student;
            }
        }
        return null;
    }

    // Delete student by ID
    public static function deleteStudentById($id)
    {
        foreach (self::$data['students'] as $index => $student) {
            if ($student['id'] == $id) {
                unset(self::$data['students'][$index]);
                self::$data['students'] = array_values(self::$data['students']); // reindex
                return true;
            }
        }
        return false;
    }

    // Create student
    public static function createStudent($name, $age)
    {
        $newId = end(self::$data['students'])['id'] + 1;
        $newStudent = ['name' => $name, 'age' => $age, 'id' => $newId];
        self::$data['students'][] = $newStudent;
        return $newStudent;
    }

    // Create teacher (in DB)
    public static function createTeacher($name, $subject)
    {
        return DB::table('teacher')->insert([
            'name' => $name,
            'subject' => $subject
        ]);
    }

    // Edit student by ID
    public static function editStudentById($id, $newData)
    {
        foreach (self::$data['students'] as $index => $student) {
            if ($student['id'] == $id) {
                self::$data['students'][$index] = array_merge($student, $newData);
                return self::$data['students'][$index];
            }
        }
        return null;
    }

    // Edit teacher by ID (in DB)
    public static function editTeacherById($id, $newData)
    {
        return DB::table('teacher')
            ->where('id', $id)
            ->update($newData);
    }
}
