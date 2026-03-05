@extends('admin.layouts.app')
<!--@section('search')
<!--<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">-->
<!--    <div class="form-group mb-0">-->
<!--      <div class="input-group input-group-alternative input-group-merge">-->
<!--        <div class="input-group-prepend">-->
<!--          <span class="input-group-text"><i class="fas fa-search"></i></span>-->
<!--        </div>-->
<!--        <input class="form-control" name="search_teacher" id="search_teacher" placeholder="Search" type="text">-->
<!--      </div>-->
<!--    </div>-->
<!--    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">-->
<!--      <span aria-hidden="true">×</span>-->
<!--    </button>-->
<!--  </form>-->
<!--@endsection-->
@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
<!--@if(session()->has('success'))-->

<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">جدول الفصول</h3>

            </div>
<div class="table-responsive">
    @can('create_term')

    <a href=".createTermModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">انشاء فصل جديد</i></a>

    @endcan

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم</th>
                    <th scope="col" class="sort" data-sort="status">العام الدراسي</th>
                    <th scope="col" class="sort" data-sort="status"> العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($terms as $item)

               <tr>
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->
                    <td class="budget">
                    {{$item->term}}

                  </td>

                  <td class="budget">
                    {{$item->year->name}}

                  </td>


<td>

    <a href=".editClassModal" class="edit" data-term="{{ $item->term }}" data-year="{{$item->year->id }}"
   data-id="{{ $item->id }}"data-toggle="modal"  >   <i class="ni ni-settings"></i></a>
</td>

                  </tr>


               @endforeach



                </tbody>
              </table>

            </div>












            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $terms->links() }}
                        </div>
                    </div>
                </div>



    </div></div>



    <div class="modal fade editClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_update" method="POST" action="{{ route('admin.term_update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="term_id" id="term_id">
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الفصل</h4>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">



                        <div class="form-group" style="text-align:right">
                            <label>اسم الفصل</label>
                            <input type="text" name="term_name" id="term_name" class="form-control"
                                 style="direction: rtl" maxlength="20"
                                required>
                        </div>



                        <div class="form-group" style="text-align:right">
                            <label>العام الدراسي</label>

                            <select name="year_id" id="year_id" class="form-control"
                                style="min-height: 36px;direction: rtl" required>

                                <option value="">اختر العام الدراسي</option>

                                @foreach ($years as $year)

                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach

                            </select>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                        <button class="btn btn-info">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



            <div class="modal fade createTermModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" action="{{ route('admin.term_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">إنشاء فصل جديد</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الفصل</label>
                                    <input type="text" name="term_name" class="form-control"
                                        value="" style="direction: rtl" maxlength="20"
                                        placeholder="مثال : الفصل الأول" required>
                                </div>



                                <div class="form-group" style="text-align:right">
                                    <label>العام الدراسي</label>

                                    <select name="year_id" id="" class="form-control"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value="">اختر العام الدراسي</option>

                                    @foreach ($years as $year)

                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach

                                    </select>

                                </div>



                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-info">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$('.edit').on('click', function () {
    var id = $(this).data('id');
    var term_name=$(this).data('term');
    var year_id=$(this).data('year');
    $('#term_id').val(id);
    $('#term_name').val(term_name);
    $('#year_id').val(year_id);


});

$(document).ready(function () {





    $('#search_teacher').on('keyup',function(){
        var search_teacher = $(this).val();
        var url = "{{ URL::to('SMARMANger/admin/teachers/teacher_filter') }}";
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            data:{

teacher_now:search_teacher,

},
            success: function (data) {

                $('#mydiv').empty();
var type="";

                $.each(data, function (key, value) {
console.log(data);
                    type += `

                    <tr>
                    <th scope="row">
                        ${value.id}
                    </th>
                    <td class="budget">
                    ${value.first_name}

                  </td>

                  <td class="budget">
                    ${value.last_name}

                  </td>


                  <td class="budget">
                    ${value.age}

                  </td>

                  <td class="budget">
                    ${value.address}

                  </td>

                  <td class="budget">
                    ${value.phone}

                  </td>

                  <td>
                      <div class="avatar-group">
                        <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">
                          <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">
                        </a>

                      </div>
                    </td>





                  </tr>

                      `;

                });


                $('#mydiv').append(type);

            },
            error: function (xhr) {

            }

        });
    });




    });


</script>


@endsection
