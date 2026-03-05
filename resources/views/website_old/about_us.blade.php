
@extends('website.layouts.app')

@section('css')
<style>
  /*  .cards-list {
  z-index: 0;
  width: 100%;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
}

.card {
  overflow: auto;
    margin: 30px auto;
    width: 300px;
    height: 300px;
    border-radius: 40px;
    box-shadow: -4px 2px 2px 0px rgb(0 0 0 / 25%), -5px -5px 4px 8px rgb(0 0 0 / 10%);
    cursor: pointer;
    transition: 0.4s;
}
.card::-webkit-scrollbar {
  width: 16px;
}

/* Track 
.card::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 10px;
}

/* Handle 
.card::-webkit-scrollbar-thumb {
  background: #acbdc5;
  border-radius: 10px;
}

/* Handle on hover 
.card::-webkit-scrollbar-thumb:hover {
  background: #425d69;
}

.card .card_image {
  width: inherit;
  height: inherit;
  border-radius: 40px;
}

.card .card_image img {
  width: inherit;
  height: inherit;
  border-radius: 40px;
  object-fit: cover;
}

.card .card_title {
    color: #000;

  padding: 13px;
  font-size: initial;
  border-radius: 0px 0px 40px 40px;
  font-family: sans-serif;
  /* font-weight: bold;
  font-size: 30px;
  margin-top: -80px;
  height: 40px; 
}

.card:hover {
  transform: scale(0.9, 0.9);
  box-shadow: 5px 5px 30px 15px rgba(0,0,0,0.25),
    -5px -5px 30px 15px rgba(0,0,0,0.22);
}

.title-white {
  color: white;
}

.title-black {
  color: black;
}

@media all and (max-width: 500px) {
  .card-list {
    /* On small screens, we are no longer using row direction but column *
    flex-direction: column;
  }
}*/
:root {
    --red: hsl(0, 78%, 62%);
    --cyan: hsl(180, 62%, 55%);
    --orange: hsl(34, 97%, 64%);
    --blue: hsl(212, 86%, 64%);
    --varyDarkBlue: hsl(234, 12%, 34%);
    --grayishBlue: hsl(229, 6%, 66%);
    --veryLightGray: hsl(0, 0%, 98%);
    --weight1: 200;
    --weight2: 400;
    --weight3: 600;
}


.attribution { 
    font-size: 11px; text-align: center; 
}
.attribution a { 
    color: hsl(228, 45%, 44%); 
}

h1:first-of-type {
    font-weight: var(--weight1);
    color: var(--varyDarkBlue);

}

h1:last-of-type {
    color: var(--varyDarkBlue);
}

@media (max-width: 400px) {
    h1 {
        font-size: 1.5rem;
    }
}

.header {
    text-align: center;
    line-height: 0.8;
    margin-bottom: 50px;
    margin-top: 100px;
}

.header p {
    margin: 0 auto;
    line-height: 2;
    color: var(--grayishBlue);
}


.box p {
    color: var(--grayishBlue);
}

.box {
    border-radius: 5px;
    box-shadow: 0px 30px 40px -20px var(--grayishBlue);
    padding: 30px;
    margin: 20px;  
}

.img {
    float: right;
}

@media (max-width: 450px) {
    .box {
       /* height: 200px;*/
    }
}

@media (max-width: 950px) and (min-width: 450px) {
    .box {
        text-align: center;
      /*  height: 180px;*/
    }
}

.cyan {
    border-top: 3px solid var(--cyan);
}
.red {
    border-top: 3px solid var(--red);
}
.blue {
    border-top: 3px solid var(--blue);
}
.orange {
    border-top: 3px solid var(--orange);
}

h2 {
    color: var(--varyDarkBlue);
    font-weight: var(--weight3);
}


@media (min-width: 950px) {
    .row1-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .row2-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .box-down {
        position: relative;
        top: 150px;
    }
    .box {
        width: 30%;
     
    }
    .header p {
        width: 30%;
    }
    
}

*{
    font-weight: 600!important;
}
</style>
@if (LaravelLocalization::setLocale()=="ar")
<style>
    .text_ar{
        text-align:right !important;
    }
</style>
@endif

@endsection
@section('contain')


    <!--section id="topOfPage" class="topTabsWrap color_section">
        <div class="container ar_con">
            <div class="row">
                <div class="col-sm-12">
                    <div class="speedBar ">
                        <a class="home" href="{{ route('website.index') }}#top">{{ __('site.Home') }} </a>
                        <span class="breadcrumbs_delimiter">  </span>
                        <a class="all" href="#">/</a>
                        <span class="breadcrumbs_delimiter"></span>

                        <span class="current">

                            {{ __('site.About us') }}

                        </span>
                    </div>
                    <h3 class="pageTitle h3">{{ __('site.About us') }} </h3>
                </div>
            </div>
        </div>
    </section-->
     <!--navbar with image-->
    @if (LaravelLocalization::setLocale()=="ar")
<section id="topOfPage" class="topTabsWrapen" >
    <div class="container ar_con">

        <div class="row">
            <div class="col-sm-12" style="margin-left: 20px">
                <div class="speedBar ">
                    <a class="home" href="{{ route('website.index') }}#top"> {{ __('site.Home') }} </a>
                    <span class="breadcrumbs_delimiter"> </span>
                    <a class="all" href="#">/</a>
                    <span class="breadcrumbs_delimiter"></span>

                    <span class="current">
                      {{ __('site.About us') }}
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
                     
                      {{ __('site.About us') }}
                       
                    </span>
                    

                </div>
          
            </div>
        </div>
    </div>
</section>
@endif

    <!--end navbar with image -->

    <section class="mainWrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 sc_column_item ar_con">
                    <div class="col-sm-6 sc_column_item margin_bottom_mini margin_right_mini">
                        <figure class="sc_image  sc_image_shape_square">
                            <img src="{{ asset('storage/'.$mor_det->img) }}" alt="">
                        </figure>
                    </div>
                    <h1 style="font-size: 30px !important">{{$mor_det['title_' .LaravelLocalization::getCurrentLocale()]}}</h1>
                    <p>{{$mor_det['text_' .LaravelLocalization::getCurrentLocale()]}}</p>

                </div>
            </div>
            <article class="postRight hrShadow post ar_con">
                <!--div class="post_info infoPost">
                    Posted
                    <a href="#" class="post_date">February 21, 2014</a>
                    <span class="separator">|</span>
                    by
                    <a href="#" class="post_author">John Doe</a>
                    <span class="separator">|</span>
                    <span class="post_cats">
                        in
                        <a class="cat_link" href="#">Post Formats,</a>
                        <a class="cat_link" href="#">Post formats fullwidth</a>
                    </span>
                </div-->
                <br>
                <br>
                <div class="sc_section  col-sm-6 sc_alignright margin_bottom_small">

                    <div class="sc_border sc_border_dark">
                        <div id="swiper_container_2" class="sc_slider sc_slider_swiper sc_slider_controls sc_slider_pagination swiper-container2">
                            <ul class="swiper-wrapper">
                                <li class="swiper-slide">
                                    <img src="{{ asset('storage/'.$mor_det->img_s1) }}" alt="">
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{ asset('storage/'.$mor_det->img_s2) }}" alt="">
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{ asset('storage/'.$mor_det->img_s3) }}" alt="">
                                </li>
                            </ul>
                            <ul class="flex-direction-nav">
                                <li>
                                    <a class="swiper-button-prev" href="#"></a>
                                </li>
                                <li>
                                    <a class="swiper-button-next" href="#"></a>
                                </li>
                            </ul>
                            <div class="flex-control-nav">
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>



                <h2 class="post_title" style="font-size: 30px">
                {{$mor_det['title1_' .LaravelLocalization::getCurrentLocale()]}}
                </h2>
                <div class="postGallery">
                    <p> </p>
                    <!--<div class="sc_title_image sc_title_left sc_size_medium">-->
                    <!--    <img src=" {{asset('website/img/lens_icon_retina.png')}}" alt="">-->
                    <!--</div>-->
                    <h3 class="sc_title sc_title_iconed" style="font-size: 25px">
                   {{$mor_det['title2_' .LaravelLocalization::getCurrentLocale()]}}</h3>
                    <p>{{$mor_det['text2_' .LaravelLocalization::getCurrentLocale()]}}</p>
                </div>


            </article>

           <br>
           <br>
           <!--new design of cards-->
        
          <div class="row1-container">
            <div class="box box-down cyan">
              <h2 style="font-size: 20px !important;text-align:center">{{ __('site.Our Objective') }}</h2>
              <p class="text_ar">{{ $about_us->objective }}</p>
              <!--<img class="img"  src="https://assets.codepen.io/2301174/icon-supervisor.svg" alt="" style="margin-top: -33px">-->
            </div>
        
            <div class="box red">
              <h2 style="font-size: 20px !important;text-align:center">{{ __('site.Our vission') }}</h2>
              <p class="text_ar">{{ $about_us->vission }}</p>
              <!--<img class="img"  src="https://assets.codepen.io/2301174/icon-team-builder.svg" alt="" style="margin-top: -33px">-->
            </div>
        
            <div class="box box-down blue">
              <h2 style="font-size: 20px !important;text-align:center">{{ __('site.Our Mission') }}</h2>
              <p class="text_ar">{{ $about_us->mission }}</p>
              <!--<img class="img"  src="https://assets.codepen.io/2301174/icon-calculator.svg" alt="" style="margin-top: -33px">-->
            </div>
          </div>
          <div class="row2-container">
            <div class="box orange">
              <h2 style="font-size: 20px !important;text-align:center">{{ __('site.Our Services') }}</h2>
              <p class="text_ar span">{{ $about_us->services }}</p>
              
                             <a class="button" style="
                                color: blue;
                            ">Read more ....</a>
              <!--<img class="img"   src="https://assets.codepen.io/2301174/icon-karma.svg" alt="" style="margin-top: -33px">-->
            </div>
          </div>
           <!--end new design of cards-->


           {{-- <div class="row">
                <div class="col-sm-12">

                    <div class="row">
                        {{-- <h2 class="text-center">Services</h2> 
                        <div class="cards-list">

                            <div class="card   ar_con1  1">
                              <div class="">
                                <h2 style="text-align: center;padding-bottom: 16px;
                                padding-top: 11px;">{{ __('site.Our Objective') }}</h2>
                              </div>
                              <div class="card_title title-white">
                                <p>{{ $about_us->objective }}</p>
                              </div>
                            </div>

                              <div class="card 2">
                              <div class="">
                                <h2 style="text-align: center;padding-bottom: 16px;
                                padding-top: 11px;">{{ __('site.Our vission') }}</h2>
                                </div>
                              <div class="card_title title-white">
                                <p> {{ $about_us->vission }} </p>
                              </div>
                            </div>

                            <div class="card 3">
                              <div class="">
                                <h2 style="text-align: center;padding-bottom: 16px;
                                padding-top: 11px;">{{ __('site.Our Mission') }}</h2>
                              </div>
                              <div class="card_title">
                                <p>{{ $about_us->mission }} </p>
                              </div>
                            </div>

                              <div class="card 4">
                              <div class="">
                                <h2 style="text-align: center;padding-bottom: 16px;
                                padding-top: 11px;">{{ __('site.Our Services') }}</h2>
                                </div>
                              <div class="card_title title-black">
                                <p class="span">{{ $about_us->services }} </p>
                                <button class="button">
                                Read more
                                </button>
                              </div>
                              </div>

                            </div>

--}}

                    </div>
                </div>
            </div>

        </div>
    </section>


    @endsection

    @section('js')
    <script>
        const span = document.querySelector('.span');
const text = span.innerText;
span.innerText = text.substring(0, 500);
let showAll = false;
const button = document.querySelector('.button');
button.addEventListener('click', () => {
  showAll = !showAll;
  span.innerText = showAll ? text : text.substring(0, 500);
  button.innerText = showAll ? 'Read less' : 'Read more ...';
});
    </script>
    @endsection
