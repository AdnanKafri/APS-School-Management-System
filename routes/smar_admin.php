<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'SMARMANger/admin', 'as' => 'admin.', 'middleware' => ['roleadmin']], function () {
  Route::get('get-backup', 'admincontroller@databasebackup')->name('get-backup');
  Route::get('backups', 'admincontroller@backups')->middleware('can:backup')->name('backups');
  Route::get('zip/{id}', 'admincontroller@zipfile')->name('zip');

  Route::post('backup_del', 'admincontroller@backup_del')->name('backup_del');

  Route::post('reset_password/{id}', 'admincontroller@reset_password')->name('reset_password');


  Route::post('reset_student_password/{student_id}', 'admincontroller@reset_student_password')->name('reset_student_password');

  Route::post('send_message', 'admincontroller@send_message')->name('send_message');



  Route::prefix('roles')->group(function () {

    Route::get('/', 'rolescontroller@index')->name('roles.index');

    Route::get('create', 'rolescontroller@create')->name('roles.create');
    Route::post('store', 'rolescontroller@store')->name('roles.store');
    Route::get('edit/{id}', 'rolescontroller@edit')->name('roles.edit');
    Route::get('delete', 'rolescontroller@delete')->name('roles.delete');

    Route::post('update', 'rolescontroller@update')->name('roles.update');

    Route::get('role_add', 'rolescontroller@role_add')->name('roles.add');
    Route::get('role_edit/{id}', 'rolescontroller@role_edit')->name('roles.edit');

  });




  Route::post('user/user_delete', 'admincontroller@user_delete')->name('user.delete');


  Route::get('students', 'admincontroller@students')->middleware('can:students')->name('students');
  Route::get('students/result_active', 'admincontroller@result_active')->name('students.result_active');
  Route::get('students/result_disable', 'admincontroller@result_disable')->name('students.result_disable');

  Route::post('student/super', 'admincontroller@student_super')->name('student.super');

  Route::post('student/less', 'admincontroller@student_less')->name('student.less');


  Route::post('student/change_lang', 'admincontroller@change_lang')->name('student.change_lang');



  Route::post('students/store', 'admincontroller@student_store')->name('student_store');
  Route::get('students/student_filter', 'admincontroller@student_filter')->name('student_filter');
  Route::get('students/student_room_filter', 'admincontroller@student_room_filter')->name('student_room_filter');

  Route::get('students/student_detail_prev/{student_id}', 'admincontroller@student_detail_prev')->name('student_detail_prev');


  Route::get('students/student_details/{student_id}', 'admincontroller@student_details')->middleware('can:edit_student')->name('student_details');
  Route::put('students/student_update/{student_id}', 'admincontroller@student_update')->name('student_update');

  Route::delete('students/destroy/{id}', 'admincontroller@destroy')->name('destroy');

  Route::get('teachers', 'admincontroller@teachers')->middleware('can:teachers')->name('teachers');
  Route::get('teachers/teacher_details/{teacher_id}', 'admincontroller@teacher_details')->name('teacher_details');
  Route::put('teachers/teacher_update/{teacher_id}', 'admincontroller@teacher_update')->name('teacher_update');
  Route::post('reset_teacher_password/{teacher_id}', 'admincontroller@reset_teacher_password')->name('reset_teacher_password');

  Route::get('teacher/set_task/{teacher_id}', 'admincontroller@set_task')->middleware('can:set_task')->name('teacher.set_task');
  Route::post('teacher/store_set_task', 'admincontroller@store_set_task')->middleware('can:set_task')->name('teacher.store_set_task');
  Route::get('teacher/edit_task/{teacher_id}', 'admincontroller@edit_task')->middleware('can:edit_task')->name('teacher.edit_task');
  Route::post('teacher/update_set_task', 'admincontroller@update_set_task')->middleware('can:edit_task')->name('teacher.update_set_task');

  Route::post('teachers/store', 'admincontroller@teacher_store')->name('teacher_store');



Route::get('teachers/teacher_filter', 'admincontroller@teacher_filter')->name('teacher_filter');
Route::get('classes', 'admincontroller@classes')->middleware('can:classes')->name('classes');
Route::post('classes/class_store', 'admincontroller@class_store')->name('class_store');
Route::post('classes/class_update', 'admincontroller@class_update')->name('class_update');



  Route::get('classes/rooms/{class_id}', 'admincontroller@rooms')->name('rooms');

  Route::post('classes/update_room', 'admincontroller@room_update')->name('room_update');


  Route::get('classes/rooms2/{class_id}/{room_id}', 'admincontroller@rooms2')->name('rooms2');



  Route::get('classes/teacher_lessons/{class_id}', 'admincontroller@teacher_lessons')->name('teacher_lessons');
  Route::get('lessons', 'admincontroller@lessons')->middleware('can:lessons')->name('lessons');
  Route::get('lessons/class_lessons/{class_id}', 'admincontroller@class_lessons')->name('class_lessons');

  Route::post('lessons/store', 'admincontroller@lesson_store')->name('lesson_store');
  Route::post('lessons/update_lesson', 'admincontroller@lesson_update')->name('lesson_update');
  Route::post('/lesson/delete', 'admincontroller@lesson_delete')->name('lesson.delete');


  Route::get('classroom/{id}', 'admincontroller@classroom')->middleware('can:show_rooms')->name('classroom');
  Route::post('classroom/room_store', 'admincontroller@room_store')->name('room_store');

  Route::get('classroom/roomlessons/{class_id}/{room_id}', 'admincontroller@roomlessons')->middleware('can:show_lessons')->name('roomlessons');
  Route::get('classroom/roomteachers/{class_id}/{room_id}', 'admincontroller@roomteachers')->name('roomteachers');
  Route::get('classroom/StudentsRoomLesson/{room_id}/{lesson_id}', 'admincontroller@StudentsRoomLesson')->middleware('can:student_marks')->name('StudentsRoomLesson');

  Route::get('classroom/roomstudent/{id1}/{id2}', 'admincontroller@roomstudent')->middleware('can:show_students')->name('roomstudent');

  Route::post('classroom/lesson/student_mark', 'admincontroller@student_mark')->name('student_mark');

  Route::get('terms', 'admincontroller@terms')->middleware('can:terms')->name('terms');
  Route::post('terms', 'admincontroller@term_store')->name('term_store');

  Route::post('terms/term_update', 'admincontroller@term_update')->name('term_update');


  Route::post('students/change', 'admincontroller@student_change')->name('student_change');
  // Route::get('students/archive/{student_id}','admincontroller@student_archive')->name('student_archive');
  Route::post('students/financial_account', 'admincontroller@financial_account')->name('financial_account');
  Route::get('students/invoices_details/{student_id}', 'admincontroller@invoices_details')->name('invoices_details');
  Route::post('students/invoices_delete/{invoice_id}', 'admincontroller@invoices_delete')->name('invoices_delete');

  Route::get('students/remain_account/{student_id}/{class_id}', 'admincontroller@remain_account')->name('remain_account');
  Route::post('students/invoice_store', 'admincontroller@invoice_store')->name('invoice_store');

  Route::get('years/show_years', 'admincontroller@show_years')->middleware('can:years')->name('show_years');
  Route::post('current_year', 'admincontroller@current_year')->name('current_year');


  Route::get('supervisors', 'admincontroller@supervisors')->middleware('can:supervisors')->name('supervisors');
  // DUPLICATE-FIX: Removed second identical supervisors route definition.
  // Route::get('supervisors', 'admincontroller@supervisors')->middleware('can:supervisors')->name('supervisors');

  Route::post('supervisor/store', 'admincontroller@supervisor_store')->name('supervisor_store');
  // Route::get('supervisors/supervisor_details/{supervisor_id}','admincontroller@supervisor_details')->name('supervisor_details');
  Route::post('reset_supervisor_password/{supervisor_id}', 'admincontroller@reset_supervisor_password')->name('reset_supervisor_password');
  Route::put('supervisors/supervisor_update/{supervisor_id}', 'admincontroller@supervisor_update')->name('supervisor_update');


  Route::get('supervisor/set_supervisor_task/{supervisor_id}', 'admincontroller@set_supervisor_task')->name('supervisor.set_supervisor_task');
  Route::post('supervisor/store_supervisor_set_task', 'admincontroller@store_supervisor_set_task')->name('supervisor.store_supervisor_set_task');
  Route::get('supervisor/edit_supervisor_task/{supervisor_id}', 'admincontroller@edit_supervisor_task')->name('supervisor.edit_supervisor_task');
  Route::post('supervisor/update_supervisor_set_task', 'admincontroller@update_supervisor_set_task')->name('supervisor.update_supervisor_set_task');

  // -------------------------------


  Route::get('slider', 'admincontroller@slider')->name('slider');

  Route::post('slider/store', 'admincontroller@slider_store')->name('slider.store');
  Route::post('slider/slider_delete', 'admincontroller@slider_delete')->name('slider.delete');
  Route::post('slider/slider_update', 'admincontroller@slider_update')->name('slider.update');


  Route::get('header_info', 'admincontroller@header_info')->name('header_info');

  Route::put('header_info/store/{slider_id}', 'admincontroller@header_info_store')->name('header_info.store');



  Route::get('inside_slider', 'admincontroller@inside_slider')->name('inside_slider');

  Route::put('inside_slider/store/{slider_id}', 'admincontroller@inside_slider_store')->name('inside_slider.store');


  Route::get('news', 'admincontroller@news')->name('news');

  Route::put('news/store/{news_id}', 'admincontroller@news_store')->name('news.store');



  Route::get('about_us', 'admincontroller@about_us')->name('about_us');
  Route::put('about_us/store/{about_us_id}', 'admincontroller@about_us_store')->name('about_us.store');

  Route::get('contacts', 'admincontroller@contacts')->name('contacts');
  Route::post('/contact/answer', 'admincontroller@contact_answer')->name('contact.answer');

  Route::post('contact/delete', 'admincontroller@contact_delete')->name('contact.delete');

  Route::get('/events', 'admincontroller@events')->name('events');
  Route::post('/events/update', 'admincontroller@events_update')->name('events.update');

  Route::post('/event/store', 'admincontroller@event_store')->name('event.store');

  Route::post('/event/delete', 'admincontroller@event_delete')->name('event.delete');


  Route::get('/blogs', 'admincontroller@blogs')->name('blogs');
  Route::post('/blog/store', 'admincontroller@blog_store')->name('blog.store');
  Route::post('/blog/update', 'admincontroller@blog_update')->name('blog.update');

  Route::post('/blog/delete', 'admincontroller@blog_delete')->name('blog.delete');



  Route::get('/news', 'admincontroller@news')->name('news');
  Route::post('/news/store', 'admincontroller@news_store')->name('news.store');
  Route::post('/news/update', 'admincontroller@news_update')->name('news.update');

  Route::post('/news/delete', 'admincontroller@news_delete')->name('news.delete');




  Route::get('/jobs', 'admincontroller@jobs')->name('jobs');
  Route::post('/job/store', 'admincontroller@job_store')->name('job.store');
  Route::post('/job/update', 'admincontroller@job_update')->name('job.update');

  Route::post('/job/delete', 'admincontroller@job_delete')->name('job.delete');

  Route::get('/applicants', 'admincontroller@applicants')->name('applicants');

  Route::post('/applicant/delete', 'admincontroller@applicant_delete')->name('applicant.delete');


  Route::get('/video', 'admincontroller@video')->name('video');

  Route::post('video/video_update', 'admincontroller@video_update')->name('video_update');


  Route::get('/footer', 'admincontroller@footer')->name('footer');

  Route::put('footer/footer_update/{footer_id}', 'admincontroller@footer_update')->name('footer_update');

  Route::get('validate_email1', 'admincontroller@validate_email1')->name('validate_email1');
});
