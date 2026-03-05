@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
     <style>

.chat-online {
    color: #34ce57
}

.chat-offline {
    color: #e4606d
}

.chat-messages {
    display: flex;
    flex-direction: column;
    max-height: 800px;
    overflow-y: scroll
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0
}

.chat-message-left {
    margin-right: auto
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto
}
.py-3 {
    padding-top: 1rem!important;
    padding-bottom: 1rem!important;
}
.px-4 {
    padding-right: 1.5rem!important;
    padding-left: 1.5rem!important;
}
.flex-grow-0 {
    flex-grow: 0!important;
}
.border-top {
    border-top: 1px solid #dee2e6!important;
}
.bg-success, .settings-panel .color-tiles .tiles.success{
  background-color: #a5c9ff !important;
    color: #fff !important;
}
.nname{
    color: #152C4F;
    font-weight: 600;
}
.btn-primary{
  background: #152C4F;
    border-color: #152C4F;
    color: #ffffff;
    font-weight: 900;
    font-size: 20px;
}
.btn-primary:hover{
  background: #a5c9ff ;
}
.bg-light, .settings-panel .color-tiles .tiles.light{
  background-color: #a5c9ff4f  !important;
}
.mb-1{
    min-height: 24px;

}

</style>
@endsection

@section('content')



<div class="main-panel" >
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">

      <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">المواد</a></li>
      <li class="li"><a href="#">رسائل مع الاستاذ </a></li>

   </ul>
    <div class="content-wrapper pb-0">
      <!--content  -->
      <main class="content">
        <div class="container p-0" style="padding-bottom: 100px !important;">

        <h1 class="h3 mb-3"></h1>

        <div class="card">

          <div class="row g-0">
            <div class="col-12 col-lg-5 col-xl-3 border-right">
              
              @foreach ($teachers as $key =>  $teacher)
               @if($teacher_id == $teacher->id)
               <input type="hidden" value="{{$teacher_id}}"  id="teacher_id">
              <a  class="list-group-item list-group-item-action border-0 active  teacher{{ $key }} @if($key  == 0)  @endif teacher"
                id="std1-tab"
                data-toggle="tab"
                href="#teacher{{ $key }}" role="tab"
                aria-controls="teacher{{ $key }}"
                aria-selected="true"
                data-id="{{ $teacher->id }}">
                <div class="badge bg-success float-right message_count"  data-id="{{ $teacher->id }}" data-count="{{ $teacher->message_count }}">{{ $teacher->message_count }}</div>
                <div class="d-flex align-items-start">
                    @if($teacher->image)
                    <img src="{{ asset('storage/'. $teacher->image) }}" class="rounded-circle mr-1" alt="William Harris" width="40" height="40">
                    @else
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="William Harris" width="40" height="40">
                    @endif

                  <div class="flex-grow-1 ml-3">
                    <span class="nname">{{ $teacher->first_name }} {{ $teacher->last_name }}  </span>
                  </div>
                </div>
              </a>
                @else
                <a  class="list-group-item list-group-item-action border-0  teacher{{ $key }} @if($key  == 0)  @endif teacher"
                id="std1-tab"
                data-toggle="tab"
                href="#teacher{{ $key }}" role="tab"
                aria-controls="teacher{{ $key }}"
                aria-selected="true"
                data-id="{{ $teacher->id }}">
                <div class="badge bg-success float-right message_count"  data-id="{{ $teacher->id }}" data-count="{{ $teacher->message_count }}">{{ $teacher->message_count }}</div>
                <div class="d-flex align-items-start">
                    @if($teacher->image)
                    <img src="{{ asset('storage/'. $teacher->image) }}" class="rounded-circle mr-1" alt="William Harris" width="40" height="40">
                    @else
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" class="rounded-circle mr-1" alt="William Harris" width="40" height="40">
                    @endif

                  <div class="flex-grow-1 ml-3">
                    <span class="nname">{{ $teacher->first_name }} {{ $teacher->last_name }}  </span>
                  </div>
                </div>
              </a>
               @endif
              @endforeach

              <hr class="d-block d-lg-none mt-1 mb-0">
            </div>
            <div class="col-12 col-lg-7 col-xl-9">
                <form action="" class="this-form1">
                    @csrf
              <div class="position-relative">
                <div class="chat-messages p-4 messages-content " id="messages">

                </div>
              </div>

              <div class="flex-grow-0 py-3 px-4 border-top">
                <div class="input-group">
                <input type="hidden" class="teacher_id" name="teacher_id">
                <input type="hidden" class="student_id" name="student_id" value="{{ $student->id }}">
                  <input type="text" class="message-box form-control"  name="message" placeholder="اكتب رسالتك">
                  <button class="btn btn-primary send">ارسال</button>
                </div>
              </div>
            </form>
            </div>
          </div>

        </div>
      </div>
    </main>

      <!--end content-->

</div>
</div>






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
    })
   
</script>

@endsection



