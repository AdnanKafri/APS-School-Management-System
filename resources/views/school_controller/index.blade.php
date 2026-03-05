@extends('school_controller.layouts.app')
@section('css')




@endsection
@section('content')



        <div class="main-panel" style="background: #f8f9fb;">
          <div class="content-wrapper pb-0">
            <div class="container">
               <div class="row">
                 <div class="col-md-12">
                   <!--tablist-->

                        <div class="card card-nav-tabs" style="direction: rtl;">

                            <!--name classes-->
                            <div class="card-header card-header-primary">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper" style="display: flex;justify-content: center;">
                                        <ul class="nav nav-tabs" data-tabs="tabs" style="justify-content: center;">
                                        @php
                                        $i=0;
                                        @endphp
                                        @foreach ($classes as $item )
                                        @php
                                        $i=$i+1;
                                        @endphp
                                        @if($i== 1)
                                            <li class="nav-item">
                                                <a  class="nav-link active" href="#tab-{{ $item->id }}"
                                                    aria-controls="#tab-{{ $item->id }}" role="tab" data-toggle="tab">{{ $item->name }}</a>
                                            </li>
                                            @else
                                            <li class="nav-item">
                                                <a  class="nav-link" href="#tab-{{ $item->id }}"
                                                    aria-controls="#tab-{{ $item->id }}" role="tab" data-toggle="tab">{{ $item->name }}</a>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    </div>
                                </div>
                            </div>
                            <!--end name classes-->


                            <div class="card-body ">
                                <div class="tab-content text-center">
                                    @php
                                    $i=0;
                                    @endphp
                                    @foreach ($classes as $item )
                                    @php
                                    $i=$i+1;
                                    @endphp


                                   {{-- <div class="tab-pane active" id="{{ $item->id }}">--}}

                                        <div role="tabpanel" @if($i == 1) class="tab-pane active"
                                         @else class="tab-pane" @endif id="tab-{{ $item->id }}">

                                       <div class="container animated bounceInLeft">
                                        <div class="row" style="justify-content: center;">
                                        @foreach ( $item->room_cor as $item1 )
                                          <div class="col-md-4" style="padding-bottom: 20px;">
                                            <a href="{{ route('dashboard.coordinator_subject',$item1->id ) }}">
                                            <div class="container4">
                                              <div class="card_box">
                                                  <span></span>
                                                  <h4 style="text-align: center; color: #fff;padding-top: 90px;">{{ $item1->name }}</h4>
                                              </div>
                                          </div>
                                          </a>
                                          </div>
                                          @endforeach
                                        </div>

                                       </div><!--container-->
                                    </div><!--tab-pane class-->
                                    @endforeach





                                </div><!--tab-content-->
                            </div><!--end card body-->

                          </div>
                        <!-- End Tabs with icons on Card -->

                    </div>
                   <!--end tablist-->

                 </div>

               </div>
          </div>
        </div>





    </div>
    </div>

    @endsection
    @section('js')
