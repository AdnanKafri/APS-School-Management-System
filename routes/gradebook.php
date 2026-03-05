<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Gradebook Module Routes - PHASE 2 CORRECTED
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'SMT/admin/gradebook', 'middleware' => ['auth']], function () {
    // Main menu (NO forced redirect)
    Route::get('/', 'Admin\GradebookController@index')->name('admin.gradebook.index');
    Route::get('/view/options', 'Admin\GradebookController@viewOptions')->name('admin.gradebook.view_options');
    
    // View by Subject flow
    Route::get('/view/subject/classes', 'Admin\GradebookController@viewClassesSubject')->name('admin.gradebook.view_classes_subject');
    Route::get('/view/subject/rooms/{classId}', 'Admin\GradebookController@viewRooms')->name('admin.gradebook.view_rooms');
    Route::get('/view/subject/subjects/{roomId}', 'Admin\GradebookController@viewSubjects')->name('admin.gradebook.view_subjects');
    Route::get('/view/subject/grid', 'Admin\GradebookController@viewGridSimple')->name('admin.gradebook.view_grid_simple');
    
    // View by Student flow
    Route::get('/view/student/classes', 'Admin\GradebookController@viewClassesStudent')->name('admin.gradebook.view_classes_student');
    Route::get('/view/student/rooms/{classId}', 'Admin\GradebookController@viewRoomsStudent')->name('admin.gradebook.view_rooms_student');
    Route::get('/view/student/students/{roomId}', 'Admin\GradebookController@viewStudents')->name('admin.gradebook.view_students');
    Route::get('/view/student/card', 'Admin\GradebookController@viewStudentCard')->name('admin.gradebook.view_student_card');

    // Aggregation Logic (Admin Only)
    Route::post('/aggregate', 'Admin\GradebookAggregationController@aggregateContext')->name('admin.gradebook.aggregate');

    // CONFIGURATION / SETTINGS (Phase 5)
    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', 'Admin\GradebookSettingsController@index')->name('admin.gradebook.settings');
        Route::get('/rooms/{classId}', 'Admin\GradebookSettingsController@viewRooms')->name('admin.gradebook.settings.rooms');
        Route::get('/subjects/{roomId}', 'Admin\GradebookSettingsController@viewSubjects')->name('admin.gradebook.settings.subjects');
        Route::get('/edit/{subjectId}', 'Admin\GradebookSettingsController@edit')->name('admin.gradebook.settings.edit');
        Route::post('/update/{subjectId}', 'Admin\GradebookSettingsController@update')->name('admin.gradebook.settings.update');
    });
});

Route::group(['middleware' => ['auth', 'roleadmin']], function () {
    Route::post('gradebook/status', 'Admin\GradebookController@toggleStatus')->name('admin.gradebook.status');
});
