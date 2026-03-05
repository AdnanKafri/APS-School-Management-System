<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'SMARMANger', 'middleware' => ['roleacadsupervisor']], function () {
  Route::get('dashboard/acadsupervisor', 'acadsupervisorcontroller@dashboard_acadsupervisors')->name('dashboard.acadsupervisor');
  Route::get('dashboard/acadsupervisor/subject/{room_id}', 'acadsupervisorcontroller@acadsupervisor_subject')->name('dashboard.acadsupervisor_subject');
  Route::get('dashboard/acadsupervisor/acadsupervisor_teacher/{room_id}/{teacher_id}/{lesson_id}', 'acadsupervisorcontroller@acadsupervisor_teacher')->name('dashboard.acadsupervisor_teacher');
  Route::get('dashboard/acadsupervisor/acadsupervisor_teacher_lesson/{room_id}/{teacher_id}/{lesson_id}', 'acadsupervisorcontroller@acadsupervisor_teacher_lesson')->name('dashboard.acadsupervisor_teacher_lesson');
  Route::get('dashboard/acadsupervisor/lessons/acadsupervisor_show/{lesson_id}/{teacher_id}/{room_id}/{lecture_id}', 'acadsupervisorcontroller@acadsupervisor_show')->name('dashboard.acadsupervisor_show');
  Route::get('dashboard/acadsupervisor/exam/quest_exam/{id}/{room_id}/{lesson_id}', 'acadsupervisorcontroller@acadsupervisor_quest_exam')->name('acadsupervisor_quest_exam');
  Route::get('dashboard/acadsupervisor/prepare/{room_id}/{class_id}/{lesson_id}/{teacher_id}', 'acadsupervisorcontroller@prepare')->name('acadsupervisor.prepare');
  Route::get('acadsupervisor/pdfdownload1/{id}', 'acadsupervisorcontroller@pdfdownload1')->name('acadsupervisor.pdfdownload1');
  Route::get('acadsupervisor/multipdfdownload1/{id}/{teacher_id}', 'acadsupervisorcontroller@multipdfdownload1')->name('acadsupervisor.multipdfdownload1');
  Route::get('dashboard/acadsupervisor/showclass/{lesson_id}/{teacher_id}/{room_id}', 'acadsupervisorcontroller@showclass')->name('acadsupervisor.showclass');
  Route::get('dashboard/acadsupervisor/searchdate', 'acadsupervisorcontroller@searchdate')->name('searchdate');
  Route::post('dashboard/acadsupervisor/addevaluion', 'acadsupervisorcontroller@addevaluion')->name('acadsupervisor.addevaluion');
  Route::post('dashboard/acadsupervisor/editevaluion', 'acadsupervisorcontroller@editevaluion')->name('acadsupervisor.editevaluion');

  Route::get('dashboard/acadsupervisor/chat', 'acadsupervisorcontroller@chat')->name('acadsupervisor.chat');

  Route::get('dashboard/acadsupervisor/pdf/{lesson_id}/{teacher_id}/{class_id}/{id}', 'acadsupervisorcontroller@pdf')->name('acadsupervisor_pdf');
  Route::get('dashboard/acadsupervisor/all_pdf/{lesson_id}/{teacher_id}/{class_id}', 'acadsupervisorcontroller@all_pdf')->name('acadsupervisor_all_pdf');
  Route::get('dashboard/acadsupervisor/coordinator_show_quize_room/{class_id}/{lesson_id}/{room_id}/{teacher}', 'acadsupervisorcontroller@acadsupervisor_show_quize')->name('acadsupervisor_show_quize_room');
  Route::get('dashboard/acadsupervisor/exam/acadsupervisor_quest_exam_quize/{id}/{room_id}/{lesson_id}/{teacher}', 'acadsupervisorcontroller@acadsupervisor_quest_exam_quize')->name('acadsupervisor_quest_exam_quize');
  Route::get('dashboard/teacher/acadsupervisor_teacher_quize_mark/{room_id}/{class_id}/{teacher_id}/{lesson_id}/{exam_id}', 'acadsupervisorcontroller@acadsupervisor_teacher_quize_mark')->name('acadsupervisor_teacher_quize_mark');

  Route::get('dashboard/acadsupervisor/quizestudent/{lec_id}/{home}/{room_id}', 'acadsupervisorcontroller@quizestudent')->name('dashboard.acadsupervisor_teacher_quize_mark.quizestudent');

  Route::get('dashboard/acadsupervisor/examstudent1/{lec_id}/{home}/{room_id}', 'acadsupervisorcontroller@examstudent1')->name('dashboard.acadsupervisor.examstudent1');
  Route::get('dashboard/acadsupervisor/correct_exam1/{exam_id}/{student_id}/{teacher_id}', 'acadsupervisorcontroller@correct_exam1')->name('acadsupervisor.correct_exam1');
  Route::get('dashboard/acadsupervisor/coordinator_show_exam_room/{class_id}/{lesson_id}/{room_id}/{teacher}', 'acadsupervisorcontroller@acadsupervisor_show_exam_room')->name('acadsupervisor_show_exam_room');
  Route::get('dashboard/acadsupervisor/acadsupervisor_teacher_exam_mark/{room_id}/{class_id}/{teacher_id}/{lesson_id}/{exam_id}', 'acadsupervisorcontroller@acadsupervisor_teacher_exam_mark')->name('acadsupervisor_teacher_exam_mark');
  Route::get('dashboard/acadsupervisor/searchlect1', 'acadsupervisorcontroller@searchlect')->name('dashboard.searchlect12');
  Route::get('dashboard/acadsupervisor/StudentsRoomLessontotal/{room_id}/{teacher_id}/{lesson_id}', 'acadsupervisorcontroller@StudentsRoomLessontotal')->name('StudentsRoomLessontotal12');
  Route::get('dashboard/acadsupervisor/StudentsRoomLessontotal_pdf/{room_id}/{teacher_id}/{lesson_id}', 'acadsupervisorcontroller@StudentsRoomLessontotal_pdf')->name('StudentsRoomLessontotal_pdf12');
  Route::get('dashboard/acadsupervisor/StudentsRoomLessontotal_excel/{room_id}/{teacher_id}/{lesson_id}', 'acadsupervisorcontroller@StudentsRoomLessontotal_excel')->name('StudentsRoomLessontotal_excel12');
  Route::get('dashboard/acadsupervisor/acadsupervisor_teacher_plan/{room_id}/{lesson_id}/{teacher_id}', 'acadsupervisorcontroller@acadsupervisor_teacher_plan')->name('acadsupervisor_teacher_plan');
  Route::get('dashboard/acadsupervisor/teacher_planification/{class_id}/{lesson_id}/{teacher_id}', 'acadsupervisorcontroller@teacher_planification')->name('acadsupervisor_teacher_planification');
  Route::get('dashboard/acadsupervisor/acadsupervisor_teacher_showunit/{room_id}/{lesson_id}/{teacher_id}', 'acadsupervisorcontroller@acadsupervisor_teacher_showunit')->name('acadsupervisor_teacher_showunit');
  Route::get('dashboard/acadsupervisor/searchunitteacher', 'acadsupervisorcontroller@searchunitteacher')->name('acadsupervisor_searchunitteacher');
  Route::get('dashboard/acadsupervisor/acadsupervisor_teacher_schedule/{teacher_id}/{room_id}/{lesson_id}', 'acadsupervisorcontroller@acadsupervisor_teacher_schedule')->name('acadsupervisor_teacher_schedule');
  Route::get('dashboard/acadsupervisor/profile', 'acadsupervisorcontroller@profile')->name('dashboard.acadsupervisor.profile');
  Route::put('dashboard/acadsupervisor/update_profile_coor/{teacher_id}', 'acadsupervisorcontroller@update_profile_coor')->name('dashboard.update_profile_acadsupervisor');
});
