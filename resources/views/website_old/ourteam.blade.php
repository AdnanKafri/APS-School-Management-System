@extends('website.layouts.app')

@section('css')
@endsection
@section('contain')
<style>
     
     .text-blk {
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  margin-left: 0px;
  line-height: 25px;
}

.responsive-cell-block {
  min-height: 75px;
}

.responsive-container-block {
  min-height: 75px;
  height: fit-content;
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  margin-top: 0px;
  margin-right: auto;
  margin-bottom: 0px;
  margin-left: auto;
  justify-content: space-evenly;
}

.outer-container {
  padding-top: 10px;
  padding-right: 50px;
  padding-bottom: 10px;
  padding-left: 50px;
 /* background-color: rgb(244, 252, 255);*/
}

.inner-container {
  max-width: 1320px;
  flex-direction: column;
  align-items: center;
  margin-top: 50px;
  margin-right: auto;
  margin-bottom: 50px;
  margin-left: auto;
}

.section-head-text {
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 5px;
  margin-left: 0px;
  font-size: 35px;
  font-weight: 700;
  line-height: 48px;
  color: rgb(0, 135, 177);
  margin: 0 0 10px 0;
}

.section-subhead-text {
  font-size: 25px;
  color: rgb(153, 153, 153);
  line-height: 35px;
  max-width: 470px;
  text-align: center;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 60px;
  margin-left: 0px;
}

.img-wrapper {
  width: 100%;
}

.team-card {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.social-media-links {
  width: 125px;
  display: flex;
  justify-content: space-between;
}

.name {
  font-size: 25px;
  font-weight: 700;
  color: rgb(102, 102, 102);
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 5px;
  margin-left: 0px;
  margin-right: 14px;
}

.position {
  font-size: 25px;
  font-weight: 700;
  color: rgb(0, 135, 177);
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 50px;
  margin-left: 0px;
}

.team-img {
        box-shadow: 1px 15px 19px -25px  black;
    border: 4px solid white;
    border-radius: 50%;
  width: 90%;
  height: 100%;
}

.team-card-container {
  width: 280px;
  margin: 0 0 40px 0;
}

@media (max-width: 500px) {
  .outer-container {
    padding: 10px 20px 10px 20px;
  }

  .section-head-text {
    text-align: center;
  }
}
    
</style>


   
    

    <!--navbar with image-->
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
                            كادرنا
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
                         
                          Our team
                           
                        </span>
                        
    
                    </div>
              
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--end navbar with iamge-->
    <!--teacher content-->
     @if($user->count()>0)
       <div class="responsive-container-block outer-container">
        <div class="responsive-container-block inner-container">
          <p class="text-blk section-head-text">
               @if (LaravelLocalization::setLocale()=="ar")
          الكادر الإداري
           @else
          The administrative staff
           @endif
          </p>
         
          <div class="responsive-container-block">
                @foreach($user as $item)
            <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
              <div class="team-card">
                <div class="img-wrapper"  style="padding-bottom: 28px;height: 280px;
    width: 280px;">
                 @if($item->img ==null)
                  
                <img class="team-img" src="{{ asset('admin/per.png') }}">
                @else
                 <img class="team-img" src="{{ asset('storage/'.$item->img) }}">
                @endif
                </div>
                  @if (LaravelLocalization::setLocale()=="ar")
                <p class="text-blk name">
                 {{$item->first_name_ar}}  {{$item->last_name_ar}}
                </p>
                
                <p class="text-blk position">
                 {{$item->discrption_ar}}
                </p>
                @else
                 <p class="text-blk name">
                 {{$item->first_name_en}}  {{$item->last_name_en}}
                </p>
                <p class="text-blk position">
                 {{$item->discrption_en}}
                </p>
                @endif
              
              </div>
            </div>
            @endforeach
           
          </div>
        </div>
      </div>
       @endif
     @if($teachers->count()>0)
    <div class="responsive-container-block outer-container">
      <div class="responsive-container-block inner-container">
            @if (LaravelLocalization::setLocale()=="ar")
        <p class="text-blk section-head-text">
     الكادر التعليمي
        </p>
        @else
         <p class="text-blk section-head-text">
      Teaching staff
        </p>
        @endif
       
        <div class="responsive-container-block">
          
          @foreach($teachers as $item)
          <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 team-card-container">
            <div class="team-card">
              <div class="img-wrapper" style="padding-bottom: 28px;height: 280px;
    width: 280px;">
                  @if($item->img ==null)
                  
                <img class="team-img" src="{{ asset('admin/per.png') }}">
                @else
                 <img class="team-img" src="{{ asset('storage/'.$item->img) }}">
                @endif
                
              </div>
               @if (LaravelLocalization::setLocale()=="ar")
              <p class="text-blk name">
                {{$item->first_name_ar}}  {{$item->last_name_ar}}
              </p>
              <p class="text-blk position">
                  {{$item->discrption_ar}}
              </p>
              @else
               <p class="text-blk name">
                {{$item->first_name_en}}  {{$item->last_name_en}}
              </p>
              <p class="text-blk position">
                  {{$item->discrption_en}}
              </p>
              @endif
             
            </div>
          </div>
     @endforeach
            <!--end card-->

        </div>
      </div>
    </div>
    @endif
    <!--end teacher content-->


       <!--Administrators content-->
     
      
      <!--end Administrators content-->
      <!--start pagination-->
      <div class="row" style="text-align: center">
        <div class="col-md-12">
             {{ $teachers->links() }}
        </div>
    </div>
      <!--end pagination-->

    @endsection

    @section('js')
    @endsection
