@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: white !important;
    }
    .form-group{
        text-align: right;
    }
    label{
        font-size: 20px;
        color: black;
    }
    input{
        font-size: 17px !important;
    }
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center !important;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid black !important;
        border-top: 1px solid black !important;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .form-group{
        margin: 0px !important;
    }
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم التوظيف</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')



  <div class="modal fade deletelessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('employee_delete') }}" method="POST"  autocomplete="off">

                                @csrf
                                <input type="hidden" name="employee_id" id="employee_id_delete" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00">حذف الطلب</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> هل أنت متأكد من حذف الطلب </label>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">تأكيد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                
<div class="modal fade" id="emp_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document" style="min-width:80%">
        <div class="modal-content">

                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">معلومات الطلب</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" >
                        <div class="col-12" style="text-align: right;font-size: 25px;color: black;">
                                <form action="{{ route('recognize_employee') }}" method="post" style="text-align: right;" >
                                    @csrf
                                    <input type="text" id="recognize_id" name="id"  hidden>
                                    <input type="submit" class="btn btn-success" value="تمييز الطلب" > 
                                </form>
                        </div>
                         <div class="col-12 col-lg-12" style="text-align: center;font-size: 30px;color: black;" >
                              <lable id="edit_type_time" style="text-aligh:center;width:100%;font-size:25px" >  </lable>
                        </div>
                        <div class="col-12 col-lg-3" style="text-align: right;font-size: 25px;color: black;">
                        </div>
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الوظائف </label>
                            <table class="table" >
                                <tbody id="edit_job">
                                    
                                </tbody>
                            </table>                        </div>
                        <div class="col-12 col-lg-3" style="text-align: right;font-size: 25px;color: black;">
                        </div>
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;" >
                            <label> الاسم </label>
                            <input type="text" readonly class="form-control" id="edit_name" >
                        </div>

                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;" >
                            <label> مكان وتاريخ الميلاد </label>
                            <input type="text" readonly class="form-control" id="edit_date" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الجنس </label>
                            <input type="text" readonly class="form-control" id="edit_gender" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الديانة </label>
                            <input type="text" readonly class="form-control" id="edit_religion" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الهاتف الأرضي </label>
                            <input type="text" readonly class="form-control" id="edit_landline_phone" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الهاتف </label>
                            <input type="text" readonly class="form-control" id="edit_phone" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> البريد الالكتروني </label>
                            <input type="text" readonly class="form-control" id="edit_email" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> العنوان </label>
                            <input type="text" readonly class="form-control" id="edit_address" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الوضع العسكري </label>
                            <input type="text" readonly class="form-control" id="edit_military" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> الوضع العائلي </label>
                            <input type="text" readonly class="form-control" id="edit_family_status" >
                        </div>
                        
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> المؤهل العلمي </label>
                            <input type="text" readonly class="form-control" id="edit_qualification" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> التخصص </label>
                            <input type="text" readonly class="form-control" id="edit_specialization" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> مكان وتاريخ المؤهل العلمي </label>
                            <input type="text" readonly class="form-control" id="edit_qualification_place" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> المؤهل التربوي </label>
                            <input type="text" readonly class="form-control" id="edit_educational_qualification" >
                        </div>
                        
                        <div class="col-12 col-lg-6" style="text-align: right;font-size: 25px;color: black;">
                            <label> مكان  وتاريخ المؤهل التربوي </label>
                            <input type="text" readonly class="form-control" id="edit_educational_qualification_place" >
                        </div>
                        
                        <div class="col-12 " style="text-align: center;font-size: 25px;color: black;">
                            <label style="font-size: 25px;font-weight: 600;color: #1a1a8d;" > اللغات </label>
                            <table class="table" >
                                <tbody id="edit_languages">
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-12" style="text-align: center;font-size: 25px;color: black;">
                            <label style="font-size: 25px;font-weight: 600;color: #1a1a8d;" > دورات الكمبيوتر </label>
                            <table class="table">
                                <thead>
                                    <th>اسم الدورة</th>
                                    <th>جهة التدريب	</th>
                                    <th>سنة الحصول عليها	</th>
                                    <th>مكان التدريب	</th>
                                </thead>
                                <tbody id="edit_computer_course">
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        
                    <div class="col-12" style="text-align: center;font-size: 25px;color: black;">
                            <label style="font-size: 25px;font-weight: 600;color: #1a1a8d;" > دورات تدريبية </label>
                            <table class="table">
                                <thead>
                                    <th>اسم الدورة</th>
                                    <th>جهة التدريب	</th>
                                    <th>سنة الحصول عليها	</th>
                                    <th>مكان التدريب	</th>
                                </thead>
                                <tbody id="edit_traning_course">
                                    
                                </tbody>
                            </table>
                    </div>
                    
                    <div class="col-12" style="text-align: center;font-size: 25px;color: black;">
                            <label style="font-size: 25px;font-weight: 600;color: #1a1a8d;" > الخبرات السابقة </label>
                            <table  class="table">
                                <thead>
                                    <th>الوظيفة</th>
                                    <th>سنوات العمل الفعلية	</th>
                                    <th>اسم العمل	</th>
                                    <th>مكان العمل	</th>
                                </thead>
                                <tbody id="edit_jobs">
                                    
                                </tbody>
                            </table>
                    </div>
                    
                        <div class="col-12" style="text-align: center;font-size: 25px;color: black;">
                             <a class="btn btn-success mt-4 mb-4  show"  > التقييم </a> 
                             <div class="Evaluation" style="display:none">
                                 <button class="btn btn-success mt-4 mb-4" id="hide1"  style="float: left;" > X </button>
                             
                                <form action="{{ route('recognize_employee') }}" method="post" style="text-align: center;" >
                                    @csrf
                                    <input type="text" id="evaluation_id" name="id" value=""  hidden>
                                    
                                    <table class="table" >
                                        <thead>
                                            <tr>
                                                <th style="background:yellow;" > الجزء الأول </th>
                                                <th> الأمتحان التحريري </th>
                                                <th> نموذج الامتحان 
                                                <input type="text" id="exam_number" class="form-control"required  name="exam_number" style="max-width: 50px;display: inline;" >   </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                  <td> المادة العلمية 
                                                  <input type="number"   min="0"  id="scientific_material" class="form-control part1" data-max="70" name="scientific_material" style="max-width: 66px;display: inline;" >  /70  </td>
                                                  <td> المادة التربوية 
                                                  <input type="number"  min="0" id="educational_material" class="form-control part1" data-max="30" name="educational_material" style="max-width: 66px;display: inline;" > /30  </td>
                                                    <td> النتيجة <input type="text" readonly class="form-control" style="max-width: 50px;display: inline;" id="resuls_part1" > /100  </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    
                                    <table class="table" >
                                        <thead>
                                            <tr>
                                                <th style="background:yellow;"  colspan="2"> الجزء الثاني </th>
                                                <th  colspan="3"> المقابلة </th>
                                                <th  colspan="2" >  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>  المظهر <input type="number" min="0"  class="form-control part2" name="style" style="max-width: 66px;display: inline;" data-max="10" id="style" >  /10  </td>
                                                <td> معايير الجسد <input type="number" min="0"  class="form-control part2"  name="body_standards" style="max-width: 66px;display: inline;" data-max="10" id="body_standards" > /10  </td>
                                                <td> استخدام الكمبيوتر <input type="number" min="0" class="form-control part2" name="computer_use" style="max-width: 66px;display: inline;" data-max="10" id="computer_use" > /10  </td>
                                                <td> الضغط النفسي <input type="number"  min="0" class="form-control part2" name="stress" style="max-width: 66px;display: inline;" data-max="10"  id="stress"> /10  </td>
                                                <td> الخبرة التدريسية <input type="number" min="0" class="form-control part2" name="teaching_experience" style="max-width: 66px;display: inline;" data-max="20"id="teaching_experience"> /20  </td>
                                                <td> المادة العلمية <input type="number" min="0" class="form-control part2" name="scientific_material2" style="max-width: 66px;display: inline;" data-max="40"id="scientific_material2" > /40  </td>
                                                <td> النتيجة <input  readonly type="text" class="form-control part2" style="max-width: 50px;display: inline;" id="resuls_part2" > /100  </td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    
                                    
                                    
                                <table class="table" >
                                        <thead>
                                            <tr>
                                                <th style="background:yellow;"  colspan="2"> الجزء الثالث </th>
                                                <th  colspan="2"> حصة مشاهدة </th>
                                                <th  colspan="2" >  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                              <td>  اللغة <input type="number" class="form-control part3" name="language" style="max-width: 66px;display: inline;" data-max="8" id="language">  /8  </td>
                                              <td> التمهيد <input type="number" class="form-control part3" name="preface" style="max-width: 66px;display: inline;" data-max="8"id="preface" > /8  </td>
                                                <td> الإدارة الصفية <input type="number" min="0" class="form-control part3" name="classroom_management" style="max-width: 66px;display: inline;" data-max="24"id="classroom_management"> /24  </td>
                                                <td> كفايات التخصص <input type="number" min="0" class="form-control part3" name="specialization_competencies" style="max-width: 66px;display: inline;" data-max="48" id="specialization_competencies"> /48  </td>
                                                <td> تعزيز السلوكيات <input type="number" min="0" class="form-control part3" name="reinforce_behaviors" style="max-width: 66px;display: inline;" data-max="12"id="reinforce_behaviors"> /12  </td>
                                                <td> النتيجة <input readonly type="text" class="form-control part3" style="max-width: 50px;display: inline;" id="resuls_part3"> /100  </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                       <table class="table" >
                                        <thead>
                                           
                                        </thead>
                                        <tbody>
                                            <tr>
                                              <td>     النتيجة النهائية لمقدم الطلب
                                           
                                              </td> 
                                              <td>  <input type="radio" id="cb1" class="cb" value="1" name="final_result" style="padding-right: 11px;" > 
                                              <label for="cb1">مقبول ويتم تعينه</label> 
                                               </td>
                                              <td><input type="radio" id="cb2"  class="cb"  value="2" name="final_result"  style="padding-right: 11px;" > 
                                                  <label for="cb2" >مقبول ويوضع على قائمة الانتظار </label> 
                                                </td>
                                               
                                               <td><input type="radio" id="cb2" class="cb"  value="3" name="final_result" style="padding-right: 11px;" >
                                                    <label  for="cb3" >غير مقبول   </label> 
                                                 </td>
                                               
                                               
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    
                                    <input type="submit" class="btn btn-success" value="حفظ" > 
                                </form>
                                </div>
                        </div>
                    

                        

                        
                        
                    </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                </div>
        </div>
    </div>
</div>




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول التوظيف</h1>
        </div>
        <div class="">
            <div class="row" >
                <div class="col-12 col-lg-4 col-xl-3" >
                    <select class="form-control" id="select_recognize" >
                        <option value="0" >الطلبات المعلقة</option>
                        <option value="1" >الطلبات المميزة</option>
                    </select>
                </div>
            </div>
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                    <th scope="col" class="sort" data-sort="status">الجنس</th>
                    <th scope="col" class="sort" data-sort="completion">العنوان</th>
                    <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                    <th scope="col" class="sort" data-sort="completion">تاريخ الطلب</th>
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


                </tbody>
              </table>



        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >
 var name_job = {
    "teacher_assistant":"مساعد مدرس",
    "teacher":"مدرس",
    "cord":"منسق",
    "administrative_guided":"موجه إداري",
    "teacher_assistant":"مساعد مدرس",
    "academic_guided":"موجه أكاديمي",
    "section_manager":"مدير قسم",
    "social_worker":"اختصاصي اجتماعي",
    "accountant":"محاسب",
    "personnel":"شؤون الموظفين",
    "secretary":"أمين سر",
    "doorman":"بواب",
    "cleaning_technician":"فني نظافة",
    "bus_supervisor":"مشرف باص",
    "private_security":"أمن خاص",
    "storkeeper":"أمين مستودع",
    "nurse":"ممرض",
    "doctor":"طبيب",
    "bus_driver":"سائق باص",
    "quality_officer":"مسؤول جودة",
    "data_entry":"مدخل بيانات",
    "recepion":"استقبال",
    "information_technology":"تكنولوجيا المعلومات",
    "maintenance_technician":"فني صيانة",
 };
 
         $('#select_recognize').change(function () {
                table_test.draw();
        })

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getemployees') }}",
            "type": "GET",
            data:function(d){
                d.select = $('#select_recognize').val();
            },
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.data.name}`;
                }
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.data.gender}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.data.address}`;
                }
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.data.phone}`;
                }
            },
                        {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.data.created_at}`;
                }
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `<a class="detail_employee" data-id="${ full.data.id }" data-toggle="modal" data-target="#emp_detail" > <i class="fa fa-eye fa-2x" style="color:#7571f9" ></i> </a>
                    <a class="delete_employee" data-id="${ full.data.id }" data-toggle="modal" data-target=".deletelessonModal" > <i class="fa fa-trash fa-2x" style="color:red" ></i> </a>`;
                }
            },

        ]
    });
    
    $(document).on('keyup','.part1',function(){
        var real_val = $(this).val(); 
        var image_val = $(this).data('max'); 
        
    });
    
    
    $(document).on('click', '.delete_employee', function () {
        $('#employee_id_delete').val( $(this).data('id') );
    })


    $(document).on('click', '.detail_employee', function () {
        var id = $(this).data("id");
        $('#recognize_id').val(id);
        
        $('.show').attr('data-id',id );
        

        $.ajax({
            
            type: "get",
            url: "{{ route('get_employee_detail') }}",
            data: {
                "id":id
            },
            success: function (data) {
                console.log(data);
                $('#edit_type_time').text(data.full_part);
                $('#edit_name').val(data.name);
                $('#edit_date').val(data.date);
                $('#edit_gender').val(data.gender);
                $('#edit_religion').val(data.religion);
                $('#edit_landline_phone').val(data.landline_phone);
                $('#edit_phone').val(data.phone);
                $('#edit_email').val(data.email);
                $('#edit_educational_qualification_place').val(data.educational_qualification_place);
                $('#edit_educational_qualification').val(data.educational_qualification);
                $('#edit_qualification_place').val(data.qualification_place);
                $('#edit_specialization').val(data.specialization);
                $('#edit_qualification').val(data.qualification);
                $('#edit_family_status').val(data.family_status);
                $('#edit_military').val(data.military);
                $('#edit_address').val(data.address);
                
                
                $('#exam_number').val(data.exam_number);
                $('#scientific_material').val(data.scientific_material);
                $('#educational_material').val(data.educational_material);
                $('#resuls_part1').val(data.educational_material+data.scientific_material);
                $('#style').val(data.style);
                $('#body_standards').val(data.body_standards);
                $('#computer_use').val(data.computer_use);
                $('#stress').val(data.stress);
                $('#teaching_experience').val(data.teaching_experience);
                $('#scientific_material2').val(data.scientific_material2);
                $('#resuls_part2').val(data.style+data.body_standards+data.computer_use+data.stress+data.teaching_experience+data.scientific_material2);
                $('#language').val(data.language);
                $('#preface').val(data.preface);
                $('#classroom_management').val(data.classroom_management);
                $('#specialization_competencies').val(data.specialization_competencies);
                $('#reinforce_behaviors').val(data.reinforce_behaviors);
                $('#resuls_part3').val(data.classroom_management+data.specialization_competencies+data.reinforce_behaviors+data.preface+data.language);
                $.each($('.cb'),function(key,value){
                    if($(this).val()==data.	final_result){
                        $(this).attr("checked", true);
                        
                    }
                    
                })
               
                $('#edit_languages').empty();
                
                $.each(JSON.parse(data.languages),function(index,element){
                    name = '';
                    if(index == "ar"){
                        name = "العربية"
                    }else if(index == "en"){
                        name = "الانكليزية";
                    }else if(index == "fr"){
                        name = "الفرنسية";
                    }
                    $('#edit_languages').append(`
                        <tr>
                            <td> ${ name } </td>
                            <td> ${ element } </td>
                        </tr>
                    `);
                })
                
                
                $('#edit_computer_course').empty();
                $.each(JSON.parse(data.computer_course),function(index,element){
                    $('#edit_computer_course').append(`
                        <tr>
                            <td> ${ element.course_name } </td>
                            <td> ${ element.training_body } </td>
                            <td> ${ element.yearof_course } </td>
                            <td> ${ element.place_course } </td>
                        </tr>
                    `);
                })
                
                $('#edit_traning_course').empty();
                $.each(JSON.parse(data.traning_course),function(index,element){
                    $('#edit_traning_course').append(`
                        <tr>
                            <td> ${ element.course_name } </td>
                            <td> ${ element.training_body } </td>
                            <td> ${ element.yearof_course } </td>
                            <td> ${ element.place_course } </td>
                        </tr>
                    `);
                })
                
                $('#edit_jobs').empty();
                $.each(JSON.parse(data.jobs),function(index,element){
                    $('#edit_jobs').append(`
                        <tr>
                            <td> ${ element.job } </td>
                            <td> ${ element.number_year } </td>
                            <td> ${ element.job_name } </td>
                            <td> ${ element.job_place } </td>
                        </tr>
                    `);
                })
                
                
                $('#edit_job').empty();
                $.each(JSON.parse(data.job),function(index,element){
                    $('#edit_job').append(`
                        <tr>
                            <td> ${ name_job[element.name] } </td>
                            <td> ${ element.type } </td>
                        </tr>
                    `);
                })
                
                
            }
        });
    
});

 

$(".show").on("click", function (e) {

    $(".Evaluation").show();
     $("#evaluation_id").val($(this).data('id'));
    
     
      
});
$(".part3").on("keyup", function (e) {
    if($(this).val()>$(this).data('max')){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }
})
$(".part2").on("keyup", function (e) {
    if($(this).val()>$(this).data('max')){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }
})
$(".part1").on("keyup", function (e) {
    if($(this).val()>$(this).data('max')){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }
})

$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});
   $("#hide1").on("click", function (e) {

    $(this).parent().hide();
     
      
});
$(document).on("click",".share_teacher",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });


</script>

@endsection
