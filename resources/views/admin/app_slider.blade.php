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
</style>

@endsection
@section('breadcrumbs')

<nav class="breadcrumbs">
     <a  class="breadcrumbs__item is-active"> قسم صور للتطبيق  </a>
    
  
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')
{{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

   



            <div class="card-header border-0">
              <h3 class="mb-0">جدول  الصور</h3>
            </div>

    <div class="table-responsive">

    <a href=".createClassModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip"> إنشاء صورة جديدة  </i></a>


              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
               
                    <th scope="col" class="sort" data-sort="budget"> الصورة </th>
                     <th scope="col" class="sort" data-sort="budget"> تعديل </th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($app_student as $item)

               <tr>
                   

                    <td>
                        <img src="{{ asset('storage/'.$item->image) }}" style="width: 100px;">
                    
                    </td>


      <td class="delete"><a style="background-color: white; color: rgb(117, 115, 115);"
    class="btn delete11" href=".deleteEmployeeModal" data-id="{{$item->id}}"  data-toggle="modal">حذف   </a>

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
                        <div class="col-md-12" >
                            {{ $app_student->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}





            <div class="modal fade createClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('app_slider_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header" style="
    text-align: right;">
                               
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                                     <h4 class="modal-title">اضافة صورة</h4>
                            </div>
                            <div class="modal-body">
                            
                                   <div class="form-group" style="text-align:right">
                                    <label>الصورة  </label>
                                    <input type="file" id="upload_file" name="img"
                                                           >
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




            <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" action="{{route('delete_app_slider')}}" method="POST">
                                        @csrf
                                      
                                        
                                        <div class="modal-header" style="
    text-align: right;">
                                            
                                            
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">حذف صورة  </h4>
                                        </div>
                                        <div class="modal-body">
                                             <input class="delete1"  hidden   name="id" >
                                            <p style="
    text-align: right;">  هل انت متأكد من حذف الصورة </p>
                                            <p class="text-warning" style="
    text-align: right;"><small>لا يمكن التراجع عن هذا الإجراء
                                           </small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="الغاء">

                                            <button class="btn btn-danger">حذف </button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$('.alert-success').hide(5000);


$(document).ready(function () {

$('.delete11').on('click', function () {
    var id = $(this).data('id');

    $('.delete1').val(id);
    
    
    


});



$('.edit').on('click', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');
    var name_en=$(this).data('name_en');
var image=$(this).data('image');
    var cost=$(this).data('cost');
    $('#class_id').val(id);
    $('#name').val(name);
    $('#name_en').val(name_en);
    $('#image').attr('src',`{{asset('storage/${image}')}}`);
    $('#cost').val(cost);




});


});
</script>

<script>


    var loadFile = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


    var loadFile_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


        $(document).on('click' , '.del_img' , function () {
            $(this).nextAll('.output').attr('style','display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click' , '.del_icon' , function () {
            $(this).prevAll('.del:first').attr('disabled',false );
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });


  </script>

@endsection
