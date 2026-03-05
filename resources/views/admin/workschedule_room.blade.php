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
    <a  class="breadcrumbs__item ">قسم الشعب </a>
    <a href="{{ route('workschedule_class') }}" class="breadcrumbs__item ">قسم جدول الدوام </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>
@endsection

@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">
            <!-- Card header -->
            <div class="card-header border-0" style="">
              <h3 class="mb-0" style="text-align: center;color: #001586">جدول الشعب</h3>
              <br>

            </div>
    <div class="table-responsive">

              <table class="table align-items-center table-flush">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">اسم الشعبة</th>
                    <th scope="col" class="sort" data-sort="status">الصف</th>
                    <th scope="col" class="sort" data-sort="status">العام الدراسي</th>
                    <!--<th scope="col" class="sort" data-sort="status">Image</th>-->

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($rooms as $item)

               <tr>
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->



                    <td class="budget" style="font-weight:bold;font-size:15px">

                    {{$item->name}}

                    </td>

                  <td class="budget">
                  {{$item->classes->name}}


                  </td>

                  <td class="budget">
                  {{$item->year->name}}

                  </td>

                    <td class="">

                    <a href=".editroomModal" class="edit"  data-class1="{{ $item->classes->id }}"
                    data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                    <i class="ni ni-settings"></i>

                    </a>
                    
                      @can('workschedule')
                      <a class="btn btn-success" href="{{ route('workschedule_exam',$item->id) }}" style="color: white;background: #3d93e4  !important;border-color: #27b4ec !important">  البرنامج الاسبوعي</a>
                   @endcan
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
                            {{ $rooms->links() }}
                        </div>
                    </div>
                </div>

        </div>
    </div>






<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click', '.edit', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name').val(name);
    $('#room_id').val(id);




});
</script>


@endsection
