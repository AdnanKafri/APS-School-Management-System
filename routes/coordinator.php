<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'SMARMANger', 'middleware' => ['rolecoordinators']], function () {
    //new routes for المشرف المدرسي
    //اضافة اسئلة
    Route::get('dashboard/coordinator/questions/{class_id}/{room_id}/{lecture_id}/{lesson_id}/','coordinatorcontroller@questions')->name('dashboard.coordinator.questions');
    Route::get('dashboard/coordinator/add_questions/{class_id}/{room_id}/{lecture_id}/{lesson_id}','coordinatorcontroller@add_questions')->name('coordinator.add_questions');
    Route::post('dashboard/coordinator/questions/update/{question_id}','coordinatorcontroller@question_update')->name('coordinator.question.update');
    //صفحة اضافة سؤال
    Route::post('dashboard/coordinator/add_questions/store','coordinatorcontroller@question_store')->name('coordinator.question.store');
    Route::get('dashboard/coordinator/questions/edit/{question_id}/{room_id}','coordinatorcontroller@question_edit')->name('coordinator.question.edit');
      //اضافة فقرة
    Route::get('dashboard/coordinator/sections/{class_id}/{room_id}/{lecture_id}/{lesson_id}','coordinatorcontroller@sections')->name('dashboard.coordinator.sections');
    //تخزين فقرة
    Route::post('dashboard/coordinator/sections/store', 'coordinatorcontroller@section_store')->name('dashboard.store');
      Route::post('dashboard/coordinator/sections/update','coordinatorcontroller@section_update')->name('dashboard.update');
    //دفتر العلامات
    Route::get('dashboard/coordinator/classes_mark_book', 'coordinatorcontroller@classes_mark_book')->name('dashboard.classes_mark_book');
    Route::get('dashboard/coordinator/mark_book_subject/{room_id}', 'coordinatorcontroller@mark_book_subject')->name('dashboard.mark_book_subject');
    Route::get('dashboard/coordinator/subject_mark_book/{room_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal')->name('dashboard.coor.StudentsRoomLessontotal');
    //كتب المدرسية
    Route::get('dashboard/coordinator/classes_book', 'coordinatorcontroller@classes_book')->name('dashboard.classes_book');
    Route::get('dashboard/coordinator/classes_book/{id}', 'coordinatorcontroller@books')->name('dashboard.book');

  Route::get('dashboard/coordinator', 'coordinatorcontroller@dashboard_coordinator')->name('dashboard.coordinator');
  Route::get('dashboard/coordinator/subject/{room_id}', 'coordinatorcontroller@coordinator_subject')->name('dashboard.coordinator_subject');
  Route::get('dashboard/coordinator/subjects/lectures/{lesson_id}/{room_id}', 'coordinatorcontroller@coordinator_subjects_lectures')->name('coordinator_subjects_lectures');
  Route::get('dashboard/coordinator/lecture_details/{lesson_id}/{room_id}/{lecture_id}', 'coordinatorcontroller@coordinator_lecture_content')->name('coordinator_lecture_content');
  //add_content
  Route::get('dashboard/coordinator/add_content/{class_id}/{coordinator_id}/{room_id}/{lecture_id}', 'coordinatorcontroller@add_content')->name('dashboard.add_content');
  Route::post('dashboard/coordinator/classes_lessons/store_items_coor', 'coordinatorcontroller@store_items_coor')->name('store_items_coor');
  //الملفات الالكترونية
  Route::get('dashboard/coordinator/coordinator_electronic_sections','coordinatorcontroller@electronic_sec')->name('coordinator_electronic_sections');
  Route::get('dashboard/coordinator/coordinator_electronic_files/{id}', 'coordinatorcontroller@electronic_files')->name('coordinator_electronic_files');
  //المذاكرات والامتحانات
  Route::get('dashboard/coordinator/exams_quizes', 'coordinatorcontroller@exams_quizes_page')->name('dashboard.coordinator.exams_quizes');
  //صفحة المواد
  Route::get('dashboard/coordinator/{room_id}/{coordinator_id}', 'coordinatorcontroller@marks_subjects')->name('dashboard.coordinator.marks.subjects');
  //عرض صفحة جميع  الامتحانات
  Route::get('dashboard/coordinator/{room_id}/{coordinator_id}/{lesson_id}', 'coordinatorcontroller@coordinator_exam_mark')->name('coordinator_exam');
  //اظهار صفحة علامات الطلاب
  Route::get('dashboard/coordinator/exam_students/{room_id}/{coordinator_id}/{lesson_id}/{exam_id}', 'coordinatorcontroller@exam_students')->name('coordinator_exam_students');
  //صفحة اضافة اسئلة
  Route::get('dashboard/coordinator/exams1_addquestion/{exam_id}/{room_id}/{class_id}/{lesson_id}', 'coordinatorcontroller@exams1_addquestion')->name('coordinator_exams1_addquestion');
  Route::post('dashboard/coordinator/exams/myquestions1', 'coordinatorcontroller@myquestions1')->name('coordinator_exams_myquestions1');
  //مشاهدة ملف الامتحان
  Route::get('dashboard/coordinator/exam/quest_exam1/{id}/{class_id}/{lesson_id}', 'coordinatorcontroller@quest_exam1')->name('coordinator.quest_exam1');
  Route::get('dashboard/coordinator/StudentsRoomLesson_quize/{room_id}/{coordinator_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLesson_quize')->name('coordinator.StudentsRoomLesson_quize');
Route::get('dashboard/coordinator/StudentsRoomLesson_exammark/{room_id}/{coordinator_id}/{lesson_id}/{exam_id}', 'coordinatorcontroller@StudentsRoomLesson_exammark')->name('coordinator.StudentsRoomLesson_exammark');
Route::get('dashboard/coordinator/studentselect/{exam}/{room}', 'coordinatorcontroller@studentselect')->name('dashboard.coordinator.studentselect');
Route::get('dashboard/coordinator/detexam', 'coordinatorcontroller@detexam')->name('dashboard.detexam');
//اضافة الطلاب للمذاكرة
Route::post('dashboard/coordinator/add_quize_student', 'coordinatorcontroller@add_quize_student')->name('coordinator.add_quize_student');
//اضاف ملف للامتحان التقليدي
Route::post('dashboard/coordinator/exams/exam_update123','coordinatorcontroller@exam_update123')->name('coordinator.dashboard.exam.update123');
Route::get('dashboard/coordinator/examstudent2/{lec_id}/{home}/{room_id}', 'coordinatorcontroller@examstudent2')->name('dashboard.coordinator.examstudent2');
//ملف الامتحان
Route::get('dashboard/coordinator/exam/correct_exam1/{exam_id}/{student_id}', 'coordinatorcontroller@correct_exam1')->name('dashboard.coordinator.correct_exam1');
Route::get('dashboard/coordinator/coor_quize/{room_id}/{coordinator_id}/{lesson_id}', 'coordinatorcontroller@coor_quize_mark')->name('coordinator_quize_mark');
// صفحة علامات المذكرات تبع الطلاب
Route::get('dashboard/coordinator/teacher_quize_students/{room_id}/{coordinator_id}/{lesson_id}/{exam_id}', 'coordinatorcontroller@coor_quize_students')->name('coor_quize_students');
//عرض وظائف الطلاب
Route::get('dashboard/coordinator/StudentsRoomLesson/{room_id}/{coordinator_id}/{lesson_id}/{exam_id}', 'coordinatorcontroller@StudentsRoomLesson')->name('coordinator.StudentsRoomLesson');
Route::get('dashboard/coordinator/homeworkestudent/{lec_id}/{home}/{room_id}', 'coordinatorcontroller@homeworkestudent')->name('coordinator.teacher.homeworkestudent');


  //نهاية التعدديلات الجديدة للمشرف المدرسي بدون مراقبة جداول الدوام

   //   مرقبة جدول الدوام

   Route::get('dashboard/coordinator/class_schedule', 'coordinatorcontroller@class_schedule')->name('coordinator.class_schedule');

    Route::get('coordinator/show_class_schedule/{room_id}/{time_zone_offset}', 'coordinatorcontroller@show_class_schedule')->name('show_class_schedule');
    Route::get('dashboard/coordinator/subjects/teacher_question/{lesson_id}/{room_id}', 'coordinatorcontroller@teacher_question')->name('teacher_question');
    Route::get('/accept_question/{question_id}', 'coordinatorcontroller@accept_question')->name('accept_question');



  Route::get('dashboard/coordinator/coordinator_teacher/{class_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@coordinator_teacher')->name('dashboard.coordinator_teacher');
  Route::get('dashboard/coordinator/coordinator_teacher_lesson/{class_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@coordinator_teacher_lesson')->name('dashboard.coordinator_teacher_lesson');
  Route::get('dashboard/coordinator/lessons/coordinator_show/{lesson_id}/{teacher_id}/{room_id}/{lecture_id}', 'coordinatorcontroller@coordinator_show')->name('dashboard.coordinator_show');
  Route::get('dashboard/coordinator/chat', 'coordinatorcontroller@chat')->name('dashboard.coordinator.chat');


  Route::get('dashboard/coordinator/prepare/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@prepare')->name('dashboard.teacher.prepare');
  Route::get('pdfdownload1/{id}', 'coordinatorcontroller@pdfdownload')->name('pdfdownload1');
  Route::get('multipdfdownload1/{id}/{teacher_id}', 'coordinatorcontroller@multipdfdownload')->name('multipdfdownload1');
  Route::get('dashboard/coordinator/searchlect1', 'coordinatorcontroller@searchlect')->name('dashboard.searchlect1');
  Route::get('dashboard/coordinator/coordinator_lesson/{class_id}/{lesson_id}', 'coordinatorcontroller@coordinator_lesson')->name('coordinator_lesson');

  Route::get('dashboard/coordinator/planification/{class_id}/{lesson_id}', 'coordinatorcontroller@planification')->name('planification');
  Route::get('dashboard/coordinator/planification_trimestrielle/{class_id}/{lesson_id}', 'coordinatorcontroller@planification_trimestrielle')->name('planification_trimestrielle');
  Route::post('dashboard/coordinator/addplanification', 'coordinatorcontroller@addplanification')->name('addplanification');
  Route::get('dashboard/coordinator/unit_analysis/{class_id}/{lesson_id}', 'coordinatorcontroller@unit_analysis')->name('unit_analysis');
  Route::post('dashboard/coordinator/addunit', 'coordinatorcontroller@addunit')->name('addunit');
  Route::get('dashboard/coordinator/show_unit/{class_id}/{lesson_id}', 'coordinatorcontroller@show_unit')->name('show_unit');
  Route::post('dashboard/coordinator/updateunit', 'coordinatorcontroller@updateunit')->name('updateunit');
  Route::get('dashboard/coordinator/searchunit', 'coordinatorcontroller@searchunit')->name('searchunit');

  Route::get('dashboard/coordinator/profile', 'coordinatorcontroller@profile')->name('dashboard.coordinator.profile');
  Route::put('dashboard/teacher/update_profile_coor/{teacher_id}', 'coordinatorcontroller@update_profile_coor')->name('dashboard.update_profile_coor');
  Route::get('dashboard/coordinator/showclass/{lesson_id}/{teacher_id}/{class_id}', 'coordinatorcontroller@showclass')->name('showclass');
  Route::post('dashboard/coordinator/addevaluion', 'coordinatorcontroller@addevaluion')->name('addevaluion');
  Route::post('dashboard/coordinator/editevaluion', 'coordinatorcontroller@editevaluion')->name('editevaluion');
  Route::get('dashboard/coordinator/searchdate', 'coordinatorcontroller@searchdate')->name('dashboard.searchdate');
  Route::get('dashboard/coordinator/pdf/{lesson_id}/{teacher_id}/{class_id}/{id}', 'coordinatorcontroller@pdf')->name('pdf');
  Route::get('dashboard/coordinator/all_pdf/{lesson_id}/{teacher_id}/{class_id}', 'coordinatorcontroller@all_pdf')->name('all_pdf');
  Route::get('dashboard/coordinator/coordinator_quize/{class_id}/{lesson_id}', 'coordinatorcontroller@coordinator_quize')->name('coordinator_quize');
  Route::post('dashboard/coordinator/store_items', 'coordinatorcontroller@store_items1')->name('dashboard.store_items1');
  Route::get('dashboard/coordinator/coordinator_show_quize/{class_id}/{lesson_id}/{room_id}', 'coordinatorcontroller@coordinator_show_quize')->name('coordinator_show_quize');
  Route::get('dashboard/coordinator/coordinator_show_exam/{class_id}/{lesson_id}/{room_id}', 'coordinatorcontroller@coordinator_show_exam')->name('coordinator_show_exam');

  Route::get('dashboard/coordinator/coordinator_table_quize/{class_id}/{lesson_id}', 'coordinatorcontroller@coordinator_table_quize')->name('coordinator_table_quize');
  Route::get('dashboard/coordinator/coordinator_table_exam/{class_id}/{lesson_id}', 'coordinatorcontroller@coordinator_table_exam')->name('coordinator_table_exam');
  Route::get('dashboard/coordinator/StudentsRoomLessontotal/{room_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal')->name('StudentsRoomLessontotal1');
  Route::get('dashboard/coordinator/StudentsRoomLessontotal_pdf/{room_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal_pdf')->name('StudentsRoomLessontotal_pdf1');
  Route::get('dashboard/coordinator/StudentsRoomLessontotal_excel/{room_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal_excel')->name('StudentsRoomLessontotal_excel1');


  Route::post('dashboard/coordinator/quize_delete', 'coordinatorcontroller@quize_delete')->name('quize_delete');
  Route::post('dashboard/coordinator/quize_update', 'coordinatorcontroller@quize_update')->name('quize_update');
  Route::get('dashboard/coordinator/coordinator_add_auto/{class_id}/{lesson_id}', 'coordinatorcontroller@coordinator_add_auto')->name('coordinator_add_auto');
  Route::get('dashboard/coordinator/add_questions/{class_id}/{lesson_id}', 'coordinatorcontroller@add_questions')->name('add_questions');
  Route::post('dashboard/coordinator/question_store', 'coordinatorcontroller@question_store')->name('question_store');
  Route::get('dashboard/coordinator/question_edit/{id}/{class_id}/{lesson_id}', 'coordinatorcontroller@question_edit')->name('question_edit');
  Route::post('dashboard/coordinator/questions/question_update/{question_id}', 'coordinatorcontroller@question_update')->name('question_update');
  Route::post('dashboard/coordinator/questions/delete', 'coordinatorcontroller@question_delete')->name('question_delete');


  Route::get('dashboard/coordinator/exams/{class_id}/{lesson_id}', 'coordinatorcontroller@exams')->name('exams');
  Route::post('dashboard/coordinator/exams/exam_store', 'coordinatorcontroller@exam_store')->name('exam_store');

  Route::post('dashboard/coordinator/exams/exam_delete', 'coordinatorcontroller@exam_delete')->name('exam_delete');
  Route::post('dashboard/coordinator/exams/exam_update', 'coordinatorcontroller@exam_update')->name('exam_update');

  Route::post('dashboard/coordinator/exams/myquestions', 'coordinatorcontroller@myquestions')->name('exams_myquestions');
  Route::get('dashboard/coordinator/exams_addquestion/{exam_id}/{room_id}/{class_id}/{lesson_id}', 'coordinatorcontroller@exams_addquestion')->name('exams_addquestion');
  Route::get('dashboard/coordinator/search', 'coordinatorcontroller@search')->name('search');
  Route::get('dashboard/coordinator/search_exam', 'coordinatorcontroller@search_exam')->name('search_exam');

  Route::get('dashboard/coordinator/exam/quest_exam/{id}/{class_id}/{lesson_id}', 'coordinatorcontroller@quest_exam')->name('quest_exam');
  Route::get('dashboard/coordinator/coordinator_tacher_room/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@coordinator_tacher_room')->name('coordinator_tacher_room');
  Route::get('dashboard/coordinator/coordinator_tacher_room_mark/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@coordinator_tacher_room_mark')->name('coordinator_tacher_room_mark');


  Route::get('dashboard/coordinator/coordinator_tacher_room1/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@coordinator_tacher_room1')->name('coordinator_tacher_room1');
  Route::get('dashboard/teacher/coordinator_teacher_quize_mark/{room_id}/{class_id}/{teacher_id}/{lesson_id}/{exam_id}', 'coordinatorcontroller@coordinator_teacher_quize_mark')->name('coordinator_teacher_quize_mark');
  Route::get('dashboard/teacher/coordinator_teacher_exam_mark/{room_id}/{class_id}/{teacher_id}/{lesson_id}/{exam_id}', 'coordinatorcontroller@coordinator_teacher_exam_mark')->name('coordinator_teacher_exam_mark');
  Route::get('dashboard/coordinator/correct_exam1/{exam_id}/{student_id}/{teacher_id}', 'coordinatorcontroller@correct_exam1')->name('correct_exam1');
  Route::get('dashboard/coordinator/coordinator_show_eaxm_room/{class_id}/{lesson_id}/{room_id}/{teacher}', 'coordinatorcontroller@coordinator_show_eaxm_room')->name('coordinator_show_eaxm_room');
  Route::get('dashboard/coordinator/coordinator_show_quize_room/{class_id}/{lesson_id}/{room_id}/{teacher}', 'coordinatorcontroller@coordinator_show_quize_room')->name('coordinator_show_quize_room');
  Route::get('dashboard/coordinator/coordinator_teacher_schedule/{teacher_id}/{class_id}/{lesson_id}', 'coordinatorcontroller@coordinator_teacher_schedule')->name('coordinator_teacher_schedule');

  Route::get('dashboard/coordinator/coordinator_teacher_showunit/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@coordinator_teacher_showunit')->name('coordinator_teacher_showunit');
  Route::get('dashboard/coordinator/searchunitteacher', 'coordinatorcontroller@searchunitteacher')->name('searchunitteacher');

  Route::get('dashboard/coordinator/teacher_planification/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@teacher_planification')->name('teacher_planification');

  Route::get('dashboard/coordinator/coordinator_teacher_plan/{class_id}/{lesson_id}/{teacher_id}', 'coordinatorcontroller@coordinator_teacher_plan')->name('coordinator_teacher_plan');
  Route::get('dashboard/coordinator/detexam', 'coordinatorcontroller@detexam')->name('dashboard.detexam');

  Route::get('dashboard/coordinator/examstudent1/{lec_id}/{home}/{room_id}', 'coordinatorcontroller@examstudent1')->name('dashboard.teacher.examstudent1');
  Route::get('dashboard/coordinator/quizestudent/{lec_id}/{home}/{room_id}', 'coordinatorcontroller@quizestudent')->name('dashboard.teacher.quizestudent');
  Route::get('dashboard/coordinator/StudentsRoomLessontotal/{room_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal')->name('StudentsRoomLessontotal1');
  Route::get('dashboard/coordinator/StudentsRoomLessontotal_pdf/{room_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal_pdf')->name('StudentsRoomLessontotal_pdf1');
  Route::get('dashboard/coordinator/StudentsRoomLessontotal_excel/{room_id}/{teacher_id}/{lesson_id}', 'coordinatorcontroller@StudentsRoomLessontotal_excel')->name('StudentsRoomLessontotal_excel1');
  Route::get('dashboard/coordinator/quest_exam1/{id}/{class_id}/{lesson_id}', 'coordinatorcontroller@quest_exam1')->name('quest_exam1');
});
