@extends('coordinators.master')
@section('css')
<style>
    /*
	/*table */
table {
  border-spacing: 1;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
  margin-top: -170px;
  margin-bottom: 100px;
  direction: rtl;


}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;

}
table thead tr {
  height: 60px;
  background: white;
  font-size: 22px;
  color: #f38639;
  border-style: solid ;
  border-color: #094e89;


}
table tbody tr {
  height: 48px;
  font-size: 18px;
  /*border-bottom: 1px solid #f38639;*/

  color: white;
}
table tbody tr:last-child {
  border: 0;
  border-radius: 15px;
}
table td, table th {
  text-align: center;
}
table td.l, table th.l {
  text-align: center;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "اسم الاختبار ";
  }
  table tbody tr td:nth-child(2):before {
    content: "وقت البداية ";
  }
  table tbody tr td:nth-child(3):before {
    content: "وقت النهاية ";
  }
  table tbody tr td:nth-child(4):before {
    content: "نوع الاختبار ";
  }
  table tbody tr td:nth-child(5):before {
    content: "الاسئلة ";
  }
  table tbody tr td:nth-child(5):before {
    content: "عمليات التعديل ";
  }
}


/* end table */
/*select and option */
:root {
  --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
  --gray: #2c71ad;
  --darkgray: #2c71ad;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;


}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 20em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639;
  float: right;
  text-align: center;


}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #f38639;
  transition: .25s all ease;
  pointer-events: none;
  float: right;
  text-align: center;

}
/* Transition */
.select:hover::after {
  color: #f38639;
  text-align: center;
  float: right;


}
</style>

@endsection
@section('content')


<section class="hero-wrap hero-wrap-2" style="background-image:url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">

                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread"> الامتحانات للشعب  </h1>
            </div>
        </div>
    </div>
</section>
<!-- start new-->
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> الامتحانات للشعب</a>
     
      <a  href="{{ route('coordinator_lesson',[$class_id->id,$lesson_id->id]) }}" class="breadcrumbs__item ">{{ $lesson_id->name }} </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class_id->id ) }}" class="breadcrumbs__item ">{{ $class_id->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<br>
  <br>
  <br>
  <br>

<!-- start add section-->



    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


    <!-- marks of homework -->
    <table  >
        <thead>
            <tr>
                <th>
                   اسم الشعبة
                </th>

                <th>
                     الامتحانات
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach (  $rooms as  $item )
            <tr >

                <td>{{ $item->name}}  </td>



                <td>
                    <a href="{{ route('coordinator_show_exam',[$class_id->id ,$lesson_id->id,$item->id ]) }}" type="button" class="btn" style="background-color: white; color: rgb(117, 115, 115);"> مشاهدة </a></td>

            </tr>


            @endforeach








        </tbody>
    </table>

    <!-- end marks of homework-->
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" />
        </svg>
    </div>



    @endsection
    @section('js')
    <script>

    </script>

    @endsection
