<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* 
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//api  المدرسة السورية القديم 

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('fetchPolicyContent','Api\websitecontroller@fetchPolicyContent');


//         Route::post('/changemessage','DashboardController@changemessage')->name('changemessage');


//     Route::post('get_login_teacher_info','Api\websitecontroller@get_login_teacher_info');

//     Route::get('teacher_classes/{teacher_id}','Api\websitecontroller@teacher_classes');
//     Route::get('teacher_rooms/{class_id}/{teacher_id}','Api\websitecontroller@teacher_rooms');
//     Route::get('teacher_subjects/{room_id}/{teacher_id}','Api\websitecontroller@teacher_subjects');
//     Route::get('teacher_lessons/{subject_id}/{room_id}/{teacher_id}','Api\websitecontroller@teacher_lessons');
//     Route::get('teacher_book_details/{subject_id}/{teacher_id}/{room_id}/{lesson_id}/{type_id}', 'Api\websitecontroller@teacher_book_details');
//     Route::get('get_teacher_lesson_details/{room_id}/{teacher_id}/{subject_id}/{lesson_id}/{type_id}', 'Api\websitecontroller@get_teacher_lesson_details');
//     Route::get('teacher_schedule/{teacher_id}', 'Api\websitecontroller@teacher_schedule');
//     Route::get('teacher_event/{teacher_id}', 'Api\websitecontroller@teacher_event');
//     Route::get('get_message/{teacher_id}', 'Api\websitecontroller@get_message');
//     Route::get('view_message/{teacher_id}/{student_id}', 'Api\websitecontroller@view_message');
     
//     Route::get('get_message_count/{teacher_id}', 'Api\websitecontroller@get_message_count');
     
//     Route::get('get_message_student/{teacher_id}/{student_id}', 'Api\websitecontroller@get_message_student');
    
//     Route::get('get_room_student/{room_id}', 'Api\websitecontroller@get_room_student');
//     Route::post('teacher/store/lecture', 'Api\websitecontroller@store_lecture');
//     Route::post('teacher/store/items', 'Api\websitecontroller@store_items');

//     Route::post('addprepare', 'Api\websitecontroller@addprepare');
//       Route::get('prepare/{teacher_id}/{class_id}/{lesson_id}/{room_id}', 'Api\websitecontroller@prepare');
//        Route::get('Meansprepare/{lesson_id}', 'Api\websitecontroller@Meansprepare');
    



// // ------------------------


//     Route::post('get_login_student_info','Api\websitecontroller@get_login_student_info');
//     Route::get('get_student_subjects/{room_id}/{student_id}','Api\websitecontroller@get_student_subjects');
//     Route::get('get_student_lessons/{subject_id}/{room_id}/{student_id}','Api\websitecontroller@get_student_lessons');
        
 
//     Route::get('get_student_lesson_details/{room_id}/{subject_id}/{student_id}/{lesson_id}/{type_id}', 'Api\websitecontroller@get_student_lesson_details');
//     Route::post('dashboard/student/upload_files','Api\websitecontroller@upload_files');
//     Route::post('dashboard/teacher/send_group_message','Api\websitecontroller@send_group_message');
//     Route::post('dashboard/teacher/send_message','Api\websitecontroller@send_message');

//     Route::get('get_student_quest_exam/{exam_id}/{student_id}', 'Api\websitecontroller@get_student_quest_exam');
//     Route::get('dashboard/student/exam_test/start/{exam_id}/{student_id}','Api\websitecontroller@start_exam_test');
//     Route::post('dashboard/student/exam_test/submit','Api\websitecontroller@save_exam');
//     // exams and quizes
//     Route::get('dashboard/student/main_exam/{room_id}/{student_id}','Api\websitecontroller@student_main_exams');
//     Route::get('dashboard/student/main_quize/{room_id}/{student_id}','Api\websitecontroller@student_main_quizes');
//     // مؤتمت
//     Route::get('dashboard/student/main_exam/start/{exam_id}/{student_id}','Api\websitecontroller@start_main_exam');
//     // رفع ملف
//     Route::post('dashboard/student/upload_exam_files','Api\websitecontroller@upload_exam_files');
//     Route::post('dashboard/student/upload_exam_files2','Api\websitecontroller@upload_exam_files2');
//     // تخزين المؤتمت 
//     Route::post('dashboard/student/main_exam/submit','Api\websitecontroller@save_main_exam');
//     // استعراض الاختبار
//     Route::get('dashboard/student/exam/view_test/{exam_id}/{student_id}','Api\websitecontroller@view_test_exam');
//     Route::get('dashboard/student/exam/view_quize/{exam_id}/{student_id}','Api\websitecontroller@view_quize_exam');

//     Route::get('dashboard/student/schedule/{room_id}/{student_id}/{time_zone_offset}','Api\websitecontroller@student_schedule');
    
//     Route::get('dashboard/student/messages/{student_id}','Api\websitecontroller@messages');
//     Route::get('dashboard/student/messages_count/{student_id}','Api\websitecontroller@all_messages_count');
//     Route::get('dashboard/student/messages/get_teacher_message/{student_id}/{teacher_id}/{user_type}','Api\websitecontroller@get_teacher_message');
//     Route::post('dashboard/student/messages/store_message','Api\websitecontroller@store_student_message');
//     Route::post('dashboard/teacher/key','Api\websitecontroller@key');


//     Route::get('dashboard/student/events/{student_id}', 'Api\websitecontroller@student_events');

//     Route::get('dashboard/student/medals/{student_id}', 'Api\websitecontroller@student_medals');
//     // الجلاءات
//     Route::get('dashboard/student/graduate/{student_id}/{room_id}', 'Api\websitecontroller@student_graduate');
//       Route::get('dashboard/student/get_certificate/{student_id}', 'Api\websitecontroller@get_certificate');




//     Route::get('app_student_sliders','Api\websitecontroller@app_student_sliders');
//     Route::get('app_teacher_sliders','Api\websitecontroller@app_teacher_sliders');
//     Route::get('admin/get_admin_message/{teacher_id}','Api\websitecontroller@get_admin_messages');
//     Route::get('admin/admin_messages/count/{teacher_id}','Api\websitecontroller@get_admin_messages_count');
//     Route::post('admin/store_admin_message','Api\websitecontroller@store_admin_message');

    
    

// Route::post('/test1' ,'studentscontroller@add_payment_receipts' );






/* 
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetchPolicyContent','Api\websitecontroller@fetchPolicyContent');


        Route::post('/changemessage','DashboardController@changemessage')->name('changemessage');


    Route::post('get_login_teacher_info','Api\websitecontroller@get_login_teacher_info');

    Route::get('teacher_classes/{teacher_id}','Api\websitecontroller@teacher_classes');
    Route::get('teacher_rooms/{class_id}/{teacher_id}','Api\websitecontroller@teacher_rooms');
    Route::get('teacher_subjects/{room_id}/{teacher_id}','Api\websitecontroller@teacher_subjects');
    Route::get('teacher_lessons/{subject_id}/{room_id}/{teacher_id}','Api\websitecontroller@teacher_lessons');
    Route::get('teacher_book_details/{subject_id}/{teacher_id}/{room_id}/{lesson_id}/{type_id}', 'Api\websitecontroller@teacher_book_details');
    Route::get('get_teacher_lesson_details/{room_id}/{teacher_id}/{subject_id}/{lesson_id}/{type_id}', 'Api\websitecontroller@get_teacher_lesson_details');
    Route::get('teacher_schedule/{teacher_id}', 'Api\websitecontroller@teacher_schedule');
    Route::get('teacher_event/{teacher_id}', 'Api\websitecontroller@teacher_event');
    Route::get('get_message/{teacher_id}', 'Api\websitecontroller@get_message');
    Route::get('view_message/{teacher_id}/{student_id}', 'Api\websitecontroller@view_message');
     
    Route::get('get_message_count/{teacher_id}', 'Api\websitecontroller@get_message_count');
     
    Route::get('get_message_student/{teacher_id}/{student_id}', 'Api\websitecontroller@get_message_student');
    
    Route::get('get_room_student/{room_id}', 'Api\websitecontroller@get_room_student');
    Route::post('teacher/store/lecture', 'Api\websitecontroller@store_lecture');
    Route::post('teacher/store/items', 'Api\websitecontroller@store_items');
    Route::post('teacher/dalete_lecture','Api\websitecontroller@dalete_lecture');

    Route::post('addprepare', 'Api\websitecontroller@addprepare');
      Route::get('prepare/{teacher_id}/{class_id}/{lesson_id}/{room_id}', 'Api\websitecontroller@prepare');
       Route::get('Meansprepare/{lesson_id}', 'Api\websitecontroller@Meansprepare');
    



// ------------------------

//api مدرسة قيم الجديد


    Route::post('get_login_student_info','Api\websitecontroller@get_login_student_info');
    Route::get('get_student_subjects/{room_id}/{student_id}','Api\websitecontroller@get_student_subjects');
    Route::get('get_student_lessons/{subject_id}/{room_id}/{student_id}','Api\websitecontroller@get_student_lessons');
        
 
    Route::get('get_student_lesson_details/{room_id}/{subject_id}/{student_id}/{lesson_id}/{type_id}', 'Api\websitecontroller@get_student_lesson_details');
    Route::post('dashboard/student/upload_files','Api\websitecontroller@upload_files');
    Route::post('dashboard/teacher/send_group_message','Api\websitecontroller@send_group_message');
    Route::post('dashboard/teacher/send_message','Api\websitecontroller@send_message');

    Route::get('get_student_quest_exam/{exam_id}/{student_id}', 'Api\websitecontroller@get_student_quest_exam');
        Route::get('dashboard/student/exam_test/start/{exam_id}/{student_id}','Api\websitecontroller@start_exam_test');

    Route::get('dashboard/student/exam_test/start/{exam_id}/{student_id}','Api\websitecontroller@start_exam_test');
    Route::post('dashboard/student/exam_test/submit','Api\websitecontroller@save_exam');
    // exams and quizes
    Route::get('dashboard/student/main_exam/{room_id}/{student_id}','Api\websitecontroller@student_main_exams');
    Route::get('dashboard/student/main_quize/{room_id}/{student_id}','Api\websitecontroller@student_main_quizes');
    // مؤتمت
    Route::get('dashboard/student/main_exam/start/{exam_id}/{student_id}','Api\websitecontroller@start_main_exam');
    // رفع ملف
    Route::post('dashboard/student/upload_exam_files','Api\websitecontroller@upload_exam_files');
    Route::post('dashboard/student/upload_exam_files2','Api\websitecontroller@upload_exam_files2');
    // تخزين المؤتمت 
    Route::post('dashboard/student/main_exam/submit','Api\websitecontroller@save_main_exam');
    // استعراض الاختبار
    Route::get('dashboard/student/exam/view_test/{exam_id}/{student_id}','Api\websitecontroller@view_test_exam');
    Route::get('dashboard/student/exam/view_quize/{exam_id}/{student_id}','Api\websitecontroller@view_quize_exam');

    Route::get('dashboard/student/schedule/{room_id}/{student_id}/{time_zone_offset}','Api\websitecontroller@student_schedule');
    
    Route::get('dashboard/student/messages/{student_id}','Api\websitecontroller@messages');
    Route::get('dashboard/student/messages_count/{student_id}','Api\websitecontroller@all_messages_count');
    Route::get('dashboard/student/messages/get_teacher_message/{student_id}/{teacher_id}/{user_type}','Api\websitecontroller@get_teacher_message');
    Route::post('dashboard/student/messages/store_message','Api\websitecontroller@store_student_message');
    Route::post('dashboard/teacher/key','Api\websitecontroller@key');


    Route::get('dashboard/student/events/{student_id}', 'Api\websitecontroller@student_events');

    Route::get('dashboard/student/medals/{student_id}', 'Api\websitecontroller@student_medals');
    // الجلاءات
    Route::get('dashboard/student/graduate/{student_id}/{room_id}', 'Api\websitecontroller@student_graduate');
    Route::get('dashboard/student/get_certificate/{student_id}', 'Api\websitecontroller@get_certificate');
  
 
 

    Route::get('app_student_sliders','Api\websitecontroller@app_student_sliders');
    Route::get('app_teacher_sliders','Api\websitecontroller@app_teacher_sliders');
    Route::get('admin/get_admin_message/{teacher_id}','Api\websitecontroller@get_admin_messages');
    Route::get('admin/admin_messages/count/{teacher_id}','Api\websitecontroller@get_admin_messages_count');
    Route::post('admin/store_admin_message','Api\websitecontroller@store_admin_message');

    
    Route::get('app_version_num','Api\websitecontroller@app_version_num');




    Route::get('app_parent_children/{parent_id}','Api\websitecontroller@app_parent_children');
    
    
    Route::get('homeworke/{student_id}/{lesson_id}/{parent_id}','Api\websitecontroller@homeworke');
    Route::get('test/{student_id}/{lesson_id}/{parent_id}','Api\websitecontroller@test');
    Route::get('quize/{student_id}/{lesson_id}/{parent_id}','Api\websitecontroller@quize');
    Route::get('exam/{student_id}/{lesson_id}/{parent_id}','Api\websitecontroller@exam');
    Route::get('certificates/{student_id}/{parent_id}','Api\websitecontroller@certificates');
    Route::get('note/{parent_id}/{view_parent?}','Api\websitecontroller@note');
    Route::get('set_zero_notf_count_parents_objection/{parent_id}','Api\websitecontroller@set_zero_notf_count_parents_objection');


  Route::get('SaveToken/{parent_id}/{fcm_token}', 'Api\websitecontroller@SaveToken');



    Route::get('go_to_stream_student/{scheduler_id}/{day_id}/{lecture_time_id}/{room_id}/{student_id}', 'Api\websitecontroller@go_to_stream_student');
    
    
    Route::get('go_to_stream_teacher/{scheduler_id}/{day_id}/{lecture_time_id}/{room_id}/{teacher_id}', 'Api\websitecontroller@go_to_stream_teacher');
    

?>