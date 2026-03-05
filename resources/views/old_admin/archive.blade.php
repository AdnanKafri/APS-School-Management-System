<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
</head>
<body>

<div class="container-fluid" style="font-size: 16px">
<div class="row">

<div class="col-md-7"></div>
<div class="col-md-5">
    <h2 style="text-align: right">الجمهورية العربية السورية</h2>
</div>

<div class="col-md-9"></div>
<div class="col-md-3">
    <h2 style="text-align: center; margin-left: 20px">وزارة التربية</h2>
</div>



<div class="col-md-7"></div>
<div class="col-md-5">
    <h4 style="text-align: right">مديرية التربية في محافظة حماه </h4>
</div>



<div class="col-md-8"></div>
<div class="col-md-4">
    <h4 style="text-align: right; margin-right: 30px"> مدرسة الادهم الافتراضية  </h4>
</div>



</div>

<br>

<div class="row">
<div class="col-md-12">
    <h1 style="text-align: center; font-weight: bold">*** وثيقة دوام مدرسية ***</h1>
</div>

<div class="col-md-12">
    <br><br>

<p style="text-align: right">
  لدى
  مراجعة
   سجلاتنا
   تبين
   لنا
   ان
<b>   الطالب:
</b>
   {{ $student->first_name }}
   {{ $student->last_name }}

<b>
    بن:

</b>
{{ $student->father_name }}
<b>
    والدته:

</b>
{{ $student->mother_name }}

      من

<b>
    مواليد:

</b>
 {{ $student->place_birth }}
<b>        عام :
</b>
{{ $student->date_birth }}
<br>
<span style="font-weight: bold">كان طالبا في مدرستنا ورقمه في سجلاتنا : {{ $student->id }}</span>
<br>
<span>قضى الأعوام التالية في مدرستنا </span>
</p>

</div>
</div>



<div class="row">
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
          <tr style="text-align: center">
            <th scope="col">النتيجة</th>

            <th scope="col">الصف</th>
            <th scope="col">العام</th>


          </tr>
        </thead>
        <tbody style="text-align: center">

            @foreach ($student->room as $item)

            <tr>
                <th scope="row">
                    @if (! $item->student_mark->isEmpty() )
                    @if ( $item->student_mark[0]->year_result)
                    {{ $item->student_mark[0]->year_result }}%
                    @endif


                    @endif
                </th>
                <td>{{ $item->classes->name }}</td>
                <td>
                   {{ App\Year::where('id',$item->year_id)->first()->name }}
                    </td>
              </tr>

            @endforeach



        </tbody>
      </table>

</div>




</div>


<div class="row">
    <div class="col-md-12">
        <br>

        <p style="text-align: right">        و بناءً على طلبه أعطي هذه الوثيقة بتاريخ  : {{ $date }}
        </p>

        <br>

    </div>


    <div class="col-md-3">
        <p style="font-weight: bold ; text-align: right"> : مدير المدرسة</p>
    </div>


    <div class="col-md-6">

    </div>


    <div class="col-md-3">
        <p style="font-weight: bold"> : أمين السر  </p>
    </div>
</div>

</div>





</body>
</html>
