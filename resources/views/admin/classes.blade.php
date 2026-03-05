@extends('admin.master')
@section('style')
    <style>
        .custom-file-label {
            display: none !important;
        }

        .custom-file-label {
            display: none;
        }

        .pagination {
            justify-content: center !important;
        }

        button.close {
            margin: 0px !important;
            padding: 0px !important;
            float: left !important;
        }

        .modal-header {
            direction: rtl;
        }
    </style>
@endsection


@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">قسم الصفوف</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if (session()->has('success'))
    -->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--
    @endif-->



        <div class="card-header border-0">
            <h3 class="mb-0">جدول الصفوف</h3>
        </div>

        <div class="table-responsive">
            @can('create_class')
                <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">إنشاء صف جديد</i></a>
            @endcan
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> الاسم بالعربية</th>
                        <th scope="col" class="sort" data-sort="budget"> الاسم بالانكليزية</th>
                        <th scope="col" class="sort" data-sort="budget"> التكلفة </th>
                        <th scope="col" class="sort" data-sort="budget"> الصورة</th>
                        <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($classes as $item)
                        <tr>

                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->name }}
                            </td>

                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->name_en }}
                            </td>
                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->fixed_cost }}
                            </td>
                            <td>


                                @if ($item->image != null)
                                    <img src="{{ asset('storage/' . $item->image) }}" width="50px" height="50px"
                                        alt="">
                                @endif
                            </td>

                            <td class="text-right">
                                <a href="{{ route('classroom', $item->id) }}" class="btn btn-success"
                                    style="margin-left: 10px">الشعب</a>
                                @can('update_class')
                                @if(count($item->stages)>0)
                                 <a href=".editClassModal" class="btn btn-secondary edit"
                                        data-name="{{ $item->name }}"
                                        data-name_en="{{ $item->name_en }}"
                                        data-fixed_cost="{{ $item->fixed_cost }}"
                                        data-description_en="{{ $item->description_en }}"
                                        data-description_ar="{{ $item->description_ar }}"
                                        data-cildren_count="{{ $item->cildren_count }}"
                                        data-lesson_count="{{ $item->lesson_count }}"
                                        data-week_count="{{ $item->week_count }}"
                                        data-cost_id="{{ $item->cost_id }}"
                                        data-image="{{ $item->image }}"
                                        data-stage_id="{{ $item->stage_id }}"
                                        data-stages_id="{{ $item->stages[0]->id }}"
                                        data-report_card="{{ $item->report_card }}"
                                         data-id="{{ $item->id }}"
                                           data-classcost="{{ $item->classCost }}"
                                            data-is_scientific="{{ $item->is_scientific }}"
                                        data-next_class="{{ $item->next_class }}" data-toggle="modal" style="color: white">
                                        تعديل </a>
                                        @else
                                         <a href=".editClassModal" class="btn btn-secondary edit"
                                        data-name="{{ $item->name }}"
                                        data-name_en="{{ $item->name_en }}"
                                        data-fixed_cost="{{ $item->fixed_cost }}"
                                        data-description_en="{{ $item->description_en }}"
                                        data-description_ar="{{ $item->description_ar }}"
                                        data-cildren_count="{{ $item->cildren_count }}"
                                        data-lesson_count="{{ $item->lesson_count }}"
                                        data-week_count="{{ $item->week_count }}"
                                        data-cost_id="{{ $item->cost_id }}"
                                        data-image="{{ $item->image }}"
                                        data-stage_id="{{ $item->stage_id }}"
                                        data-stages_id=""
                                        data-report_card="{{ $item->report_card }}"
                                         data-id="{{ $item->id }}"
                                            data-is_scientific="{{ $item->is_scientific }}"
                                           data-classcost="{{ $item->classCost }}"
                                        data-next_class="{{ $item->next_class }}" data-toggle="modal" style="color: white">
                                        تعديل </a>
                                @endif

                                @endcan
                                @can('delete_class')
                                    <a href=".deleteClassModal" class="delete2 btn btn-warning text-light "
                                        style="color: white !important;background: #4e90aa  !important;border-color: #008CC4 !important;
                      margin-right: 10px"
                                        data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-toggle="modal">
                                        {{-- <i class="fa fa-trash" style="font-size: 30px;color: #af686e"></i> --}}
                                        حذف
                                    </a>
                                @endcan

                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>

        </div>

        <div class="clearfix" style="padding-left:10px;text-align: center">
            <div class="hint-text">Showing
                <b>{{ !request('page') ? '1' : request('page') }}</b>
                out of <b>{{ ceil($count / paginate_num) }}</b> entries
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $classes->links() }}
                </div>
            </div>
        </div>


    </div>
    {{-- </div> --}}



    {{-- $class_cost = Class_cost::whereIn('class_id', $all_classes->pluck('id'))
    ->whereIn('country_id', $countries_currencies->pluck('id'))
->get(); --}}



    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('class_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة صف</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:right">
                            <label>اسم الصف بالعربية</label>
                            <input type="text" name="class_name" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label>اسم الصف بالانكليزية</label>
                            <input type="text" name="class_name_en" class="form-control" value=""
                                placeholder="example :first" maxlength="20" required>
                        </div>
                        <div class="form-group" style="text-align:right">
                                        <label>اذا كان الصف مرحلة ثانوية هل هو ادبي او علمي</label>
                                         <select name="is_scientific" id="" class="form-control"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="" hidden> حدد  هل      الصف ادبي او علمي     </option>

                                                <option value="1">أدبي</option>
                                                <option value="2"> علمي</option>

                                        </select>
                                    </div>
                        <div class="form-group" style="text-align:right">
                            <label>   الحلقة  الدراسية </label>

                            <select name="stage_id" id="" class="form-control lesson_id"
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد   الحلقة  الدراسية </option>
                                @foreach($stages as $stage)
                                <option value="{{$stage->id}}"> {{ $stage->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> المرحلة الدراسية </label>

                            <select name="stages_id" id="" class="form-control lesson_id"
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد  المرحلة الدراسية </option>
                                @foreach($stage1 as $stage)
                                <option value="{{$stage->id}}"> {{ $stage->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        {{-- <div class="form-group" style="text-align:right">
                            <label> المرحلة الدراسية </label>



                            <select name="stage_id" id="" class="form-control lesson_id"
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد المرحلة الدراسية </option>
                                <input id="cost_id" type="number" name="cost" class="form-control" value=""
                                style="direction: rtl">

                            </select>
                        </div> --}}
                        <div class="form-group" style="text-align:right">
                            <label> تصميم الجلاء </label>

                            <select name="report_card" id="" class="form-control lesson_id"
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد تصميم الجلاء </option>
                                <option value="1"> صف 1-4</option>
                                <option value="2">صف 5-6</option>
                                <option value="3"> صف 7-8</option>
                                <option value="4"> صف 9</option>
                                <option value="5"> صف 10 علمي </option>
                                <option value="6"> صف 10 أدبي</option>
                                <option value="7"> صف 11 علمي </option>
                                <option value="8"> صف 11 أدبي</option>
                                <option value="9"> صف 12 علمي </option>
                                <option value="10"> صف 12 أدبي</option>
                                {{-- <option value="11">   فئة ب مستوى اول </option>
                                <option value="12">  فئة ب مستوى ثاني </option>
                                <option value="13"> فئة ب مستوى ثالث</option>
                                <option value="14"> فئة ب مستوى رابع   </option> --}}
                            </select>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> تحديد الصف التالي عند النجاح </label>

                            <select name="next_class" id="" class="form-control "
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد الصف التالي </option>
                                @foreach ($all_classes as $class)
                                    <option value="{{ $class->id }}"> {{ $class->name }}</option>
                                @endforeach
                                <option value="0"> لا يوجد</option>
                            </select>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> المبلغ </label>
                            <input type="number" id="fixed_cost" name="fixed_cost" class="form-control" value=""
                                placeholder="600" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> الوصف بالانكليزية </label>
                            <input type="text" id="description_en" name="description_en" class="form-control" value=""
                                placeholder="Example: An ideal class studying the approved first-grade curriculum." maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> الوصف بالعربية </label>
                            <input type="text" id="description_ar" name="description_ar" class="form-control" value=""
                                placeholder="مثال:صف مثالي يدرس منهاج الصف الاول المعتمد" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> عدد الطلاب</label>
                            <input type="number" id="cildren_count" name="cildren_count" min="0" class="form-control" value=""
                                placeholder="20" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> عدد الدروس  </label>
                            <input type="number" id="lesson_count" name="lesson_count" min="0" class="form-control" value=""
                                placeholder="24" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> عدد الأسابيع </label>
                            <input type="number" id="week_count" name="week_count" min="0" class="form-control" value=""
                                placeholder="16" maxlength="20" required>
                        </div>
                        {{-- <div class="form-group" id="show" style="text-align:right">
                            <input id="cost_id" type="hidden" name="cost" class="form-control" value=""
                            style="direction: rtl">
                            <!--<label>المبلغ</label>-->
                            <!--<select id="country_select" name="country_id[]" class="form-control">-->
                            <!--    <option value="">اختر البلد للدفع</option>-->
                            <!--    @foreach ($countries_currencies as $item)-->
                            <!--    @if ($item->active == 1)-->
                            <!--        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>-->
                            <!--    @endif-->
                            <!--@endforeach-->
                            <!--</select>-->


                              @foreach ($countries_currencies as $item)
                                @if ($item->active == 1)
                                       <label> المبلغ {{ $item->name_ar }}   </label>
                                       <input  type="number"  class="form-control" name="countries[{{$item->id}}]"  required >
                                @endif
                            @endforeach
                            <br>
                            <br>

                        </div> --}}
                        <div class="form-group" style="text-align:right">
                            <label>الصورة</label>
                            <input type="file" name="image" onchange="loadFile(event)" id="input_image11"
                                class="input_image form-control" required>
                            <label class="custom-file-label" for="customFileLang">Select file</label>
                            <span class="close-btn del_img" title="الغاء" id="del_img"
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none" src="" class="output" width="200px"
                                alt="">
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: right;">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
//     <script>

//     // Get the select element and the show_inputs div
//     var selectElement = document.getElementById('country_select');
//     var showInputsDiv = document.querySelector('.show_inputs');
//     var classIdInput = document.getElementById('class_id');
//     // Create an array to store the country IDs and costs
//     var countryData = [];
//     // Add event listener to the select element
//     selectElement.addEventListener('change', function() {
//         // Get the selected option's value and text
//         var selectedOption = selectElement.value;
//         var selectedOptionText = selectElement.options[selectElement.selectedIndex].text;
//         // Create a new input element
//         var newInput = document.createElement('input');
//         newInput.type = 'number';
//         newInput.name = 'cost';
//         newInput.className = 'form-control mb-3';
//         newInput.style.direction = 'rtl';
//         newInput.placeholder = 'ادخل المبلغ لدولة' + ' ' + selectedOptionText;
//         newInput.required = true;
//         // Append the new input element to the show_inputs div
//         showInputsDiv.appendChild(newInput);
//         // Store the country ID and cost in the countryData array
//         countryData.push({
//             country_id: selectedOption,
//             cost: null // You can set an initial value or leave it as null
//         });
//         // Remove the selected option from the select element
//         selectElement.remove(selectElement.selectedIndex);
//     });

//     // Function to send an AJAX request to store the cost value in the database
//     function storeCost(countryId, classId, cost) {
//         var xhr = new XMLHttpRequest();
//         xhr.open('POST', '/class_store', true);
//         xhr.setRequestHeader('Content-Type', 'application/json');
//         xhr.onreadystatechange = function() {
//             if (xhr.readyState === 4 && xhr.status === 200) {
//                 console.log(xhr.responseText);
//             }
//         };
//         xhr.send(JSON.stringify({
//             country_id: countryId,
//             class_id: classId,
//             cost: cost
//         }));
//     }

//     // Add event listener to the show_inputs div to capture cost value changes
//     showInputsDiv.addEventListener('change', function(event) {
//         var target = event.target;
//         if (target.tagName === 'INPUT' && target.name === 'cost') {
//             var index = Array.from(showInputsDiv.children).indexOf(target);
//             var value = parseFloat(target.value);
//             if (!isNaN(value)) {
//                 countryData[index].cost = value;
//                 // Call the storeCost function to store the cost value in the database
//                 storeCost(countryData[index].country_id, classIdInput.value, value);
//             } else {
//                 // Handle the case when the entered value is not a valid number
//                 alert('Please enter a valid number for the cost.');
//             }
//         }
//     });
// </script>








    <div class="modal fade editClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_update" method="POST" action="{{ route('class_update') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الصف</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                         <input type="hidden" name="class_id" id="class_id10">
                        <div class="form-group" style="text-align:right">
                            <label>اسم الصف بالعربية</label>
                            <input type="text" name="class_name" class="form-control" required
                                        value="" style="direction: rtl" id="name"
                                        placeholder="مثال :أول" maxlength="20" >
                        </div>
                                          <div class="form-group" style="text-align:right">
                                        <label>اذا كان الصف مرحلة ثانوية هل هو ادبي او علمي</label>
                                         <select name="is_scientific" id="is_scientific" class="form-control is_scientific"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="" hidden> حدد  هل      الصف ادبي او علمي     </option>

                                                <option value="1">أدبي</option>
                                                <option value="2"> علمي</option>

                                        </select>
                                      </div>
                        <div class="form-group" style="text-align:right">
                            <label>اسم الصف بالانكليزية</label>
                             <input type="text" name="class_name_en" id="name_en" class="form-control"
                                        value=""
                                        placeholder="example :first" maxlength="20" >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>   الحقلة الدراسية </label>

                            <select name="stage_id" id="stage_id" class="form-control stage_id"
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد  الحلقة الدراسية </option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"> {{ $stage->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> المرحلة الدراسية </label>

                            <select name="stages_id" id="stages_id" class="form-control lesson_id"
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد  المرحلة الدراسية </option>
                                @foreach($stage1 as $stage)
                                <option value="{{$stage->id}}"> {{ $stage->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> تصميم الجلاء </label>

                            <select name="report_card" id="report_card" class="form-control "
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد تصميم الجلاء </option>
                                <option value="1"> صف 1-4</option>
                                <option value="2">صف 5-6</option>
                                <option value="3"> صف 7-8</option>
                                <option value="4"> صف 9</option>
                                <option value="5"> صف 10 علمي </option>
                                <option value="6"> صف 10 أدبي</option>
                                <option value="7"> صف 11 علمي </option>
                                <option value="8"> صف 11 أدبي</option>
                                <option value="9"> صف 12 علمي </option>
                                <option value="10"> صف 12 أدبي</option>
                                {{-- <option value="11">   فئة ب مستوى اول </option>
                                <option value="12">  فئة ب مستوى ثاني </option>
                                <option value="13"> فئة ب مستوى ثالث</option>
                                <option value="14"> فئة ب مستوى رابع   </option> --}}


                            </select>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> تحديد الصف التالي عند النجاح </label>

                            <select name="next_class" id="next_class" class="form-control "
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد الصف التالي </option>
                                @foreach ($all_classes as $class)
                                    <option value="{{ $class->id }}"> {{ $class->name }}</option>
                                @endforeach
                                <option value="0"> لا يوجد</option>
                            </select>
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label> المبلغ </label>
                             <input type="number" name="fixed_cost" id="fixed_cost" class="form-control"
                                        value=""
                                        placeholder="" maxlength="20" >
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> الوصف بالانكليزية </label>
                            <input type="text" id="description_en" name="description_en" class="form-control" value=""
                                placeholder="" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> الوصف بالعربية </label>
                            <input type="text" id="description_ar" name="description_ar" class="form-control" value=""
                                placeholder="" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> عدد الطلاب</label>
                            <input type="number" id="cildren_count" min="0" name="cildren_count" class="form-control" value=""
                                placeholder="" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> عدد الدروس  </label>
                            <input type="number" id="lesson_count" min="0" name="lesson_count" class="form-control" value=""
                                placeholder="" maxlength="20" required>
                        </div>
                        <div class="form-group" id="show" style="text-align:right">
                            <label> عدد الأسابيع </label>
                            <input type="number" id="week_count" min="0" name="week_count" class="form-control" value=""
                                placeholder="" maxlength="20" required>
                        </div>









                        <div class="form-group" style="text-align:right">
                            <label>الصورة </label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            <img src="" width="50px" height="50px" class="del_edit_img" id="image"
                                alt="لايوجد">
                            <span class="close-btn del_icon" title="الغاء" id=""
                                style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>

                            <input type="file" name="image" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="ar">
                            <label class="custom-file-label" for="customFileLang"> اختر صورة</label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src="" width="200px"
                                alt="">
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: right;">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade deleteEmployeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_delete" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h4 class="modal-title">Delete element</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                        <button class="btn btn-danger">Delete</button>


                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- delete class  --}}

    <div class="modal fade deleteClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_delete" action="{{ route('class_delete') }}" method="POST" autocomplete="off">

                    @csrf
                    <input type="hidden" name="class_id_delete" id="class_id_delete" required>

                    <div class="modal-header">
                        <h4 class="modal-title" style="color: #f00">حذف الصف</h4>
                        <button type="button" class="close" style="color: #f00" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group" style="text-align:right">
                            <label style="font-size: 18px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


                            <input type="password" style="direction:rtl" id="delete_code" name="delete_code"
                                class="form-control a" value="" placeholder="أدخل كود الحذف  " required>
                        </div>

                    </div>
                    <div class="modal-footer" style="justify-content: right;">
                        <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                        <button class="btn btn-danger">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end delete class  --}}


    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
    $('.edit').click(function() {
        var class_id = $(this).data('id');
        var name = $(this).data('name');
        var name_en = $(this).data('name_en');
        var fixed_cost = $(this).data('fixed_cost');
        var description_en = $(this).data('description_en');
        var description_ar = $(this).data('description_ar');
        var cildren_count = $(this).data('cildren_count');
        var lesson_count = $(this).data('lesson_count');
        var week_count = $(this).data('week_count');
        var cost_id = $(this).data('cost_id');
        var image = $(this).data('image');
        var stage_id = $(this).data('stage_id');
        var stages_id = $(this).data('stages_id');
        var report_card = $(this).data('report_card');
        var next_class = $(this).data('next_class');
         var classCost = $(this).data('classcost');
          var is_scientific = $(this).data('is_scientific');
          $.each($('.classCost10'), function (index, val) {
           $(this).val('');


          })
          $.each(classCost, function (index, val) {
           $(`.modal-body #${val.country_id}`).val(val.cost);


          })

        // Assign values to modal form fields
        $('.modal-body #class_id10').val(class_id);
        $('.modal-body #name').val(name);
        $('.modal-body #name_en').val(name_en);
        $('.modal-body #fixed_cost').val(fixed_cost);
        $('.modal-body #description_en').val(description_en);
        $('.modal-body #description_ar').val(description_ar);
        $('.modal-body #cildren_count').val(cildren_count);
        $('.modal-body #lesson_count').val(lesson_count);
        $('.modal-body #week_count').val(week_count);
        $('.modal-body #cost_id').val(cost_id);
        $('.modal-body #image').attr('src', image);
        $('.modal-body #stage_id').val(stage_id);
         $('.modal-body #stages_id').val(stages_id);
        $('.modal-body #report_card').val(report_card);
        $('.modal-body #next_class').val(next_class);
        $('.modal-body #is_scientific').val(is_scientific);

    });
});
    </script>
    <script>

        $('.alert-success').hide(5000);


        $(document).ready(function() {

            $('.delete').on('click', function() {

                var id = $(this).data('id');
                var url = "{{ URL::to('SMARMANger/admin/students') }}";
                $('#form_delete').attr("action", url);

            });



            // $('.edit').on('click', function () {
            //     var id = $(this).data('id');
            //     var name=$(this).data('name');
            //     var name_en=$(this).data('name_en');
            //     var image=$(this).data('image');
            //     var annual_installment=$(this).data('annual_installment');
            //     var stage_id=$(this).data('stage_id');
            //     var report_card=$(this).data('report_card');
            //     var next_class=$(this).data('next_class');
            //     $('#class_id').val(id);
            //     $('#name').val(name);
            //     $('#name_en').val(name_en);
            //     $('#image').attr('src',`{{ asset('storage/${image}') }}`);
            //     $('#annual_installment').val(annual_installment);
            //     $('#stage_id').val(stage_id);
            //     $('#report_card').val(report_card);
            //     $('#next_class').val(next_class);
            // });



            // // Clear previous content in the div
            // $('#annual_installment_div').empty();

            // // Generate unique IDs for each input field
            // var index = 0;
            // $.each(annual_installment, function (index, installment) {
            //     var installmentElement = $(`
        //         <input type="number" name="cost" id="annual_installment_${index}" class="form-control mb-2" value="${installment}" style="direction: rtl">
        //     `);
            //     $('#annual_installment_div').append(installmentElement);
            //     index++;
            // });



            $(document).on('click', '.delete2', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#name_delete').val(name);
                $('#class_id_delete').val(id);
            });


        });
    </script>

    <script>
        var loadFile = function(event) {
            var id = event.target.id;
            var input_image = document.getElementById(id);
            var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img = input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

                output.setAttribute('style', 'display:inline');
                del_img.setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

        };


        var loadFile_edit = function(event) {
            var id = event.target.id;
            var input_image = document.getElementById(id);
            var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img = input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style', 'display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style', 'display:none');

            output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

                output.setAttribute('style', 'display:inline');
                del_img.setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

        };


        $(document).on('click', '.del_img', function() {
            $(this).nextAll('.output').attr('style', 'display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click', '.del_icon', function() {
            $(this).prevAll('.del:first').attr('disabled', false);
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });
    </script>
@endsection
