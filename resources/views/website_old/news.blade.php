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

                            {{ __('site.Our News') }}

                        </span>
                    </div>
                    <h3 class="pageTitle h3">{{ __('site.Our News') }}</h3>
                </div>
            </div>
        </div>
    </section-->
     <!--navbar with image-->
    @if (LaravelLocalization::setLocale()=="ar")
    <section id="topOfPage" class="topTabsWrapen" >
        <div class="container ar_con">
    
            <div class="row">
                <div class="col-sm-12" style="margin-left: -59px">
                    <div class="speedBar ">
                        <a class="home" href="{{ route('website.index') }}#top"> {{ __('site.Home') }} </a>
                        <span class="breadcrumbs_delimiter"> </span>
                        <a class="all" href="#">/</a>
                        <span class="breadcrumbs_delimiter"></span>
    
                        <span class="current">
                            {{ __('site.Our News') }}
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
                         
                            {{ __('site.Our News') }}
                           
                        </span>
                        
    
                    </div>
              
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--end navbar with iamge-->

    <section class="portfolio_mansory_columns">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="style_portfolio_mc" class="masonryWrap">
                        <section class="masonry isotope" data-columns="3">

                            @foreach($news as  $item)
                            <article class="isotopeElement isotopeElementShow ar_con">
                                <div class="isotopePadding">
                                    <div class="thumb hoverIncrease" data-image="{{ asset('storage/'.$item->image1) }}" data-title="Donec lacinia elementum nunc">
                                        <img alt="Donec lacinia elementum nunc" src="{{ asset('storage/'.$item->image1) }}" style="height:225px">
                                    </div>
                                    <h4>
                                        <a style="color: rgb(0,30,75)" href="{{route('website.news.single',$item->id)}}">{{$item['title_'.LaravelLocalization::getCurrentLocale()]}}</a>
                                    </h4>
                                    <p style="height:50px; overflow:hidden">{{$item['content_'.LaravelLocalization::getCurrentLocale()]}}.. </p>
                                    <div class="masonryInfo">
                                        {{ __('site.Posted') }}
                                        <a href="#" class="post_date">{{ $item->created_at }}</a>
                                    </div>
                                    <div class="masonryMore">
                                        <ul>
                                            <li class="squareButton light ico">
                                                <a class="fa-link" title="More" href="{{route('website.news.single',$item->id)}}">{{ __('site.Learn more') }} ...</a>
                                            </li>
                                            <!--li class="squareButton light ico">
                                                <a class="fa-eye" title="Views - 1064" href="#">1064</a>
                                            </li>
                                            <li class="squareButton light ico">
                                                <a class="fa-comment" title="Comments - 0" href="#comments">0</a>
                                            </li-->
                                        </ul>
                                    </div>
                                </div>
                            </article>
                            @endforeach






                        </section>
                    </div>
                    <div class="clearfix ar_con" style="padding-left:10px">
                        {{-- <div class="hint-text" style="text-align: center">Showing
                            <b>{{ !request('page')? "1" : request('page') }}</b>
                            out of <b>{{ ceil($count/paginate_num) }}</b> entries</div> --}}
                        <div class="row">
                            <div class="col-md-12">
                                {{ $news->links() }}
                            </div>
                        </div>
                    </div>
                    {{-- <div id="pagination" class="pagination no_padding_bottom">
                        <ul class="pageLibrary">
                            <li class="pager_pages libPage">
                                Page
                                <input class="navInput" readonly="readonly" type="text" size="1" value="1">
                                of {{ ceil($count/paginate_num) }}
                                <div id="pageNavSlider" class="boxShadow pageFocusBlock navPadding" >
                                    <div class="sc_slider sc_slider_swiper sc_slider_controls sc_slider_controls_top sc_slider_nopagination sc_slider_noautoplay">
                                        <ul>
                                            <li>
                                                <div class="pageNumber">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="#" class="active">1</a>
                                                                </td>
                                                                <td>
                                                                    <a href="#">2</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="flex-direction-nav">
                                        <li>
                                            <a class="flex-prev" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="flex-next" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="pager_next ico right squareButton light">
                                <a href="#">Next </a>
                            </li>
                            <li class="pager_last ico right squareButton light">
                                <a href="#">Last </a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    @endsection

    @section('js')
    @endsection
