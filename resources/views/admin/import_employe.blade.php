@extends('admin.master')

@section('style')

@endsection

@section('breadcrumbs')
@endsection
@section('content')
<div class="card" style="margin: 30px">
    <div class="card-body" style="text-align: right;">
        <div class="card-title">
            @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
 <form action="{{route('admin.employeesimport')}}" method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="select" class=" form-control-label"> إدخال  الموظفين  </label>
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="file" name="file" required class="form-control">
                        </div>
                    </div>
                    <input type="submit" value="ادخال" class="btn btn-primary" />
                </form>
</div>
</div>
</div>
@endsection


@section('js')


@endsection
