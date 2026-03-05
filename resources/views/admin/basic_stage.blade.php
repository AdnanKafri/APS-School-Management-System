@extends('admin.master')



@section('breadcrumbs')

<nav class="breadcrumbs">
     <a  class="breadcrumbs__item is-active">   المراحل </a>

    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')


<head>



    <style>
    .custom-file-label{
    display:none !important;
    }
        .custom-file-label{
            display:none;
        }


.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}




.wrapper2{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper2 .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper2 .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper2 .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper2 input[type="radio"]{
  display: none;
}
#option-3:checked:checked ~ .option-3,
#option-4:checked:checked ~ .option-4{
  border-color: #0069d9;
  background: #0069d9;
}
#option-3:checked:checked ~ .option-3 .dot,
#option-4:checked:checked ~ .option-4 .dot{
  background: #fff;
}
#option-3:checked:checked ~ .option-3 .dot::before,
#option-4:checked:checked ~ .option-4 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper2 .option span{
  font-size: 20px;
  color: #808080;
}
#option-3:checked:checked ~ .option-3 span,
#option-4:checked:checked ~ .option-4 span{
  color: #fff;
}


.wrapper3{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper3 .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper3 .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper3 .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper3 input[type="radio"]{
  display: none;
}
#option-5:checked:checked ~ .option-5,
#option-6:checked:checked ~ .option-6{
  border-color: #0069d9;
  background: #0069d9;
}
#option-5:checked:checked ~ .option-5 .dot,
#option-6:checked:checked ~ .option-6 .dot{
  background: #fff;
}
#option-5:checked:checked ~ .option-5 .dot::before,
#option-6:checked:checked ~ .option-6 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper2 .option span{
  font-size: 20px;
  color: #808080;
}
#option-5:checked:checked ~ .option-5 span,
#option-6:checked:checked ~ .option-6 span{
  color: #fff;
}







.wrapper4{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper4 .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper4 .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper4 .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper4 input[type="radio"]{
  display: none;
}
#option-7:checked:checked ~ .option-7,
#option-8:checked:checked ~ .option-8{
  border-color: #0069d9;
  background: #0069d9;
}
#option-7:checked:checked ~ .option-7 .dot,
#option-8:checked:checked ~ .option-8 .dot{
  background: #fff;
}
#option-7:checked:checked ~ .option-7 .dot::before,
#option-8:checked:checked ~ .option-8 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper4 .option span{
  font-size: 20px;
  color: #808080;
}
#option-7:checked:checked ~ .option-7 span,
#option-8:checked:checked ~ .option-8 span{
  color: #fff;
}









.wrapper_lang{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_lang .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_lang .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_lang .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_lang input[type="radio"]{
  display: none;
}
#option-lang1:checked:checked ~ .option-lang1,
#option-lang2:checked:checked ~ .option-lang2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-lang1:checked:checked ~ .option-lang1 .dot,
#option-lang2:checked:checked ~ .option-lang2 .dot{
  background: #fff;
}
#option-lang1:checked:checked ~ .option-lang1 .dot::before,
#option-lang2:checked:checked ~ .option-lang2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_lang .option span{
  font-size: 20px;
  color: #808080;
}
#option-lang1:checked:checked ~ .option-lang1 span,
#option-lang2:checked:checked ~ .option-lang2 span{
  color: #fff;
}










.wrapper_religion{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_religion .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_religion .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_religion .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_religion input[type="radio"]{
  display: none;
}
#option-religion1:checked:checked ~ .option-religion1,
#option-religion2:checked:checked ~ .option-religion2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-religion1:checked:checked ~ .option-religion1 .dot,
#option-religion2:checked:checked ~ .option-religion2 .dot{
  background: #fff;
}
#option-religion1:checked:checked ~ .option-religion1 .dot::before,
#option-religion2:checked:checked ~ .option-religion2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_religion .option span{
  font-size: 20px;
  color: #808080;
}
#option-religion1:checked:checked ~ .option-religion1 span,
#option-religion2:checked:checked ~ .option-religion2 span{
  color: #fff;
}
a.btn{
    color: white !important;
}



@media only screen and (max-width: 750px) {
    .wrapper{

        width: 220px !important;
    }

}

input[type=file]{
  max-width: 200px;
  display: inline-block;
}
input[type=file]{
  max-width: 200px;
  display: inline-block;
}
th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black;
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center;
}
button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}

.select2-container{
        width: 100% !important;
    }
    </style>
</head>


    <div class="card" style="direction:rtl;text-align:right;margin: 20px">
            <!-- Card header -->

            <div class="card-header border-0">
              <h1 class="mb-0" style="text-align: center">جدول   المراحل</h1>
         @can('add_basic_stage')
                    <a href=".createModal" class=" btn btn-success" id="primary" data-toggle="modal" style="background: #6ABAA3;border-color: #6ABAA3"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء  مرحلة</i></a>
          @endcan

                <label style="margin-left: 350px" for=""></label>
                {{-- <select style="display: inline; width: 40%; direction:rtl" class="dropdown-product selectpicker form-control aaa" id="myInputclass" title="Choose Your Class">
                                       <option value="">اختر الصف الدراسي...</option>

                    @foreach ($classes as $class)

                    <option value="{{$class->id}}">{{$class->name}}</option>

                    @endforeach
                  </select> --}}

               </div>

<div class="table-responsive">




              <table class="table align-items-center table-flush">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم </th>
    
                    {{-- <th scope="col" class="sort" data-sort="budget">   الصفوف </th> --}}

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($stage as $item)

               <tr  id="base_subject_{{$item->id}}">

                    <td class="budget">
                        {{$item->name}}
                    </td>

                    {{-- <td class="budget">
                      @foreach($item->basic_stages_classes as $satge_class)
                      {{$satge_class->classes->name}}
                      @endforeach
                     
                    </td>   --}}

                    <td>
               @can('edit_basic_stage')
                            <a href=".editModal" class="edit btn btn-info" 
                            data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-basic_stages_classes="{{ $item->basic_stages_classes }}" 
                            data-toggle="modal" >
                                {{-- <i class="fa fa-edit" style="font-size: 30px;color: #0083FF"></i> --}}
                                تعديل   المرحلة 
                            </a>
             @endcan
                    </td>

                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>










            <div class="clearfix" style="padding-left:10px;text-align: center;">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex;justify-content: center">
                            {{ $stage->links() }}
                        </div>
                    </div>
                </div>





    </div>









                <div class="modal fade createModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="" action="{{ route('add_stage') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">إنشاء  مرحلة </h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>

                                  <div class="type_div">

                                  </div>




                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label>اسم  المرحلة  </label>
                                        <input type="text" name="name" class="form-control a"
                                            value="" style="direction:rtl"
                                            placeholder="اكتب الاسم"   required>
                                    </div>
                                    
                                    <div class="form-group" style="text-align:right">
                                        <label>   صفوف المرحلة </label>
 
                                        <select name="classes[]"   multiple="multiple" class="form-control  class_stage "
                                            style="min-height: 36px;direction: rtl" required>
                                         @foreach ( $classes  as  $class)
                                         <option value="{{$class->id}}"> {{$class->name}} </option>
                                         @endforeach
                                           
                                          


                                        </select>

                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>






                {{-- start edit modal --}}
                <div class="modal fade editModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('edit_stage') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="id" id="edit_id">

                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل  مرحلة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" style="text-align:right">
                                        <label> اسم  المرحلة  </label>
                                        <input type="text" style="direction:rtl" id="edit_name" name="name" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" required>
                                    </div>
                                     <div class="form-group" style="text-align:right">
                                        <label>  صفوف المرحلة </label>
                                      <div id="dvContainer2">

                                      </div>
                                        {{-- <select name="type" id="class_stage" class="form-control   class_stage  "
                                        style="min-height: 36px;direction: rtl" required>
                                            @foreach ( $classes  as  $class)
                                            <option value="{{$class->id}}"> {{$class->name}} </option>
                                            @endforeach
                                       
                                      


                                    </select> --}}


                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end edti modal --}}

                {{-- start delete modal --}}
                {{-- <div class="modal fade " id="delete_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('admin.base_subject_delete') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="base_subject_id" id="base_subject_id_delete" class="base_subject_id_delete">

                                <div class="modal-header">
                                    <h4 class="modal-title">حذف القسم</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">



                                    <div class="form-group" style="text-align:right">
                                        <label> اسم القسم </label>
                                        <input type="text" style="direction:rtl" id="name" name="name" class="form-control base_subject_name_delete"
                                            value="" readonly >
                                    </div>








                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                {{-- end modal  --}}

                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
                <script>
              
             $('.class_stage').select2();
             $(document).on("click",".edit",function () {
              id=  $(this).data("id");
              name=  $(this).data("name");
              basic_stages_classes = $(this).data('basic_stages_classes');
              $('#edit_id').val(id);
              $('#edit_name').val(name);

              var t = `<select name="classes[]" id="class_stage" class="form-control    class_stage  "multiple="multiple"
                                        style="min-height: 36px;direction: rtl" required>`;
             $.each(@json( $classes ), function (index, value) {
        
        select = false;
        $.each(basic_stages_classes, function (index2, value2) {
            if(value2.class_id == value.id){
              select = true;  
            }
        });
        t+= `<option ${select ? "selected" : ""} value="${ value.id }"> ${ value.name } </option>`;
        
    });
    t+= `</select>`;
    $('#class_stage').remove();

    $('#dvContainer2').append(t);
    $('#class_stage').select2();
  
   
});
               </script>

                @endsection
