@extends('supervisors.layouts.app')

@section('email')
{{ $supervisor->email }}
@endsection

@section('image')
{{ asset('storage/'.$supervisor->image) }}
@endsection

@section('name')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}

@endsection
@section('my_info')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}
@endsection


@section('classes')
{{ route('dashboard.supervisor.classes',$supervisor->id) }}
@endsection



@section('classes2')
{{ route('dashboard.supervisor.classes2',$supervisor->id) }}
@endsection



@section('messages')
{{ route('dashboard.supervisor.teachers',$supervisor->id) }}
@endsection
 

<head>
    <style>
        a{
        color:#019983 !important;
    }
            a:hover{
            color: #337AB7 !important;
            transition: all 1s ease;
            text-decoration: none !important;
        }


    </style>
</head>

@section('content')






<h1 style="text-align: center"> المدرسون</h1>





<div class=" col-md-12 col-sm-12 col-xs-12" style="direction:rtl">
<input type="hidden" name="" id="supervisor_id" value="{{ $supervisor->id }}">
       <label for="">الصف الدراسي</label>

    <br>
    <select name="class_id" id="classes" style="width: 600px;height: 40px; margin-bottom: 20px; direction: rtl" required>
        <option value="">-- يرجى الاختيار --</option>

        @foreach ($classes as $class)

        <option value="{{ $class->id }}">{{ $class->name }}</option>


        @endforeach


    </select>

    <br>
    <label for="">المواد الدراسية</label>
<br>
    <select name="room_id" id="rooms" style="width: 600px;height: 40px; margin-bottom: 20px;direction: rtl " required>


    </select>

    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
                <a type="button" id="group_message"
                href="" class="btn bg-teal waves-effect">

                    <i class="material-icons">forum</i>

                    ارسال لكافة مدرسي المادة

                </a>


            </h2>


        </div>





        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead >
                    <tr>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold;text-align: center; font-size: 16px">الرقم التسلسلي </th>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold;text-align: center; font-size: 16px">  اسم المدرس </th>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold;text-align: center; font-size: 16px"> العملية</th>


                    </tr>
                </thead>
                <tbody style="text-align: center" id="mydiv">





                </tbody>
            </table>
        </div>




    </div>
</div>







<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>

<script>
    $(document).ready(function () {

    $("button.dropdown-toggle" ).remove();

    $('#group_message').hide();
    $(document).on('change', '#classes', function () {
var teacher_id=$('#teacher_id').val();
var class_id=$(this).val();


$('#group_message').hide();


        var url = "{{ URL::to('SUNRISEMANger/dashboard/supervisor/class/lessons2') }}/" + class_id ;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                console.log(data);
                $('#rooms').empty();
                var type = `

                    <option value="">اختر المادة </option>

                    `;

                $.each(data, function (key, value) {


                    type += `

<option value="${value.id}">${value.name}</option>

                      `;

                });


                $('#rooms').append(type);

            },
            error: function (xhr) {

            }

        });

});



$(document).on('change', '#rooms', function () {

var supervisor_id=$('#supervisor_id').val();
var lesson_id=$(this).val();
$('#group_message').show();

$('#group_message').attr('href',"{{ URL('SUNRISEMANger/dashboard/supervisor/send_group_item') }}/"+lesson_id);



        var url = "{{ URL::to('SUNRISEMANger/dashboard/supervisor/lesson/teachers') }}/" + lesson_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

console.log(data);
                $('#mydiv').empty();
                var type = `

                    `;

                $.each(data, function (key, value) {


                    type += `
                    <tr>

                    <td>${value.id}</td>
                    <td>${value.first_name} ${value.last_name}</td>
                    <td>`;



                    type+=`
                    <a href="{{URL::to('SUNRISEMANger/dashboard/supervisor/send_item/${value.id}/${lesson_id}')}}"  class="btn bg-teal waves-effect" data-toggle="modal" data-id="${value.id}"
                  ><i class="material-icons">forum</i> ارسال عنصر</a>

                  <a href="{{URL::to('SUNRISEMANger/dashboard/supervisor/show_old_item/${value.id}/${lesson_id}')}}"  class="btn bg-teal waves-effect" data-toggle="modal" data-id="${value.id}"
                  ><i class="material-icons">forum</i> عرض المحتوى السابق</a>

  </td>
  </tr>

                    `;



                });

type+=`

`;

                $('#mydiv').append(type);

            },
            error: function (xhr) {

            }

        });

});


    });
</script>



@endsection
