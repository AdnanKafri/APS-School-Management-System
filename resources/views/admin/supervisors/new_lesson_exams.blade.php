@extends('supervisors.layouts.new_app')
@section('css')
<style>

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
 /* margin-top: -170px;
  margin-bottom: 100px;*/
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
    content: "اسم الامتحان ";
	color: #094e89;
  }
  table tbody tr td:nth-child(2):before {
    content: "وقت البداية ";
	color: #094e89;

  }
  table tbody tr td:nth-child(3):before {
    content: "وقت النهاية ";
	color: #094e89;
  }
  table tbody tr td:nth-child(4):before {
    content: "عرض العلامات ";
	color: #094e89;
  }


}

</style>
@endsection

@section('content')



<section class="hero-wrap hero-wrap-2" style="background-image:url( {{  asset('teachers/ppp.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                <h1 class="mb-0 bread">علامات الامتحانات </h1>
            </div>
        </div>
    </div>
</section>
<!-- start new-->


<br>
<br>

<br>
<br>


<!-- marks of homework -->
<table class="" >
<thead>
  <tr>
      <th>اسم الامتحانات  </th>
      <th>وقت البداية </th>
      <th>وقت النهاية </th>
      <th>عرض العلامات  </th>

  </tr>
</thead>
<tbody>
    @foreach ( $exam as $item)
    @if(($item->type=='5' && $item->name_exam !=null) || $item->type=='3' )
  <tr>

      <td> {{ $item->name_exam }} </td>

      <td>{{ $item->start_time }}</td>
      <td>{{ $item->end_time }}</td>

      <td><a style="background-color: white; color: rgb(117, 115, 115);"
        href="{{ route('edu_supervisor.exam.marks',[$room_id ,$lesson_id,$item->id]) }}" class="btn">الامتحان  </a>

         </td>
  </tr>
  @endif
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
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

@endsection

@section('js')
@endsection
