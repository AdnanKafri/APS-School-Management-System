<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'SMARMANger', 'middleware' => ['rolestudent']], function () {

  Route::get('/login/student', 'studentscontroller@create')->name('studentlogin');
  Route::post('/login/student', 'studentscontroller@studentLogin')->name('studentlogin');
  // os : changed made by osama
  // Route::get('dashboard/student', 'studentscontroller@dashboard')->name('dashboard');
  Route::get('dashboard/student', 'studentscontroller@lessons')->name('dashboard');
  Route::get('dashboard/student_admin_message', 'studentscontroller@student_admin_message')->name('student_admin_message');
  Route::post('/add_mes', 'studentscontroller@add_mes')->name('add_mes');



  // osama edit lesson: is the subject like math.
  Route::get('dashboard/student/courses/content/{lesson_id}/{student_id}', 'studentscontroller@course_content')->name('dashboard.student.course.content');
  // مررنا اي دي المادة والطالب
  Route::get('dashboard/student/lesson/lectures/{lesson_id}/{room_id}/{student_id}', 'studentscontroller@lectures')->name('dashboard.student.lesson.lectures');
  Route::get('dashboard/student/lesson/lecture/extra_files/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_extra_file')->name('dashboard.student.lesson.lecture.extra_files');
  Route::get('dashboard/student/lesson/lecture/video/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_video')->name('dashboard.student.lesson.lecture.video');
  Route::get('dashboard/student/lesson/lecture/audio/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_audio')->name('dashboard.student.lesson.lecture.audio');
  Route::get('dashboard/student/lesson/lecture/homework/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_homework')->name('dashboard.student.lesson.lecture.homework');
  Route::get('dashboard/student/lesson/lecture/quize/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_quize')->name('dashboard.student.lesson.lecture.quize');
  Route::get('dashboard/student/lesson/lecture/exam/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_exam')->name('dashboard.student.lesson.lecture.exam');
  Route::get('dashboard/student/lesson/lecture/marks/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_mark')->name('dashboard.student.lesson.lecture.marks');
  // الاختبارات
  Route::get('dashboard/student/exam/test/start_exam/{exam_id}', 'studentscontroller@start_exam')->name('dashboard.student.exam.start_exam');
  Route::post('dashboard/student/exam/save_exam', 'studentscontroller@save_exam')->name('dashboard.student.save_exam');
  Route::get('dashboard/student/view/exam/{exam_id}', 'studentscontroller@view_exam')->name('dashboard.student.exam.view_exam');
  // الامتحانات والمذاكرات
  Route::get('dashboard/student/start_main_exam/{exam_id}', 'studentscontroller@start_main_exam')->name('dashboard.student.start_main_exam');
  Route::post('dashboard/student/exam/save_main_exam', 'studentscontroller@save_main_exam')->name('dashboard.student.save_main_exam');
  Route::get('dashboard/student/view/main_exam/{exam_id}', 'studentscontroller@view_main_exam')->name('dashboard.student.exam.view_main_exam');
//   Route::get('/myTest', 'studentscontroller@save_main_exam_test');


  Route::get('dashboard/student/lesson/lecture/content/{lesson_id}/{student_id}/{lecture_id}', 'studentscontroller@lecture_content')->name('dashboard.student.lesson.lecture.content');
  //واجهة تخزين جدول حصص شعبة من قبل الادمن
  Route::get('dashboard/student/room/schedule/{room_id}/{student_id}', 'studentscontroller@set_schedule')->name('dashboard.student.room.set_schedule');
  Route::post('dashboard/student/room/save_schedule', 'studentscontroller@save_schedule')->name('dashboard.room.save.schedule');
  //واجهة استعراض جدول حصص شعبة لطالب
  Route::get('dashboard/students/room/view_schedule/{room_id}/{student_id}/{time_zone_offset}', 'studentscontroller@student_schedule')->name('dashboard.students.room.view_schedule');
  //واجهة استعراض جدول حصص  الاستاذ
  Route::get('dashboard/teacher/view_schedule/{student_id}/{room_id}/{teacher_id}', 'studentscontroller@teacher_schedule')->name('dashboard.teacher.view_schedule');
  //اختبار توقيت  الحصة ب شعبة لطالب
  Route::get('dashboard/students/room/go_to_stream/{scheduler_id}/{day_id}/{lecture_time_id}/{room_id}/{student_id}', 'studentscontroller@go_to_stream')->name('dashboard.students.room.go_to_stream');
  // جلب امتحانات الطالب
  Route::get('dashboard/student/room/exams/{room_id}/{student_id}', 'studentscontroller@student_exams')->name('dashboard.student.room.exams');
  Route::get('dashboard/student/room/main_exams/{room_id}/{student_id}', 'studentscontroller@student_main_exams')->name('dashboard.student.room.main.exams');
  Route::get('dashboard/student/room/main_quizes/{room_id}/{student_id}', 'studentscontroller@student_main_quizes')->name('dashboard.student.room.main.quizes');

  // الملف الشخصي
  Route::get('dashboard/student/profile/{student_id}/{room_id}', 'studentscontroller@profile')->name('dashboard.student.profile');
  Route::post('dashboard/student/profile_store', 'studentscontroller@profile_store')->name('dashboard.student.profile_store');


  Route::get('dashboard/student/medical_profile/{room_id}/{student_id}', 'studentscontroller@medical_profile')->name('dashboard.student.medical_profile');
  Route::get('dashboard2/student/medical_profile/details/{type}', 'studentscontroller@medical_profile_details')->name('dashboard.student.medical_profile_details');


  Route::get('dashboard/student/transport/{room_id}/{student_id}', 'studentscontroller@transport')->name('dashboard.student.transport');


  Route::post('dashboard/student/upload_files', 'studentscontroller@upload_files')->name('dashboard.student.upload_files');
  Route::post('dashboard/student/upload_exam_files', 'studentscontroller@upload_exam_files')->name('dashboard.student.upload_exam_files');
//الكتب المدرسية
Route::get('dashboard/student/book/{id}', 'studentscontroller@books_student')->name('student.book');
//الملفات الالكترونية
Route::get('dashboard/student/electronic_sections','studentscontroller@electronic_sections')->name('student_electronic_sections');
Route::get('dashboard/student/electronic_files/{id}', 'studentscontroller@student_electronic_files')->name('student_electronic_files');



  //  old routes
  Route::get('dashboard/student/results/{student_id}', 'studentscontroller@results')->name('dashboard.student.results');

  Route::put('dashboard/student/update_profile/{student_id}', 'studentscontroller@update_profile')->name('dashboard.student.update_profile');
  Route::put('dashboard/student/update_password/{student_id}', 'studentscontroller@update_password')->name('dashboard.student.update_password');
  Route::delete('dashboard/student/delete_answer/{id}/{student_id}/{file_id}/{type}', 'studentscontroller@delete_answer')->name('dashboard.student.delete_answer');
  Route::post('dashboard/student/delete_answer2', 'studentscontroller@delete_answer2')->name('dashboard.student.delete_answer2');

  Route::get('dashboard/student/lessons/{student_id}', 'studentscontroller@lessons')->name('dashboard.student.lessons');
  Route::get('dashboard/student/lessons/details/{lesson_id}/{student_id}', 'studentscontroller@lesson_detail')->name('dashboard.student.lessons.details');
  Route::post('dashboard/student/lessons/upload_store', 'studentscontroller@upload_store')->name('dashboard.student.upload_store');

  Route::get('dashboard/student/financial_account/{student_id}', 'studentscontroller@financial_account')->name('dashboard.financial_account');
  Route::post('dashboard/checkout', 'studentscontroller@checkout')->name('dashboard.checkout');

  //  الرسائل
  Route::get('dashboard/student/messages/{student_id}/{teacher_id}', 'studentscontroller@messages')->name('dashboard.student.messages');
  Route::get('dashboard/student/get_teacher_message/{student_id}/{teacher_id}', 'studentscontroller@get_teacher_message')->name('dashboard.student.get_teacher_message');
  Route::post('dashboard/student/store_student_message', 'studentscontroller@store_student_message')->name('dashboard.student.store_student_message');


  Route::get('dashboard/student/medals/{student_id}', 'studentscontroller@student_medals')->name('dashboard.student.student_medals');


  Route::get('dashboard/student/events', 'studentscontroller@events')->name('dashboard.student.events');
  Route::post('dashboard/charge', 'studentscontroller@charge')->name('dashboard.charge');
  Route::get('dashboard/student/objection/{room_id}', 'studentscontroller@objection')->name('dashboard.student.objection');
  Route::get('getteacher/{lesson_id}', 'studentscontroller@getteacher')->name('getteacher');
  Route::post('dashboard/objection_store', 'studentscontroller@objection_store')->name('objection_store');
  Route::get('dashboard/certificates/{room_id}', 'studentscontroller@certificates')->name('certificates');
  Route::post('dashboard/certificates_stor', 'studentscontroller@certificates_stor')->name('certificates_stor');
  Route::get('dashboard/edit_2/{id}', 'studentscontroller@edit_2')->name('edit_2');
  Route::get('dashboard/newcertificate/{id}', 'studentscontroller@newcertificate')->name('newcertificate');
  Route::get('dashboard/new44/{id}', 'studentscontroller@new44')->name('new441');
  Route::get('dashboard/ncertificate12/{id}', 'studentscontroller@ncertificate12')->name('ncertificate12');
  Route::get('dashboard/newcerti12/{id}', 'studentscontroller@newcerti')->name('newcerti12');
  Route::get('dashboard/certificate_22/{id}', 'studentscontroller@certificate_22')->name('certificate_22');
  Route::get('dashboard/new22/{id}', 'studentscontroller@new2')->name('new22');

  Route::get('dashboard/student_exam', 'studentscontroller@student_exam')->name('student_exam');
  Route::get('dashboard/student/view/report/card', 'studentscontroller@student_view_report_card')->name('student_view_report_card');
  Route::post('dashboard/student/add_payment_receipts', 'studentscontroller@add_payment_receipts')->name('add_payment_receipts');
  Route::get('dashboard/student/payment_receipts_last', 'studentscontroller@payment_receipts_last')->name('payment_receipts_last');

  Route::get('dashboard/student/student_info', 'studentscontroller@student_info')->name('student_info');
  Route::post('dashboard/student/edit_student_info/{student_id}', 'studentscontroller@edit_student_info')->name('edit_student_info');
  Route::post('dashboard/student/modification_request', 'studentscontroller@modification_request')->name('modification_request');
//تميز الاشعار كمقروء
 Route::get('dashboard/student/read_notification/{id}', 'studentscontroller@read_notification')->name('read_notification');
 // الغاء الاشعارات بعد تسجيل الخروج
  Route::get('dashboard/student/deletekey_notification', 'studentscontroller@deletekey_notification')->name('deletekey_notification');

  Route::get('studentSaveToken', 'studentscontroller@studentSaveToken')->name('studentSaveToken');

  ///  المكافات والعقوبات
Route::get('dashboard/student/student_rewads/{student_id}', 'studentscontroller@student_rewads')->name('student.student_rewads');
Route::get('dashboard/student/student_sanctions/{student_id}', 'studentscontroller@student_sanctions')->name('student.student_sanctions');


});
