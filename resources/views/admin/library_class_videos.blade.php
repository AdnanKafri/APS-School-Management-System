@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
    }
    th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black
    }
    td{
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center !important;
    }
   .modal-header .close {
       margin: -1rem auto -1rem -1rem;
   }

</style>

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">فيديوهات الموسوعة </a>
    <a href="{{ route('library') }}" class="breadcrumbs__item ">قسم الصفوف</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">
            <!-- Card header -->
            <div class="card-header border-0" style="">
              <h3 class="mb-0" style="text-align: center;color: #001586"    > فيديوهات الموسوعة الإلكترونية</h3>
              <br>

            </div>
    <div class="table-responsive">
        <a href=".createVideoModal" class=" btn btn-success" data-toggle="modal"
        data-id=""><i class="material-icons" data-toggle="tooltip">  إضافة فيديو جديد</i></a>

              <table class="table align-items-center table-flush">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">عنوان الفيديو </th>
                    <th scope="col" class="sort" data-sort="status">الصف</th>
                    <th scope="col" class="sort" data-sort="status">المدرس</th>
                    <th scope="col" class="sort" data-sort="status">الفيديو</th>

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($class_videos as $item)

               <tr>
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->



                    <td class="budget" style="font-weight:bold;font-size:15px">

                    {{$item->name}}

                    </td>

                  <td class="budget">
                  {{$item->classe->name}}


                  </td>
                  <td class="budget">
                  {{$item->teacher->first_name}}
                  {{$item->teacher->last_name}}


                  </td>
                  <td class="budget">
                  <video  controls   style="border-radius: 10px; width:200px;height:240px;">
                      <source src="{{ asset('storage/'. $item->file) }}" type="video/mp4">
                   </video>


                  </td>

                

                    <!--<td>-->
                    <!--  <div class="avatar-group">-->
                    <!--    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">-->
                    <!--      <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">-->
                    <!--    </a>-->

                    <!--  </div>-->
                    <!--</td>-->



                    <td class="">
                      <!--<div class="dropdown">-->
                      <!--  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                      <!--    <i class="fas fa-ellipsis-v"></i>-->
                      <!--  </a>-->
                      <!--  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">-->
                      <!--  <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"-->
                      <!--    data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
                      <!--        title="Delete">&#xE872; Delete</i></a>-->
                      <!--    <a class="dropdown-item" href="#">Another action</a>-->
                      <!--    <a class="dropdown-item" href="#">Something else here</a>-->
                      <!--  </div>-->
                      <!--</div>-->
                   

                      <a class="btn btn-success" href="{{ asset('storage/'. $item->file) }}" target="_blank">مشاهدة</a>
                      <a href=".editVideoModal" style="color: white !important;background: #0f739b !important;border-color: #0e8dbe !important"
                          class="edit btn btn-success"  data-class_id="{{ $item->class_id }}" data-teacher_id="{{ $item->teacher_id }}"
                          data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                          {{-- <i class="ni ni-settings"></i> --}}
                              تعديل
                      </a>
                      <a href=".deleteVideoModal" class="delete btn btn-warning text-light " style="color: white !important;background: #09516d !important;border-color: #008CC4 !important"
                       data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                        {{-- <i class="fa fa-trash" style="font-size: 30px;color: #af686e"></i> --}}
                        حذف
                    </a>
                    </td>


                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>





            <div class="clearfix" style="padding-left:10px;text-align: center">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $class_videos->links() }}
                        </div>
                    </div>
                </div>

        </div>
    </div>



                <div class="modal fade editVideoModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('library_video_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="class_id"  value="{{ $class_id }}">
                                <input type="hidden" name="file_id"  value="" class="file_id">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">تعديل الفيديو</h4>
                                </div>
                                <div class="modal-body" style="text-align:right">
                                    <div class="form-group">
                                        <label>العنوان </label>
                                        <input type="text" id="name" name="name" style="direction: rtl" class="form-control name"
                                            value=""
                                            placeholder="أدخل العنوان  " maxlength="30" required>
                                    </div>

                               
                                 <div class="form-group">
                                        <label> المدرس</label>

                                        <select name="teacher_id" id="" class="form-control teacher_id "
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر المدرس  </option>

                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->first_name }}  {{ $teacher->last_name }}</option>
                                        @endforeach

                                        </select>

                                </div>
                                 <div class="form-group" style="text-align:right">
                                        <label> المادة</label>

                                        <select name="teacher_id" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر المادة  </option>

                                       
                                        </select>

                                </div>
                                <div class="form-group">
                                        <label>تحميل فيديو </label>
                                        <input type="file" id="file" name="file" style="direction: rtl" class="form-control"
                                            value=""  accept="video/*" 
                                            placeholder="أدخل فيديو" >
                                </div>
    
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="modal fade createVideoModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('library_video_store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="class_id"  value="{{ $class_id }}">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"  style="text-align:center !important">إضافة فيديو جديد </h4>
                                </div>
                                <div class="modal-body"  style="text-align:right">
                                    <div class="form-group">
                                        <label>العنوان </label>
                                        <input type="text" id="name" name="name" style="direction: rtl" class="form-control a"
                                            value=""
                                            placeholder="أدخل العنوان  " maxlength="30" required>
                                    </div>
    
                               
                                 <div class="form-group" style="text-align:right">
                                        <label> المدرس</label>

                                        <select name="teacher_id" id="" class="form-control teacher_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر المدرس  </option>

                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->first_name }}  {{ $teacher->last_name }}</option>
                                        @endforeach

                                        </select>

                                </div>
                                 <div class="form-group" style="text-align:right">
                                        <label> المادة</label>

                                        <select name="teacher_id" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر المادة  </option>

                                       
                                        </select>

                                </div>
                                 
                                <div class="form-group">
                                    <label>تحميل فيديو </label>
                                    <input type="file" id="file" name="file" style="direction: rtl" class="form-control"
                                        value="" accept="video/*" 
                                        placeholder="أدخل فيديو" required>
                                </div>

                               


                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                {{-- delete file  --}}

                <div class="modal fade deleteVideoModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('library_video_delete') }}" method="POST" autocomplete="off">

                                @csrf
                                <input type="hidden" name="file_id" id="file_id" required class="file_id_delete">

                                <div class="modal-header" >
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" style="color: #f00">حذف الفيديو</h4>
                                </div>
                                <div class="modal-body" style="text-align:right">
                                <div class="form-group">
                                    <label>اسم فيديو </label>
                                    <input type="text" id="name_delete" name="" style="direction: rtl" class="form-control name_delete"
                                      readonly>
                                </div>
                                   

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end delete room  --}}

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click', '.edit', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');
    var teacher_id=$(this).data('teacher_id');

    $('.file_id').val(id);
    $('.name').val(name);
    $('.teacher_id').val(teacher_id);




});
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('.name_delete').val(name);
    $('.file_id_delete').val(id);
});

$(document).on('change', '.teacher_id', function (event) {
          
          
            var teacher_id = $(this).val();
            var form = $('.this-form');
            var url = "{{ URL::to('SMT/admin/library/get_teacher_subjects') }}/"+ teacher_id;

            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                        console.log(data);

                    },error: function(error){
                    console.log('insider function',error);
                    var x = JSON.parse(error.responseText);
                        $.each(x.errors, function(key,value) {
                            swal({title:"خطأ",text:`<p>${value}</p>`,html:!0});
                        });
                    }
                });
            });
</script>


@endsection
