@extends('admin.master')

@section('style')
<style>
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
    button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.pagination{
    justify-content: center;
}
</style>

@endsection

@section('content')

<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h2 class="mb-0" style="color: #001586;text-align: center" >جدول مدرسي الشعبة</h2>
            </div>
<div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="">
                <tr>

                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم</th>

                    <th scope="col" class="sort" data-sort="budget"> العمر</th>
                    <th scope="col" class="sort" data-sort="budget"> الهاتف</th>

                    <th scope="col" class="sort" data-sort="completion">المادة</th>
                    <!--<th scope="col" class="sort" data-sort="completion">Action</th>-->

                </tr>
                </thead>
                <tbody class="list">


@php
    $i=0;
@endphp


                   @foreach ($teachers as $value)


                  <tr>

                   <!--<th scope="row">-->
                   <!-- {{$value->id}}-->
                   <!-- </th>-->



                    <td class="budget">
{{ App\Teacher::where('id',$value->teacher_id)->first()->first_name }}
{{ App\Teacher::where('id',$value->teacher_id)->first()->last_name }}



                    </td>


                    <td class="budget">

                        {{-- {{$value->age}} --}}
                        {{ App\Teacher::where('id',$value->teacher_id)->first()->age }}

                    </td>

                    <td class="budget">
                        {{ App\Teacher::where('id',$value->teacher_id)->first()->phone }}

                        {{-- {{$value->phone}} --}}

                    </td>

                    <td class="budget">
                        {{ App\Lesson::where('id',$value->lesson_id)->first()->name }}





                    </td>


                    <!--<td class="text-right">-->
                    <!--    <div class="dropdown">-->
                    <!--      <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                    <!--        <i class="fas fa-ellipsis-v"></i>-->
                    <!--      </a>-->
                    <!--      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">-->
                    <!--      <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"-->
                    <!--        data-id="{{$value->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
                    <!--            title="Delete">&#xE872; Delete</i></a>-->
                    <!--        <a class="dropdown-item" href="#">Another action</a>-->
                    <!--        <a class="dropdown-item" href="#">Something else here</a>-->
                    <!--      </div>-->
                    <!--    </div>-->

                    <!--  </td>-->


                    </tr>

                   @endforeach









               <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete these Records?</p>
                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">

                                            <button class="btn btn-danger">Delete</button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </tbody>
              </table>

            </div>





            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text" style="text-align: center">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $teachers->links() }}
                        </div>
                    </div>
                </div>

    </div>
</div>

                <script>

$(document).ready(function () {

$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students')}}";
    $('#form_delete').attr("action", url);


});

});
</script>

@endsection
