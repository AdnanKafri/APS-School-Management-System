@extends('website.layouts.app')

@section('css')
<style>
   
    @media (min-width:200px) and (max-width:449px){
       .newrow{
       
          position: relative;
           left: 27px !important; 
       }
    }
    @media (min-width:450px) and (max-width:759px){
        .newrow{
       
       position: relative;
        left: 70px !important; 
    }
    }
    @media (min-width:800px) and (max-width:975px){
        .newrow{
             position: relative;
             left: 70px !important
        }
    }
    @media (min-width:980px) and (max-width:1022px){
         .newrow{
            position: relative;
            left: 50px !important
         }
    }
   </style>
@endsection
@section('contain')


  @if (LaravelLocalization::setLocale()=="ar")
    <section id="topOfPage" class="topTabsWrapen" >
        <div class="container ar_con">
    
            <div class="row">
                <div class="col-sm-12" style="margin-left: -67px">
                    <div class="speedBar ">
                        <a class="home" href="{{ route('website.index') }}#top"> {{ __('site.Home') }} </a>
                        <span class="breadcrumbs_delimiter"> </span>
                        <a class="all" href="#">/</a>
                        <span class="breadcrumbs_delimiter"></span>
    
                        <span class="current">
                              @if (LaravelLocalization::setLocale()=="ar")
                            {{ $classes->name }}
                            @else
                            {{ $classes->name_en }}
                            @endif

                        </span>
                    </div>
                    
              
                   
                </div>
            </div>
        </div>
    </section>
    @endif
    
    @if (LaravelLocalization::setLocale()=="en")
    <section id="topOfPage" class="topTabsWrapar " >
        <div class="container ar_con">
            <div class="row">
                <div class="col-sm-12" style="margin-left: -30px">
                    <div class="speedBar ">
                        <a class="home" href="{{ route('website.index') }}#top">{{ __('site.Home') }} </a>
                        <span class="breadcrumbs_delimiter"> </span>
                        <a class="all" href="#">/</a>
                        <span class="breadcrumbs_delimiter"></span>
    
                        <span class="current">

                            @if (LaravelLocalization::setLocale()=="ar")
                            {{ $classes->name }}
                            @else
                            {{ $classes->name_en }}
                            @endif

                        </span>
    
                    </div>
         
                </div>
            </div>
        </div>
    </section>
    @endif

  


    <section class="mainWrap">
         <div class="container">
              <!--our books -->
              <h2 class="ar_con"> @if (LaravelLocalization::setLocale()=="ar")
                {{ $classes->name }}
                @else
                {{ $classes->name_en }}
                @endif
            </h2>
              <div class="sc_blogger sc_blogger_horizontal style_portfolio4 portfolioWrap">
                  <section class="newcol portfolio isotopeElement  folio4col" data-columns="4"  >
                    <div class="newrow" style="position: relative; left:161px;top: 25px;">
                    @foreach ($classes->lessons as $class)
                    @if ($class->books != null)
                        @foreach (json_decode($class->books) as $item)
                  
                 
                    <article class="isotopeElement hover_Shift isotopeElementShow" style="top: -39px !important;" >
                          <div class="ih-item colored circle effect10 bottom_to_top">
                              <a   @if ($item->type == "link")
                                href="{{ $item->value }}"
                            @else
                                href="{{ asset('storage/'.$item->value) }}"
                            @endif
                            class="taphover">
                                  <div class="img">
                                      <img alt="Vestibulum ut lacus et magna" src="{{ asset('website/img/portfolio/portfolio16x9_8-287x287.jpg') }} ">
                                  </div>
                                  <div class="info">
                                      <div class="info-back">
                                          <h4>{{ __('site.Download') }} </h4>

                                      </div>
                                  </div>
                                  <br>

                                  <a  @if ($item->type == "link")
                                    href="{{ $item->value }}"
                                @else
                                    href="{{ asset('storage/'.$item->value) }}"
                                @endif class="btn btn-primary"
                                   style="margin-left: 65px !important;margin-bottom: 20px !important; 
                                     position:relative; top:-14px !important
                                   ">{{ str_replace('_', '-', app()->getLocale()) == "en" ? $item->name_en : $item->name_ar }}  </a>

                              </a>

                         
                      </article>
                      @endforeach
                      @endif

                  @endforeach
                    </div>
                  </section>
              </div>
              <!--end our books -->
        </div>




    </section>
    @endsection
    @section('js')
@endsection


