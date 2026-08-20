@extends('students.layouts.app4')

@section('title', 'الرسائل مع المعلمين')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <span class="sp-page-header__eyebrow">التواصل المدرسي</span>
                    <h1>الرسائل مع المعلمين</h1>
                    <p>اختر معلماً للاطلاع على المحادثة وإرسال رسالة.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>المعلمون</span><strong>{{ $teachers->count() }}</strong></div>
                </div>
            </section>

            <section class="sp-chat sp-card">
                <aside class="sp-chat__contacts" aria-label="قائمة المعلمين">
                    <div class="sp-chat__contacts-header"><strong>المعلمون</strong><small>اختر محادثة</small></div>
                    <div class="sp-chat__contacts-list">
                        @forelse ($teachers as $key => $teacher)
                            @php $isSelected = (int) $teacher_id === (int) $teacher->id || ((int) $teacher_id === 0 && $key === 0); @endphp
                            @if ($isSelected)<input type="hidden" value="{{ $teacher_id }}" id="teacher_id">@endif
                            <a class="sp-chat-contact teacher teacher{{ $key }} {{ $isSelected ? 'active' : '' }}" href="#teacher{{ $key }}" data-toggle="tab" role="tab" data-id="{{ $teacher->id }}" aria-selected="{{ $isSelected ? 'true' : 'false' }}">
                                <img src="{{ $teacher->image ? asset('storage/' . $teacher->image) : asset('student/avatar.png') }}" alt="صورة {{ $teacher->first_name }} {{ $teacher->last_name }}">
                                <span><strong class="nname">{{ $teacher->first_name }} {{ $teacher->last_name }}</strong><small>فتح المحادثة</small></span>
                                @if ($teacher->message_count)
                                    <span class="sp-chat-contact__count message_count" data-id="{{ $teacher->id }}" data-count="{{ $teacher->message_count }}">{{ $teacher->message_count }}</span>
                                @else
                                    <span class="message_count" data-id="{{ $teacher->id }}" data-count="0" hidden>0</span>
                                @endif
                            </a>
                        @empty
                            <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-account-off-outline"></i></span><h3>لا يوجد معلمون متاحون</h3></div>
                        @endforelse
                    </div>
                </aside>

                <div class="sp-chat__conversation">
                    <div class="sp-chat__conversation-header"><span class="sp-icon-box"><i class="mdi mdi-message-text-outline"></i></span><span><strong>المحادثة</strong><small>الرسائل محفوظة ضمن العام الدراسي الحالي</small></span></div>
                    <form action="" class="this-form1 sp-chat__form">
                        @csrf
                        <div class="chat-messages messages-content sp-chat__messages" id="messages">
                            <div class="sp-chat__placeholder"><i class="mdi mdi-message-processing-outline"></i><span>اختر معلماً لعرض الرسائل</span></div>
                        </div>
                        <div class="sp-chat__composer">
                            <input type="hidden" class="teacher_id" name="teacher_id">
                            <input type="hidden" class="student_id" name="student_id" value="{{ $student->id }}">
                            <input type="text" class="message-box form-control" name="message" placeholder="اكتب رسالتك" autocomplete="off">
                            <button type="submit" class="sp-btn sp-btn--primary send"><i class="mdi mdi-send"></i> إرسال</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
@section('js')
<script>

    $( document ).ready(function(){
        // let teachers = $('.nav-pills').children() ;
        // $.each(teachers,function(key,element){
        //     console.log(element);
        //     console.log(element.data('id'));
        // });
       
        $('.this-form1').hide();
            const messages2 = document.getElementById('messages');
            messages2.scrollTop = messages2.scrollHeight;
            const student_id = {{ $student->id }} ;
            let student_image = "{{ $student->details->personal_image }}" ;
            student_image = student_image.length > 0 ? 'storage/' + student_image  : 'student-UI/person-image...PNG ' ;
            var teacher_id = $('.teacher0').data('id');
            $('.message-box').val('');
            
        //  if($('#teacher_id').val()!=0){
             
        //       var url = "{{ URL::to('SMARMANger/dashboard/student/get_teacher_message') }}/"+ student_id +'/'+ $('#teacher_id').val();
        //   $.ajax({
              
        //         url: url,
        //         type: "get",
        //         contentType: 'application/json',
        //         success: function (data) {
        //             let messages = '' ;
        //             console.log(data);
        //             $.each(data.messages, function (key, message) {

        //                 if (message.type == 1){

        //                     messages += `
        //                     <div class="chat-message-right pb-4">
        //             <div>
        //                 <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
        //               <div class="text-muted small text-nowrap mt-2">
        //                 <p style="font-size: 9px;margin-bottom: 0px;">${ message.time }  </p>
        //                 <p style="font-size: 9px;">${ message.date }  </p>
        //               </div>
        //             </div>
        //             <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
        //               <div class="font-weight-bold mb-1" >انت</div>
        //               ${ message.message }
        //             </div>
        //           </div>
        //                         `;
        //                 }else {
        //                     messages += `
        //                     <div class="chat-message-left pb-4">
        //             <div>
        //                 <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
        //                 <div class="text-muted small text-nowrap mt-2">  <p style="font-size: 9px;margin-bottom: 0px;">${ message.time }  </p>
        //                 <p style="font-size: 9px;">${ message.date }  </p></div>

        //             </div>
        //             <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
        //               <div class="font-weight-bold mb-1">${ message.teacher.first_name } ${ message.teacher.last_name }</div>
        //               ${ message.message }
        //             </div>
        //           </div>

        //                     `;
        //                 }

        //             });



        //                 $('.messages-content').children().remove();
        //                 $('.messages-content').append(messages);
                  


        //                 $.each($('.message_count'), function (key, value) {
        //               if($(this).data('id')==teacher_id ) {
        //                   $(this).text(0);
        //               } 
                         
        //              })
        //               $('.this-form1').show();
        //                  // Get the height of the content inside the div
        //                   var contentHeight = document.getElementById('messages').scrollHeight;
                        
        //                   // Get the height of the div
        //                   var divHeight = document.getElementById('messages').clientHeight;
                        
        //                   // Scroll to the bottom of the content inside the div
        //                   document.getElementById('messages').scrollTop = contentHeight - divHeight;
        //             },
        //             error: function (xhr) {

        //             }

        //     });
  
        // }
            

            $(document).on('click', '.teacher', function (event) {


                $.each($('.teacher'), function (key1, value) {
                    $(value).removeClass('active')  ;
                })
                $(this).addClass('active');
            var teacher_id = $(this).data('id');
            console.log(teacher_id);
            var url = "{{ URL::to('SMARMANger/dashboard/student/get_teacher_message') }}/"+ student_id +'/'+ teacher_id;

            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    let messages = '' ;
                    console.log(data);
                    $.each(data.messages, function (key, message) {
                        if (message.type == 1){

                                    messages += `
                                    <div class="chat-message-right pb-4">
                                    <div>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">  <p style="font-size: 9px;margin-bottom: 0px;">${ message.time }  </p>
                        <p style="font-size: 9px;">${ message.date }  </p> </div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                    <div class="font-weight-bold mb-1">انت</div>
                                    ${ message.message }
                                    </div>
                                    </div>
                                        `;
                                    }else {
                                    messages += `
                                    <div class="chat-message-left pb-4">
                                    <div>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">
                                   <p style="font-size: 9px;margin-bottom: 0px;">${ message.time }  </p>
                                    <p style="font-size: 9px;">${ message.date }  </p></div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                    <div class="font-weight-bold mb-1">${ message.teacher.first_name } ${ message.teacher.last_name }</div>
                                    ${ message.message }
                                    </div>
                                    </div>

                                    `;
                                    }

                    });


                    $('.messages-content').children().remove();
                    $('.messages-content').append(messages);
                    $('.message-box').text('');
                    messages2.scrollTop = messages2.scrollHeight;
                     $.each($('.message_count'), function (key, value) {
                       if($(this).data('id')==teacher_id ) {
                           $(this).text(0);
                       } 
                         
                     })
                    
                      $('.this-form1').show();
                    },
                    error: function (xhr) {

                    }

            });

            }) ;
 $('input').keypress(function(event) {
    if (event.which == 13) {
         event.preventDefault();
            var student_id = {{ $student->id }};
            var teacher_id = $('a.active').data('id');
            $('.teacher_id').val(teacher_id);
            var form = $('.this-form1');
            var url = "{{ URL::to('SMARMANger/dashboard/student/store_student_message') }}";
            var dt = new Date();
var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
var twoDigitMonth = ((dt.getMonth().length+1) === 1)? (dt.getMonth()+1) : '0' + (dt.getMonth()+1);

var date = dt.getDate() + "/" + twoDigitMonth + "/" + dt.getFullYear();


            $.ajax({
                    // url:"{{ route('save.schedule') }}",
                    url: url,
                    type: "POST",
                    data: form.serialize(),
                    success: function (response2) {
                        console.log(response2);
                        let message = response2.message ;
                        let messages = '' ;
                        if (message.type == 1){
                            messages += `
                            <div class="chat-message-right pb-4">
                                    <div>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">  <p style="font-size: 9px;margin-bottom: 0px;">${ time }  </p>
                                    <p style="font-size: 9px;">${ date }  </p> </div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                    <div class="font-weight-bold mb-1">انت</div>
                                    ${ message.message }
                                    </div>
                                    </div>
                                `;
                        }else {
                            messages += `
                            <div class="chat-message-left pb-4">
                                    <div>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">
                                <p style="font-size: 9px;margin-bottom: 0px;">${ time }  </p>
                        <p style="font-size: 9px;">${ date }  </p></div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                    <div class="font-weight-bold mb-1">${ message.teacher.first_name } ${ message.teacher.last_name }</div>
                                    ${ message.message }
                                    </div>
                                    </div>
                            `;
                        }


                    $('.messages-content').append(messages);
                    $('.message-box').val('');

                    messages2.scrollTop = messages2.scrollHeight;
                    // $(".messages-content")[0].scrollHeight

                    },error: function(error){
                    console.log('insider function',error);
                    var x = JSON.parse(error.responseText);
                        $.each(x.errors, function(key,value) {
                            swal({title:"خطأ",text:`<p>${value}</p>`,html:!0});
                        });
                    }
                }); 
    }})

            $(document).on('click', '.send', function (event) {
            event.preventDefault();
            var student_id = {{ $student->id }};
            var teacher_id = $('a.active').data('id');
            $('.teacher_id').val(teacher_id);
            var form = $('.this-form1');
            var url = "{{ URL::to('SMARMANger/dashboard/student/store_student_message') }}";
            var dt = new Date();
var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
var twoDigitMonth = ((dt.getMonth().length+1) === 1)? (dt.getMonth()+1) : '0' + (dt.getMonth()+1);

var date = dt.getDate() + "/" + twoDigitMonth + "/" + dt.getFullYear();


            $.ajax({
                    // url:"{{ route('save.schedule') }}",
                    url: url,
                    type: "POST",
                    data: form.serialize(),
                    success: function (response2) {
                        console.log(response2);
                        let message = response2.message ;
                        let messages = '' ;
                        if (message.type == 1){
                            messages += `
                            <div class="chat-message-right pb-4">
                                    <div>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">  <p style="font-size: 9px;margin-bottom: 0px;">${ time }  </p>
                                    <p style="font-size: 9px;">${ date }  </p> </div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                    <div class="font-weight-bold mb-1">انت</div>
                                    ${ message.message }
                                    </div>
                                    </div>
                                `;
                        }else {
                            messages += `
                            <div class="chat-message-left pb-4">
                                    <div>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">
                                <p style="font-size: 9px;margin-bottom: 0px;">${ time }  </p>
                        <p style="font-size: 9px;">${ date }  </p></div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                    <div class="font-weight-bold mb-1">${ message.teacher.first_name } ${ message.teacher.last_name }</div>
                                    ${ message.message }
                                    </div>
                                    </div>
                            `;
                        }


                    $('.messages-content').append(messages);
                    $('.message-box').val('');

                    messages2.scrollTop = messages2.scrollHeight;
                    // $(".messages-content")[0].scrollHeight

                    },error: function(error){
                    console.log('insider function',error);
                    var x = JSON.parse(error.responseText);
                        $.each(x.errors, function(key,value) {
                            swal({title:"خطأ",text:`<p>${value}</p>`,html:!0});
                        });
                    }
                });
            });

            $('.teacher.active').first().trigger('click');
    })
   
</script>

@endsection


