@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
     <style>
    /*
	/*table */
table {
  border-spacing: 1;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
  margin-top: -170px;
  margin-bottom: 100px;
  direction: rtl;


}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;

}
table thead tr {
  height: 60px;
  background: white;
  font-size: 22px;
  color: #f38639;
  border-style: solid ;
  border-color: #094e89;


}
table tbody tr {
  height: 48px;
  font-size: 18px;
  /*border-bottom: 1px solid #f38639;*/

  color: white;
}
table tbody tr:last-child {
  border: 0;
  border-radius: 15px;
}
table td, table th {
  text-align: center;
}
table td.l, table th.l {
  text-align: center;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "اسم الاختبار ";
  }
  table tbody tr td:nth-child(2):before {
    content: "وقت البداية ";
  }
  table tbody tr td:nth-child(3):before {
    content: "وقت النهاية ";
  }
  table tbody tr td:nth-child(4):before {
    content: "نوع الاختبار ";
  }
  table tbody tr td:nth-child(5):before {
    content: "الاسئلة ";
  }
  table tbody tr td:nth-child(5):before {
    content: "عمليات التعديل ";
  }
}


/* end table */
/*select and option */
:root {
  --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
  --gray: #2c71ad;
  --darkgray: #2c71ad;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;


}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 20em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639;
  float: right;
  text-align: center;


}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #f38639;
  transition: .25s all ease;
  pointer-events: none;
  float: right;
  text-align: center;

}
/* Transition */
.select:hover::after {
  color: #f38639;
  text-align: center;
  float: right;


}
 .cart-count
{
  display: flex;
  position: relative;
  align-items:center;
  justify-content:center;
  min-width:1.3rem;
  height:1.3rem;
  border-radius:50%;
  font-weight:700;
  font-size:0.7rem;
  line-height:1;
  
  margin-left:20px;
  margin-top:-40px;
  color:#f38639;
  background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);
}
</style>


	<section class="hero-wrap hero-wrap-2" style="background-image: url('{{  asset('teachers/ppp.jpg') }}'); border-bottom-right-radius: 70px 50px;">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end justify-content-center">
				<div class="col-md-12 ftco-animate pb-5 text-right">
					{{-- <p class="breadcrumbs"></p> --}}
					<h1 class="mb-0 bread">   الاعتراضات  </h1>
				</div>
			</div>
		</div>
	</section>
  <!-- start new-->

<div class="col-md-10 " style="margin: auto; direction: rtl; text-align:center">

    @if (session()->has('success'))

    <script>
        window.onload = function() {
            notif({
                msg: "  تم التخزين بنجاح  ",
                type: "success"
            })
        }

    </script>
@endif
    @if (session()->has('otherday'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{ session()->get('otherday') }} ",
                type: "warning"
            })
        }

    </script>
@endif
    @if (session()->has('othertime'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{ session()->get('othertime') }} ",
                type: "warning"
            })
        }

    </script>
@endif
@if ($errors->any())

        @foreach ($errors->all() as $error)
        {{-- <li>{{ $error }}</li> --}}
        <script>
            window.onload = function() {
                notif({
                    msg: `{{  $error }}`  ,
                    type: "error"
                })
            }

        </script>
        @endforeach

@endif
<br>
<br>
<br>
<br>
<br>
<div class="col-md-12 heading-section text-center ">
    <button style=" width:120px" type="button" class="btn btn-primary launch" data-toggle="modal"
        data-target="#staticBackdrop5">
        اضافة اعتراض  &nbsp; <i class="fa fa-plus"></i> </button>
        <div class="modal fade" id="staticBackdrop5" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-right">
                        <i style="color:#495057" class="fa fa-close close" data-dismiss="modal">
                        </i>
                        <br>
                    </div>
                    <div class="tabs mt-3">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">

                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                                <div class="mt-4 mx-4">
                                    <form action="{{route('objection_store')}}" method="post" autocomplete="off">

                                        @csrf
                                    
                                    <div class="text-center" style="height: auto;">
                                        <h5>  اضافة اعتراض </h5>
                                        <br>
                                        <!-- start select option-->
                                         
                                        <span style="float:right">تحديد الفصل   </span>
                                        <br>
                                        <br>
                                       <input type="hidden" name="room_id" id="class_id" value="{{ $room_id}}">
                                        <select id="myselection" required  class="term" name="term_id"
                                            style="width: 300px;  height:50px; text-align: center;">
                                             <option style="text-align: center;" value="">اختر الفصل   </option>
                                         
                                            <option style="text-align: center;" value="1">الفصل الاول </option>
                                            <option style="text-align: center;" value="2">الفصل الثاني </option>

                                           
                                        </select>
                                        <br>
                                        <br>

                                        <span style="float:right">اسم المادة </span>
                                        <br>
                                        <br>
                                       <input type="hidden" name="room_id" id="class_id" value="{{ $room_id}}">
                                        <select id="myselection" required  class="lesson" name="lesson_id"
                                            style="width: 300px;  height:50px; text-align: center;">
                                             <option style="text-align: center;" value="">اختر المادة </option>
                                            @foreach($lessons as $item)
                                            <option style="text-align: center;" value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                           
                                        </select>
                                        <br>
                                        <br>
                                        <span style="float: right;">اسم المعلم  </span>
                                        <br>
                                        
                                        <select id="myselection" required class="teacher" name="teacher_id"
                                            style="width: 300px;  height:50px; text-align: center;">
                                           
                                           
                                        </select>
                                        <br>
                                        <br>
                                        <span style="float: right;"> السبب </span>
                                        <br>
                                         <textarea name="note" required  class="form-control" style="direction:rtl" cols="3"
                                            rows="2"></textarea>
                                       
                                       
                                        <br>






                                        <div class="px-5 pay" style="text-align: center;">
                                            <button  type="submit" class="btn btn-primary" style="width: 200px;">
                                                حفظ
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end model-->

        <!--- end add section -->
    </div>
        </div>
      <br>
<br>
<br>
<br>  
  <br>
  <br>
  <br>

  <table  >
        <thead>
            <tr>
                <th>
                   اسم   المعلم 
                </th>
             
                <th>
                  تاريخ  الاعتراض 
                </th>

                <th>
                    السبب
                 </th>
                  <th>
                     الحالة 
                 </th>


            </tr>
        </thead>
        <tbody>
            @foreach ( $objection2  as  $item )
            <tr id="exam1">
                <td>{{$item->teacher->first_name  }} {{$item->teacher->last_name  }}</td>
                 
           
     
             <td>{{$item->created_at}} </td>
             
              <td>{{$item->note}} </td>
              @if($item->type==0)
               <td><button  class="btn" style="color: white;
    border: 2px solid #f58634;
   
    box-shadow: -3px 2px 1px 1px #333036ad;" > قيد المعالجة         </button> </td>
               @elseif($item->type==1)
                <td><button  class="btn" style="color: white;
    border: 2px solid #f58634;
   
    box-shadow: -3px 2px 1px 1px #333036ad;">تمت المعالجة    </button> </td>
               @endif
            </tr>


            @endforeach








        </tbody>
    </table>
</div>
<!-- end new-->

  <br>
  <br>
  <br>
  <br>




	@endsection
    @section('js-scripts')
    <script>
        $(document).ready(function(){
             $(".lesson").on("change", function (e) {
                    $('.teacher').empty();
                 lesson_id=$(this).val();
                  var url = "{{ URL::to('SMARMANger/getteacher') }}/" + lesson_id ;
        $.ajax({
url: url,

type: "get",
contentType: 'application/json',
success: function (data) {

console.log(data);
  
 $.each(data, function (key, value) {
     
    $('.teacher').append(` <option style="text-align: center;" value="${value.id}">${value.first_name} ${value.last_name}</option>`);

     
     
    
     
 })


},
error: function (xhr) {

}

});
                 
             })

           
        //     $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
            let xx ;
            let my_room = {{ $room_id }} ;
            $('.add_time').on('click',function(){
                xx = $(this).data('xx');
                day = $(this).data('day');
                time2 = $(this).data('time');
                day_id = $(this).data('day_id');
                time_id = $(this).data('time_id');
                $(`.day`).val(day);
               $(`.time`).val(time2);
                $(`.day_id`).val(day_id);
               $(`.time_id`).val(time_id);
            });
           
            $('.save_lecture_time').on('click',function(e){
                e.preventDefault() ;
                let lesson_id = $('select.lesson_id').val();
                let teacher_id = $('select.teacher_id').val();
                let day_id = $(`.day_id`).val();
                let lecture_time_id = $(`.time_id`).val();
                $.ajax({
                    url:"{{ route('dashboard.room.save.schedule') }}",
                    type: "POST",

                    data: {
                            'lesson_id' : lesson_id,
                            'teacher_id' : teacher_id,
                            'room_id' : my_room,
                            'day_id' : day_id,
                            'lecture_time_id' : lecture_time_id,
                            '_token': "{{ csrf_token() }}"

                        },
                    success: function (response2) {
                        console.log(response2);
                        let lesson_name = $( ".wide option:selected" ).text();
                        let lesson_id = $( ".wide " ).val();
                        let teacher_name = $( ".teacher_id option:selected" ).text();
                        // let lesson_id = $( ".wide " ).val();

                        $(`.${xx}`).val(lesson_name);
                        $(`.id-${xx}`).val(lesson_id);
                        $(`.lesson_name-${xx}`).text(lesson_name);
                        $(`.teacher_name-${xx}`).text(`(${teacher_name})`);

                        $("#add_schedule").modal('hide');

                        notif({
                        msg: "تم الإضافة  بنجاح",
                        type: "success"
                    })
                    console.log('content name',response2);
                    },error: function(error){
                    console.log('insider function',error);
                    var x = JSON.parse(error.responseText);
                        $.each(x.errors, function(key,value) {
                            notif({
                                        msg: `${value}`,
                                        type: "error",
                            });
                        });
                    }
                });

            })
        });
        
    </script>
    @endsection
