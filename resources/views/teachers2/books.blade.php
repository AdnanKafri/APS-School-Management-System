@extends('teachers2.layouts.app')
@section('css')
<style>
 a:hover{
 color: #152C4F;
        }
 article {
  --img-scale: 1.001;
  --title-color: #152C4F;
  --link-icon-translate: -20px;
  --link-icon-opacity: 0;
  position: relative;
  border-radius: 16px;
  box-shadow: none;
  background: #fff;
  transform-origin: center;
  transition: all 0.4s ease-in-out;
  overflow: hidden;
}

article a::after {
  position: absolute;
  inset-block: 0;
  inset-inline: 0;
  cursor: pointer;
  content: "";
}

/* basic article elements styling */
article h2 {
    letter-spacing: 0;
  margin: 0 0 18px 0;
  font-size: 19px;
  color: var(--title-color);
  transition: color 0.3s ease-out;
}

figure {
  margin: 0;
  padding: 0;
  aspect-ratio: 16 / 9;
  overflow: hidden;
}

article img {
  max-width: 100%;
  transform-origin: center;
  transform: scale(var(--img-scale));
  transition: transform 0.4s ease-in-out;
}

.article-body {
  padding: 24px;
}

article a {
  display: inline-flex;
  align-items: center;
  text-decoration: none;
  color: #152C4F;
}

article a:focus {
  outline: 1px dotted #152C4F;
}

article a .icon {
  min-width: 24px;
  width: 24px;
  height: 24px;
  margin-left: 5px;
  transform: translateX(var(--link-icon-translate));
  opacity: var(--link-icon-opacity);
  transition: all 0.3s;
}

/* using the has() relational pseudo selector to update our custom properties */
article:has(:hover, :focus) {
  --img-scale: 1.1;
  --title-color: #427ace;
  --link-icon-translate: 0;
  --link-icon-opacity: 1;
   box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
}


/************************
Generic layout (demo looks)
**************************/

*/*,
*::before,
*::after {
  box-sizing: border-box;
}

body {
  margin: 0;
  padding: 48px 0;
  font-family: "Figtree", sans-serif;
  font-size: 1.2rem;
  line-height: 1.6rem;
  background-image: linear-gradient(45deg, #7c9885, #b5b682);
  min-height: 100vh;
}*/

.articles {
  display: grid;
  max-width: 1200px;
  margin-inline: auto;
  padding-inline: 24px;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px;
}

/*@media screen and (max-width: 960px) {
  article {
    container: card/inline-size;
    right: 30px;


}*/
@media (min-width:200px) and (max-width:350px){
    article{
        width: 55%;
    }
}
@media (min-width:351px) and (max-width:365px){
    article{
        width: 70%;
        left: 20px
    }
}

@media (min-width:366px) and (max-width:465px){
    article{
        width: 82%;

    }
}


  .article-body p {
    display: none;
  }
}

@container card (min-width: 380px) {
  .article-wrapper {
    display: grid;
    grid-template-columns: 100px 1fr;
    gap: 16px;
  }
  .article-body {
    padding-left: 0;
  }
  figure {
    width: 100%;
    height: 100%;
    overflow: hidden;
  }
  figure img {
    height: 100%;
    aspect-ratio: 1;
    object-fit: cover;
  }
}

.sr-only:not(:focus):not(:active) {
  clip: rect(0 0 0 0);
  clip-path: inset(50%);
  height: 1px;
  overflow: hidden;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}

</style>
@endsection

@section('content')

<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room->id ,'teacher_id'=>$teacher->id])}}">{{ $room->name }}</a></li>
      <li class="li"><a href="#">{{ $lesson->name }}</a></li>
   </ul>


    <div class="content-wrapper pb-0">
     <!--start books-->
       <div class="container" style="padding-bottom: 100px;">
         <div class="row" style="margin: auto;
         justify-content: center;">
          @if(isset($lesson->books))
          @foreach ($lesson->books as $book)
           <div class="col-md-4" style="padding-bottom: 20px;">
            <section class="articles">
              <article>
                <div class="article-wrapper">
                  <figure>
                    <img src="{{asset('teachers_2/icons/sub1.jpg')}}" alt="" />
                  </figure>
                  <div class="article-body">
                    <h2>{{ $book->name_ar }}</h2>

                    <a class="read-more" target="_blank"
                    @if ($book->type == 'link')
                    href=" {{$book->value}}"
                    @else
                    href=" {{ asset('storage/'.$book->value) }}"
                    @endif
                    >
                      استعراض المحتوى <span class="sr-only"></span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                      </svg>
                    </a>

                  </div>
                </div>
              </article>
            </section>
           </div>
           @endforeach
           @endif
           </div>

         </div>

       </div>
     <!--end books-->
</div><!--end container of cards-->
<!-- page-body-wrapper ends -->
</div>
</div><!--end container-scroller-->

@endsection
