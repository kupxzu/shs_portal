<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BuildingController;
use App\Http\Controllers\API\TrackController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\GradeController;
use App\Http\Controllers\API\SetController;
use App\Http\Controllers\API\SetStudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API v1 Routes
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('student/login', [StudentController::class, 'login']);
    Route::post('teacher/login', [TeacherController::class, 'login']);
    Route::post('admin/login', [AdminController::class, 'login']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', function (Request $request) {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        });
        
        // Student routes
        Route::apiResource('students', StudentController::class);
        
        // Teacher routes
        Route::apiResource('teachers', TeacherController::class);
        
        // Admin routes
        Route::apiResource('admins', AdminController::class);
        
        // Building routes
        Route::apiResource('buildings', BuildingController::class);
        
        // Track routes
        Route::apiResource('tracks', TrackController::class);
        
        // Room routes
        Route::apiResource('rooms', RoomController::class);
        
        // Section routes
        Route::apiResource('sections', SectionController::class);
        
        // Department routes
        Route::apiResource('departments', DepartmentController::class);
        
        // Grade routes
        Route::apiResource('grades', GradeController::class);
        
        // Set routes
        Route::apiResource('sets', SetController::class);
        
        // Set Student relationship routes
        Route::apiResource('set-students', SetStudentController::class);
        Route::get('students/{studentId}/sets', [SetStudentController::class, 'getStudentSets']);
        Route::get('sets/{setId}/students', [SetStudentController::class, 'getSetStudents']);
    });
    
    // Public routes (if needed)
    Route::get('public/departments', [DepartmentController::class, 'index']);
    Route::get('public/tracks', [TrackController::class, 'index']);
});

// Web Routes (if you need any)
Route::get('/', function () {
    return view('welcome');
});