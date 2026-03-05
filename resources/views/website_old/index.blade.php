@extends('website.layouts.app')

@section('css')
@endsection
@section('contain')
<style>
  /* For iPhone 4 Portrait or Landscape View */
@media(min-width: 320px) and (max-width:536px)
 {
    .responsiv{
            margin-left: 37px !important
        }
}

@media(min-width: 540px) and (max-width:739px)
 {
    .responsiv{
            margin-left: 55px !important
        }
}
@media(min-width: 739px) and (max-width:1193px)
 {
    .responsiv{
            margin-left: 83px !important
        }
}
 
     /*design for classes*/
     @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


.section{
  position: relative;  
  height: 450px;
 /* width: 1075px;*/
  display: flex;
  align-items: center;
}

.swiper{
  width: 950px;
}

.cardd{
  
  position: relative;
  background: #fff;
  border-radius: 20px;
  margin: 20px 0;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

.cardd::before{
  content: "";
  position: absolute;
  height: 40%;
  width: 100%;
 /* background: #7d2ae8;*/
  border-radius: 20px 20px 0 0;
}

.cardd .card-content{
  display: flex;
  flex-direction: column;
  align-items: center;
 /* padding: 30px;*/
 padding-bottom: 14px !important;
  position: relative;
  z-index: 100;
}

section .cardd .image{
  height: 140px;
  width: 140px;
  border-radius: 50%;
  padding: 3px;
  background: #7d2ae8;
}

section .cardd .image img{
  height: 100%;
  width: 100%;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #fff;
}

.cardd .media-icons{
  position: absolute;
  top: 10px;
  right: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.cardd .media-icons i{
  color: #fff;
  opacity: 0.6;
  margin-top: 10px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.cardd .media-icons i:hover{
  opacity: 1;
}

.cardd .name-profession{
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 10px;
  color: ;
} 

.name-profession .name{
  font-size: 20px;
  font-weight: 600;
}

.name-profession .profession{
  font-size:15px;
  font-weight: 500;
}

.cardd .rating{
  display: flex;
  align-items: center;
  margin-top: 18px;
}

.cardd .rating i{
  font-size: 18px;
  margin: 0 2px;
  color: #7d2ae8;
}

.cardd .button{
  width: 100%;
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
}

.cardd .button button{
  background: #7d2ae8;
  outline: none;
  border: none;
  color: #fff;
  padding: 8px 22px;
  border-radius: 20px;
  font-size: 14px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.button button:hover{
  background: #6616d0;
}

.swiper-pagination{
  position: absolute;
}

.swiper-pagination-bullet{
  height: 7px;
  width: 26px;
  border-radius: 25px;
  background: #7d2ae8;
}

.swiper-button-next, .swiper-button-prev{
  opacity: 0.7;
  color: #7d2ae8;
  

  transition: all 0.3s ease;
}
.swiper-button-next:hover, .swiper-button-prev:hover{
  opacity: 1;
  color: #7d2ae8;
}
@media (max-width:412px){
    .swiper-button-next, .swiper-button-prev{
        margin-top: -170px !important;
    }
}
     /*end design for classes*/
     .navcard{
        color: #fff !important;
     }
     .navcard:hover{
        color: #001e4b !important
     }

</style>



    <section>
        <div class="sliderHomeBullets staticSlider slider_engine_royal slider_alias_4">
            <div class="royalSlider">
                @php
                $i=0;
                @endphp
                @foreach($sliders as $item)
                 @php
                $i=$i+1;
                @endphp
                @if($i%2!=0)
                  <div class="slideContent slide-1" style="background-image:url('{{ asset('storage/'.$item->image) }}')">
                    <div class="">
                        <!--<img alt="" class="rsABlock image"-->
                        <!--data-fade-effect="none" data-move-effect="left" data-opposite="true"-->
                        <!--data-move-offset="900" data-delay="200" data-speed="900" data-easing="easeOutBack" -->
                        <!--src="{{ asset('storage/'.$item->image) }}" data-rsw="1020" data-rsh="500">-->
                        <div class="rsABlock textBlock theme_accent" data-fade-effect="none" data-move-effect="left" data-opposite="true" data-move-offset="1200" data-delay="700" data-speed="1200" data-easing="" data-rsw="707" data-rsh="471">
                            <!--<div class="title"> {{ __('site.Welcome to Smart Syrian School') }}</div>-->
                            <!--<p>  {{ __('site.Your Children are Safe With Us!') }}    </p>-->
                   
                                <div class="title">  <p style=" max-width: 30ch;">{{$item->header}}</p> </div>
                            
                            <!--<p>  {{ __('site.Your Children are Safe With Us!') }}    </p>-->
                            
                        </div>
                        <!--div class="rsABlock order" data-fade-effect="none" data-move-effect="bottom" data-opposite="true" data-move-offset="950" data-delay="1500" data-speed="900" data-easing="" data-rsw="707" data-rsh="471">
                            <a href="#">Purchase Now</a>
                        </div-->
                    </div>
                </div>
                @else
                
                <div class="slideContent slide-2" style="background-image:url('{{ asset('storage/'.$item->image) }}')" >
                    <div class="">
                        <!--<img alt="" style="left:0%" class="rsABlock image" data-fade-effect="none" data-move-effect="left" -->
                        <!--data-opposite="true" data-move-offset="900" data-delay="200" data-speed="900" data-easing="easeOutBack" src="{{ asset('storage/'.$item->image) }}" data-rsw="1020" data-rsh="500">-->
                        <div class="rsABlock textBlock" data-fade-effect="none" data-move-effect="right" data-opposite="true" data-move-offset="900" data-delay="700" data-speed="1200" data-easing="" data-rsw="707" data-rsh="471">
                           
                                <div class="title">  <p style=" max-width: 20ch;color:white">{{$item->header}}</p> </div>
                              
                        </div>
                        <!--div class="rsABlock order" data-fade-
                            effect="none" data-move-effect="bottom" data-opposite="true" data-move-offset="950" data-delay="950" data-speed="900" data-easing="" data-rsw="707" data-rsh="471">
                            <a href="#">Learn with us!</a>
                        </div-->
                    </div>
                </div>
                @endif
                
                
                @endforeach
                
              
                
            </div>
        </div>
    </section>
    <!---satrt new card design-->
    <br>
    <br>
    
<section style="margin-top: 12% !important">   
        <div class="our-course-categories-two">
           <div class="container">
               <div class="row">
                   <div class="col-lg-12">
                       <div class="course-categories-two-wrap">
                          
                           <div class="coustom-col-3">
                               <!-- single-course-categories -->
                               <div class="single-course-categories-two  wow fadeInBottom " 
                               data-wow-duration="0.4s" style="background-color: #0093d1;">
                                   <div class="item-inner">
                                       <div class="cours-icon">
                                           <span class="coure-icon-inner1">
                                            <a href="{{ route('website.ourteam') }}" >
                                               <img src=" {{asset('website/our teames.png')}}" alt="" style="width: 50px">
                                            </a>
                                           </span>
                                       </div>
                                       <div class="cours-title" >
                                        {{--@if (LaravelLocalization::setLocale()=="ar")
                                        <h4>{{ $dav[0]->title_ar }} </h4>
                                        @else
            
                                            <h4>{{ $dav[0]->title_en }} </h4>
                                       
                                        @endif--}}
                                          <h4><a class="navcard"   href="{{ route('website.ourteam') }}"> {{__('site.Our team')}}</a></h4>
                                         {{--  <p>  @if (LaravelLocalization::setLocale()=="ar")
                                            {{ $dav[0]->text_ar }}
                                            @else
                                            {{ $dav[0]->text_en }}
                                            @endif </p>--}}
                                            <p>{{$advantages->ourteams}}</p>
                                           
                                       </div>
                                   </div>
                               </div><!--// single-course-categories -->
                           </div>
                           
                           <div class="coustom-col-3">
                               <!-- single-course-categories -->
                               <div class="single-course-categories-two sunglow 
                                wow fadeInBottom" data-wow-duration="0.8s">
                                   <div class="item-inner">
                                       <div class="cours-icon">
                                           <span class="coure-icon-inner2">
                                            <a href="{{ route('website.jobs') }}" >
                                               <img src="{{asset('website/join us.png')}}" alt="" style="width: 50px">
                                            </a>
                                           </span>
                                       </div>
                                       <div class="cours-title">
                                      {{--  @if (LaravelLocalization::setLocale()=="ar")
                                        <h4>{{ $dav[1]->title_ar }} </h4>
                                        @else
            
                                            <h4>{{ $dav[1]->title_en }} </h4>
                                        
                                        @endif--}}
                                        <h4><a  class="navcard"   href="{{ route('website.jobs') }}"> {{__('site.Join us')}}</a></h4>

                                          {{-- <p>  
                                             @if (LaravelLocalization::setLocale()=="ar")
                                            {{ $dav[1]->text_ar }}
                                            @else
                                            {{ $dav[1]->text_en }}
                                            @endif </p>--}}
                                            <p>{{$advantages->joinus}}</p>
                                          
                                       </div>
                                   </div>
                               </div><!--// single-course-categories -->
                           </div>
                           
                           
                           <div class="coustom-col-3">
                               <!-- single-course-categories -->
                               <div class="single-course-categories-two mariner  wow fadeInBottom" data-wow-duration="1.2s">
                                   <div class="item-inner">
                                       <div class="cours-icon">
                                           <span class="coure-icon-inner3">
                                            <a href="{{ route('website.register') }}" >
                                               <img src="{{asset('website/new student .png')}}" alt="" style="width: 50px">
                                            </a>
                                           </span>
                                       </div>
                                       <div class="cours-title">
                                       {{-- @if (LaravelLocalization::setLocale()=="ar")
                                        <h4>{{ $dav[2]->title_ar }} </h4>
                                        @else
            
                                            <h4>{{ $dav[2]->title_en }} </h4>
                                        
                                        @endif--}}
                                         <h4><a class="navcard" href="{{ route('website.register') }}" >{{__('site.Register student')}}</a></h4>
                                       {{-- <p>  
                                            @if (LaravelLocalization::setLocale()=="ar")
                                           {{ $dav[2]->text_ar }}
                                           @else
                                           {{ $dav[2]->text_en }}
                                           @endif </p>--}}
                                           <p>{{$advantages->register}}</p>
                                       </div>
                                   </div>
                               </div><!--// single-course-categories -->
                           </div>
                           
                           <div class="coustom-col-3">
                               <!-- single-course-categories -->
                               <div class="single-course-categories-two brilliantrose  wow fadeInBottom" data-wow-duration="1.6s">
                                   <div class="item-inner">
                                       <div class="cours-icon">
                                           <span class="coure-icon-inner4">
                                            <a href="#classes" >
                                               <img src="{{asset('website/our class.png')}}" alt="" style="width: 50px">
                                            </a>
                                           </span>
                                       </div>
                                       <div class="cours-title" >
                                       {{-- @if (LaravelLocalization::setLocale()=="ar")
                                        <h4>{{ $dav[3]->title_ar }} </h4>
                                        @else
            
                                            <h4>{{ $dav[3]->title_en }} </h4>
                                        
                                        @endif--}}
                                        <h4>
                                         <a  class="navcard"  href="#classes" class="navcard">{{__('site.Our classes')}}</a>
                                        </h4>
                                          {{-- <p>  
                                            @if (LaravelLocalization::setLocale()=="ar")
                                           {{ $dav[3]->text_ar }}
                                           @else
                                           {{ $dav[3]->text_en }}
                                           @endif </p>--}}
                                           <p>{{$advantages->ourclasses}}</p>
                                       </div>
                                   </div>
                               </div><!--// single-course-categories -->
                           </div>
                           
                       </div>
                   </div>
               </div>
           </div>
       </div>
       </section>  
    <!--end new card design-->
  

 <!--start yalow section-->
{{--    <section class="text-center color_section">
        <div class="container">
            <div class="row">
                <div class="sc_content user_header">
                    <h2 class="sc_title sc_title_regular">{{ __('site.What We Offer') }}</h2>
                    <div class="col-md-3 col-sm-6">
                        <a href="#">
                            <span class="sc_icon rt-icon-diamond "></span>
                        </a>

                        <div class="sc_section">
                            @if (LaravelLocalization::setLocale()=="ar")
                            <a href="#">{{ $dav[0]->title_ar }} </a>
                            @else

                                <a href="#">{{ $dav[0]->title_en }} </a>
                            </a>
                            @endif
                        </div>
                        <div class="sc_section">

                            @if (LaravelLocalization::setLocale()=="ar")
                            {{ $dav[0]->text_ar }}
                            @else
                            {{ $dav[0]->text_en }}
                            @endif
                            </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <a href="#">
                            <span class="sc_icon rt-icon-heart4 "></span>
                        </a>
                        <div class="sc_section">
                            @if (LaravelLocalization::setLocale()=="ar")
                            <a href="#">{{ $dav[1]->title_ar }} </a>
                            @else

                                <a href="#">{{ $dav[1]->title_en }} </a>
                            </a>
                            @endif
                        </div>
                        <div class="sc_section"> 
                            @if (LaravelLocalization::setLocale()=="ar")
                            {{ $dav[1]->text_ar }}
                            @else
                            {{ $dav[1]->text_en }}
                            @endif</div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="#">
                            <span class="sc_icon rt-icon-star "></span>
                        </a>
                        <div class="sc_section">
                            @if (LaravelLocalization::setLocale()=="ar")
                            <a href="#">{{ $dav[2]->title_ar }} </a>
                            @else

                                <a href="#">{{ $dav[2]->title_en }} </a>
                            </a>
                            @endif
                        </div>
                        <div class="sc_section">   @if (LaravelLocalization::setLocale()=="ar")
                            {{ $dav[2]->text_ar }}
                            @else
                            {{ $dav[2]->text_en }}
                            @endif</div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="#">
                            <span class="sc_icon rt-icon-clipboard "></span>
                        </a>
                        <div class="sc_section">
                            @if (LaravelLocalization::setLocale()=="ar")
                            <a href="#">{{ $dav[3]->title_ar }} </a>
                            @else

                                <a href="#">{{ $dav[3]->title_en }} </a>
                            </a>
                            @endif
                        </div>
                        <div class="sc_section">   @if (LaravelLocalization::setLocale()=="ar")
                            {{ $dav[3]->text_ar }}
                            @else
                            {{ $dav[3]->text_en }}
                            @endif </div>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}
    <!--end yallow section-->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="sc_parallax light" data-parallax-speed="0.3" data-parallax-x-pos="50%" data-parallax-y-pos="50%">
                    <div class="sc_parallax_content parallax_bg5" >
                        <div class="container">
                            <div class="sc_section sc_alignright col-sm-6 text-center">
                                <h1 class="sc_title sc_title_regular theme_accent margin_top_big"  style="font-size: 30px !important;color: #001e4b;">
                                    {{ __('site.About us') }}
                                </h1>
                                <h3 class="sc_title sc_title_divider theme_accent2" style="font-size: 17px !important;">
                                    <span class="sc_title_divider_before"></span>
                                    {{ __('site.Popular information') }}
                                    <span class="sc_title_divider_after"></span>
                                </h3>
                                <div>
                                  <p>{{ $about_us->popular_information }}</p>
                                </div>
                                <div class="sc_section margin_top_small margin_bottom_big">
                                    <!--div class="sc_button sc_button_style_global sc_button_size_big theme_accent_bg squareButton global big margin_right_mini">
                                        <a href="#" class="">Purchase now</a>
                                    </div-->
                                    <div class="sc_button sc_button_style_global sc_button_size_big theme_accent_bg squareButton global big">
                                        <a href="{{route('website.about_us')  }}" class="">{{ __('site.Learn more') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


      <!---new design-->
           <!--new design for classes-->
           <div class="row" id="classes">
            <div class="col-sm-12">
                <h2 class="sc_title sc_title_regular text-center margin_bottom_mini" 
                style="font-size: 35px !important;color: #001e4b;padding-top:39px !important ;padding-bottom:0px !important">
                    {{ __('site.Our classes') }}</h2>
            </div>
        </div>
    <div class="section">
    
        <div class="swiper mySwiper container">
          <div class="swiper-wrapper content">

            <!--new -->
           
        
            <!--end new -->
            @foreach($classes as $item)
            <div class="swiper-slide cardd" style="width: 240.667px!important"> <!--start card-->
              <div class="card-content" > 
                
                    <img src="{{ asset('storage/'.$item->image) }}" alt="" >
                
    
                <div class="rating">
                  
                
                <span style="color: #001e4b">
                    @if (LaravelLocalization::setLocale()=="ar")
                    <a style="color: #001e4b" href="{{route('website.book',$item->id)}}">{{ $item->name }}</a>
                    @else
                    <a style="color: #001e4b" href="{{route('website.book',$item->id)}}">{{ $item->name_en }}</a>
                    @endif
                </span>
            </div>
    
                <div class="button">
                 
                   
                
                  <!--button class="hireMe">Hire Me</button-->
                  <div class="relatedMore">
                    <ul>
                        <li class="squareButton light ico" style="margin-left: 13px;">
                            <a style="margin-left: -20px;" class="fa-link" 

                            title="More" href="{{route('website.book',$item->id)}}">

                                @if (LaravelLocalization::setLocale()=="ar")

                                {{ count($item->lessons )}}  مادة
                            @else
                            {{ count($item->lessons )}}  Lessons
                        @endif   
                    </a>
                        </li>

                    </ul>
                </div>
                </div>

              </div>
            </div><!--end card-->
            @endforeach


    
          </div>
        </div>
        <br>
        <br>
    
          <div class="swiper-button-next" style="color: #001e4b !important;"></div>
          <div class="swiper-button-prev" style="color: #001e4b !important"></div>
          <!--div class="swiper-pagination"></div-->

    </div><!--end section-->
    <!--end design for classes-->
      <!--end new design-->



  <br>
  <br>
  <br>

    <section id="course-part" class=" gray-bg ">
        <div class="row" style="margin-right:0 !important">
            <div class="col-lg-2" style="width:8% !important"></div>
            <div class="col-lg-10 responsiv" 
            style="width:85%">

<video class="video-fluid z-depth-1" style="width:110%" autoplay loop controls muted>
    <!--source src="https://smartsyrianschool.com/storage/videosfiles/em4N9fO6x9s2kTSJknUqhKJaE53RpBOu8qcVFxOn.mp4"
     type="video/mp4" /-->
     <source src="{{ asset('storage/'.$other->img3) }}">

  </video>


            </div>
    </div>
</section>


   {{-- <section style="background-color: #f8f8f8;">
        <div class="container-fluid">
            <div class="row">

             <div class="col-md-6">
                <div class="sc_parallax light" data-parallax-speed="-0.2" data-parallax-x-pos="50%" data-parallax-y-pos="50%">
                    <div class="sc_parallax_content ">
                        <div class="sc_content container margin_top_big margin_bottom_big ">
                            <div class="col-sm-6 sc_column_item">
                                <h2 class="text-center">
                                    {{ __('site.Our News') }}
                                    <br>

                                </h2>
                                @php
                                     $i=0;
                                @endphp
                                @foreach ( $news as $item )

                                  @if ($item->type==1)
                                  @php
                                  $i=$i+1
                                   @endphp
                                  <div class="sc_section margin_top_small">
                                    <div class="sc_title_image sc_title_left sc_size_medium">
                                        @if ($i%2==0)
                                        <img src=" {{ asset('website/img/hand_icon_retina.png ') }} " alt="">
                                         @else

                                         <img src=" {{ asset('website/img/lens_icon_retina.png') }} " alt="">
                                         @endif

                                    </div>
                                    <h3 class="sc_title sc_title_iconed">{{ $item->title }}</h3>
                                    {{ $item->content }}
                                </div>
                                  @endif
                                @endforeach


                                <br>
                                <br>
                                <a href="{{ route('website.news') }}" class="btn btn-primary"
                                > {{ __('site.Learn more') }}  </a>
                            </div>
                        </div>
                    </div>
                     <!-- button for learn more-->


                </a>

                 <!--end button for learn more-->
                </div>
            </div><!--end col-->
            <div class="col-md-6 light" data-parallax-speed="-0.2" data-parallax-x-pos="50%" data-parallax-y-pos="50%" style="padding-top: 80px;">
                 <img src="{{ asset('storage/'.$other->img3) }}">

            </div>





            </div>
        </div>
    </section>
--}}
<br>
<br>
<br>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 3,
      spaceBetween: 30,
      slidesPerGroup: 3,
      loop: true,
      loopFillGroupWithBlank: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>
    


    @endsection

    @section('js')
    @endsection





