<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Gradebook Module Routes - PHASE 2 CORRECTED
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'SMT/admin/gradebook', 'middleware' => ['auth', 'roleadmin', 'can:student_marks']], function () {
    // Main menu (NO forced redirect)
    Route::get('/', 'Admin\GradebookController@index')->name('admin.gradebook.index');
    Route::group(['prefix'=>'templates', 'as'=>'admin.gradebook.templates.'], function () {
        Route::get('/', 'Admin\GradebookTemplateController@index')->name('index');
        Route::post('/', 'Admin\GradebookTemplateController@store')->name('store');
        Route::get('/{template}', 'Admin\GradebookTemplateController@show')->name('show');
        Route::post('/{template}/draft', 'Admin\GradebookTemplateController@save')->name('save');
        Route::post('/{template}/discard', 'Admin\GradebookTemplateController@discard')->name('discard');
        Route::post('/{template}/start', 'Admin\GradebookTemplateController@start')->name('start');
        Route::get('/{template}/preview', 'Admin\GradebookTemplateController@preview')->name('preview');
        Route::post('/{template}/publish', 'Admin\GradebookTemplateController@publish')->name('publish');
        Route::get('/{template}/versions/{version}', 'Admin\GradebookTemplateController@version')->name('version');
        Route::post('/{template}/versions/{version}/duplicate', 'Admin\GradebookTemplateController@duplicate')->name('duplicate');
    });
    Route::get('/equivalence', 'Admin\AssessmentEquivalenceController@index')->name('admin.gradebook.equivalence');
    Route::post('/equivalence', 'Admin\AssessmentEquivalenceController@store')->name('admin.gradebook.equivalence.store');
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

Route::group(['middleware' => ['auth', 'roleadmin', 'can:student_marks']], function () {
    Route::post('gradebook/status', 'Admin\GradebookController@toggleStatus')->name('admin.gradebook.status');
});
