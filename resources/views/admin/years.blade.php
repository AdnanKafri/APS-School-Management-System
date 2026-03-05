@extends('admin.master')
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
<div class="col">
    <div class="card" style="direction: rtl;
    text-align: right;">
<!--@if(session()->has('success'))-->


<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

            <!-- Card header -->
            <div class="card-header border-0" style="text-align:right">
              <h3 class="mb-0"> {{ $current_year->name }} العام الحالي</h3>

            </div>

            <button type="button" class="btn btn-primary btn-block" data-toggle="collapse" data-target="#demo">تغيير العام الدراسي</button>




            <div id="demo" class="col-md-6 collapse" style="direction:rtl">
                <br>
                <form action="{{ route('admin.current_year') }}" method="post">
                    @csrf

                    <div class="form-group">

                        <select name="year_id" id="years2" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر العام الدراسي</option>

                        @foreach ($years as $year)

                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach

                        </select>

                    </div>


                    <button class="btn btn-info" >حفظ</button>
                </form>



            </div>






    </div></div>
                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

</script>


@endsection
