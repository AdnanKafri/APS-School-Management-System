
@if($prepare->count()>0)
@foreach ($prepare as  $item )
<div id="load">

    <input name="prepare_id"  class="common-input mb-20 form-control" hidden  value="{{$item->id}}"  type="text">
   <div >
     <div class="row" style="padding-right: 20px;">
       <h7>التحضير اليومي لمادة </h7>&nbsp;
       <input style="width: 200px; text-align: center;margin-top: -20px;height:40px !important;"  class="common-input mb-20 form-control" disabled  value="{{ $lesson_id->name }}"  type="text">
       <input style="width: 200px; text-align: center;margin-top: -20px;height:40px !important;" name="lesson_id"  class="common-input mb-20 form-control" hidden  value="{{ $lesson_id->id }}"  type="text">
     </div>
     <br>
     <div class="row"  style="padding-right: 20px;">
       <h7>الصف : </h7> &nbsp;
       <input style="width: 100px; text-align: center;margin-top: -20px;height:40px !important;"  value="{{ $class_id->name }}" disabled  class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <input   hidden value="{{ $term->id }}" name="term_id"  type="text">&nbsp;&nbsp;&nbsp;

       <input  name="class_id"   value="{{ $class_id->id }}"  hidden  class="common-input mb-20 form-control" type="text">

       &nbsp;&nbsp;
       <div class="room" style="display: inline-flex;">
       <h7>الشعبة : </h7> &nbsp;
       @if(json_decode($item->room_id))
        @foreach(json_decode($item->room_id) as $item1 )
        @if($item1)
       <input style="width: 50px; text-align: center;margin-top: -20px;height:40px !important;" name="room_id[]" value="{{ $item1 }}" class=" room1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;">/

     </h3>&nbsp;
     @endif
     @endforeach
     @else
     <input style="width: 50px; text-align: center;margin-top: -20px;height:40px !important;" name="room_id[]" value="" class=" room1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
     <h3 style="color: #f38639;">/
     @endif
       </div>
       {{-- <input style="width: 30px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;" >/</h3>&nbsp; --}}
       {{-- <input style="width: 30px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
       <!--h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"-->
       <div class="Period" style="display: inline-flex;">
       <h7>الحصة : </h7>&nbsp;
          @if(json_decode($item->period))
       @foreach(json_decode($item->period) as $item1 )
       @if($item1)
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;" name="period[]" value="{{ $item1 }}" class=" Period1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;">/</h3>&nbsp;


       @endif
       @endforeach
       @else
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;" name="period[]" value="" class=" Period1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;">/</h3>&nbsp;
       @endif
       </div>
       {{-- <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
       {{-- <h3 style="color: #f38639;">/</h3>&nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
       <!--h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"-->
       <h7>زمن الحصة : </h7> &nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;"
       name="class_time" value="{{ $item->class_time }}" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       {{-- <h7>عدد الحصص: </h7> &nbsp;
       <input name="number_of_lecture" value="{{ $item->number_of_lecture }}" style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
      </div>

      <div class="row"  style="padding-right: 20px;">
       <h7>التاريخ : </h7>&nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;" value="{{ $item->day }}" placeholder="day" name="day" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
       <h3 style="color: #f38639;">/</h3>
       <input style="width: 40px; text-align: center; margin-top: -20px;height:40px !important;"  value="{{ $item->month }}" placeholder="month"  name="month" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
       <h3 style="color: #f38639">/</h3>
       <input style="width: 40px; text-align: center; margin-top: -20px;height:40px !important;" value="{{ $item->year }}" placeholder="year" name="year" class="common-input mb-20 form-control" type="text"-->&nbsp;&nbsp;&nbsp;

       <h7>الوحدة : </h7>
       <input style="width: 100px; text-align: center; margin-top: -20px;height:40px !important;" value="{{ $item->unit }}"  name="unit" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;


       <h7>الدرس: </h7>
       <input style="width: 180px; text-align: center;margin-top: -20px;height:40px !important;" value="{{ $item->lecture }}" name="lecture" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;

      </div>
         <br>


      <!-- new div-->

      <div class="row"  style="padding-right: 20px;" >

      <h7  >Acte de language : </h7>
      <input name="The_general_goal_of_the_lesson" value="{{ $item->The_general_goal_of_the_lesson }}" style="width: 240px; text-align: center;height:40px !important;"
      class="common-input mb-20 form-control" type="text">
       &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      <h7 >Situation de communication	  : </h7>
      <input name="stimulating_initialization" value="{{ $item->stimulating_initialization }}" style="width: 240px; text-align: center;height:40px !important;" class="common-input mb-20 form-control" type="text">
      <!-- end new div-->

     </div>
     <br>
     <br>
     <h5 style="text-align: center;">Linguistique</h5>
     <div class="row" style="justify-content: center;direction: ltr;">
       <!-- start cards-->

       <div class="data-card" >
         <h7 style="text-align: center;">
            Lexique: </h7>
      <textarea  name="Lexique" value="{{ $item->Lexique }}" class="form-control" cols="5" rows="4" >
        {{ $item->Lexique }}</textarea>
       </div>
       <div class="data-card" >
         <h7 style="text-align: center;"> Points grammaticaux: </h7>
          <br>
      <textarea name="Points_grammaticaux"  value="{{ $item->Points_grammaticaux }}" class="form-control" cols="5" rows="4" >
        {{ $item->Points_grammaticaux }}
    </textarea>
       </div>

       <div class="data-card" >
         <h7 style="text-align: center;"> Phonetique : </h7>
          <br>
      <textarea name="Phonetique" value="{{ $item->Phonetique }}" class="form-control" cols="5" rows="4" >
        {{ $item->Phonetique }}</textarea>
       </div>

       <!-- end cards-->

     </div>

     <div class="row" style="justify-content: center;direction: ltr;">
       <div class="data-card" style="width: 230px;" >
         <h7 style="text-align: center;"> Materiel : </h7>
          <br>
      <textarea name="Materiel" class="form-control" cols="5" rows="4" >{{ $item->Materiel }}</textarea>

       </div>
       <div class="data-card" style="width: 230px;">
         <h7 style="text-align: center;">Taches
            (Competences)
             : </h7>
          <br>
      <textarea name="Taches" class="form-control" cols="5" rows="4" >
        {{ $item->Taches }}
      </textarea>
       </div>
       <div class="data-card" style="width: 230px;">
         <h7 style="text-align: center;">Evaluation  : </h7>
          <br>
      <textarea name="Evaluation" class="form-control" cols="5" rows="4" >
        {{ $item->Evaluation }}
      </textarea>
       </div>


     </div>
    <!-- style for number-->

    <!-- end style -->

   </div>
   <div class="row" style="justify-content: center;padding-top: -200px;">
    <p>{{ $item->number }}</p>
    </div>
 
   <!-- end menue -->

</div>
<button  id="buttondown"  class="btn btn-primary" style="width: 114px;display:none" >
    <a href="{{ route('pdfdownload1',$item->id) }}" target="_blank">
        page de chargement</a>
          </button>
          <button  id="buttondown1"  class="btn btn-primary" style="width: 114px;display:none"  >
            <a href="{{ route('multipdfdownload1',[$item->id,$teacher->id]) }}" target="_blank">
                tout télécharger</a>
                  </button>
@endforeach

@else

   <div >
     <div class="row" style="padding-right: 20px;">
       <h7>التحضير اليومي لمادة </h7>&nbsp;
       <input style="width: 200px; text-align: center;margin-top: -20px;height:40px !important;"class="common-input mb-20 form-control" disabled  value="{{ $lesson_id->name }}"  type="text">
       <input style="width: 200px; text-align: center;margin-top: -20px;height:40px !important;" name="lesson_id"  class="common-input mb-20 form-control" hidden  value="{{ $lesson_id->id }}"  type="text">


     </div>
     <br>
     <div class="row"  style="padding-right: 20px;">
       <h7>الصف : </h7> &nbsp;
       <input style="width: 100px; text-align: center;margin-top: -20px;height:40px !important;"  value="{{ $class_id->name }}" disabled  class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <input   hidden value="{{ $term->id }}" name="term_id"  class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;

       <input  name="class_id" hidden  value="{{ $class_id->id }}"    type="text">

       &nbsp;&nbsp;
       <div class="room" style="display: inline-flex;">
       <h7>الشعبة : </h7> &nbsp;

       <input style="width: 30px; text-align: center;margin-top: -20px;height:40px !important;" name="room_id[]" class=" room1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;">/
     </h3>&nbsp;
       </div>
       {{-- <input style="width: 30px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;" >/</h3>&nbsp; --}}
       {{-- <input style="width: 30px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
       <!--h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"-->
       <div class="Period" style="display: inline-flex;">
       <h7>الحصة : </h7>&nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;" name="period[]" class=" Period1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;">/</h3>&nbsp;
       </div>
       {{-- <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
       {{-- <h3 style="color: #f38639;">/</h3>&nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
       <!--h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"-->
       <h7>زمن الحصة : </h7> &nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;"
       name="class_time" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
      </div>

      <div class="row"  style="padding-right: 20px;">
       <h7>التاريخ : </h7>&nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;height:40px !important;" placeholder="day" name="day" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
       <h3 style="color: #f38639;">/</h3>
       <input style="width: 40px; text-align: center; margin-top: -20px;height:40px !important;"  placeholder="month"  name="month" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
       <h3 style="color: #f38639">/</h3>
       <input style="width: 40px; text-align: center; margin-top: -20px;height:40px !important;" placeholder="year" name="year" class="common-input mb-20 form-control" type="text"-->&nbsp;&nbsp;&nbsp;

       <h7>الوحدة : </h7>
       <input style="width: 100px; text-align: center; margin-top: -20px;height:40px !important;" name="unit" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;


       <h7>الدرس: </h7>
       <input style="width: 180px; text-align: center;margin-top: -20px;height:40px !important;" name="lecture" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;

      </div>
         <br>


      <!-- new div-->
      <div class="row"  style="padding-right: 20px;direction: ltr;" >
      <h7  > Acte de language  : </h7>
      <input name="The_general_goal_of_the_lesson" style="width: 240px;height:40px !important; text-align: center;"
      class="common-input mb-20 form-control" type="text">
       &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      <h7 >Situation de communication  : </h7>
      <input name="stimulating_initialization" style="width: 240px;height:40px !important; text-align: center;" class="common-input mb-20 form-control" type="text">
      <!-- end new div-->

     </div>
     <br>
     <br>
     <h5 style="
     text-align: center;
 ">Linguistique</h5>
     <div class="row" style="justify-content: center;direction: ltr;">
       <!-- start cards-->

       <div class="data-card" >
         <h7 style="text-align: center;">
            Lexique: </h7>
      <textarea  name="Lexique" value="" class="form-control" cols="5" rows="4" >
        </textarea>
       </div>
       <div class="data-card" >
         <h7 style="text-align: center;"> Points grammaticaux: </h7>
          <br>
      <textarea name="Points_grammaticaux"  value="" class="form-control" cols="5" rows="4" >

    </textarea>
       </div>

       <div class="data-card" >
         <h7 style="text-align: center;"> Phonetique : </h7>
          <br>
      <textarea name="Phonetique" value="" class="form-control" cols="5" rows="4" >
       </textarea>
       </div>

       <!-- end cards-->

     </div>

     <div class="row" style="justify-content: center;direction: ltr;">
       <div class="data-card" style="width: 230px;" >
         <h7 style="text-align: center;"> Materiel : </h7>
          <br>
      <textarea name="Materiel" class="form-control" cols="5" rows="4" ></textarea>

       </div>
       <div class="data-card" style="width: 230px;">
         <h7 style="text-align: center;">Taches
            (Competences)
             : </h7>
          <br>
      <textarea name="Taches" class="form-control" cols="5" rows="4" >

      </textarea>
       </div>
       <div class="data-card" style="width: 230px;">
         <h7 style="text-align: center;">Evaluation  : </h7>
          <br>
      <textarea name="Evaluation" class="form-control" cols="5" rows="4" >

      </textarea>
       </div>


     </div>
    <!-- style for number-->

    <!-- end style -->

   </div>


@endif
