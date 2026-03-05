@extends('students.layouts.app4')
@section('title')
    School
@endsection
@section('css')
<style>
    /* @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap");

*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  --color: rgba(30, 30, 30);
  --bgColor: rgba(245, 245, 245);
  min-height: 100vh;
  display: grid;
  align-content: center;
  gap: 2rem;
  padding: 2rem;
  font-family: "Poppins", sans-serif;
  color: var(--color);
  background: var(--bgColor);
}

h1 {
  text-align: center;
} */

.ul2 {
  --color: rgba(30, 30, 30);
  --bgColor: rgba(245, 245, 245);
  --col-gap: 2rem;
  --row-gap: 2rem;
  --line-w: 0.25rem;
  display: grid;
  grid-template-columns: var(--line-w) 1fr;
  grid-auto-columns: max-content;
  column-gap: var(--col-gap);
  list-style: none;
  width: min(60rem, 100%);
  margin-inline: auto;
}

/* line */
.ul2::before {
  content: "";
  grid-column: 1;
  grid-row: 1 / span 20;
  background: rgb(225, 225, 225);
  border-radius: calc(var(--line-w) / 2);
}

/* columns*/

/* row gaps */
.ul2 li:not(:last-child) {
  margin-bottom: var(--row-gap);
}

/* card */
.ul2 li {
  grid-column: 2;
  --inlineP: 1.5rem;
  margin-inline: var(--inlineP);
  grid-row: span 2;
  display: grid;
  grid-template-rows: min-content min-content min-content;
}

/* date */
.ul2 li .date {
  --dateH: 3rem;
  height: var(--dateH);
  margin-inline: calc(var(--inlineP) * -1);

  text-align: center;
  background-color: var(--accent-color);

  color: white;
  font-size: 1.25rem;
  font-weight: 700;

  display: grid;
  place-content: center;
  position: relative;

  border-radius: calc(var(--dateH) / 2) 0 0 calc(var(--dateH) / 2);
}

/* date flap */
.ul2 li .date::before {
  content: "";
  width: var(--inlineP);
  aspect-ratio: 1;
  background: var(--accent-color);
  background-image: linear-gradient(rgba(0, 0, 0, 0.2) 100%, transparent);
  position: absolute;
  top: 100%;

  clip-path: polygon(0 0, 100% 0, 0 100%);
  right: 0;
}

/* circle */
.ul2 li .date::after {
  content: "";
  position: absolute;
  width: 2rem;
  aspect-ratio: 1;
  background: var(--bgColor);
  border: 0.3rem solid var(--accent-color);
  border-radius: 50%;
  top: 50%;

  transform: translate(50%, -50%);
  right: calc(100% + var(--col-gap) + var(--line-w) / 2);
}

/* title descr */
.ul2 li .title,
.ul2 li .descr {
  background: var(--bgColor);
  position: relative;
  padding-inline: 1.5rem;
}
.ul2 li .title {
  overflow: hidden;
  padding-block-start: 1.5rem;
  padding-block-end: 1rem;
  font-weight: 500;
}
.ul2 li .descr {
    padding-top: 20px;
    padding-block-end: 1.5rem;
    font-weight: 300;
    margin: auto;
}

/* shadows */
.ul2 li .title::before,
.ul2 li .descr::before {
  content: "";
  position: absolute;
  width: 90%;
  height: 0.5rem;
  background: rgba(0, 0, 0, 0.5);
  left: 50%;
  border-radius: 50%;
  filter: blur(4px);
  transform: translate(-50%, 50%);
}
.ul2 li .title::before {
  bottom: calc(100% + 0.125rem);
}

.ul2 li .descr::before {
  z-index: -1;
  bottom: 0.25rem;
}

@media (min-width: 40rem) {
    .ul2 {
    grid-template-columns: 1fr var(--line-w) 1fr;
  }
  .ul2::before {
    grid-column: 2;
  }
  .ul2 li:nth-child(odd) {
    grid-column: 1;
  }
  .ul2 li:nth-child(even) {
    grid-column: 3;
  }

  /* start second card */
  .ul2 li:nth-child(2) {
    grid-row: 2/4;
  }

  .ul2 li:nth-child(odd) .date::before {
    clip-path: polygon(0 0, 100% 0, 100% 100%);
    left: 0;
  }

  .ul2 li:nth-child(odd) .date::after {
    transform: translate(-50%, -50%);
    left: calc(100% + var(--col-gap) + var(--line-w) / 2);
  }
  .ul2 li:nth-child(odd) .date {
    border-radius: 0 calc(var(--dateH) / 2) calc(var(--dateH) / 2) 0;
  }
}

.credits {
  margin-top: 1rem;
  text-align: right;
}
.credits a {
  color: var(--color);
}
/* css for download button */
.button {
  --main-focus: #2d8cf0;
  --font-color: #323232;
  --bg-color-sub: #dedede;
  --bg-color: #eee;
  --main-color: #2b4770;
  position: relative;
  width: 150px;
  height: 40px;
  cursor: pointer;
  display: flex;
  align-items: center;
  border: 2px solid var(--main-color);
  box-shadow: 4px 4px var(--main-color);
  background-color: var(--bg-color);
  border-radius: 10px;
  overflow: hidden;
}

.button, .button__icon, .button__text {
  transition: all 0.3s;
}

.button .button__text {
  transform: translateX(22px);
  color: var(--font-color);
  font-weight: 600;
}

.button .button__icon {
  position: absolute;
  transform: translateX(105px);
  height: 100%;
  width: 24px;
  background-color: var(--bg-color-sub);
  display: flex;
  align-items: center;
  justify-content: center;
}

.button .svg {
  width: 20px;
  fill: var(--main-color);
}

.button:hover {
  background: var(--bg-color);
}

.button:hover .button__text {
  color: transparent;
}

.button:hover .button__icon {
  width: 148px;
  transform: translateX(0);
}

.button:active {
  transform: translate(3px, 3px);
  box-shadow: 0px 0px var(--main-color);
}
/* end css */
@media(min-width:100px) and (max-width:900px){
    .ul2 li .date{
        font-size: 15px !important;

    }
}
</style>
@endsection




@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#">الكتب المدرسية</a></li>

   </ul>
        <div class="content-wrapper pb-0">
            <!--content -->
            <!--card of subjects-->
            <div class="container" style="padding-bottom: 100px;">

                <ul class="ul2">
                    @foreach ($classes->lessons as $class)
                    @if ($class->books != null)
                    @foreach (json_decode($class->books) as $item)
                    <li style="--accent-color:#29518d">
                        <div class="date">{{ str_replace('_', '-', app()->getLocale()) == "en" ? $item->name_en : $item->name_ar }}</div>
                        <div class="descr">
                            <a @if ($item->type == "link")
                                href="{{ $item->value }}"
                            @else
                                href="{{ asset('storage/'.$item->value) }}"
                            @endif target="_blank"
                             class="button" type="button">
                            <span class="button__text">تحميل الكتاب</span>
                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg"><path d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z"></path><path d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z"></path><path d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z"></path></svg></span>
                            </a>
                        </div>
                    </li>
                    @endforeach
                    @endif
                    @endforeach
                </ul>


            </div><!--end container of cards-->
            <!-- page-body-wrapper ends -->
        </div>
    </div>
@endsection
@section('js')
<script>
   // Array of colors
const colors = ['#45b649','#29518d', '#6097e9'];

// Loop through each <li> element
$('.ul2 li').each(function(index) {
  // Get the color based on the index
  const color = colors[index % colors.length];

  // Change the style color
  $(this).css('--accent-color', color);
});

</script>
@endsection
