

@if($prepare->count()>0)




@foreach ($prepare as $item )
<div id="load" style=" Dejavu Sans">

        <input name="prepare_id" class="common-input mb-20 form-control" hidden value="{{$item->id}}" type="text">
        <div>
            <div class="row" style="padding-right: 20px;">
                <h7>التحضير اليومي لمادة </h7>&nbsp;
                <input style="width: 200px; text-align: center;margin-top: -20px;"
                    class="common-input mb-20 form-control" disabled value="{{ $lesson_id->name }}" type="text">
                <input style="width: 200px; text-align: center;margin-top: -20px;" name="lesson_id"
                    class="common-input mb-20 form-control" hidden value="{{ $lesson_id->id }}" type="text">
            </div>
            <br>
            <div class="row" style="padding-right: 20px;">
                <h7>الصف : </h7> &nbsp;
                <input style="width: 100px; text-align: center;margin-top: -20px;" value="{{ $class_id->name }}"
                    disabled class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
                <input hidden value="{{ $term->id }}" name="term_id" type="text">&nbsp;&nbsp;&nbsp;

                <input name="class_id" value="{{ $class_id->id }}" hidden class="common-input mb-20 form-control"
                    type="text">

                &nbsp;&nbsp;
                <div class="room" style="display: inline-flex;">
                    <h7>الشعبة : </h7> &nbsp;
                    @if(json_decode($item->room_id))
                    @foreach(json_decode($item->room_id) as $item1 )
                    @if($item1)
                    <input style="width: 50px; text-align: center;margin-top: -20px;" name="room_id[]"
                        value="{{ $item1 }}" class=" room1 common-input mb-20 form-control"
                        type="text">&nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/

                    </h3>&nbsp;
                    @endif
                    @endforeach
                    @else
                    <input style="width: 50px; text-align: center;margin-top: -20px;" name="room_id[]" value=""
                        class=" room1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/
                        @endif
                </div>
                <input style="width: 30px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
       <h3 style="color: #f38639;" >/</h3>&nbsp;
                {{-- <input style="width: 30px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
                <h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"> --}}
                <div class="Period" style="display: inline-flex;">
                    <h7>الحصة : </h7>&nbsp;
                    @if(json_decode($item->period))
                    @foreach(json_decode($item->period) as $item1 )
                    @if($item1)
                    <input style="width: 40px; text-align: center;margin-top: -20px;" name="Period[]"
                        value="{{ $item1 }}" class=" Period1 common-input mb-20 form-control"
                        type="text">&nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/</h3>&nbsp;


                    @endif
                    @endforeach
                    @else
                    <input style="width: 40px; text-align: center;margin-top: -20px;" name="Period[]" value=""
                        class=" Period1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/</h3>&nbsp;
                    @endif
                </div>
                <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
                <h3 style="color: #f38639;">/</h3>&nbsp;
       {{-- <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
               <h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"> --}}
                <h7>زمن الحصة : </h7> &nbsp;
                <input style="width: 40px; text-align: center;margin-top: -20px;" name="class_time"
                    value="{{ $item->class_time }}" class="common-input mb-20 form-control"
                    type="text">&nbsp;&nbsp;&nbsp;
                <h7>عدد الحصص: </h7> &nbsp;
                <input name="number_of_lecture" value="{{ $item->number_of_lecture }}"
                    style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control"
                    type="text">&nbsp;&nbsp;&nbsp;
            </div>

            <div class="row" style="padding-right: 20px;">
                <h7>التاريخ : </h7>&nbsp;
                <input style="width: 40px; text-align: center;margin-top: -20px;" value="{{ $item->day }}"
                    placeholder="day" name="day" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
                <h3 style="color: #f38639;">/</h3>
                <input style="width: 40px; text-align: center; margin-top: -20px;" value="{{ $item->month }}"
                    placeholder="month" name="month" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
                <h3 style="color: #f38639">/</h3>
                <input style="width: 40px; text-align: center; margin-top: -20px;" value="{{ $item->year }}"
                    placeholder="year" name="year" class="common-input mb-20 form-control" type="text"
                    >&nbsp;&nbsp;&nbsp;

                <h7>الوحدة : </h7>
                <input style="width: 100px; text-align: center; margin-top: -20px;" value="{{ $item->unit }}"
                    name="unit" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;


                <h7>الدرس: </h7>
                <input style="width: 180px; text-align: center;margin-top: -20px;" value="{{ $item->lecture }}"
                    name="lecture" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;

            </div>
            <br>


            <!-- new div-->
            <div class="row" style="padding-right: 20px;">
                <h7>الهدف العام للدرس : </h7>
                <input name="The_general_goal_of_the_lesson" value="{{ $item->The_general_goal_of_the_lesson }}"
                    style="width: 240px; text-align: center;" class="common-input mb-20 form-control" type="text">
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <h7>تهيئة محفزة : </h7>
                <input name="stimulating_initialization" value="{{ $item->stimulating_initialization }}"
                    style="width: 240px; text-align: center;" class="common-input mb-20 form-control" type="text">
                <!-- end new div-->

            </div>
            <br>
            <br>
            <div class="row" style="justify-content: center;">

                <input id="conatin" name="conatin" hidden type="text">
                <div class="data-card" style="width:900px">
                    <div class="tab1cards">
                        <!-- one div-->

                        <div>
                            <a class="appendbtn"> <img src="{{  asset('edit-question/icons8-plus-24.png') }}" title="Add row"></a> &nbsp;&nbsp; <h7>
                                مؤشرات الأداء</h7>
                                @php
                                    $i=0;
                                @endphp
                                 @if($item->procedures_and_activities != null)
                                @foreach (json_decode($item->procedures_and_activities) as $key=>$item3 )

                                @php
                                    $i=$i+1;
                                @endphp
                                <input hidden class="i" value="{{ $i }}" type="text">
                                <textarea   data-id="{{ $i }}" class="comt common-input mb-20 form-control" cols="5" rows="2" value="{{ $item3[0] }}" style="text-align: right;
                                width: 180px;">{{ $item3[0] }}</textarea>
                                {{-- <input style="width: 180px; text-align: center;" data-id="{{ $i }}"  value="{{ $item3[0] }}" class="comt common-input mb-20 form-control"
                                type="text"> --}}
                                @endforeach
                               @endif


                            <div class="appendme"></div>
                        </div>

                        <!-- end one -->
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- start tow div -->
                        <div>
                            </a>
                            <h7> الزمن </h7>
                            @php
                                    $i=0;
                                @endphp
                                 @if($item->procedures_and_activities != null)
                            @foreach (json_decode($item->procedures_and_activities) as $key=>$item3 )
                            @php
                                    $i=$i+1;
                                @endphp
                                 <input hidden class="i" value="{{ $i }}" type="text">
                                 <textarea  data-id="{{ $i }}" class="comt common-input mb-20 form-control" cols="5" rows="2" value="{{ $item3[1] }}"
                                 style="text-align: right;
                                 width: 180px;">{{ $item3[1] }}</textarea>
                                {{-- <input style="width: 180px; text-align: center;" data-id="{{ $i }}"  value="{{ $item3[1] }}" class="comt common-input mb-20 form-control"
                                type="text"> --}}
                                @endforeach
                                @endif
                            <div class="appendme"> </div>


                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- end two div -->
                        <!-- start three div -->
                        <div>
                            <h7> الاجراءات و المناشط </h7>
                            @php
                                    $i=0;
                                @endphp
                                 @if($item->procedures_and_activities != null)
                            @foreach (json_decode($item->procedures_and_activities) as $key=>$item3 )
                            @php
                                    $i=$i+1;
                                @endphp

                                 <input hidden class="i" value="{{ $i }}" type="text">
                                 <textarea   style="text-align: right;
                                 width: 180px;" data-id="{{ $i }}" class="comt common-input mb-20 form-control" cols="5" rows="2" value="{{ $item3[2] }}">{{ $item3[2] }}</textarea>

                            {{-- <input style="width: 180px; text-align: center;" data-id="{{ $i }}"  value="{{ $item3[2] }}" class="comt common-input mb-20 form-control"
                            type="text"> --}}
                            @endforeach
                            @endif
                            <div class="appendme"> </div>

                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- end three div -->
                        <!-- four div-->
                        <div>
                            <h7> التقويم المرحلي </h7>
                            @php
                                    $i=0;
                                @endphp
                                 @if($item->procedures_and_activities != null)
                            @foreach (json_decode($item->procedures_and_activities) as $key=>$item3 )
                            @php
                                    $i=$i+1;
                                @endphp
                             <textarea  style="text-align: right;
                             width: 180px;" data-id="{{ $i }}" class="comt common-input mb-20 form-control" cols="5" rows="2" value="{{ $item3[3] }}">{{ $item3[3] }}</textarea>

                            {{-- <input style="width: 180px; text-align: center;" data-id="{{ $i }}"  value="{{ $item3[3] }}" class="comt common-input mb-20 form-control"
                            type="text"> --}}
                            @endforeach
                            @endif
                            <div class="appendme"> </div>

                        </div>
                        <!-- end four -->


                    </div>

                </div>


                <!-- end cards-->
            </div>

            <div class="row" style="justify-content: center;">
                <div class="data-card" style="width: 400px;">
                    <h7 style="text-align: center;">الوسائل : </h7>

                    <ul class="ks-cboxtags">
                        <div class="row" style="justify-content: center;">
                           @if($item->means!='null' && $item->created_at <= "2022-10-12 07:50:09" )
                            @foreach(json_decode($item->means) as $item2 )

                            @if($item2 =="Rainbow Dash")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Cotton Candy")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Rarity")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Moondancer")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Surprise")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Twilight Sparkle")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Fluttershy")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Derpy Hooves")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Princess Celestia")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Gusty")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Discord")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Clover")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Baby Moondancer")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Baby Moondancer")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Medley")
                            <input type="checkbox" hidden class="y" value="{{$item2 }}">

                            @endif
                              @endforeach
                           @elseif($item->means != 'null' && $item->created_at > "2022-10-12 07:50:09"  )
                               @foreach(json_decode($item->means) as $item2 )
                                @foreach($means as $item3 )
                               @if($item2==$item3->id)
                             <input type="checkbox" hidden class="y2" value="{{$item2 }}">
                          
                            @endif
                            @endforeach
                             @endforeach
                            @endif
                            @if($item->created_at <= "2022-10-12 07:50:09" ) 
                            <li> <input type="checkbox" id="checkboxOne" class="x" data-id="Rainbow Dash" name="means[]"
                                    value="Rainbow Dash">
                                <label for="checkboxOne">الحاسوب </label></li>
                            <li><input type="checkbox" id="checkboxTwo" class="x" data-id="Cotton Candy" name="means[]"
                                    data-id="Cotton Candy" value="Cotton Candy"><label for="checkboxTwo">السبورة البيضاء
                                </label></li>

                            <li><input type="checkbox" id="checkboxThree" name="means[]" class="x" data-id="Rarity"
                                    value="Rarity"><label for="checkboxThree">السبورة الذكية </label></li>
                            <li><input type="checkbox" id="checkboxFour" name="means[]" class="x" data-id="Moondancer"
                                    value="Moondancer"><label for="checkboxFour">اوراق عمل </label></li>
                            <li><input type="checkbox" id="checkboxFive" name="means[]" class="x" data-id="Surprise"
                                    value="Surprise"><label for="checkboxFive">البطاقات </label></li>
                            <li><input type="checkbox" id="checkboxSix" name="means[]" class="x"
                                    data-id="Twilight Sparkle" value="Twilight Sparkle"><label for="checkboxSix">الخرائط
                                </label></li>

                            <li><input type="checkbox" id="checkboxSeven" name="means[]" class="x" data-id="Fluttershy"
                                    value="Fluttershy"><label for="checkboxSeven">مشهد فيديو </label></li>
                            <li><input type="checkbox" id="checkboxEight" name="means[]" class="x"
                                    data-id="Derpy Hooves" value="Derpy Hooves"><label for="checkboxEight">المجسمات
                                </label></li>
                            <li><input type="checkbox" id="checkboxNine" name="means[]" class="x"
                                    data-id="Princess Celestia" value="Princess Celestia"><label
                                    for="checkboxNine">المعاجم
                                </label></li>
                            <li><input type="checkbox" id="checkboxTen" name="means[]" class="x" data-id="Gusty"
                                    value="Gusty"><label for="checkboxTen">اللوحات </label></li>
                            <li class="ks-selected"><input type="checkbox" name="means[]" class="x" data-id="Discord"
                                    id="checkboxEleven" value="Discord"><label for="checkboxEleven">القصص</label></li>
                            <li><input type="checkbox" id="checkboxTwelve" name="means[]" class="x" data-id="Clover"
                                    value="Clover"><label for="checkboxTwelve">الصور </label></li>
                            <li><input type="checkbox" id="checkboxThirteen" name="means[]" class="x"
                                    data-id="Baby Moondancer" value="Baby Moondancer"><label
                                    for="checkboxThirteen">المطويات
                                </label></li>
                            <li><input type="checkbox" id="checkboxFourteen" name="means[]" class="x" data-id="Medley"
                                    value="Medley"><label for="checkboxFourteen">اخرى </label></li>
                                     @else
                                   @foreach($means as $item4 )
                                   <li> <input type="checkbox" id="checkbox{{$item4->name}}" class="x" data-id="{{$item4->id}}" name="means[]"
                                    value="{{$item4->id}}">
                                <label for="checkbox{{$item4->name}}">{{$item4->name}} </label></li>
                                   @endforeach 
                                   @endif
                        </div>
                    </ul>
                </div>
                <!-- new checkbox -->
                <div class="data-card" style="width: 400px;">
                    <h7 style="text-align: center;">الاستراتيجيات و الطرق المتبعة : </h7>

                    <ul class="ks-cboxtags">
                        <div class="row " style="justify-content: center;">
                            @if($item->roads!='null' && $item->created_at <= "2022-10-12 07:50:09"  )
                            @foreach(json_decode($item->roads) as $item2 )

                            @if($item2 =="Rainbow Dash")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Cotton Candy")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Rarity")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Moondancer")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Surprise")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Twilight Sparkle")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Fluttershy")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Derpy Hooves")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Princess Celestia")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">
                            @endif
                            @if($item2 =="Gusty")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Discord")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Clover")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Baby Moondancer")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif

                            @if($item2 =="Medley")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Medley1")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Medley2")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Medley3")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Medley4")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @if($item2 =="Medley5")
                            <input type="checkbox" hidden class="y1" value="{{$item2 }}">

                            @endif
                            @endforeach
                         @elseif($item->roads != 'null' && $item->created_at > "2022-10-12 07:50:09"  )
                             
                               @foreach(json_decode($item->roads) as $item2 )
                                @foreach($road as $item32 )
                               @if($item2==$item32->id)
                             <input type="checkbox" hidden class="y12" value="{{$item2}}">
                          
                            @endif
                            @endforeach
                             @endforeach
                          
                            @endif
                             @if($item->created_at <= "2022-10-12 07:50:09" ) 
                            <li><input type="checkbox" id="checkboxO" name="roads[]" class="x1" data-id="Rainbow Dash"
                                    value="Rainbow Dash"><label for="checkboxO">التعليم الاصفي </label></li>
                            <li><input type="checkbox" id="checkboxT" name="roads[]" class="x1" data-id="Cotton Candy"
                                    value="Cotton Candy"><label for="checkboxT">البحث و الاستكشاف </label></li>
                            <li><input type="checkbox" id="checkboxTh" name="roads[]" class="x1" data-id="Rarity"
                                    value="Rarity"><label for="checkboxTh">العصف الذهني </label></li>
                            <li><input type="checkbox" id="checkboxF" name="roads[]" class="x1" data-id="Moondancer"
                                    value="Moondancer"><label for="checkboxF">المناظرة</label></li>
                            <li><input type="checkbox" id="checkboxFi" name="roads[]" class="x1" data-id="Surprise"
                                    value="Surprise"><label for="checkboxFi">الاستماع </label></li>
                            <li><input type="checkbox" id="checkboxS" name="roads[]" class="x1"
                                    data-id="Twilight Sparkle" value="Twilight Sparkle">
                                <label for="checkboxS">التعليل
                                </label></li>
                            <li><input type="checkbox" id="checkboxSev" name="roads[]" class="x1" data-id="Fluttershy"
                                    value="Fluttershy"><label for="checkboxSev">التجربة </label></li>
                            <li><input type="checkbox" id="checkboxEig" name="roads[]" class="x1" data-id="Derpy Hooves"
                                    value="Derpy Hooves"><label for="checkboxEig">المخططات </label></li>
                            <li><input type="checkbox" id="checkboxNi" name="roads[]" class="x1"
                                    data-id="Princess Celestia" value="Princess Celestia"><label for="checkboxNi">العمل
                                    الفردي
                                </label></li>
                            <li><input type="checkbox" id="checkboxTen1" name="roads[]" class="x1" data-id="Gusty"
                                    value="Gusty"><label for="checkboxTen1">التعلم الثنائي </label></li>
                            <li class="ks-selected"><input type="checkbox" name="roads[]" class="x1" data-id="Discord"
                                    id="checkboxElev" value="Discord">
                                <label for="checkboxElev">التعلم التعاوني </label></li>
                            <li><input type="checkbox" id="checkboxTw" name="roads[]" class="x1" data-id="Clover"
                                    value="Clover"><label for="checkboxTw">التعلم الذاتي </label></li>
                            <li><input type="checkbox" id="checkboxThir" name="roads[]" class="x1"
                                    data-id="Baby Moondancer" value="Baby Moondancer"><label for="checkboxThir">التعلم
                                    بالأقران
                                </label></li>
                            <li><input type="checkbox" id="checkboxFourt" name="roads[]" class="x1" data-id="Medley"
                                    value="Medley"><label for="checkboxFourt">الحوار و المناقشة </label></li>
                            <li><input type="checkbox" id="checkbox2" name="roads[]" class="x1" data-id="Medley1"
                                    value="Medley1"><label for="checkbox2">التعلم باللعب </label></li>
                            <li><input type="checkbox" id="checkbox3" name="roads[]" class="x1" data-id="Medley2"
                                    value="Medley2"><label for="checkbox3">الاستنتاج </label></li>
                            <li><input type="checkbox" id="checkbox4" name="roads[]" class="x1" data-id="Medley3"
                                    value="Medley3"><label for="checkbox4">التحليل </label></li>
                            <li><input type="checkbox" id="checkbox5" name="roads[]" class="x1" data-id="Medley4"
                                    value="Medley4"><label for="checkbox5">التلخيص </label></li>
                            <li><input type="checkbox" id="checkbox6" name="roads[]" class="x1" data-id="Medley4"
                                    value="Medley4"><label for="checkbox6">التمييز والتحديد </label></li>
                        @else
                                   @foreach($road as $item4 )
                                   <li> <input type="checkbox" id="checkbox{{$item4->name}}" class="x1" data-id="{{$item4->id}}" name="roads[]"
                                    value="{{$item4->id}}">
                                <label for="checkbox{{$item4->name}}">{{$item4->name}} </label></li>
                                   @endforeach 
                                   @endif
                        </div>
                    </ul>
                </div>
                <!-- end new -->

            </div>
            <div class="row" style="justify-content: center;">
                <div class="data-card" style="width: 230px;">
                    <h7 style="text-align: center;">الواجب المنزلي : </h7>
                    <br>
                    <textarea name="homework" class="form-control" cols="5" rows="4">{{ $item->homework }}</textarea>

                </div>
                <div class="data-card" style="width: 230px;">
                    <h7 style="text-align: center;">ملاحظات : </h7>
                    <br>
                    <textarea name="note" class="form-control" cols="5" rows="4">
        {{ $item->note }}
      </textarea>
                </div>
                <div class="data-card" style="width: 230px;">
                    <h7 style="text-align: center;">المفاهيم و المصطلحات : </h7>
                    <br>
                    <textarea name="concepts_and_terminology" class="form-control" cols="5" rows="4">
                        {{ $item->concepts_and_terminology }}
                    </textarea>
                </div>
                <div class="data-card" style="width: 230px;">
                    <h7 style="text-align: center;">التقويم النهائي : </h7>
                    <br>
                    <textarea name="Final_calendar" class="form-control" cols="5" rows="4">
        {{ $item->Final_calendar }}
      </textarea>
                </div>

            </div>
            <!-- style for number-->

            <!-- end style -->

        </div>
        <div class="row" style="justify-content: center;padding-top: -200px;">
            <p>{{ $item->number }}</p>
            </div>

</div>
<button  id="buttondown"  class="btn btn-primary" style="width: 100px;display:none" >
<a href="{{ route('acadsupervisor.pdfdownload1',$item->id) }}" target="_blank">
    تنزيل الصفحة</a>
      </button>
      <button  id="buttondown1"  class="btn btn-primary" style="width: 100px;display:none"  >
        <a href="{{ route('acadsupervisor.multipdfdownload1',[$item->id,$teacher->id]) }}" target="_blank" >
            تنزيل الدفتر </a>
              </button>

@endforeach

@else

    <div>
        <div class="row" style="padding-right: 20px;">
            <h7>التحضير اليومي لمادة </h7>&nbsp;
            <input style="width: 200px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control"
                disabled value="{{ $lesson_id->name }}" type="text">
            <input style="width: 200px; text-align: center;margin-top: -20px;" name="lesson_id"
                class="common-input mb-20 form-control" hidden value="{{ $lesson_id->id }}" type="text">


        </div>
        <br>
        <div class="row" style="padding-right: 20px;">
            <h7>الصف : </h7> &nbsp;
            <input style="width: 100px; text-align: center;margin-top: -20px;" value="{{ $class_id->name }}" disabled
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
            <input hidden value="{{ $term->id }}" name="term_id" class="common-input mb-20 form-control"
                type="text">&nbsp;&nbsp;&nbsp;

            <input name="class_id" hidden value="{{ $class_id->id }}" type="text">

            &nbsp;&nbsp;
            <div class="room" style="display: inline-flex;">
                <h7>الشعبة : </h7> &nbsp;

                <input style="width: 30px; text-align: center;margin-top: -20px;" name="room_id[]"
                    class=" room1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
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
                <input style="width: 40px; text-align: center;margin-top: -20px;" name="Period[]"
                    class=" Period1 common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
                <h3 style="color: #f38639;">/</h3>&nbsp;
            </div>
            {{-- <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
            {{-- <h3 style="color: #f38639;">/</h3>&nbsp;
       <input style="width: 40px; text-align: center;margin-top: -20px;" class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp; --}}
            <!--h3 style="color: #f38639;margin-top: 20px;">/</h3>
       <input style="width: 50px; text-align: center;" class="common-input mb-20 form-control" type="text"-->
            <h7>زمن الحصة : </h7> &nbsp;
            <input style="width: 40px; text-align: center;margin-top: -20px;" name="class_time"
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
            <h7>عدد الحصص: </h7> &nbsp;
            <input name="number_of_lecture" style="width: 40px; text-align: center;margin-top: -20px;"
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;
        </div>

        <div class="row" style="padding-right: 20px;">
            <h7>التاريخ : </h7>&nbsp;
            <input style="width: 40px; text-align: center;margin-top: -20px;" placeholder="day" name="day"
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
            <h3 style="color: #f38639;">/</h3>
            <input style="width: 40px; text-align: center; margin-top: -20px;" placeholder="month" name="month"
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;
            <h3 style="color: #f38639">/</h3>
            <input style="width: 40px; text-align: center; margin-top: -20px;" placeholder="year" name="year"
                class="common-input mb-20 form-control" type="text" -->&nbsp;&nbsp;&nbsp;

            <h7>الوحدة : </h7>
            <input style="width: 100px; text-align: center; margin-top: -20px;" name="unit"
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;


            <h7>الدرس: </h7>
            <input style="width: 180px; text-align: center;margin-top: -20px;" name="lecture"
                class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;

        </div>
        <br>


        <!-- new div-->
        <div class="row" style="padding-right: 20px;">
            <h7>الهدف العام للدرس : </h7>
            <input name="The_general_goal_of_the_lesson" style="width: 240px; text-align: center;"
                class="common-input mb-20 form-control" type="text">
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <h7>تهيئة محفزة : </h7>
            <input name="stimulating_initialization" style="width: 240px; text-align: center;"
                class="common-input mb-20 form-control" type="text">
            <!-- end new div-->

        </div>
        <br>
        <br>
        <div class="row" style="justify-content: center;">

<input id="conatin" name="conatin" hidden type="text">
            <div class="data-card" style="width:900px">
                <div class="tab1cards">
                    <!-- one div-->
                    <input hidden class="i" value="1" type="text">
                    <div>
                        <a class="appendbtn"> <img src="{{  asset('edit-question/icons8-plus-24.png') }}" title="Add row"></a> &nbsp;&nbsp; <h7>
                            مؤشرات الأداء</h7>
                            <textarea  data-id="1" class="comt common-input mb-20 form-control" cols="5" rows="2"></textarea>
                        {{-- <input style="width: 180px; text-align: center;" data-id="1" class="comt common-input mb-20 form-control"
                            type="text"> --}}


                        <div class="appendme"></div>
                    </div>

                    <!-- end one -->
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- start tow div -->
                    <div>
                        </a>
                        <h7> الزمن </h7>
                        <textarea  data-id="1" class="comt common-input mb-20 form-control" cols="5" rows="2"></textarea>
                        {{-- <input style="width: 180px; text-align: center;"data-id="1" class="comt common-input mb-20 form-control"
                            type="text"> --}}
                        <div class="appendme"> </div>


                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- end two div -->
                    <!-- start three div -->
                    <div>
                        <h7> الاجراءات و المناشط </h7>
                        <textarea  data-id="1" class="comt common-input mb-20 form-control" cols="5" rows="2" style="text-align: right;
                        width: 180px;"></textarea>
                        {{-- <input style="width: 180px; text-align: center;"data-id="1" class="comt common-input mb-20 form-control"
                            type="text"> --}}
                        <div class="appendme"> </div>

                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- end three div -->
                    <!-- four div-->
                    <div>
                        <h7> التقويم المرحلي </h7>
                        <textarea  data-id="1" class="comt common-input mb-20 form-control" cols="5" rows="2"style="text-align: right;
                                 width: 180px;"></textarea>
                        {{-- <input style="width: 180px; text-align: center;" class="comt common-input mb-20 form-control"
                            type="text"> --}}
                        <div class="appendme"> </div>

                    </div>
                    <!-- end four -->


                </div>

            </div>


            <!-- end cards-->
        </div>
        <div class="row" style="justify-content: center;">
            <div class="data-card" style="width: 400px;">
                <h7 style="text-align: center;">الوسائل : </h7>

                <ul class="ks-cboxtags">
                    <div class="row" style="justify-content: center;">
                      @foreach($means as $item)
                        <li><input type="checkbox" id="checkbox{{$item->name}}" name="means[]" value="{{$item->id}}">
                            <label for="checkbox{{$item->name}}">{{$item->name}} </label></li>
                            @endforeach
    </div>
                </ul>
            </div>
            <!-- new checkbox -->
            <div class="data-card" style="width: 400px;">
                <h7 style="text-align: center;">الاستراتيجيات و الطرق المتبعة : </h7>

                <ul class="ks-cboxtags">
                    <div class="row " style="justify-content: center;">
                           @foreach($road as $item)
                        <li><input type="checkbox" id="checkbox{{$item->name}}" name="roads[]" value="{{$item->id}}">
                            <label for="checkbox{{$item->name}}">{{$item->name}} </label></li>
                            @endforeach    </div>
                </ul>
            </div>
            <!-- end new -->

        </div>
        <div class="row" style="justify-content: center;">
            <div class="data-card" style="width: 230px;">
                <h7 style="text-align: center;">الواجب المنزلي : </h7>
                <br>
                <textarea name="homework" class="form-control" cols="5" rows="4"></textarea>
            </div>
            <div class="data-card" style="width: 230px;">
                <h7 style="text-align: center;">ملاحظات : </h7>
                <br>
                <textarea name="note" class="form-control" cols="5" rows="4"></textarea>
            </div>
            <div class="data-card" style="width: 230px;" >
                <h7 style="text-align: center;">المفاهيم و المصطلحات : </h7>
                 <br>
             <textarea name="concepts_and_terminology" class="form-control" cols="5" rows="4" ></textarea>
              </div>
            <div class="data-card" style="width: 230px;">
                <h7 style="text-align: center;">التقويم النهائي : </h7>
                <br>
                <textarea name="Final_calendar" class="form-control" cols="5" rows="4"></textarea>
            </div>

        </div>
        <!-- style for number-->

        <!-- end style -->

    </div>

@endif
