@extends('admin.layouts.app')
@section('search')
<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
    <div class="form-group mb-0">
      <div class="input-group input-group-alternative input-group-merge">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input class="form-control" name="search_teacher" id="search_teacher" placeholder="Search" type="text">
      </div>
    </div>
    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </form>
@endsection
@section('content')
<div class="col">
    <div class="card">

        
      <div class="card-header border-0">
        <h3 class="mb-0" style="display:inline-block">Invoices Table</h3>
        for
        <h3 style="display:inline-block; text-align:right; color:green">{{$student->first_name}} {{$student->last_name}}</h3>
      </div>
<div class="table-responsive">

  

        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="sort" data-sort="name">Id</th>
              <th scope="col" class="sort" data-sort="budget">Invoice Number</th>
              <th scope="col" class="sort" data-sort="status">Invoice Amount</th>
              <th scope="col" class="sort" data-sort="completion">Date</th>
              <th scope="col" class="sort" data-sort="completion">Action</th>

            </tr>
          </thead>
          <tbody class="list" id="mydiv">
          @foreach ($invoices_details as $item)

         <tr>
              <th scope="row">
              {{$item->id}}
              </th>
              <td class="budget">
              {{$item->invoice_number}}

            </td>

            <td class="budget">
              {{$item->invoice_amount}}

            </td>

            <td class="budget">
              {{$item->created_at}}

            </td>




              <td class="text-right">
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                    data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                        title="Delete">&#xE872; Delete</i></a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </div>
              </td>


            </tr>


         @endforeach



          </tbody>
        </table>

      </div>

    </div></div>

    <div class="modal fade deleteEmployeeModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <form id="form_delete" method="POST">
                  @csrf
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


                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$(document).ready(function () {

$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students/invoices_delete')}}/"+id;
    $('#form_delete').attr("action", url);


});

});
</script>


@endsection
