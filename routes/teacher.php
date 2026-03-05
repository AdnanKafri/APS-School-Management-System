<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'SMARMANger', 'middleware' => ['roleteacher']], function () {
    // Phase 4: Unified Teacher Gradebook (Parallel Module)
    Route::get('dashboard/teacher/gradebook/{class_id}/{room_id}/{subject_id}', 'Teacher\TeacherGradebookController@index')->name('teacher.gradebook.index');
    Route::post('dashboard/teacher/gradebook/save', 'Teacher\TeacherGradebookController@saveMark')->name('teacher.gradebook.save');

    //new teachers2 routes
 //1
Route::get('teacher', 'TeacherController_New@dashboard_teacher')->name('dashboard.teacher');
//

//2
Route::get('teacher_lessons2/{room_id}/{teacher_id}', 'TeacherController_New@teacher_lessons2')->name('dashboard.teacher_lessons2');
//

//3
Route::get('dashboard/teacher/lessons/lectures/{lesson_id}/{teacher_id}/{room_id}', 'TeacherController_New@lectures')->name('dashboard.lessons.lectures');
//

//4
Route::post('teachers2/teacher_lessons/store', 'TeacherController_New@store_lecture')->name('dashboard.lessons.lecture.store');
Route::post('teachers2/teacher_lessons/update', 'TeacherController_New@update_lecture')->name('dashboard.lessons.lecture.update');
Route::post('dashboard/teacher/dalete_lecture', 'TeacherController_New@dalete_lecture')->name('dashboard.lec.delete');
//
//search lecture
Route::get('teachers2/teacher_lessons/search_lecture', 'TeacherController_New@search_lecture')->name('search_lecture');
Route::get('teachers2/teacher_lessons/search_lecturetime', 'TeacherController_New@search_lecturetime')->name('search_lecturetime');

// Route::get('dashboard/teacher/lecquestion/{lec_id}', 'teacherscontroller@selectlesson')->name('dashboard.teacher.selectlesson');

//5
Route::get('teacher_messages', 'TeacherController_New@teacher_messages')->name('dashboard.teacher_messages');
// 5.1
Route::get('dashboard/teacher/send_message', 'TeacherController_New@send_message')->name('dashboard.send_message');
//5.2
Route::post('dashboard/teacher/send_group_message', 'TeacherController_New@send_group_message')->name('dashboard.send_group_message');
//
//6 teacher event
Route::get('teacher_events', 'TeacherController_New@teacher_event')->name('teacher_events');
Route::post('teacher_events/store', 'TeacherController_New@store_teacher_event')->name('teacher_events.event_store');
Route::post('teacher_events/edit', 'TeacherController_New@update_teacher_event')->name('teacher_events.edit');
//end teacher event

//add_content
Route::get('dashboard/teacher/teacher_rooms2/{class_id}/{teacher_id}/{room_id}/{lecture_id}', 'TeacherController_New@teacher_rooms2')->name('dashboard.teacher_rooms2');
Route::post('dashboard/teacher/classes_lessons/store_items', 'TeacherController_New@store_items')->name('dashboard.store_items');
//show_content
Route::get('dashboard/teacher/lessons/book_details/{lesson_id}/{teacher_id}/{room_id}/{lecture_id}', 'TeacherController_New@book_details')->name('dashboard.student.lessons.book_details');
//Route for book of subject
Route::get('teacher/books/{lesson_id}/{teacher_id}/{room_id}', 'TeacherController_New@books_subject')->name('teacher.books');
//edit video and audio
Route::get('dashboard/teacher/edit_video/{home_id}','TeacherController_New@edit_video')->name('dashboard.edit_video');
Route::get('dashboard/teacher/edit_audio/{home_id}','TeacherController_New@edit_audio')->name('dashboard.edit_audio');
// route for schedual table
Route::get('dashboard/teacher/teacher_schedule', 'TeacherController_New@teacher_schedule')->name('dashboard.teacher_schedule');
//exams_quizes_page
Route::get('teacher/exams_quizes', 'TeacherController_New@exams_quizes_page')->name('teacher.exams_quizes');
//marks_subjects_page
Route::get('teacher_marks_subjects/{room_id}/{teacher_id}', 'TeacherController_New@marks_subjects')->name('teacher.marks.subjects');
//show all messages of students
Route::get('teacher/filter_message', 'TeacherController_New@filter_message')->name('filter_message');
Route::get('teacher/get_message', 'TeacherController_New@get_message')->name('get_message');
Route::get('dashboard/teacher/show_message/{student_id}', 'TeacherController_New@show_message')->name('show_message');
// for prize marks page
Route::get('dashboard/teacher/medal/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@medal')->name('medal');
Route::post('dashboard/medal_store','TeacherController_New@medal_store')->name('medal_store');
Route::post('dashboard/medal_delete','TeacherController_New@medal_delete')->name('medal_delete');

//edit homework page
Route::get('dashboard/teacher/edit_home/{home_id}','TeacherController_New@edit_home')->name('dashboard.edit_home');
//mark homework
Route::get('dashboard/teacher/StudentsRoomLesson_homeworke/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLesson_homeworke')->name('dashboard.StudentsRoomLesson_homeworke');
//عرض وظائف الطلاب
Route::get('dashboard/teacher/StudentsRoomLesson/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'TeacherController_New@StudentsRoomLesson')->name('dashboard.StudentsRoomLesson');
//علامة وظيفة الطالب
Route::post('dashboard/teacher/student_save_mark', 'TeacherController_New@student_save_mark')->name('dashboard.teacher.student_save_mark');
Route::get('dashboard/exam/quest_exam/{id}', 'TeacherController_New@quest_exam')->name('dashboard.quest_exam');
Route::get('dashboard/addition/delete','TeacherController_New@addition_delete')->name('dashboard.addition.delete');
Route::post('dashboard/file1/update/{file_id}','TeacherController_New@file_update')->name('dashboard.file.update');
Route::post('dashboard/video/update/{file_id}','TeacherController_New@video_update')->name('dashboard.video.update');
Route::post('dashboard/audio/update/{file_id}','TeacherController_New@audio_update')->name('dashboard.audio.update');
Route::get('dashboard/exam/correct_exam/{exam_id}/{student_id}', 'TeacherController_New@correct_exam')->name('dashboard.correct_exam');
Route::get('dashboard/exam/correct_exam1/{exam_id}/{student_id}', 'TeacherController_New@correct_exam1')->name('dashboard.correct_exam1');

Route::post('dashboard/teacher/event/store', 'TeacherController_New@event_store')->name('dashboard.event.store');
Route::post('dashboard/teacher/event_delete', 'TeacherController_New@event_delete')->name('dashboard.event.delete');
Route::get('dashboard/teacher/class/rooms/{class_id}/{teacher_id}', 'TeacherController_New@class_rooms')->name('dashboard.class.rooms');
Route::get('dashboard/teacher/homeworkestudent/{lec_id}/{home}/{room_id}', 'TeacherController_New@homeworkestudent')->name('dashboard.teacher.homeworkestudent');
Route::get('dashboard/teacher/download_zip/{room_id}/{exam_id}', 'TeacherController_New@download_zip')->name('dashboard.teacher.download_zip');
//تجميع الملفات بمجلد واحد للمذاكرات
Route::get('dashboard/teacher/quize_zip/{room_id}/{exam_id}', 'TeacherController_New@quize_zip')->name('dashboard.teacher.quize_zip');

Route::get('dashboard/teacher/teacher_quize/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@teacher_quize_mark')->name('teacher_quize');
Route::post('dashboard/teacher/exams/exam_update123','TeacherController_New@exam_update123')->name('dashboard.exam.update123');
Route::get('dashboard/teacher/detexam', 'TeacherController_New@detexam')->name('dashboard.detexam');
Route::get('dashboard/teacher/studentselect/{exam}/{room}', 'TeacherController_New@studentselect')->name('dashboard.teacher.studentselect');
Route::post('dashboard/teacher/quize_student', 'TeacherController_New@quize_student')->name('quize_student');
//اضافة الطلاب للمذاكرة
Route::post('dashboard/teacher/add_quize_student', 'TeacherController_New@add_quize_student')->name('add_quize_student');
//دفتر العلامات
Route::post('classroom/lesson/teacher/student_mark','admincontroller@student_mark')->name('admin.teacher_student_mark');
Route::get('dashboard/teacher/StudentsRoomLessontotal/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLessontotal')->name('dashboard.StudentsRoomLessontotal');
Route::get('dashboard/teacher/StudentsRoomLessontotal_pdf/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLessontotal_pdf')->name('dashboard.StudentsRoomLessontotal_pdf');
Route::get('dashboard/teacher/StudentsRoomLessontotal_excel/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLessontotal_excel')->name('dashboard.StudentsRoomLessontotal_excel');
//نهاية دفتر العلامات
Route::get('dashboard/teacher/search_eaxm', 'TeacherController_New@search_eaxm')->name('search_eaxm');
Route::get('dashboard/teacher/search_test', 'TeacherController_New@search_test')->name('search_test');





//صفحة علامات المذكرات
Route::get('dashboard/teacher/teacher_quize_students/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'TeacherController_New@teacher_quize_students')->name('teacher_quize_students');
// حفظ علامة الطالب للمذاكرة او الامتحان
Route::post('dashboard/teacher/student_save_mark_quize', 'TeacherController_New@student_save_mark_quize')->name('dashboard.teacher.student_save_mark_quize');
//فلترة للمذاكرات المقدم من غيره
Route::get('dashboard/teacher/quizestudent/{lec_id}/{home}/{room_id}', 'TeacherController_New@quizestudent')->name('dashboard.teacher.quizestudent');
//اضافة علامة للمذاكرة بعد الajax
Route::get('dashboard/teacher/student_save_mark3', 'TeacherController_New@student_save_mark3')->name('dashboard.teacher.student_save_mark3');
//عرض صفحة جميع  الامتحانات
Route::get('dashboard/teacher/teacher_exam/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@teacher_exam_mark')->name('teacher_exam');
//اظهار صفحة علامات الطلاب
Route::get('dashboard/teacher/teacher_exam_students/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'TeacherController_New@teacher_exam_students')->name('teacher_exam_students');
//اضافة علامة للوظيفة بعد ال ajax
Route::get('dashboard/teacher/student_save_mark_homework', 'TeacherController_New@student_save_mark_homework')->name('dashboard.teacher.student_save_mark_homework');

//صفحة اضافة محتوى مؤتمت
Route::get('dashboard/teacher/questions/{class_id}/{room_id}/{lecture_id}/{lesson_id}/','TeacherController_New@questions')->name('dashboard.teacher.questions');
Route::post('dashboard/teacher/questions/delete','TeacherController_New@question_delete')->name('dashboard.question.delete');
Route::get('dashboard/teacher/examstudent2/{lec_id}/{home}/{room_id}', 'TeacherController_New@examstudent2')->name('dashboard.teacher.examstudent2');
Route::get('dashboard/teacher/exams/{class_id}/{lecture_id}/{room_id}','TeacherController_New@exams')->name('dashboard.teacher.exams');
Route::get('dashboard/teacher/sections/{class_id}/{room_id}/{lecture_id}/{lesson_id}','TeacherController_New@sections')->name('dashboard.teacher.sections');
Route::get('dashboard/teacher/add_questions/{class_id}/{room_id}/{lecture_id}/{lesson_id}','TeacherController_New@add_questions')->name('dashboard.teacher.add_questions');
//صفحة اضافة سؤال
Route::post('dashboard/teacher/add_questions/store','TeacherController_New@question_store')->name('tofel_exam.question.store');
//تخزين فقرة
Route::post('dashboard/teacher/sections/store','TeacherController_New@section_store')->name('dashboard.section.store');
Route::post('dashboard/teacher/sections/update','TeacherController_New@section_update')->name('dashboard.section.update');
//حذف امتحان
Route::post('dashboard/teacher/exams/exam_delete', 'TeacherController_New@exam_delete')->name('dashboard.exam.delete');
//اضافة اختبار
Route::post('dashboard/teacher/exams/exam_store', 'TeacherController_New@exam_store')->name('dashboard.exam.store');
//تعديل اختبار
Route::post('dashboard/teacher/exams/exam_update','TeacherController_New@exam_update')->name('dashboard.exam.update');
Route::get('dashboard/teacher/exams_addquestion/{exam_id}/{lecture_id}/{room_id}', 'TeacherController_New@exams_addquestion')->name('dashboard.exams_addquestion');
Route::get('dashboard/teacher/questions/edit/{question_id}/{room_id}','TeacherController_New@question_edit')->name('dashboard.question.edit');
Route::post('dashboard/teacher/questions/update/{question_id}','TeacherController_New@question_update')->name('dashboard.question.update');
Route::get('dashboard/teacher/file_answers/{file_id}/{lesson_id}/{teacher_id}/{room_id}', 'TeacherController_New@file_answers')->name('dashboard.teacher.file_answers');
//صفحة بنك الاسئلة

Route::post('dashboard/teacher/exams/myquestions', 'TeacherController_New@myquestions')->name('dashboard.exams.myquestions');
Route::post('dashboard/teacher/exams/myquestions1', 'TeacherController_New@myquestions1')->name('dashboard.exams.myquestions1');
Route::get('dashboard/teacher/search', 'TeacherController_New@search')->name('dashboard.teacher.search');
Route::get('dashboard/teacher/searchlect','TeacherController_New@searchlect')->name('dashboard.searchlect');
Route::get('dashboard/exam/quest_exam1/{id}/{class_id}/{lesson_id}', 'TeacherController_New@quest_exam1')->name('dashboard.quest_exam1');
Route::get('dashboard/teacher/StudentsRoomLesson_exammark/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'TeacherController_New@StudentsRoomLesson_exammark')->name('dashboard.StudentsRoomLesson_exammark');
Route::get('dashboard/teacher/exams1_addquestion/{exam_id}/{room_id}/{class_id}/{lesson_id}', 'TeacherController_New@exams1_addquestion')->name('exams1_addquestion');
Route::get('dashboard/teacher/StudentsRoomLesson_exam/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLesson_exam')->name('dashboard.StudentsRoomLesson_exam');
Route::get('dashboard/teacher/export_exam/{exam_id}/{room_id}/{lesson_id}', 'TeacherController_New@export_exam')->name('export_exam');
Route::get('dashboard/teacher/export_exam1/{exam_id}/{room_id}/{lesson_id}', 'TeacherController_New@export_exam1')->name('export_exam1');
Route::get('dashboard/teacher/teacher_quize_mark/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'TeacherController_New@teacher_quize_mark')->name('teacher_quize_mark');
Route::get('dashboard/teacher/StudentsRoomLesson_quize/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLesson_quize')->name('dashboard.StudentsRoomLesson_quize');
Route::get('dashboard/teacher/StudentsRoomLesson_quize1/{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@StudentsRoomLesson_quize1')->name('dashboard.StudentsRoomLesson_quize1');
Route::get('dashboard/teacher/student_save_mark3', 'TeacherController_New@student_save_mark3')->name('dashboard.teacher.student_save_mark3');
Route::post('dashboard/teacher/student_save_mark2', 'TeacherController_New@student_save_mark2')->name('dashboard.teacher.student_save_mark2');
Route::get('dashboard/teacher/student_save_mark1', 'TeacherController_New@student_save_mark1')->name('dashboard.teacher.student_save_mark1');
Route::post('dashboard/exam/update_result1', 'TeacherController_New@update_result1')->name('dashboard.update_result1');
Route::get('dashboard/teacher/lecquestion/{lec_id}/{exam}', 'TeacherController_New@lecquestion')->name('dashboard.teacher.lecquestion');
Route::get('dashboard/teacher/lecquestion1/{lec_id}/{exam}', 'TeacherController_New@lecquestion1')->name('dashboard.teacher.lecquestion1');
Route::get('dashboard/teacher/examstudent/{lec_id}/{home}', 'TeacherController_New@examstudent')->name('dashboard.teacher.examstudent');
Route::post('dashboard/exam/update_result', 'TeacherController_New@update_result')->name('dashboard.update_result');
// صفحة صفوف دفتر العلامات

Route::get('dashboard/teacher/mark_class', 'TeacherController_New@mark_class')->name('teacher.mark_class');
Route::get('dashboard/teacher/mark_room/{room_id}/{teacher_id}', 'TeacherController_New@mark_room')->name('teacher.mark_room');

//  المكافات والعقوبات
Route::get('dashboard/teacher/teacher_rewads_and_sanction_class', 'TeacherController_New@teacher_rewads_and_sanction_class')->name('teacher.teacher_rewads_and_sanction_class');
Route::get('dashboard/teacher/teacher_rewads_and_sanction_subject{room_id}/{teacher_id}', 'TeacherController_New@teacher_rewads_and_sanction_subject')->name('teacher_rewads_and_sanction_subject');
Route::get('dashboard/teacher/teacher_rewads_students{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@teacher_rewads_students')->name('teacher_rewads_students');
Route::post('dashboard/exam/teacher_rewads_students_store', 'TeacherController_New@teacher_rewads_students_store')->name('teacher_rewads_students_store');
Route::post('dashboard/teacher_rewads_students_delete', 'TeacherController_New@teacher_rewads_students_delete')->name('teacher_rewads_students_delete');
Route::get('dashboard/teacher/teacher_sanction_students{room_id}/{teacher_id}/{lesson_id}', 'TeacherController_New@teacher_sanction_students')->name('teacher_sanction_students');

// Route::get('teacher/get_objection/{number}', 'teacherscontroller@get_objection')->name('get_objection');
// Route::get('teacher/filtersolve/{lec}', 'teacherscontroller@filtersolve')->name('filtersolve');
// Route::get('teacher/solve/{id}', 'teacherscontroller@solve')->name('solve');
// Route::get('teacher/teacher_objection_term/', 'teacherscontroller@teacher_objection_term')->name('teacher_objection_term');
// Route::get('dashboard/teacher/file_answers/{file_id}/{lesson_id}/{teacher_id}/{room_id}', 'teacherscontroller@file_answers')->name('dashboard.teacher.file_answers');


// Route::get('dashboard/teacher/edit_quize/{home_id}','teacherscontroller@edit_quize')->name('dashboard.edit_quize');
// Route::get('dashboard/teacher/key', 'teacherscontroller@key')->name('dashboard.key');
// Route::get('dashboard/teacher/unit_analysis1/{class_id}/{lesson_id}/{room_id}','teacherscontroller@unit_analysis1')->name('dashboard.unit_analysis1');
// Route::get('dashboard/teacher/unit_analysis/{class_id}/{lesson_id}/{room_id}','teacherscontroller@unit_analysis')->name('dashboard.unit_analysis');
// Route::post('dashboard/teacher/addunit','teacherscontroller@addunit')->name('dashboard.addunit');
// Route::get('dashboard/teacher/show_unit/{class_id}/{lesson_id}/{room_id}','teacherscontroller@show_unit')->name('dashboard.show_unit');
// Route::get('dashboard/teacher/searchunit','teacherscontroller@searchunit')->name('dashboard.searchunit');
// Route::get('dashboard/teacher/searchunit1','teacherscontroller@searchunit1')->name('dashboard.searchunit1');

// Route::get('dashboard/teacher/searchlect','teacherscontroller@searchlect')->name('dashboard.searchlect');
// Route::post('dashboard/teacher/updateunit','teacherscontroller@updateunit')->name('dashboard.updateunit');
// // Route::get('dashboard/teacher/profile', 'teacherscontroller@profile')->name('dashboard.teacher.profile');

// Route::put('dashboard/teacher/update_password/{teacher_id}', 'teacherscontroller@update_password')->name('dashboard.teacher.update_password');


// Route::get('dashboard/teacher/classes_lessons/{teacher_id}', 'teacherscontroller@classes_lessons')->name('dashboard.classes_lessons');

Route::get('dashboard/teacher/class/lessons/{class_id}', 'studentscontroller@class_lessons')->name('dashboard.class.lessons');




// Route::get('dashboard/teacher/classes/{teacher_id}', 'teacherscontroller@teacher_classes')->name('dashboard.teacher_classes');
// Route::post('dashboard/teacher/room_lessons', 'teacherscontroller@room_lessons')->name('dashboard.room_lessons');
// Route::post('dashboard/teacher/event_delete', 'teacherscontroller@event_delete')->name('dashboard.event.delete');

// Route::get('dashboard/teacher/classes_lessons2/{teacher_id}', 'markstatuscontroller@classes_lessons2')->name('dashboard.classes_lessons2');
// Route::get('dashboard/teacher/teacher_rooms3/{class_id}/{teacher_id}', 'markstatuscontroller@teacher_rooms3')->name('dashboard.teacher_rooms3');
// Route::get('dashboard/teacher/teacher_lessons4/{room_id}/{teacher_id}', 'markstatuscontroller@teacher_lessons4')->name('dashboard.teacher_lessons4');


// Route::get('dashboard/teacher/marks_status/{room_id}/{lesson_id}','teacherscontroller@marks_status')->name('dashboard.marks_status');



// Route::get('dashboard/teacher/quize_active/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@quize_active')->name('dashboard.quize_active');
// Route::get('dashboard/teacher/quize_disable/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@quize_disable')->name('dashboard.quize_disable');


// Route::get('dashboard/teacher/oral_active/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@oral_active')->name('dashboard.oral_active');
// Route::get('dashboard/teacher/oral_disable/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@oral_disable')->name('dashboard.oral_disable');


// Route::get('dashboard/teacher/activity_active/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@activity_active')->name('dashboard.activity_active');
// Route::get('dashboard/teacher/activity_disable/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@activity_disable')->name('dashboard.activity_disable');

// //schedule
// Route::get('dashboard/teacher/homework_active/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@homework_active')->name('dashboard.homework_active');
// Route::get('dashboard/teacher/homework_disable/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@homework_disable')->name('dashboard.homework_disable');

// //

// Route::get('dashboard/teacher/planification_trimestrielle/{class_id}/{lesson_id}/{room_id}','teacherscontroller@planification_trimestrielle')->name('dashboard.planification_trimestrielle');
// Route::get('dashboard/teacher/teacher_planification1/{class_id}/{lesson_id}/{room_id}','teacherscontroller@teacher_planification1')->name('teacher_planification1');

// Route::post('dashboard/teacher/addplanification','teacherscontroller@addplanification')->name('dashboard.addplanification');
// Route::get('dashboard/teacher/planification_trimestrielle1/{class_id}/{lesson_id}/{room_id}','teacherscontroller@planification_trimestrielle1')->name('dashboard.planification_trimestrielle1');

// Route::get('dashboard/teacher/acadsupervisore_planification1/{class_id}/{lesson_id}/{room_id}','teacherscontroller@acadsupervisore_planification1')->name('acadsupervisore_planification1');
// Route::post('dashboard/addprepare', 'teacherscontroller@addprepare')->name('dashboard.addprepare');
// Route::post('dashboard/exam/update_result', 'teacherscontroller@update_result')->name('dashboard.update_result');
// Route::post('dashboard/exam/update_result1', 'teacherscontroller@update_result1')->name('dashboard.update_result1');
// Route::get('dashboard/teacher/exam_active/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@exam_active')->name('dashboard.exam_active');
// Route::get('dashboard/teacher/exam_disable/{teacher_id}/{room_id}/{lesson_id}','markstatuscontroller@exam_disable')->name('dashboard.exam_disable');
// //schedule
// //Route::get('dashboard/teacher/teacher_schedule', 'teacherscontroller@teacher_schedule')->name('dashboard.teacher_schedule');
// //
// Route::get('dashboard/teacher/chat', 'teacherscontroller@chat')->name('dashboard.chat');
// Route::get('dashboard/teacher/google_meets/{teacher_id}/{room_id}/{lesson_id}',   'teacherscontroller@google_meets')->name('teacher.google_meets');
// Route::post('dashboard/teacher/google_meet_update','teacherscontroller@google_meet_update')->name('teacher.google_meet_update');
// Route::post('dashboard/teacher/google_meet_delete','teacherscontroller@google_meet_delete')->name('teacher.google_meet_delete');



// Route::get('dashboard/teacher/prepare/{class_id}/{lesson_id}/{room_id}', 'teacherscontroller@prepare')->name('dashboard.prepare');
// Route::get('dashboard/teacher/teacher_rooms/{class_id}/{teacher_id}', 'teacherscontroller@teacher_rooms')->name('dashboard.teacher_rooms');
// Route::get('dashboard/teacher/teacher_lessons/{room_id}/{teacher_id}', 'teacherscontroller@teacher_lessons')->name('dashboard.teacher_lessons');

// Route::get('dashboard/teacher/teacher_quize_mark/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'teacherscontroller@teacher_quize_mark')->name('teacher_quize_mark');
// // Route::get('dashboard/teacher/StudentsRoomLesson_exammark1/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'teacherscontroller@StudentsRoomLesson_exammark1')->name('dashboard.StudentsRoomLesson_exammark1');
// Route::get('dashboard/teacher/StudentsRoomLesson_exammark/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'teacherscontroller@StudentsRoomLesson_exammark')->name('dashboard.StudentsRoomLesson_exammark');

// Route::get('dashboard/teacher/StudentsRoomLesson_quize/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@StudentsRoomLesson_quize')->name('dashboard.StudentsRoomLesson_quize');
// Route::get('dashboard/teacher/StudentsRoomLesson_quize1/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@StudentsRoomLesson_quize1')->name('dashboard.StudentsRoomLesson_quize1');

// Route::get('dashboard/teacher/certificate/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@certificate')->name('certificate');
// Route::get('dashboard/teacher/StudentsRoomLesson_exam/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@StudentsRoomLesson_exam')->name('dashboard.StudentsRoomLesson_exam');
// Route::get('dashboard/teacher/StudentsRoomLessontotal/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@StudentsRoomLessontotal')->name('dashboard.StudentsRoomLessontotal');
// Route::get('dashboard/teacher/StudentsRoomLessontotal_pdf/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@StudentsRoomLessontotal_pdf')->name('dashboard.StudentsRoomLessontotal_pdf');

// Route::get('dashboard/teacher/StudentsRoomLessontotal_excel/{room_id}/{teacher_id}/{lesson_id}', 'teacherscontroller@StudentsRoomLessontotal_excel')->name('dashboard.StudentsRoomLessontotal_excel');
// Route::get('dashboard/teacher/teacher_addexamorquize/{class_id}/{teacher_id}', 'teacherscontroller@teacher_addexamorquize')->name('dashboard.teacher_addexamorquize');
// Route::get('dashboard/teacher/detexam', 'teacherscontroller@detexam')->name('dashboard.detexam');


// Route::post('dashboard/certificate_store','teacherscontroller@certificate_store')->name('certificate_store');
// Route::post('dashboard/certificate_delete','teacherscontroller@certificate_delete')->name('certificate_delete');


//     Route::get('dashboard/file/edit/{file_id}','teacherscontroller@file_edit')->name('dashboard.file.edit');
//     Route::get('dashboard/file/edit/{file_id}','teacherscontroller@edit_exam1')->name('dashboard.exam.edit');

//     Route::post('dashboard/audio/update/{file_id}','teacherscontroller@audio_update')->name('dashboard.audio.update');
//     Route::post('dashboard/video/update/{file_id}','teacherscontroller@video_update')->name('dashboard.video.update');

//     Route::post('dashboard/file/update/{file_id}','teacherscontroller@quize_update')->name('dashboard.quize.update');
//     Route::post('dashboard/teacher/exams/exam_update11/{file_id}','teacherscontroller@exam_update11')->name('dashboard.exam1.update');
//
//      Route::get('dashboard/exam/quest_exam1/{id}/{class_id}/{lesson_id}', 'teacherscontroller@quest_exam1')->name('dashboard.quest_exam1');

//     Route::post('dashboard/teacher/exams/exam_update','teacherscontroller@exam_update')->name('dashboard.exam.update');
//        Route::post('dashboard/teacher/exams/exam_update123','teacherscontroller@exam_update123')->name('dashboard.exam.update123');
// Route::get('dashboard/teacher/search', 'teacherscontroller@search')->name('dashboard.teacher.search');
//  Route::get('pdfdownload/{id}','teacherscontroller@pdfdownload')->name('pdfdownload');
//     Route::get('multipdfdownload/{id}','teacherscontroller@multipdfdownload')->name('multipdfdownload');
// Route::get('dashboard/teacher/examstudent2/{lec_id}/{home}/{room_id}', 'teacherscontroller@examstudent2')->name('dashboard.teacher.examstudent2');
// Route::get('dashboard/teacher/studentselect/{exam}/{room}', 'teacherscontroller@studentselect')->name('dashboard.teacher.studentselect');
// Route::get('dashboard/teacher/examstudent/{lec_id}/{home}', 'teacherscontroller@examstudent')->name('dashboard.teacher.examstudent');

// Route::get('dashboard/teacher/homeworkestudent/{lec_id}/{home}', 'teacherscontroller@homeworkestudent')->name('dashboard.teacher.homeworkestudent');
// Route::get('dashboard/teacher/quizestudent/{lec_id}/{home}/{room_id}', 'teacherscontroller@quizestudent')->name('dashboard.teacher.quizestudent');
// Route::get('dashboard/teacher/export_exam/{exam_id}/{room_id}/{lesson_id}', 'teacherscontroller@export_exam')->name('export_exam');
// Route::get('dashboard/teacher/export_exam1/{exam_id}/{room_id}/{lesson_id}', 'teacherscontroller@export_exam1')->name('export_exam1');




// Route::get('dashboard/teacher/lecquestion/{lec_id}/{exam}', 'teacherscontroller@lecquestion')->name('dashboard.teacher.lecquestion');
// Route::get('dashboard/teacher/lecquestion1/{lec_id}/{exam}', 'teacherscontroller@lecquestion1')->name('dashboard.teacher.lecquestion1');
// Route::get('dashboard/teacher/students/{teacher_id}', 'teacherscontroller@students')->name('dashboard.teacher.students');
// Route::get('dashboard/teacher/class/rooms/{class_id}/{teacher_id}', 'teacherscontroller@class_rooms')->name('dashboard.class.rooms');
// Route::get('dashboard/teacher/room/students/{room_id}', 'teacherscontroller@room_students')->name('dashboard.room.students');
// Route::post('dashboard/teacher/exams/myquestions', 'teacherscontroller@myquestions')->name('dashboard.exams.myquestions');
// Route::post('dashboard/teacher/exams/myquestions1', 'teacherscontroller@myquestions1')->name('dashboard.exams.myquestions1');

// Route::get('dashboard/teacher/exams_addquestion/{exam_id}/{lecture_id}/{room_id}', 'teacherscontroller@exams_addquestion')->name('dashboard.exams_addquestion');
// Route::get('dashboard/teacher/exams1_addquestion/{exam_id}/{room_id}/{class_id}/{lesson_id}', 'teacherscontroller@exams1_addquestion')->name('exams1_addquestion');
// Route::get('dashboard/teacher/write_message/{student_id}', 'teacherscontroller@write_message')->name('dashboard.write_message');

// Route::get('dashboard/teacher/class/rooms/lessons/{room_id}/{teacher_id}', 'teacherscontroller@lessons')->name('dashboard.class.rooms.lessons');
// Route::post('dashboard/teacher/exams/exam_delete','teacherscontroller@exam_delete')->name('dashboard.exam.delete');
// Route::get('dashboard/teacher/write_group_message/{room_id}', 'teacherscontroller@write_group_message')->name('dashboard.write_group_message');


// Route::post('dashboard/teacher/exams/exam_store','teacherscontroller@exam_store')->name('dashboard.exam.store');
// Route::get('dashboard/teacher/exams/{class_id}/{lecture_id}/{room_id}','teacherscontroller@exams')->name('dashboard.teacher.exams');
// Route::post('dashboard/teacher/sections/store','teacherscontroller@section_store')->name('dashboard.section.store');
// Route::get('dashboard/teacher/messages/{student_id}', 'teacherscontroller@messages')->name('dashboard.teacher.messages');
// Route::get('dashboard/teacher/sections/{class_id}/{room_id}/{lecture_id}/{lesson_id}','teacherscontroller@sections')->name('dashboard.teacher.sections');
// Route::post('dashboard/teacher/questions/update/{question_id}','teacherscontroller@question_update')->name('dashboard.question.update');


// Route::post('dashboard/teacher/questions/delete','teacherscontroller@question_delete')->name('dashboard.question.delete');
// Route::get('dashboard/teacher/show_supervisor_items', 'teacherscontroller@show_supervisor_items')->name('dashboard.teacher.show_supervisor_items');
// Route::get('dashboard/teacher/questions/{class_id}/{room_id}/{lecture_id}/{lesson_id}/','teacherscontroller@questions')->name('dashboard.teacher.questions');
// Route::get('dashboard/teacher/add_questions/{class_id}/{room_id}/{lecture_id}/{lesson_id}','teacherscontroller@add_questions')->name('dashboard.teacher.add_questions');
// Route::post('/tofel_exam/questions/store','teacherscontroller@question_store')->name('tofel_exam.question.store');

// Route::get('dashboard/teacher/events', 'teacherscontroller@events')->name('dashboard.events');




// Route::get('dashboard/teacher/questions/edit/{question_id}/{room_id}','teacherscontroller@question_edit')->name('dashboard.question.edit');
// Route::get('dashboard/teacher/add_event', 'teacherscontroller@add_event')->name('dashboard.add_event');

// Route::get('dashboard/teacher/event/edit/{event_id}', 'teacherscontroller@event_edit')->name('dashboard.event.edit');

// Route::post('dashboard/teacher/event/update', 'teacherscontroller@event_update')->name('dashboard.event.update');
// Route::post('dashboard/teacher/questions/update/{question_id}','teacherscontroller@question_update')->name('dashboard.question.update');
// Route::post('dashboard/teacher/sections/update','teacherscontroller@section_update')->name('dashboard.section.update');
// Route::post('dashboard/teacher/delete_event', 'teacherscontroller@delete_event')->name('dashboard.teacher.delete_event');

// Route::get('dashboard/teacher/student_save_mark3', 'teacherscontroller@student_save_mark3')->name('dashboard.teacher.student_save_mark3');
// Route::post('dashboard/teacher/student_save_mark2', 'teacherscontroller@student_save_mark2')->name('dashboard.teacher.student_save_mark2');
// Route::get('dashboard/teacher/student_save_mark1', 'teacherscontroller@student_save_mark1')->name('dashboard.teacher.student_save_mark1');


// Route::get('dashboard/classes/teacher_lessons3/{class_id}','teacherscontroller@teacher_lessons3')->name('dashboard.teacher_lessons3');
// Route::post('dashboard/teacher/quize_student', 'teacherscontroller@quize_student')->name('quize_student');
// Route::get('dashboard/classes/rooms3/{class_id}','teacherscontroller@rooms3')->name('rooms3');



////// تعديلاتي
Route::get('dashboard/teacher/profile', 'TeacherController_New@profile')->name('dashboard.teacher.profile');
Route::put('dashboard/teacher/update_profile1/{teacher_id}', 'TeacherController_New@update_profile1')->name('dashboard.teacher.update_profile');
//route for live class
Route::get('dashboard/teacher/room/go_to_stream/{scheduler_id}/{day_id}/{lecture_time_id}/{room_id}/{teacher_id}', 'TeacherController_New@go_to_stream')->name('dashboard.teacher.room.go_to_stream');
Route::get('dashboard/teacher/StudentsRoomLesson_exammark1/{room_id}/{teacher_id}/{lesson_id}/{exam_id}', 'TeacherController_New@StudentsRoomLesson_exammark1')->name('dashboard.StudentsRoomLesson_exammark1');



});
