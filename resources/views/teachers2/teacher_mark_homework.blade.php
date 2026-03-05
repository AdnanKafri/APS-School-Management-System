@extends('teachers2.layouts.app')
@section('css')
<style>
        /*responsive table*/
  /**/

  table {
    border: 1px solid #ccc ;
    border-collapse: collapse !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    margin-top:10px !important;
  }

  table caption {
    font-size: 1.5em !important;
    margin: .25em 0 .75em !important;
  }

  table tr {
    background: #f8f8f8 !important;
    border: 1px solid #ddd ;
    padding: .35em !important;
  }

  table th, table td {
    padding: .625em !important;
    text-align: center !important;
  }

  table th {
    font-size: 20px !important;

  }

  table td img { text-align: center; }
  @media screen and (max-width: 900px) {

  table { border: none !important; }


  table thead { display: none !important; }

  table tr {
    /*border-bottom: 3px solid #ddd!important ;*/
    border-bottom: none !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    display: block!important;
    margin-bottom: .625em !important;
  }

  table td {
    padding: 10px !important;
    border-top: 1px solid #ddd !important;
    border-bottom: none !important;
    display: block !important;
    font-size: .8em !important;
    text-align: right !important;
  }

  table td:before {
    content: attr(data-label) !important;
    float: left !important;
    font-weight: bold !important;

  }

  table td:last-child {
  border-bottom: 1px solid #ddd !important;
  border-right: 1px solid #ddd;
   }


  }
    /*css for show homework button*/
    a:hover{
      color: #fff;
      text-decoration: none;
    }
    .home {
  position: relative;
 /* margin: 0;*/
  width: 120px;
  padding: 0.8em 1em;
  outline: none;
  text-decoration: none;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  border: none;
  text-transform: uppercase;
  background-color: #14315C   ;
  border-radius: 10px;
  color: #fff;
  font-weight: 300;
  font-size: 18px;
  font-family: inherit;
  z-index: 0;
  overflow: hidden;
  transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
}

.home:hover {
  animation: sh0 0.5s ease-in-out both;
}

@keyframes sh0 {
  0% {
    transform: rotate(0deg) translate3d(0, 0, 0);
  }

  25% {
    transform: rotate(7deg) translate3d(0, 0, 0);
  }

  50% {
    transform: rotate(-7deg) translate3d(0, 0, 0);
  }

  75% {
    transform: rotate(1deg) translate3d(0, 0, 0);
  }

  100% {
    transform: rotate(0deg) translate3d(0, 0, 0);
  }
}

.home:hover span {
  animation: storm 0.7s ease-in-out both;
  animation-delay: 0.06s;
}

.home::before,
.home::after {
  content: '';
  position: absolute;
  right: 0;
  bottom: 0;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #fff;
  opacity: 0;
  transition: transform 0.15s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.15s cubic-bezier(0.02, 0.01, 0.47, 1);
  z-index: -1;
  transform: translate(100%, -25%) translate3d(0, 0, 0);
}

.home:hover::before,
.home:hover::after {
  opacity: 0.15;
  transition: transform 0.2s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.2s cubic-bezier(0.02, 0.01, 0.47, 1);
}

.home:hover::before {
  transform: translate3d(50%, 0, 0) scale(0.9);
}

.home:hover::after {
  transform: translate(50%, 0) scale(1.1);
}


    /*end css*/
</style>
@endsection
@section('content')

<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}">{{ $room->name }}  </a></li>
      {{--<li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}">{{ $lesson->name }}  </a></li>--}}
      <li class="li"><a href="#">الوظائف</a></li>
   </ul>
    <div class="content-wrapper pb-0">
       <!--start content-->
        <div class="container" style="direction: rtl;">
           <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 style="text-align: center;padding-bottom: 20px;color: #152C4F;font-size: 28px;">علامات الوظائف</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>اسم الوظيفة</th>
                          <th>وقت البداية</th>
                          <th>وقت النهاية </th>
                          <th>عرض الوظيفة</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ( $homeworke as $item)
                        <tr>
                          <td data-label="اسم الوظيفة" class="py-1">
                            {{ $item->namehomework }}
                          </td>
                          <td data-label="وقت البداية">{{ $item->start_time }}</td>
                          <td data-label="وقت النهاية">
                            {{ $item->end_time }}
                          </td>
                          <td data-label="عرض الوظيفة">
                            <a href="{{ route('dashboard.StudentsRoomLesson',[$room_id ,$teacher->id,$lesson_id,$item->id]) }}" class="home">
                            <span>عرض الوظيفة </span>
                            </a>
                      </td>

                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

           </div>

        </div>
       <!--end content-->
    </div><!--end content-wrapper pb-0-->
  </div><!--end main panels-->
@endsection
