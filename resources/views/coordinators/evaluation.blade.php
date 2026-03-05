@if($evaluation->count()>0)
@foreach ($evaluation as  $item )
<div id="load" style=" Dejavu Sans">
    <form style="width:1000px;"  action="{{ route('editevaluion') }}"  class="mb-5" method="post" >
        <!-- start menue -->
        @csrf
        <input   hidden name="id" value="{{ $item->id }}">

    <div class="data-card" style="margin: 0 auto;">
        <div class="text pl-3">
            <small style="color: red;" data-aos="fade-down" data-aos-duration="500" data-aos-delay="1000">
                يضع المقيمون اشارة تحت البنود التالية(غيرمقبول , مقبول , جيد , ممتاز ) ووضع مجموع درجات
                المعيار والملاحظات في الحقل الأخير </small>
            <br>
            <br>

            <div class="Row ">

                <div class="Column">
                    <div class="page">
                        <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input   hidden name="class_id" value="{{ $classes->id }}">
                            <input type="number" id="first-name" class="field__input" placeholder="" name="final_grade" value="{{ $item->final_grade }}" style="width: 100px; text-align: center;">
                            <span class="field__label-wrap" aria-hidden="true">
                                <span class="field__label"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="Column">
                    <h5 style="color: gray;">الدرجة النهائية </h5>

                </div>
                <div class="Column"></div>
                <div class="Column"></div>
                <div class="Column"></div>
                <div class="Column"></div>
                <div class="Column"></div>


            </div><!-- end row -->

            <div class="grid-container">
                <div class="Row">
                    <!--row-->
                    <div class="Column"></div>
                    <div class="Column">
                        <div class="page" style="margin-top: -60px;">
                            <div class="field field_v1">
                                <label for="first-name" class="ha-screen-reader"></label>
                                <input id="first-name" class="field__input" placeholder=""
                                    style="width: 150px;"  disabled readonly value="{{ $lesson->name }}">
                                    <input   hidden name="lesson_id"  value="{{ $lesson->id }}">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="Column">
                        <h5 style="width: 100px;color: gray;"> : المادة </h5>
                    </div>

                    <div class="Column">
                        <div class="page" style="margin-top: -60px; ">
                            <div class="field field_v1">
                                <label for="first-name" class="ha-screen-reader"></label>
                                <input   hidden name="teacher_id" value="{{ $teacher->id }}">
                                <input id="first-name" class="field__input" placeholder=""
                                    style="width: 150px;" disabled  readonly value="{{ $teacher->first_name }} {{ $teacher->last_name }}">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="Column">
                        <h5 style="width: 100px;color: gray;">:الاسم </h5>
                    </div>
                </div>
                <!--end row -->
            </div><!-- end grid-->




            <div class="grid-container">
                <div class="Row">
                    <!--row-->
                    <div class="Column"></div>
                    <div class="Column">
                        <div class="page" style="margin-top: -60px;">
                            <div class="field field_v1">
                                <label class="ha-screen-reader"></label>
                                <input class="field__input" placeholder="" required name="date" value="{{ $item->date }}" type="date"
                                    style="width: 154px;">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="Column">
                        <h5 style="width: 105px;color: gray;"> : تاريخ التقييم</h5>
                    </div>

                    <div class="Column">
                        <div class="page" style="margin-top: -60px; ">
                            <div class="field field_v1">
                                <label for="first-name" class="ha-screen-reader"></label>
                                <input id="first-name"  name="title" class="field__input" value="{{ $item->title }}" placeholder=""
                                    style="width: 150px;">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="Column">
                        <h5 style="width: 100px;color: gray;">:الموضوع</h5>
                    </div>
                </div>
                <!--end row -->
            </div><!-- end grid-->

            <!-- end new-->
        </div>
    </div>
    <!-- end 1 card -->
    <!-- start card 2-->
    <br>
    <br>
    <div class="data-card" style="margin: 0 auto ; margin-top: 30px;">
        <div class="text pl-3">
            <table>
                <thead>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المجالات </th>
                        <th rowspan="1" colspan="4" style="text-align: center;">مستوى الأداء </th>
                        <th rowspan="1" colspan="1">ملاحظات </th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 1 : اللغة</th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>سلامة اللغة والتعبير الصوتي تبعا للموقف التعليمي</td>
                        @if($item->Standard1==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22"
                                value="1" checked name="Standard1[]"> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard1==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard1==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                    value="3" > </td>
                                                @endif
                                                @if($item->Standard1==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                    value="4"checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                            value="4"> </td>
                                                        @endif


                        <td  style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard1_mark" value="{{ $item->Standard1_mark }}"   placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 2 : التمهيد </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                    </tr>
                    <tr>
                        <td>التهيئة الحافزة والدخول الى الدرس </td>

                        @if($item->Standard2==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard2==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard2==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard2==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                            value="4"> </td>
                                                        @endif



                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"   name="Standard2_mark"  value="{{ $item->Standard2_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 3 : الادارة الصفية
                        </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 24 </th>
                    </tr>
                    <tr>
                        <td>حيوية المعلم ولغة الجسد </td>
                        @if($item->Standard31==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard31==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard31==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard31==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;"  name="Standard31_mark" type="number"   value="{{ $item->Standard31_mark }}" >
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>استراتيجيات التعلم النشط </td>
                        @if($item->Standard32==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard32==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard32==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard32==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard32_mark"  value="{{ $item->Standard32_mark }}"  placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>مشاركة الطلبة وتعزيز تفاعلهم </td>
                        @if($item->Standard33==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard33==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard33==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard33==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard33_mark"  value="{{ $item->Standard33_mark }}"  placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 4 : كفايات التخصص
                        </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 48</th>
                    </tr>
                    <tr>
                        <td>احكام المادة العلمية </td>
                        @if($item->Standard41==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard41==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard41==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard41==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input"  type="number"  name="Standard41_mark"  value="{{ $item->Standard41_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>توضيح اهداف الدرس للطلبة </td>
                        @if($item->Standard42==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard42==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard42==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard42==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input"  type="number"  name="Standard42_mark"  value="{{ $item->Standard42_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>توضيح المفاهيم والمصطلحات الجديدة </td>
                        @if($item->Standard43==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard43==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard43==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard43==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"   name="Standard43_mark"  value="{{ $item->Standard43_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>تفعيل التكنلوجيا والوسائل التعليمية الحديثة التي تحقق الشروط التربوية </td>
                        @if($item->Standard44==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard44==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard44==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard44==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input"  type="number"   name="Standard44_mark"  value="{{ $item->Standard44_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>مراعاة الفروق الفردية للطلبة </td>
                        @if($item->Standard45==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard45==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard45==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard45==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard45_mark"  value="{{ $item->Standard45_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>التقويم المرحلي </td>
                        @if($item->Standard46==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard46==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard46==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard46==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard46_mark"  value="{{ $item->Standard46_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>طرح اسئلة تأملية لتنمية مهارات التفكير العليا </td>
                        @if($item->Standard47==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard47==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard47==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard47==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard47_mark"  value="{{ $item->Standard47_mark }}"  placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>التقويم النهائي </td>
                        @if($item->Standard48==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard48==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard48==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard48==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard48_mark"  value="{{ $item->Standard48_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 5: تعزيز السلوكيات
                        </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 12</th>
                    </tr>
                    <tr>
                        <td>الربط بالحياة العملية </td>
                        @if($item->Standard51==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard51==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard51==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard51==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard51_mark" type="number"  type="number"   value="{{ $item->Standard51_mark }}" class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>تعزيز القيم والسلوكيات الايجابية </td>
                        @if($item->Standard52==1)
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                value="1" checked> </td>
                                @else
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                    value="1" > </td>
                                @endif

                                @if($item->Standard52==2)
                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                    value="2" checked> </td>
                                        @else
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                            value="2"> </td>
                                        @endif

                                        @if($item->Standard52==3)
                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                            value="3" checked> </td>
                                                @else
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                    value="3"> </td>
                                                @endif
                                                @if($item->Standard52==4)
                                                <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                    value="4" checked> </td>
                                                        @else
                                                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                            value="4"> </td>
                                                        @endif
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input"  type="number"  name="Standard52_mark"  value="{{ $item->Standard52_mark }}" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="Row " style="margin: 0 auto ; text-align: center;">
        <p style="text-align: center"> {{ $item->number }}</p>
        <button class="btn btn-primary " type="submit" style="margin:0 auto; width: 200px; height:40px;margin-top: 70px;
        background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ
        </button>
    </div>
    </form>
    <button  id="buttondown"  class="btn btn-primary" style="width: 100px;display:none;color: aliceblue;" >

        <a href="{{ route('pdf',[$lesson->id,$teacher->id,$classes->id,$item->id]) }}"  target="_blank" style="color: aliceblue;">
            تنزيل التقيم</a>
              </button>
              <button  id="buttondown1"  class="btn btn-primary" style="width: 200px;display:none;color: aliceblue;"  >
                <a href="{{ route('all_pdf',[$lesson->id,$teacher->id,$classes->id]) }}"  target="_blank" style="color: aliceblue;">
                    تنزيل كامل صفحات التقييم </a>
                      </button>

</div>
@endforeach
@else
<div id="load" style=" Dejavu Sans">
    <form  action="{{ route('addevaluion') }}"   method="post" >
        <!-- start menue -->
        @csrf
        <div>
    <div class="data-card" style="margin: 0 auto;">
        <div class="text pl-3">
            <small style="color: red;" data-aos="fade-down" data-aos-duration="500" data-aos-delay="1000">
                يضع المقيمون اشارة تحت البنود التالية(غيرمقبول , مقبول , جيد , ممتاز ) ووضع مجموع درجات
                المعيار والملاحظات في الحقل الأخير </small>
            <br>
            <br>

            <div class="Row ">

                <div class="Column">
                    <div class="page">
                        <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input   hidden name="class_id" value="{{ $classes->id }}">
                            <input id="first-name" class="field__input" placeholder="" type="number"  name="final_grade" style="width: 100px; text-align: center;">
                            <span class="field__label-wrap" aria-hidden="true">
                                <span class="field__label"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="Column">
                    <h5 style="color: gray;">الدرجة النهائية </h5>

                </div>
                <div class="Column"></div>
                <div class="Column"></div>
                <div class="Column"></div>
                <div class="Column"></div>
                <div class="Column"></div>


            </div><!-- end row -->

            <div class="grid-container">
                <div class="Row">
                    <!--row-->
                    <div class="Column"></div>
                    <div class="Column">
                        <div class="page" style="margin-top: -60px;">
                            <div class="field field_v1">
                                <label for="first-name" class="ha-screen-reader"></label>
                                <input id="first-name" class="field__input" placeholder=""
                                    style="width: 150px;" disabled readonly value="{{ $lesson->name }}">
                                    <input   hidden name="lesson_id" value="{{ $lesson->id }}">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="Column">
                        <h5 style="width: 100px;color: gray;"> : المادة </h5>
                    </div>

                    <div class="Column">
                        <div class="page" style="margin-top: -60px; ">
                            <div class="field field_v1">
                                <label for="first-name" class="ha-screen-reader"></label>
                                <input   hidden name="teacher_id" value="{{ $teacher->id }}">
                                <input id="first-name" class="field__input" placeholder=""
                                    style="width: 150px;" disabled  readonly value="{{ $teacher->first_name }} {{ $teacher->last_name }}" >
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="Column">
                        <h5 style="width: 100px;color: gray;">:الاسم </h5>
                    </div>
                </div>
                <!--end row -->
            </div><!-- end grid-->




            <div class="grid-container">
                <div class="Row">
                    <!--row-->
                    <div class="Column"></div>
                    <div class="Column">
                        <div class="page" style="margin-top: -60px;">
                            <div class="field field_v1">
                                <label class="ha-screen-reader"></label>
                                <input class="field__input" placeholder="" required  name="date" type="date"
                                    style="width: 154px;">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="Column">
                        <h5 style="width: 105px;color: gray;"> : تاريخ التقييم</h5>
                    </div>

                    <div class="Column">
                        <div class="page" style="margin-top: -60px; ">
                            <div class="field field_v1">
                                <label for="first-name" class="ha-screen-reader"></label>
                                <input id="first-name" class="field__input" name="title" placeholder=""
                                    style="width: 150px;">
                                <span class="field__label-wrap" aria-hidden="true">
                                    <span class="field__label"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="Column">
                        <h5 style="width: 100px;color: gray;">:الموضوع</h5>
                    </div>
                </div>
                <!--end row -->
            </div><!-- end grid-->

            <!-- end new-->
        </div>
    </div>
    <!-- end 1 card -->
    <!-- start card 2-->
    <br>
    <br>
    <div class="data-card" style="margin: 0 auto ; margin-top: 30px;">
        <div class="text pl-3">
            <table>
                <thead>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المجالات </th>
                        <th rowspan="1" colspan="4" style="text-align: center;">مستوى الأداء </th>
                        <th rowspan="1" colspan="1">ملاحظات </th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 1 : اللغة</th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>سلامة اللغة والتعبير الصوتي تبعا للموقف التعليمي</td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                value="4"> </td>
                        <td>
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard1_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 2 : التمهيد </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                    </tr>
                    <tr>
                        <td>التهيئة الحافزة والدخول الى الدرس </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard2_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 3 : الادارة الصفية
                        </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 24 </th>
                    </tr>
                    <tr>
                        <td>حيوية المعلم ولغة الجسد </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard31_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>استراتيجيات التعلم النشط </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard32_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>مشاركة الطلبة وتعزيز تفاعلهم </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard33_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 4 : كفايات التخصص
                        </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 48</th>
                    </tr>
                    <tr>
                        <td>احكام المادة العلمية </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard41_mark"  placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>توضيح اهداف الدرس للطلبة </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input"  type="number" name="Standard42_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>توضيح المفاهيم والمصطلحات الجديدة </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" class="field__input" type="number"  name="Standard43_mark" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>تفعيل التكنلوجيا والوسائل التعليمية الحديثة التي تحقق الشروط التربوية </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard44_mark"  type="number" class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>مراعاة الفروق الفردية للطلبة </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard45_mark"  type="number"  class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>التقويم المرحلي </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard46_mark" type="number"  class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>طرح اسئلة تأملية لتنمية مهارات التفكير العليا </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name"   name="Standard47_mark" type="number" class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>التقويم النهائي </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard48_mark" type="number"  class="field__input" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 5: تعزيز السلوكيات
                        </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 12</th>
                    </tr>
                    <tr>
                        <td>الربط بالحياة العملية </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard51_mark" class="field__input"  type="number" placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>تعزيز القيم والسلوكيات الايجابية </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                value="1"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                value="2"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                value="3"> </td>
                        <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                value="4"> </td>
                        <td style="text-align: center;">
                            <div class="page" style="margin-top: -30px;">
                                <div class="field field_v1">
                                    <label for="first-name" class="ha-screen-reader"></label>
                                    <input id="first-name" name="Standard52_mark" class="field__input" type="number"  placeholder=""
                                        style="width: 100px; text-align: center;">
                                    <span class="field__label-wrap" aria-hidden="true">
                                        <span class="field__label"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
        </div>
    <div class="Row " style="margin: 0 auto ; text-align: center;">
        <button type="submit" class="btn btn-primary " style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;
        background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ
        </button>
    </div>
    </form>

</div>
@endif
