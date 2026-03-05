@extends('website.layouts.app')

@section('css')
 @if (LaravelLocalization::setLocale()=="ar")
 <style>
     .cv{
         direction: rtl;
     }
 </style>
 @else
  <style>
    .cv{
         direction: ltr;
     }
 </style>
 @endif
@endsection
@section('contain')





    <section style="background-color: #f8f8f8;">
        <div class="container ar_con ">
            <div class="row">


                @if(session()->has('success'))
                <div class="alert alert-success" style="    text-align: center;">
                    {{ session()->get('success') }}
                </div>
            @endif


                     <div class="row container  justify-content-center">
                         <div class="col-lg-12 grid-margin stretch-card">
                             <div class="card">
                                 <div class="card-body">
                                     <h4 class="card-title">{{ __('site.Join Our Team') }}</h4>

                                     <div class="table-responsive">
                                         <table class="table table-hover" style="color: black;
                                         background: white;
                                         box-shadow: -3px 2px 6px 2px;

                                         font-size: larger;
                                         font-weight: 500;
                                         text-align: center;">
                                             <thead>
                                                 <tr>
                                                     <th style="text-align: center;">{{ __('site.Job Title') }}</th>
                                                     <th style="text-align: center;">{{ __('site.Description') }}</th>
                                                     <th style="text-align: center;">{{ __('site.Created at') }}</th>
                                                     <th  style="text-align: center;">{{ __('site.Action') }}</th>

                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach ($jobs as $item)
                                                 @if ($item->type==0)
                                                 <tr style="text-align: center;">
                                                    <td>{{ $item->title }}</td>
                                                    <td style="width: 250px;">

                                                        {{ str_replace('     ', '', $item->description) }}


                                                    </td>
                                                    <td>{{ $item->created_at }}</td>

                                                    <td>
                                                        <a class="applicant" href=".createJobModal" data-id="{{ $item->id }}" data-toggle="modal">{{__('site.Send CV')}}</a>
                                                    </td>
                                                </tr>
                                                 @endif

                                                 @endforeach




                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>





            </div> <!-- row -->
             <div class="row">
                 <div class="col-lg-12">
                     <nav class="courses-pagination mt-50">
                         <ul class="pagination justify-content-center">


                             <div class="row">
                                 <div class="col-md-10">
                                     <i class="fa fa-angle-right1">   {{ $jobs->links() }}  </i>
                                 </div>
                             </div>


                         </ul>
                     </nav>  <!-- courses pagination -->
                 </div>
             </div>  <!-- row -->
         </div>
            </section>
            <div class="modal fade createJobModal">
                <div class="modal-dialog">
                    <div class="modal-content cv">
                        <form id="form_update" action="{{ route('website.applicant.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">Send CV</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">


                                <div class="form-group">
                                    <label>{{ __('site.First Name') }}</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="" style="direction: rtl" maxlength="100"
                                        placeholder="{{ __('site.Enter your first name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('site.Last Name') }}</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="" style="direction: rtl" maxlength="100"
                                        placeholder="{{ __('site.Enter your last name') }}" required>
                                </div>



                                <div class="form-group">
                                    <label>{{ __('site.E-mail') }}</label>
                                    <input type="email" name="email" class="form-control"
                                        value=""  maxlength="100"
                                        placeholder="{{ __('site.Enter your email') }}" required>
                                </div>


                                <div class="form-group">
                                    <label>{{ __('site.Phone') }}</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="" style="" maxlength="20"
                                        placeholder="{{ __('site.Enter your phone') }}" required>
                                </div>



                                <div class="form-group">
                                    <label>{{ __('site.Cv') }}</label>

                                    <input type="file" name="cv_file" class="form-control" placeholder="test" required>

                                </div>

                                <input type="hidden" name="job_id" id="job_id">


                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">{{ __('site.Cancel') }}</a>
                                <button class="btn btn-info">{{ __('site.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


    @endsection

    @section('js')
    <script>
         $(document).on('click','.applicant',function(e){
        var job_id=$(this).data('id');

        $('#job_id').val(job_id);



    });

        </script>
    @endsection





