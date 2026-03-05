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
   .modal-header .close {

        margin-right: 314px !important;
}
</style>

@endsection
    @section('breadcrumbs')

<nav class="breadcrumbs">

    <a  class="breadcrumbs__item is-active">   البيانات  </a>
    <a  href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')

    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">



            <div class="card-header border-0">
              <h3 class="mb-0 text-center">بيانات المدرسة   </h3>
            </div>

    <div class="table-responsive">

    <a href=".createClassModal" class=" btn btn-success m-3" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip"> تعديل البيانات </i></a>


        <!--<a href="" class=" btn btn-success m-3"> تعديل البيانات </i></a>-->


              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget">  اسم المدرسة </th>
                        <th scope="col" class="sort" data-sort="budget">    اسم المدرسة بالانكليزي  </th>
                        <th scope="col" class="sort" data-sort="budget">       الفيديو      </th>
                        <th scope="col" class="sort" data-sort="budget"> اللوغو      </th>
                        <th scope="col" class="sort" data-sort="budget"> اللوغو في الحسابات        </th>

                    </tr>
                </thead>
                <tbody class="list">
                <tr>
                    <td class="budget" style="font-weight:bold;font-size:15px">
                        {{$school_data->name}}
                    </td>


                        <td class="budget"style="font-weight:bold;font-size:15px">
                        {{$school_data->name_en}}
                    </td>


                  <td class="budget" style="width: 50%">

                    <video class="video " style="width:60%" autoplay loop controls muted>

                      <source src="{{ asset('storage/'.$school_data->video) }}">

                   </video>

                   </td>

                    <td class="budget"style="font-weight:bold;font-size:15px">
                        <img src="{{  asset('storage/'. $school_data->logo)}}" alt="Logo" style="width: 100px">
                    </td>
                    <td class="budget"style="font-weight:bold;font-size:15px">
                        <img src="{{  asset('storage/'. $school_data->logo_account)}}" alt="cover" style="width: 100px">
                    </td>
                </tr>
                </tbody>
              </table>

            </div>




    </div>
{{-- </div> --}}





            <div class="modal fade createClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('school_data_update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">بيانات المدرسة </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>  اسم المدرسة  </label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{$school_data->name}}" style="direction: rtl"
                                          >
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label> اسم المدرسة بالانكليزي    </label>
                                    <input type="text" name="name_en" class="form-control"
                                        value="{{$school_data->name_en}}"
                                          >
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>  الفيديو           </label><br>

                                     <input type="file" id="upload_file" class="form-control"
                                     name="video"
                                                           >


                                                                </div>



                                <div class="form-group" style="text-align:right">
                                    <label> اللوغو     </label>
                                    <input type="file" name="logo" class="form-control"  >
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label> اللوغو بالحسابات      </label>
                                    <input type="file" name="logo_account" class="form-control"  >
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





<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>



@endsection
