@extends('website.layouts.app')

@section('css')
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

                            {{ __('site.Contact Us') }}

                        </span>
                    </div>
                    <h3 class="pageTitle h3">{{ __('site.Contact Us') }}</h3>
                </div>
            </div>
        </div>
    </section-->
    
     <!--new navbar image-->
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
                            {{ __('site.Contact Us') }}
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
                         
                            {{ __('site.Contact Us') }}
                           
                        </span>
                        
    
                    </div>
              
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--end navbar image-->
    

    <section class="mainWrap">
        <div class="container ar_con">
            <div class="row">
                <div class="col-sm-12">

                    <div class="columnsWrap">
                        <div class="col-sm-6 sc_column_item">
                            <figure class="sc_image  sc_image_shape_square">
                                <img src="{{ asset('storage/'.$footer->img) }}" alt="">
                            </figure>
                        </div>
                        <div class="col-sm-6 sc_column_item">
                            <h1 style="font-size: 30px; color:#001e4b">{{ $footer->title }}</h1>
                            <p>{!! $footer->content !!}</p>
                            <h1 style="font-size: 30px; color:#001e4b"> {{ __('site.Business hours') }} </h1>
                            <p>
                                <strong>
                                    
                                    {!! $footer->business_hours !!}
                                    {{-- Monday – Friday 9am to 5pm
                                    <br>
                                    Saturday – 9am to 2pm
                                    <br>
                                    Sunday – Closed --}}
                                </strong>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="sc_contact_form sc_contact_form_contact">
                        <h1 class="title" style="font-size: 30px; color:#001e4b">{{ __('site.Send Us a Message') }} </h1>
                        <form  data-formtype="contact"  action="{{ route('website.contact.store') }}" method="post" >
                            @csrf

                            <div class="columnsWrap">
                                <div class="col-sm-4">
                                    <label class="required" for="sc_contact_form_username">{{ __('site.Name') }}</label>
                                    <input id="sc_contact_form_username" type="text" name="name" required data-error="Name is required.">
                                </div>
                                <div class="col-sm-4">
                                    <label class="required" for="sc_contact_form_email"> {{ __('site.E-mail') }}</label>
                                    <input id="sc_contact_form_email" type="text" name="email" required data-error="Valid email is required.">
                                </div>
                                <div class="col-sm-4">
                                    <label class="required" for="sc_contact_form_subj">{{ __('site.Subject') }}</label>
                                    <input id="sc_contact_form_subj" type="text" name="subject" required data-error="Subject is required.">
                                </div>
                            </div>
                            <div class="message">
                                <label class="required" for="sc_contact_form_message">{{ __('site.Your Message') }}</label>
                                <textarea id="sc_contact_form_message" class="textAreaSize" name="message_ar"></textarea>
                            </div>
                            <div class="sc_contact_form_button">
                                <div class="squareButton ico">
                                    <button type="submit" style="height: 28px;
                                    line-height: 28px;
                                    display: block;
                                    border: 1px solid #ddd;
                                    padding: 0 9px;
                                    color: #777;
                                    position: relative;
                                    font-size: 14px;
                                    font-weight: 300;
                                    background-color: #fff;
                                    overflow: hidden;" class=" icon-comment">{{ __('site.Send Message') }}</button>
                                </div>
                            </div>
                            <div class="result sc_infobox"></div>
                        </form>
                    </div>
                </div>
            </div>

            


        </div>
    </section>

    @endsection

    @section('js')
    @endsection
