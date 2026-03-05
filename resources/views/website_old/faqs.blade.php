@extends('website.layouts.app')

@section('css')
<style>
    .card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.card {
    position: relative;
    display: -ms-flexbox;
    display: -webkit-box;
    display: flex;
    -ms-flex-direction: column;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 0.25rem;}
    .card-body {
    -ms-flex: 1 1 auto;
    -webkit-box-flex: 1;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.mb-5, .my-5 {
    margin-bottom: 3rem!important;
}
.mt-4, .my-4 {
    margin-top: 1.5rem!important;
}
.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}
.flex-column {
    -ms-flex-direction: column!important;
    -webkit-box-orient: vertical!important;
    -webkit-box-direction: normal!important;
    flex-direction: column!important;}
    .card-header:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}
.mb-0, .my-0 {
    margin-bottom: 0!important;
    padding: 9px;
    font-size: large;
}

h5{

    font-weight: 700 !important;
    color: #1d2025;
    margin: 0px;
    line-height: 1.2;
}
.card-body {
    -ms-flex: 1 1 auto;
    -webkit-box-flex: 1;
    flex: 1 1 auto;
    padding: 1.25rem;
}
</style>
@endsection
@section('contain')
@if (LaravelLocalization::setLocale()=="ar")



<section id="event-page" class="pt-90 pb-120 gray-bg">
    <div class="container">
       <div class="row" style="direction: rtl; text-align: right">

        <div class="col-md-12">

        <div class="card">
            <div class="card-header text-center" style="height: 48px;font-size: large;">
              <span>{{ __('site.FAQ & Knowledgebase') }}</span>
            </div>
            <div class="card-body">
              <div class="flex flex-column mb-5 mt-4 faq-section">
                <div class="row">
                  <div class="col-md-12">
                    <div id="accordion">

                        @foreach ($faqs as $item)

                      <div class="card">
                        <div class="card-header" id="heading-2">
                          <h5 class="mb-0">
                            <a class="collapsed"   style="  color: #13a3ee  !important;
                            text-decoration: none;
                            background-color: transparent;
                            -webkit-text-decoration-skip: objects;"role="button" data-toggle="collapse" href="#collapse-{{ $item->id }}" aria-expanded="false" aria-controls="collapse-2">
                            {{ $item->message }}
                            </a>
                          </h5>
                        </div>
                        <div id="collapse-{{ $item->id }}" class="collapse" data-parent="#accordion" aria-labelledby="heading-2">
                          <div class="card-body">

                            {{ $item->answer }}
                        </div>
                        </div>
                      </div>

                      @endforeach

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


        </div>

    </div>
</section>









@else





<section id="event-page" class="pt-90 pb-120 gray-bg">
    <div class="container">
       <div class="row">
        <div class="col-md-12">


        <div class="card">
            <div class="card-header text-center" style="height: 48px;font-size: large;">
              <span>{{ __('site.FAQ & Knowledgebase') }}</span>
            </div>
            <div class="card-body">
              <div class="flex flex-column mb-5 mt-4 faq-section">
                <div class="row">
                  <div class="col-md-12">
                    <div id="accordion">

                        @foreach ($faqs as $item)

                      <div class="card">
                        <div class="card-header" id="heading-2">
                          <h5 class="mb-0">
                            <a class="collapsed"  style="  color: #13a3ee  !important;
                            text-decoration: none;
                            background-color: transparent;
                            -webkit-text-decoration-skip: objects;" role="button" data-toggle="collapse" href="#collapse-{{ $item->id }}" aria-expanded="false" aria-controls="collapse-2">
                            {{ $item->message }}
                            </a>
                          </h5>
                        </div>
                        <div id="collapse-{{ $item->id }}" class="collapse" data-parent="#accordion" aria-labelledby="heading-2">
                          <div class="card-body">

                            {{ $item->answer }}
                        </div>
                        </div>
                      </div>

                      @endforeach

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


          </div>


    </div>
</section>








@endif

@endsection
@section('js')

<script>


$(document).on('click','.applicant',function(e){
    var job_id=$(this).data('id');

    $('#job_id').val(job_id);



});



</script>
@endsection
