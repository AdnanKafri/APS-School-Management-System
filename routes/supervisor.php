<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'SMARMANger', 'middleware' => ['rolesupervisor']], function () {
  Route::get('dashboard/supervisor', 'supervisorscontroller@dashboard_supervisor')->name('dashboard.supervisor');
  Route::get('dashboard/supervisor/chat', 'supervisorscontroller@chat')->name('supervisor.chat');
  Route::get('dashboard/supervisor/classes/{supervisor_id}', 'supervisorscontroller@classes')->name('dashboard.supervisor.classes');
  Route::get('dashboard/supervisor/class_lessons/{class_id}', 'supervisorscontroller@class_lessons')->name('dashboard.supervisor.class_lessons');
  Route::get('dashboard/supervisor/lesson_rooms/{class_id}/{lesson_id}', 'supervisorscontroller@lesson_rooms')->name('dashboard.supervisor.lesson_rooms');
  Route::get('dashboard/supervisor/lesson_rooms/book_details/{lesson_id}/{room_id}', 'supervisorscontroller@book_details')->name('dashboard.supervisor.lessons.book_details');
  Route::get('dashboard/supervisor/file_answers/{file_id}/{lesson_id}/{room_id}', 'supervisorscontroller@file_answers')->name('dashboard.supervisor.file_answers');
  Route::get('dashboard/supervisor/StudentsRoomLesson/{room_id}/{teacher_id}/{lesson_id}', 'supervisorscontroller@StudentsRoomLesson')->name('dashboard.supervisor.StudentsRoomLesson');


  Route::get('dashboard/supervisor/classes2/{supervisor_id}', 'supervisorscontroller@classes2')->name('dashboard.supervisor.classes2');
  Route::get('dashboard/supervisor/class_rooms/{class_id}', 'supervisorscontroller@class_rooms')->name('dashboard.supervisor.class_rooms');
  Route::get('dashboard/supervisor/students_rooms/{room_id}', 'supervisorscontroller@students_rooms')->name('dashboard.supervisor.students_rooms');
  Route::get('dashboard/supervisor/student_results/{student_id}', 'supervisorscontroller@student_results')->name('dashboard.supervisor.student_results');


  Route::get('dashboard/supervisor/teachers/{supervisor_id}', 'supervisorscontroller@teachers')->name('dashboard.supervisor.teachers');
  Route::get('dashboard/supervisor/class/lessons2/{class_id}', 'supervisorscontroller@class_lessons2')->name('dashboard.class.lessons');
  Route::get('dashboard/supervisor/lesson/teachers/{lesson_id}', 'supervisorscontroller@lesson_teachers')->name('dashboard.lesson.teachers');

  Route::get('dashboard/supervisor/write_message/{teacher_id}', 'supervisorscontroller@write_message')->name('dashboard.supervisor.write_message');
  Route::post('dashboard/supervisor/send_message/{teacher_id}', 'supervisorscontroller@send_message')->name('dashboard.supervisor.send_message');

  Route::get('dashboard/supervisor/write_group_message/{lesson_id}', 'supervisorscontroller@write_group_message')->name('dashboard.supervisor.write_group_message');
  Route::post('dashboard/supervisor/send_group_message/{lesson_id}', 'supervisorscontroller@send_group_message')->name('dashboard.supervisor.send_group_message');

  Route::get('dashboard/supervisor/teachers2', 'supervisorscontroller@teachers2')->name('dashboard.supervisor.teachers2');

  Route::get('dashboard/supervisor/send_item/{teacher_id}/{lesson_id}', 'supervisorscontroller@send_item')->name('dashboard.supervisor.send_item');
  Route::post('dashboard/supervisor/store_item', 'supervisorscontroller@store_item')->name('dashboard.supervisor.store_item');
  Route::get('dashboard/supervisor/send_group_item/{lesson_id}', 'supervisorscontroller@send_group_item')->name('dashboard.supervisor.send_group_item');

  Route::post('dashboard/supervisor/store_group_item', 'supervisorscontroller@store_group_item')->name('dashboard.supervisor.store_group_item');

  Route::get('dashboard/supervisor/show_old_item/{teacher_id}/{lesson_id}', 'supervisorscontroller@show_old_item')->name('dashboard.supervisor.show_old_item');

  Route::post('dashboard/supervisor/delete_item', 'supervisorscontroller@delete_item')->name('dashboard.supervisor.delete_item');
  Route::get('dashboard/supervisor/edit_item/{item_id}', 'supervisorscontroller@edit_item')->name('dashboard.supervisor.edit_item');

  Route::post('dashboard/supervisor/update_item', 'supervisorscontroller@update_item')->name('dashboard.supervisor.update_item');



  Route::put('dashboard/supervisor/update_profile/{supervisor_id}', 'supervisorscontroller@update_profile')->name('dashboard.supervisor.update_profile');
  Route::put('dashboard/supervisor/update_password/{supervisor_id}', 'supervisorscontroller@update_password')->name('dashboard.supervisor.update_password');


  // الملف الشخصي
  Route::get('dashboard/supervisor/profile/{supervisor_id}', 'supervisorscontroller@profile')->name('dashboard.supervisor.profile');
  Route::post('dashboard/supervisor/profile_store', 'supervisorscontroller@profile_store')->name('dashboard.supervisor.profile_store');
});



// المشرفين التربويين واجهات الحساب
Route::get('dashboard/edu_supervisor/classes/{supervisor_id}', 'supervisorscontroller@classes')->name('dashboard.edu_supervisor.classes');
Route::get('dashboard/edu_supervisor/subjects/{room_id}', 'supervisorscontroller@supervisor_subjects')->name('dashboard.edu_supervisor.subjects');
Route::get('dashboard/edu_supervisor/subjects/lectures/{lesson_id}/{room_id}', 'supervisorscontroller@supervisor_subjects_lectures')->name('dashboard.edu_supervisor.subjects.lectures');
Route::get('dashboard/edu_supervisor/lecture_details/{lesson_id}/{room_id}/{lecture_id}', 'supervisorscontroller@supervisor_lecture_content')->name('dashboard.edu_supervisor.lecture_content');

Route::get('dashboard/edu_supervisor/lesson/homeworke/{room_id}/{lesson_id}', 'supervisorscontroller@lesson_homeworks')->name('edu_supervisor.lesson.homeworks');
Route::get('dashboard/edu_supervisor/homeworke,/marks/{room_id}/{lesson_id}/{content_id}', 'supervisorscontroller@homework_marks')->name('edu_Supervisor.homework.marks');

Route::get('dashboard/edu_supervisor/lesson/quize/{room_id}/{lesson_id}', 'supervisorscontroller@lesson_quizes')->name('edu_supervisor.lesson.quize');
Route::get('dashboard/edu_supervisor/quize/marks/{room_id}/{lesson_id}', 'supervisorscontroller@quize_marks')->name('edu_supervisor.quize.marks');

Route::get('dashboard/edu_supervisor/lesson/quize1/{room_id}/{lesson_id}', 'supervisorscontroller@lesson_quizes1')->name('edu_supervisor.lesson.quize1');

Route::get('dashboard/edu_supervisor/exam/marks/{room_id}/{lesson_id}/{exam_id}', 'supervisorscontroller@exam_marks')->name('edu_supervisor.exam.marks');
Route::get('dashboard/edu_supervisor/lesson/exams/{room_id}/{lesson_id}', 'supervisorscontroller@Lesson_exams')->name('edu_supervisor.lesson.exams');

Route::get('dashboard/edu_supervisor/lesson/total/marks/{room_id}/{lesson_id}', 'supervisorscontroller@lesson_total_marks')->name('edu_supervisor.lesson.total.marks');
