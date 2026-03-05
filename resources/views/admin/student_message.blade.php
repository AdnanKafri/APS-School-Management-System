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
</style>
<style>
    .para{
        margin-bottom: 0rem
    }
   .speech-row {
display: flex;
justify-content: center;
}
.speech-img {
align-self: center;
max-width: 100%;
height: auto;

}
.speech-img img {
border-radius: 50%;
}
.speech-bubble {
max-width: 300px;
font-family: sans-serif;
margin: 1rem;
padding: 1rem;
position: relative;
border: 2px solid #f38639;
background: #fff;
border-radius: 0.4em;
}
.speech-bubble:before, .speech-bubble:after {
content: '';
position: absolute;
left: 0;
top: 50%;
width: 0;
height: 0;
border: 20px solid transparent;
border-right-color: #f38639;
border-left: 0;
margin-top: -20px;
margin-left: -20px;
}
.speech-bubble:after {
border-right-color: #fff;
margin-left: -18px;
z-index: 1;
}
.nav1-item{
width: 220px;

}
.nav-link{
color: #2c71ad;
}
.nav-link :focus {
color: #2c71ad;
}

.tab-content{
padding-left: 50px;
}


.text-1{
font-size: small;
color: rgba(177, 171, 171, 0.979);
padding-left: 30px;
}
.speech-img{

margin-right: 10px;
}


p {
word-wrap: anywhere
}

</style>
@endsection
@section('breadcrumbs')

<nav class="breadcrumbs">
     <a  class="breadcrumbs__item is-active"> الرسائل  </a>

    <a  href="{{ route('student_contact') }}" class="breadcrumbs__item ">قسم   تواصل الطلاب </a>
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



        <section style="background-color: #eee;">
            <div class="container py-5">

              <div class="row">


                <div class="col-md-12
                 col-lg-10 col-xl-10">

                  <ul class="list-unstyled">
                    @foreach ( $s_mess as $item )
                    @if ($item->type==0)
                      <li class="d-flex justify-content-between mb-4" >

                        <i class='fas fa-user-tie' style="width: 6%;
                        font-size: 248%;"></i>

                        <div class="card" style="width: 93%;">
                          <div class="card-header d-flex justify-content-between p-3">
                            <p class="fw-bold mb-0">الادارة </p>
                            <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{ $item->created_at }}  </p>

                        </div>
                          <div class="card-body">
                            <p class="mb-0">
                                {{ $item->message }}
                            </p>
                          </div>
                        </div>
                      </li>
                    @else
                       <li class="d-flex justify-content-between mb-4">
                        <div class="card w-100" style="margin-left: 5px;">
                          <div class="card-header d-flex justify-content-between p-3">
                            <p class="fw-bold mb-0">{{ $item->student->first_name }}  {{ $item->student->last_name }}</p>
                            <p class="text-muted small mb-0"><i class="far fa-clock"></i>{{ $item->created_at }} </p>
                          </div>
                          <div class="card-body">
                            <p class="mb-0">
                                {{ $item->message }}
                            </p>
                          </div>
                        </div>
                        @if($item->student->image)
                        <img src="{{ asset('storage/'. $item->student->image) }}" alt="avatar"
                          class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                          @else
                          <i class='fas fa-user-tie' style="width: 6%;
                        font-size: 248%;"></i>
                          @endif
                      </li>

                    @endif

                    @endforeach

                    <form id="form_delete" action="{{route('send_message_admin_reply')}}" method="POST">
                        @csrf

                    <li class="bg-white mb-3">
                      <div class="form-outline">

                         <input type="text" hidden name="student" value="{{ $student->id  }}">
                        <textarea class="form-control" name="message" id="textAreaExample2" placeholder="Message" rows="4"></textarea>
                        {{-- <label class="form-label" for="textAreaExample2"></label> --}}
                      </div>
                    </li>
                    <button type="submit" class="btn btn-info btn-rounded float-end">Send</button>
                    </form>
                  </ul>

                </div>

              </div>

            </div>
          </section>



    </div>


@endsection
