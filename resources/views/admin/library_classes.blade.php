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
        button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}
</style>

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الصفوف</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
{{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif-->



            <div class="card-header border-0">
              <h3 class="mb-0">جدول الصفوف</h3>
            </div>

    <div class="table-responsive">

    <!--<a href=".createClassModal" class=" btn btn-success" data-toggle="modal"-->
    <!--data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء صف جديد</i></a>-->


              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالعربية</th>
            <th scope="col" class="sort" data-sort="budget"> الاسم بالانكليزية</th>
            <th scope="col" class="sort" data-sort="budget">  </th>

                 

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($classes as $item)

               <tr>
                <!--    <th scope="row">-->
                <!--    {{$item->id}}-->
                <!--</th>-->


                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->name}}
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                    {{$item->name_en}}
                  </td>

                  <td class="text-right">
                      <a href="{{route('library_class_videos',$item->id)}}" class="btn btn-success" style="margin-left: 10px">الفيديوهات</a>

                     
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
                            {{ $classes->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}





            





        



            
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$('.alert-success').hide(5000);


$(document).ready(function () {



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
