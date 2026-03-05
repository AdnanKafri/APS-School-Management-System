<?php

use Illuminate\Support\Facades\Route;

// ============================================================
// SECURITY FIX: /SMT/admin/* routes now require type=2 (Admin)
// Previously: only 'auth' — any logged-in user could access.
// Now: 'auth' + 'roleadmin' — only Admin (type=2) can enter.
// Admin workflow is 100% unchanged. Non-admins are redirected.
// ============================================================
Route::group(['middleware' => ['web', 'auth', 'roleadmin']], function () {
  Route::group(['prefix' => 'SMT/admin'], function () {


    Route::get('/all_workschedule/{id}', 'ReportController@all_workschedule')->name('all_workschedule');

    Route::get('/reports', 'ReportController@index')->name('reports');
    Route::get('/report_student', 'ReportController@students')->name('report_student');
    Route::get('/getteachers2', 'ReportController@getteachers2')->name('getteachers2');
    Route::get('/student_pdf', 'ReportController@student_pdf')->name('student_pdf');
    Route::get('/teacher_pdf', 'ReportController@teacher_pdf')->name('teacher_pdf');
    Route::get('/teacher_attend', 'ReportController@teacher_attend')->name('teacher_attend');
    Route::get('/getstudents2', 'ReportController@getstudents2')->name('getstudents2');
    Route::post('/getstudent_with_attend', 'ReportController@getstudent_with_attend')->name('getstudent_with_attend');
    Route::get('/update_tracer', 'ReportController@update_tracer')->name('update_tracer');
    Route::get('teachers_schedule', 'ReportController@teachers_schedule')->name('teachers_schedule');
    Route::get('/getstudentsdetails/{id}', 'ReportController@getstudentsdetails')->name('getstudentsdetails');

    Route::post('/export_student', 'ReportController@export_student')->name('export_student');
    Route::get('/getstudent/select2/','ReportController@getstudent_select2')->name('getstudent_select2');
    Route::get('/student/report/chart/','ReportController@student_report_chart')->name('student_report_chart');
    Route::get('/get_data_chart','ReportController@get_data_chart')->name('get_data_chart');
    Route::get('/get_info_class_bystudent','ReportController@get_info_class_bystudent')->name('get_info_class_bystudent');
    Route::get('/get_info_class','ReportController@get_info_class')->name('get_info_class');
    Route::get('/start-queue-worker', 'DashboardController@startQueueWorker')->name('start-queue-worker');
    Route::get('/chat', 'DashboardController@chat_admin')->name('chat_admin');
    Route::get('/getchat', 'DashboardController@getchat')->name('getchat');
    Route::get('/all_chat', 'DashboardController@all_chat')->name('all_chat');
    Route::get('/getchat2', 'DashboardController@getchat2')->name('getchat2');
    Route::get('/get_chat_admin', 'DashboardController@get_chat_admin')->name('get_chat_admin');
    Route::post('/storechat', 'DashboardController@storechat')->name('storechat');
    Route::post('/changemessage', 'DashboardController@changemessage')->name('changemessage');
    Route::post('/employee_delete', 'DashboardController@employee_delete')->name('employee_delete');
    Route::post('/recognize_employee', 'DashboardController@recognize_employee')->name('recognize_employee');


    Route::post('/student/probe', 'DashboardController@probe_student')->name('probe_student');
    Route::post('/change_password', 'DashboardController@change_password')->name('change_password');

    Route::get('/getstudentsprobe', 'DashboardController@getstudentsprobe')->name('getstudentsprobe');
    Route::get('/studentprobe', 'DashboardController@studentprobe')->name('studentprobe');

    // Compatibility routes required by legacy admin Blade route('admin.*') links.
    Route::get('base_subjects/{class_id}', 'DashboardController@base_subjects')->name('admin.base_subjects');
    Route::post('base_subject_store', 'DashboardController@base_subject_store')->name('admin.base_subject_store');
    Route::post('base_subject_update', 'DashboardController@base_subject_update')->name('admin.base_subject_update');
    Route::post('base_subject_delete', 'DashboardController@base_subject_delete')->name('admin.base_subject_delete');
    Route::get('objections', 'DashboardController@objection')->name('admin.objections');
    Route::post('delete_objection', 'DashboardController@delete_objection')->name('delete_objection');
    Route::get('our_team', 'DashboardController@our_team')->name('our_team');
    Route::post('google_meet_add', 'DashboardController@google_meet_add')->name('admin.google_meet_add');
    Route::post('student/super', 'DashboardController@student_super')->name('student.super');
    Route::get('teacher_schedule/{id}', 'DashboardController@teacher_schedule')->name('teacher_schedule');
    Route::get('student_attendance/{student_id}/{room_id}/{month}', 'DashboardController@student_attendance')->name('student_attendance');
    Route::post('student_vaccines_update/{student_id}', 'DashboardController@student_vaccines_update')->name('student_vaccines_update');
    Route::get('edu_supervisor/subjects/{room_id}', 'DashboardController@admin_supervisor_subjects')->name('edu_supervisor.subjects');
    Route::get('edu_supervisor/subjects/lectures/{lesson_id}/{room_id}', 'DashboardController@admin_supervisor_subjects_lectures')->name('edu_supervisor.subjects.lectures');
    Route::get('edu_supervisor/lecture_details/{lesson_id}/{room_id}/{lecture_id}', 'DashboardController@admin_supervisor_lecture_content')->name('edu_supervisor.lecture_content');



    Route::put('supervisors/supervisor_update/{supervisor_id}', 'DashboardController@supervisor_update')->name('supervisor_update');
    Route::put('acadsupervisors/supervisor_update/{supervisor_id}', 'DashboardController@acadsupervisor_update')->name('acadsupervisor_update');


    Route::post('/delete_student', 'DashboardController@delete_student')->name('delete_student');
    Route::post('/importedatabase', 'DashboardController@importedatabase')->name('importedatabase');

    Route::get('/index', 'DashboardController@index')->name('dashboard.index');
    Route::get('websitejob', 'DashboardController@websitejob')->name('websitejob');
    Route::get('studentimport', 'DashboardController@studentimport')->name('studentimport');
    Route::get('secret_keeper', 'DashboardController@secret_keeper')->name('secret_keeper');
    Route::get('admin_dashboard_supervisor', 'DashboardController@admin_dashboard_supervisor')->name('admin_dashboard_supervisor');
    Route::get('certificate_fields', 'DashboardController@certificate_fields')->name('certificate_fields');
    Route::get('app_slider', 'DashboardController@app_slider')->name('app_slider');
    Route::post('export_student1', 'DashboardController@export_student1')->name('export_student1');
    Route::post('export_teacher', 'DashboardController@export_teacher')->name('export_teacher');
    Route::post('st_import', 'DashboardController@st_import')->name('st_import');
    Route::post('tech_import', 'DashboardController@tech_import')->name('tech_import');
    Route::get('hide_student_from_supervisor', 'DashboardController@hideStudentFromSupervisor')->name('hide_student_from_supervisor');
    Route::post('hide_student_of_supervisor', 'DashboardController@hideStudentOfSupervisor')->name('hide_student_of_supervisor');
    Route::post('show_student_of_supervisor', 'DashboardController@showStudentOfSupervisor')->name('show_student_of_supervisor');
    Route::get('get_hidden_students_from_supervisor', 'DashboardController@getHiddenStudentsFromSupervisor')->name('get_hidden_students_from_supervisor');

    Route::get('/teachers', 'DashboardController@teachers')->name('teachers');
    Route::get('/employees', 'DashboardController@employees')->name('employees');
    Route::get('/library', 'DashboardController@library')->name('library');
    Route::get('/library/classvideos/{class_id}', 'DashboardController@library_class_videos')->name('library_class_videos');
    Route::get('/library/get_teacher_subjects/{teacher_id}', 'DashboardController@get_teacher_subjects')->name('get_teacher_subjects');
    Route::post('/library/classvideos/store', 'DashboardController@library_video_store')->name('library_video_store');
    Route::post('/library/classvideos/update', 'DashboardController@library_video_update')->name('library_video_update');
    Route::post('/library/classvideos/delete', 'DashboardController@library_video_delete')->name('library_video_delete');

    Route::get('/students', 'DashboardController@students')->name('students');
    Route::post('students/store', 'DashboardController@student_store')->name('student_store');
    Route::get('/studentadmission', 'DashboardController@studentadmission')->name('studentadmission');
    Route::get('/students/financial', 'DashboardController@students_financial')->name('students_financial');

    Route::get('/students/financial_transport', 'TransportationController@students_financial_transport')->name('students_financial_transport');
    Route::get('/students/financial_transport_student_filter', 'TransportationController@financial_transport_student_filter')->name('financial_transport_student_filter');
    Route::get('/students/transport_invoices/{student_id}', 'TransportationController@transport_invoices')->name('transport_invoices');
    Route::post('/students/transport_invoice_store', 'TransportationController@transport_invoice_store')->name('transport_invoice_store');


    Route::get('/getemployees', 'DashboardController@getemployees')->name('getemployees');
    Route::get('/get_employee_detail', 'DashboardController@get_employee_detail')->name('get_employee_detail');
    Route::get('/getstudents', 'DashboardController@getstudents')->name('getstudents');
    Route::get('/getusers', 'DashboardController@getusers')->name('getusers');
    Route::get('/getteachers', 'DashboardController@getteachers')->name('getteachers');
    Route::get('/getterm', 'DashboardController@getterm')->name('getterm');
    Route::get('/getyear', 'DashboardController@getyear')->name('getyear');
    Route::get('/year/get_terms', 'DashboardController@getyear_terms')->name('getyear_terms');
    Route::get('/getobj', 'DashboardController@getobj')->name('getobj');


    Route::post('/term_store', 'DashboardController@term_store')->name('term_store');
    Route::post('/term_update', 'DashboardController@term_update')->name('term_update');
    Route::post('/year_store', 'DashboardController@year_store')->name('year_store');
    Route::post('/year_update', 'DashboardController@year_update')->name('year_update');

    //route for countries_currencies
    Route::get('/countries_currencies', 'DashboardController@countries_currencies')->name('countries_currencies');
    Route::post('/countries_currencies_store', 'DashboardController@add_countries_currencies')->name('add_countries_currencies');
    Route::post('/countries_currencies_update', 'DashboardController@update_countries_currencies')->name('update_countries_currencies');
    Route::post('/countries_currencies_archive', 'DashboardController@archive_countries_currencies')->name('archive_countries_currencies');
    Route::post('/countries_currencies_archive/{id}', 'DashboardController@countries_currencies_archive')->name('activate');
    //route for school_staf
    Route::get('/school_staf', 'DashboardController@school_staf')->name('school_staf');
    Route::post('/school_staf_store', 'DashboardController@add_school_staff')->name('add_school_staff');
    Route::post('/school_staf_update', 'DashboardController@school_staf_update')->name('school_staf_update');
    Route::post('/school_staf_delete', 'DashboardController@delete_school_staff')->name('delete_school_staff');
         Route::get('import_employe','DashboardController@import_employe')->name('import_employe');
                     Route::post('employeesimport','DashboardController@employeesimport')->name('admin.employeesimport');
     //files of school staff
    Route::get('/employee/{id}', 'DashboardController@school_staff_files')->name('employee.attendance');
    Route::post('/staf_file_store/{id}', 'DashboardController@add_staff_file')->name('staff_file_store');
    Route::post('/school_staf_file_delete', 'DashboardController@delete_school_staff_file')->name('delete_school_staff_file');
 //electronic section routes
    Route::get('/electronic_section', 'DashboardController@electronic_sections')->name('electronic_section');
    Route::post('/electronic_section_store', 'DashboardController@add_electronic_sections')->name('electronic_section_store');
    Route::post('/electronic_section_update', 'DashboardController@update_electronic_sections')->name('electronic_section_update');
    Route::post('/electronic_section_delete', 'DashboardController@delete_electronic_sections')->name('electronic_section_delete');

    // electronic files
    Route::get('/electronic_files/{id}', 'DashboardController@school_electronic_files')->name('school_electronic_files');
    Route::post('/electronic_files/{id}', 'DashboardController@add_electronic_file')->name('add_electronic_file');
    Route::post('/electronic_files_delete', 'DashboardController@delete_electronic_file')->name('delete_electronic_file');
    Route::get('/getstudentsapprove', 'DashboardController@getstudentsapprove')->name('getstudentsapprove');
    Route::get('/getstudentsfina', 'DashboardController@getstudentsfina')->name('getstudentsfina');

    Route::post('/teachers/store', 'DashboardController@teacher_store')->name('teacher_store');
    Route::post('/student/approve', 'DashboardController@approve_student')->name('approve_student');


    Route::post('/student/student/request/delete', 'DashboardController@delete_student_request')->name('delete_student_request');
    Route::post('/student/student/request/delete/multiple', 'DashboardController@delete_multiple_student')->name('delete_multiple_student');


    Route::post('teachers/teacher_update', 'DashboardController@teacher_update')->name('teacher_update');

    Route::get('teacher/set_task/{teacher_id}', 'DashboardController@set_task')->name('teacher.set_task');

    Route::post('teacher/store_set_task', 'DashboardController@store_set_task')->name('teacher.store_set_task');
    Route::post('/news/store', 'DashboardController@news_store')->name('news.store');
    Route::get('classes/teacher_lessons/{class_id}', 'DashboardController@teacher_lessons')->name('teacher_lessons');
    Route::get('classes/rooms/{class_id}', 'DashboardController@rooms')->name('rooms');
    Route::post('students/change', 'DashboardController@student_change')->name('student_change');
    Route::post('students/invoice_store', 'DashboardController@invoice_store')->name('invoice_store');
    Route::post('student/change_lang', 'DashboardController@change_lang')->name('change_lang');
    Route::post('send_message', 'DashboardController@send_message')->name('send_message');
    Route::post('student/less', 'DashboardController@student_less')->name('student.less');
    Route::post('student/more', 'DashboardController@student_more')->name('student.more');
    Route::get('student/student_select', 'DashboardController@student_select')->name('student_select');

    Route::get('backups', 'DashboardController@backups')->name('backups');
    Route::get('backups/create', 'DashboardController@backups_create')->name('backups.create');
    Route::get('backups/download/{file_name}', 'DashboardController@backups_download')->name('backups.download');
    Route::get('backups/delete/{file_name}', 'DashboardController@backups_delete')->name('backups.delete');

    Route::get('users', 'DashboardController@users')->name('users');
    Route::post('users/store', 'DashboardController@user_store')->name('user_store');
    Route::post('users/update', 'DashboardController@user_update')->name('user_update');
    Route::post('/user/delete', 'DashboardController@user_delete')->name('user.delete');

    Route::get('roles', 'DashboardController@roles')->name('roles');
    Route::post('roles/store', 'DashboardController@role_store')->name('role_store');
    Route::post('roles/update', 'DashboardController@role_update')->name('role_update');
    Route::post('/role/delete', 'DashboardController@role_delete')->name('role.delete');



    Route::get('teachers/attendance/{id}', 'ReportController@teacherattends')->name('teacher.attendance2');


    Route::get('students/student_filter', 'admincontroller@student_filter')->name('student_filter');
    Route::get('students/student_room_filter', 'admincontroller@student_room_filter')->name('student_room_filter');

    Route::get('students/student_detail_prev/{student_id}', 'admincontroller@student_detail_prev')->name('student_detail_prev');


    Route::get('students/student_details/{student_id}', 'admincontroller@student_details')->middleware('can:edit_student')->name('student_details');
    Route::put('students/student_update/{student_id}', 'admincontroller@student_update')->name('student_update');

    Route::delete('students/destroy/{id}', 'admincontroller@destroy')->name('destroy');

    Route::get('teachers/teacher_details/{teacher_id}', 'admincontroller@teacher_details')->name('teacher_details');
    Route::put('teachers/teacher_update/{teacher_id}', 'admincontroller@teacher_update')->name('teacher_update_by_id');
    Route::post('reset_teacher_password/{teacher_id}', 'admincontroller@reset_teacher_password')->name('reset_teacher_password');

    Route::get('teacher/set_task/{teacher_id}', 'admincontroller@set_task')->middleware('can:set_task')->name('teacher.set_task');
    Route::post('teacher/store_set_task', 'admincontroller@store_set_task')->middleware('can:set_task')->name('teacher.store_set_task');
    Route::get('teacher/edit_task/{teacher_id}', 'admincontroller@edit_task')->middleware('can:edit_task')->name('teacher.edit_task');
    Route::post('teacher/update_set_task', 'admincontroller@update_set_task')->middleware('can:edit_task')->name('teacher.update_set_task');




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

    Route::put('news/store/{news_id}', 'admincontroller@news_store')->name('news.store_by_id');



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
    // phase document 12
    Route::get('students/phase_12/{student_id}', 'DashboardController@student_phase_12')->name('student_phase_12');
    
    // النسب
    Route::get('/get/ministerial_and_financial_ratios','DashboardController@ministerial_and_financial_ratios')->name('ministerial_and_financial_ratios');
    Route::post('/update_ratios','DashboardController@update_ratios')->name('update_ratios');
    Route::get('/get/all_ratios','DashboardController@all_ratios')->name('all_ratios');
    Route::get('/get/all_ratios_details','DashboardController@all_ratios_details')->name('all_ratios_details');
    Route::get('/get/getstudentsfina_datails','DashboardController@getstudentsfina_datails')->name('getstudentsfina_datails');
    
    // المراحل
    Route::get('/get/basic_stage','DashboardController@basic_stage')->name('basic_stage');
    Route::post('/add_stage','DashboardController@add_stage')->name('add_stage');
    Route::post('/edit_stage','DashboardController@edit_stage')->name('edit_stage');
    
    // جلب الصفوف حسب المرحلة
    Route::get('stages_class/{id}','DashboardController@stages_class')->name('stages_class');
    Route::get('stages_class_secret/{id}','DashboardController@stages_class_secret')->name('stages_class_secret');

    // archive
    Route::get('archives','DashboardController@archives')->name('archives');
    Route::get('archives_students','DashboardController@archives_students')->name('archives_students');
    Route::get('archives_teachers','DashboardController@archives_teachers')->name('archives_teachers');
    Route::get('archive_student_year','DashboardController@archive_student_year')->name('archive_student_year');
    Route::get('archives_students_details/{id}','DashboardController@archives_students_details')->name('archives_students_details');
    Route::get('archives_teacher','DashboardController@archives_teacher')->name('archives_teacher');
    Route::get('archive_teacher_year','DashboardController@archive_teacher_year')->name('archive_teacher_year');
    Route::post('teacher_archive','DashboardController@teacher_archive')->name('teacher_archive');

    // super_file
    Route::post('add_super_file','DashboardController@add_super_file')->name('add_super_file');
    Route::post('delete_super_file','DashboardController@delete_super_file')->name('delete_super_file');
    
    // اقسام البناء
    Route::get('construction_departments','DashboardController@construction_departments')->name('construction_departments');
    Route::post('construction_departments_store','DashboardController@construction_departments_store')->name('construction_departments_store');
    Route::post('construction_departments_update','DashboardController@construction_departments_update')->name('construction_departments_update');
    Route::get('department_details/{construction_department_id}','DashboardController@department_details')->name('department_details');
    Route::post('department_details_store','DashboardController@department_details_store')->name('department_details_store');
    Route::post('department_details_update','DashboardController@department_details_update')->name('department_details_update');
    Route::post('department_details_delete','DashboardController@department_details_delete')->name('department_details_delete');
    Route::post('construction_departments_delete','DashboardController@construction_departments_delete')->name('construction_departments_delete');

    // اقسام الطالب
    Route::get('student_details_department','DashboardController@student_details_department')->name('student_details_department');
    Route::post('student_details_department_store','DashboardController@student_details_department_store')->name('student_details_department_store');
    Route::post('student_details_department_update','DashboardController@student_details_department_update')->name('student_details_department_update');
    Route::get('student_details_department_fields/{id}','DashboardController@student_details_department_fields')->name('student_details_department_fields');
    Route::post('student_details_department_fields_store','DashboardController@student_details_department_fields_store')->name('student_details_department_fields_store');
    Route::post('student_details_department_fields_update','DashboardController@student_details_department_fields_update')->name('student_details_department_fields_update');
    Route::post('student_details_department_fields_delete','DashboardController@student_details_department_fields_delete')->name('student_details_department_fields_delete');
    Route::post('student_details_department_delete','DashboardController@student_details_department_delete')->name('student_details_department_delete');

    // اقسام الاستاذ
    Route::get('teacher_details_departments','DashboardController@teacher_details_departments')->name('teacher_details_departments');
    Route::post('teacher_details_department_store','DashboardController@teacher_details_department_store')->name('teacher_details_department_store');
    Route::post('teacher_details_department_update','DashboardController@teacher_details_department_update')->name('teacher_details_department_update');
    Route::get('teacher_details_department_fields/{id}','DashboardController@teacher_details_department_fields')->name('teacher_details_department_fields');
    Route::post('teacher_details_department_fields_store','DashboardController@teacher_details_department_fields_store')->name('teacher_details_department_fields_store');
    Route::post('teacher_details_department_fields_update','DashboardController@teacher_details_department_fields_update')->name('teacher_details_department_fields_update');
    Route::post('teacher_details_department_fields_delete','DashboardController@teacher_details_department_fields_delete')->name('teacher_details_department_fields_delete');
    Route::post('teacher_details_department_delete','DashboardController@teacher_details_department_delete')->name('teacher_details_department_delete');
    // Preserve legacy URL without duplicating teacher_details route name.
    Route::get('teacher_details/{id}','DashboardController@teacher_details');

    // ------------------------------------------------------------
    // Restored legacy SMT/admin named routes used by admin blades
    // ------------------------------------------------------------
    Route::post('lessons/teacher_delete', 'DashboardController@teacher_delete')->name('teacher_delete');
    Route::get('classroom/workschedule/{room_id}', 'DashboardController@workschedule')->name('workschedule');
    Route::get('classroom/workschedule_manager/{room_id}', 'DashboardController@workschedule_manager')->name('workschedule_manager');
    Route::post('save_schedule', 'DashboardController@save_schedule')->name('save.schedule');
    Route::post('dashboard/room/delete_lecture_time', 'DashboardController@delete_lecture_time')->name('dashboard.room.delete.lecture_time');
    Route::post('classes/class_delete', 'DashboardController@class_delete')->name('class_delete');
    Route::post('classes/delete_room', 'DashboardController@room_delete')->name('room_delete');
    Route::get('classroom/StudentsRoomLesson_pdf/{room_id}/{lesson_id}', 'DashboardController@StudentsRoomLesson_pdf')->name('StudentsRoomLesson_pdf');
    Route::get('classroom/StudentsRoomLesson_excel/{room_id}/{lesson_id}', 'DashboardController@StudentsRoomLesson_excel')->name('StudentsRoomLesson_excel');
    Route::post('lessons/delete_lesson', 'DashboardController@lesson_delete2')->name('lesson_delete');
    Route::post('book/update', 'DashboardController@book_update')->name('book_update');
    Route::get('acadsupervisors', 'DashboardController@acadsupervisors')->name('acadsupervisors');
    Route::get('acadsupervisors/supervisor_details/{supervisor_id}', 'DashboardController@acadsupervisor_details')->name('acadsupervisor_details');
    Route::post('acadsupervisor/store', 'DashboardController@acadsupervisor_store')->name('acadsupervisor_store');
    Route::post('acadsupervisor/store_supervisor_set_task', 'DashboardController@store_acadsupervisor_set_task')->name('acadsupervisor.store_acadsupervisor_set_task');
    Route::get('coordinators', 'DashboardController@coordinators')->name('coordinators');
    Route::post('coordinator/store', 'DashboardController@coordinator_store')->name('coordinator_store');
    Route::post('coordinator/update', 'DashboardController@coordinator_update')->name('coordinator_update');
    Route::get('coordinator/set_task/{coordinator_id}', 'DashboardController@set_coordinator_task')->name('set_coordinator_task');
    Route::get('coordinator/edit_coordinator_task/{coordinator_id}', 'DashboardController@edit_coordinator_task')->name('edit_coordinator_task');
    Route::post('coordinator/store_coordinator_task', 'DashboardController@store_coordinator_task')->name('coordinator.store_task');
    Route::post('coordinator/update_coordinator_set_task', 'DashboardController@update_coordinator_task')->name('coordinator.update_task');
    Route::post('user_store', 'DashboardController@user_store')->name('admin.user_store');
    Route::post('user_update', 'DashboardController@user_update')->name('admin.user_update');
    Route::post('user_delete', 'DashboardController@user_delete')->name('admin.user_delete');
    Route::post('transportation/bus_lines_store', 'TransportationController@bus_lines_store')->name('bus_lines_store');
    Route::post('transportation/bus_lines_update', 'TransportationController@bus_lines_update')->name('bus_lines_update');
    Route::get('buses/{id}', 'TransportationController@buses')->name('buses');
    Route::post('buses/buses_store', 'TransportationController@buses_store')->name('buses_store');
    Route::post('buses/buses_update', 'TransportationController@buses_update')->name('buses_update');
    Route::get('bus_students/{bus_id}', 'TransportationController@bus_students')->name('bus_students');
    Route::post('bus_students_store', 'TransportationController@bus_students_store')->name('bus_students_store');
    Route::post('bus_students_delete', 'TransportationController@bus_students_delete')->name('bus_students_delete');
    Route::post('classroom/lesson/admin/student_mark_admin', 'admincontroller@student_mark_admin')->name('student_mark_admin');
    Route::post('classroom/lesson/admin/student_mark_admin_details', 'admincontroller@student_mark_admin_details')->name('student_mark_admin_details');
    Route::post('mainDepartments/mainDepartment_store', 'adminstrationcontroller@mainDepartment_store')->name('mainDepartment_store');
    Route::get('subDepartments/{mainDepartment_id}', 'adminstrationcontroller@subDepartments')->name('subDepartments');
    Route::post('subDepartments/subDepartment_store', 'adminstrationcontroller@subDepartment_store')->name('subDepartment_store');
    Route::get('adminEmployees/{subDepartment_id}', 'adminstrationcontroller@adminEmployees')->name('adminEmployees');
    Route::post('adminEmployees/adminEmployee_store', 'adminstrationcontroller@adminEmployee_store')->name('adminEmployee_store');
    Route::post('adminEmployees/adminEmployee_update', 'adminstrationcontroller@adminEmployee_update')->name('adminEmployee_update');

    Route::get('export_students_detail','DashboardController@export_students_detail')->name('export_students_detail');
    Route::post('export_student_detail_page','DashboardController@export_student_detail_page')->name('export_student_detail_page');
    
    // لوحة التحكم الكاملة بالموقع (داخل لوحة الإدارة)
    Route::get('websitecontroller', 'DashboardController@websitecontroller')->name('websitecontroller');
    Route::get('websitecontrol', 'DashboardController@websitecontroller')->name('websitecontrol');
    Route::get('websitehome', 'DashboardController@websitehome')->name('websitehome');
    Route::get('websitecontactus', 'DashboardController@websitecontactus')->name('websitecontactus');
    Route::get('about_us1', 'DashboardController@about_us1')->name('about_us1');

    // CMS website sections (legacy names used by admin blades)
    Route::get('advantages', 'DashboardController@advantages')->name('advantages');
    Route::post('advntages_store', 'DashboardController@advntages_store')->name('advntages_store');
    Route::post('delete_advantges', 'DashboardController@delete_advantges')->name('delete_advantges');

    Route::get('about', 'DashboardController@about')->name('about');
    Route::post('about_store', 'DashboardController@about_store')->name('about_store');

    Route::get('vision_mission_website', 'DashboardController@vision_mission_website')->name('vision_mission_website');
    Route::post('vision_mission_website/store', 'DashboardController@vision_mission_website_store')->name('vision_mission_website.store');
    Route::post('vision_mission_website/update', 'DashboardController@vision_mission_website_update')->name('vision_mission_website.update');
    Route::post('vision_mission_website/delete', 'DashboardController@vision_mission_website_delete')->name('vision_mission_website.delete');

    Route::get('service_website', 'DashboardController@service_website')->name('service_website');
    Route::post('service_website/store', 'DashboardController@service_website_store')->name('service_website.store');
    Route::post('service_website/update', 'DashboardController@service_website_update')->name('service_website.update');
    Route::post('service_website/delete', 'DashboardController@service_website_delete')->name('service_website.delete');

    Route::get('our_services_feature_website', 'DashboardController@our_services_feature_website')->name('our_services_feature_website');
    Route::post('our_services_feature_website/store', 'DashboardController@our_services_feature_website_store')->name('our_services_feature_website.store');
    Route::post('our_services_feature_website/update', 'DashboardController@our_services_feature_website_update')->name('our_services_feature_website.update');
    Route::post('our_services_feature_website/delete', 'DashboardController@our_services_feature_website_delete')->name('our_services_feature_website.delete');

    Route::get('how_it_works_website', 'DashboardController@how_it_works_website')->name('how_it_works_website');
    Route::post('how_it_works_website/store', 'DashboardController@how_it_works_website_store')->name('how_it_works_website.store');
    Route::post('how_it_works_website/update', 'DashboardController@how_it_works_website_update')->name('how_it_works_website.update');
    Route::post('how_it_works_website/delete', 'DashboardController@how_it_works_website_delete')->name('how_it_works_website.delete');

    Route::get('gallery', 'DashboardController@gallery')->name('gallery');
    Route::post('gallery/store', 'DashboardController@gallery_store')->name('gallery.store');
    Route::post('gallery/update', 'DashboardController@gallery_update')->name('gallery.update');
    Route::post('gallery/delete', 'DashboardController@gallery_delete')->name('gallery.delete');

    Route::get('counter_website', 'DashboardController@counter_website')->name('counter_website');
    Route::post('counter_website/store', 'DashboardController@counter_website_store')->name('counter_website.store');
    Route::post('counter_website/update', 'DashboardController@counter_website_update')->name('counter_website.update');
    Route::post('counter_website/delete', 'DashboardController@counter_website_delete')->name('counter_website.delete');

    Route::get('testimonials_website', 'DashboardController@testimonials_website')->name('testimonials_website');
    Route::post('testimonials_website/store', 'DashboardController@testimonials_website_store')->name('testimonials_website.store');
    Route::post('testimonials_website/update', 'DashboardController@testimonials_website_update')->name('testimonials_website.update');
    Route::post('testimonials_website/delete', 'DashboardController@testimonials_website_delete')->name('testimonials_website.delete');

    Route::get('blogs_website', 'DashboardController@blogs_website')->name('blogs_website');
    Route::post('blogs_website/store', 'DashboardController@blogs_website_store')->name('blogs_website.store');
    Route::post('blogs_website/update', 'DashboardController@blogs_website_update')->name('blogs_website.update');
    Route::post('blogs_website/delete', 'DashboardController@blogs_website_delete')->name('blogs_website.delete');

    Route::get('footer_website', 'DashboardController@footer_website')->name('footer_website');
    Route::post('footer_website/update', 'DashboardController@footer_website_update')->name('footer_website.update');

    Route::get('faqs_website', 'DashboardController@faqs_website')->name('faqs_website');
    Route::post('faqs_website/store', 'DashboardController@faqs_website_store')->name('faqs_website.store');
    Route::post('faqs_website/update', 'DashboardController@faqs_website_update')->name('faqs_website.update');
    Route::post('faqs_website/delete', 'DashboardController@faqs_website_delete')->name('faqs_website.delete');

    Route::get('contact_website', 'DashboardController@contact_website')->name('contact_website');
    Route::post('contact_website/delete', 'DashboardController@contact_website_delete')->name('contact_website.delete');

    // تواصل الطلاب مع الإدارة
    Route::get('student_contact', 'DashboardController@student_contact')->name('student_contact');

    // إدارة الصلاحيات (مرآة لمسار SMARMANger/admin/roles)
    Route::prefix('roles')->group(function () {
        Route::get('/', 'rolescontroller@index')->name('admin.roles.index');
        Route::post('store', 'rolescontroller@store')->name('admin.roles.store');
        Route::post('update', 'rolescontroller@update')->name('admin.roles.update');
        Route::get('add', 'rolescontroller@role_add')->name('admin.roles.add');
        Route::get('edit/{id}', 'rolescontroller@role_edit')->name('admin.roles.edit');
    });

    // النجاح والرسوب / الجلاءات - الصفوف
    Route::get('classes/graduation', 'DashboardController@classes_graduation')->name('classes.graduation');

    // الإدارة - الأقسام الرئيسية
    Route::get('adminstration/mainDepartments', 'adminstrationcontroller@mainDepartments')->name('mainDepartments');

    // الإدارة - مدراء الأفرع
    Route::get('adminstration/adminstrators', 'adminstrationcontroller@adminstrators')->name('adminstrators');
    Route::post('adminstration/adminstrator_store', 'adminstrationcontroller@adminstrator_store')->name('adminstrator_store');

    // قسم المواصلات
    Route::get('transportations', 'TransportationController@transportation')->name('transportations');
    Route::get('transportations/bus_supervisors', 'TransportationController@bus_supervisor')->name('bus_supervisor');
    Route::post('transportations/bus_supervisors/store', 'TransportationController@bus_supervisor_store')->name('bus_supervisor_store');
    Route::post('transportations/bus_supervisors/update', 'TransportationController@bus_supervisor_update')->name('bus_supervisor_update');
    Route::post('transportations/bus_supervisors/delete', 'TransportationController@bus_supervisor_delete')->name('bus_supervisor_delete');

    Route::get('transportations/bus_drivers', 'TransportationController@bus_driver')->name('bus_driver');
    Route::post('transportations/bus_drivers/store', 'TransportationController@bus_driver_store')->name('bus_driver_store');
    Route::post('transportations/bus_drivers/update', 'TransportationController@bus_driver_update')->name('bus_driver_update');
    Route::post('transportations/bus_drivers/delete', 'TransportationController@bus_driver_delete')->name('bus_driver_delete');

    // قسم المناهج (الصفوف → المناهج)
    Route::get('lessons2', 'DashboardController@lessons2')->name('lessons2');

    // جدول الحصص (الحصص اليومية)
    Route::get('sessions', 'DashboardController@sessions')->name('sessions');
    Route::get('session_class/{id}', 'DashboardController@session_class')->name('session_class');
    Route::post('session_store', 'DashboardController@session_store')->name('session_store');
    Route::post('session_store1', 'DashboardController@session_store1')->name('session_store1');
    Route::post('session_update', 'DashboardController@session_update')->name('session_update');
    Route::post('session/delete', 'DashboardController@session_delete')->name('allsession_delete');
    Route::post('session_delete', 'DashboardController@session_delete')->name('session_delete');

    // جدول الحضور والاختبارات
    Route::get('classes/manager', 'DashboardController@classes_manager')->name('classes.manager');
    Route::get('classroom/manager/{id}', 'DashboardController@classroom_manager')->name('classroom_manager');
    Route::get('classes/view/exams', 'DashboardController@classes_view_exams')->name('classes.view.exams');
    Route::get('classroom/exams/{id}', 'DashboardController@classroom_exams')->name('classroom_exams');
    Route::get('class/room/quizes/{room_id}', 'DashboardController@room_quizes')->name('room_quizes');
    Route::post('class/room/quize/store', 'DashboardController@quize_store')->name('quize.store');
    Route::post('class/room/quize/update', 'DashboardController@quize_update')->name('quize.update');
    Route::get('class/room/exams/{room_id}', 'DashboardController@room_exams')->name('room_exams');
    Route::post('class/room/exam/store', 'DashboardController@exam_store')->name('exam.store');
    Route::post('class/room/exam/update', 'DashboardController@exam_update')->name('exam.update');
    Route::post('class/room/exam_quize/delete', 'DashboardController@exam_quize_delete')->name('exam_quize.delete');
    Route::get('class/room/students/exams/{room_id}/{exam_id}', 'DashboardController@room_students_exam')->name('room_students_exam');
    // إعادة تفعيل الامتحان
    Route::post('dashboard/teacher/exam_reactivate', 'teacherscontroller@exam_reactivate')->name('exam_reactivate');

    // المكافأت والعقوبات
    Route::get('Rewards_and_sanctions','DashboardController@Rewards_and_sanctions')->name('Rewards_and_sanctions');
    Route::get('rewards','DashboardController@rewards')->name('rewards');
    Route::get('sanctions','DashboardController@sanctions')->name('sanctions');
    Route::post('rewards_and_sanction_store','DashboardController@rewards_and_sanction_store')->name('rewards_and_sanction_store');
    Route::post('rewards_and_sanction_update','DashboardController@rewards_and_sanction_update')->name('rewards_and_sanction_update');
    Route::post('rewards_and_sanction_delete','DashboardController@rewards_and_sanction_delete')->name('rewards_and_sanction_delete');
    
    // مشرف وزاري عقوبات
    Route::get('supervisor_rewads','DashboardController@supervisor_rewads')->name('supervisor_rewads');
    Route::get('supervisor_sanctions','DashboardController@supervisor_sanctions')->name('supervisor_sanctions');
    Route::get('filter_rewads','DashboardController@filter_rewads')->name('filter_rewads');
    
    // فلترة مذاكرات
    Route::get('quize_filter_search','DashboardController@quize_filter_search')->name('quize_filter_search');
    Route::get('exam_filter_search','DashboardController@exam_filter_search')->name('exam_filter_search');
    Route::get('workschedule_room/{class_id}','DashboardController@workschedule_room')->name('workschedule_room');
    Route::get('classroom/workschedule_exam/{room_id}', 'DashboardController@workschedule_exam')->name('workschedule_exam');
    Route::get('workschedule_class','DashboardController@workschedule_class')->name('workschedule_class');
    Route::post('dashboard/admin/student/pass/check/by/admin_class9', 'DashboardController@student_pass_check_by_admin_9')->name('student_pass_check_by_admin_9');
    
    // صفحة بيانات المدرسة
    Route::get('dashboard/admin/school_data', 'DashboardController@school_data')->name('school_data');
    Route::post('dashboard/admin/school_data_update', 'DashboardController@school_data_update')->name('school_data_update');
  });
});
