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
    }
    td{
        font-size: 17px;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .dropdown-item{
        color: black !important;
        width: auto !important;
    }
    .fa-folder{
        margin: 2px;
    }
    .dorat{
        color: blue !important;
    }
    img{
        border-radius:50%;
    }
    /* ///////////////////////////////////// */


.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}








.wrapper_lang{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_lang .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_lang .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_lang .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_lang input[type="radio"]{
  display: none;
}
#option-lang1:checked:checked ~ .option-lang1,
#option-lang2:checked:checked ~ .option-lang2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-lang1:checked:checked ~ .option-lang1 .dot,
#option-lang2:checked:checked ~ .option-lang2 .dot{
  background: #fff;
}
#option-lang1:checked:checked ~ .option-lang1 .dot::before,
#option-lang2:checked:checked ~ .option-lang2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_lang .option span{
  font-size: 20px;
  color: #808080;
}
#option-lang1:checked:checked ~ .option-lang1 span,
#option-lang2:checked:checked ~ .option-lang2 span{
  color: #fff;
}

th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center;
}
.dt-button{
    color: black !important;
}
#table_xx_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')
<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">تصدير     </a>
    <a href="{{ route('export_students_detail') }}" class="breadcrumbs__item ">تصدير بيانات الطلاب  </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')







<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الطلاب</h1>
        </div>
        
        <div class="m-4">
            <table class="table align-items-center" id="table_xx">
                <thead class="thead-light">
                    <tr>
                        @if (in_array('id',$fields))
                        <th scope="col" class="sort">رقم التسجيل   </th>
                        @endif
                        @if (in_array('first_name',$fields))
                        <th scope="col" class="sort">  الاسم الاول     </th>
                        @endif
                        @if (in_array('last_name',$fields))
                        <th scope="col" class="sort">   الكنية      </th>
                        @endif
                        @if (in_array('father_name',$fields))
                        <th scope="col" class="sort">   اسم الاب      </th>
                        @endif
                        @if (in_array('mother_name',$fields))
                        <th scope="col" class="sort">   اسم الام       </th>
                        @endif
                        @if (in_array('date_birth',$fields))
                        <th scope="col" class="sort">    تاريخ الولادة       </th>
                        @endif
                        @if (in_array('address',$fields))
                        <th scope="col" class="sort">   العنوان        </th>
                        @endif
                        @if (in_array('country',$fields))
                        <th scope="col" class="sort">    الدولة        </th>
                        @endif
                        @if (in_array('phone',$fields))
                        <th scope="col" class="sort">     الهاتف        </th>
                        @endif
                        @if (in_array('religion',$fields))
                        <th scope="col" class="sort">     الديانة        </th>
                        @endif
                        @if (in_array('lang',$fields))
                        <th scope="col" class="sort">     اللغة        </th>
                        @endif
                        @if (in_array('email',$fields))
                        <th scope="col" class="sort">     الايميل         </th>
                        @endif
                        @if (in_array('password',$fields))
                        <th scope="col" class="sort">     كلمة السر        </th>
                        @endif
                         @if (in_array('class',$fields))
                        <th scope="col" class="sort">      الصف         </th>
                        @endif
                         @if (in_array('room',$fields))
                        <th scope="col" class="sort">      الشعبة        </th>
                        @endif
                       
                       
                      
                      </tr>
                </thead>
                <tbody >
                    @foreach($students as $item)
                    <tr>
                        @if (in_array('id',$fields))
                        <td >{{$item->id}}    </th>
                        @endif
                        @if (in_array('first_name',$fields))
                        <td >{{$item->first_name}}    </th>
                        @endif
                        @if (in_array('last_name',$fields))
                        <td >{{$item->last_name}}    </th>
                        @endif
                        @if (in_array('father_name',$fields))
                        <td >{{$item->father_name}}    </th>
                        @endif
                        @if (in_array('mother_name',$fields))
                        <td >{{$item->mother_name}}    </th>   
                        @endif
                        @if (in_array('date_birth',$fields))
                        <td >{{$item->date_birth}}    </th>   
                        @endif
                        @if (in_array('address',$fields))
                        <td >{{$item->address}}    </th>   
                        @endif
                        @if (in_array('country',$fields))
                        <td >{{$item->country}}    </th>   
                        @endif
                        @if (in_array('phone',$fields))
                        <td >{{$item->phone}}    </th>   
                        @endif
                        @if (in_array('religion',$fields))
                        <td >{{$item->religion}}    </th>   
                        @endif
                        @if (in_array('lang',$fields))
                        <td >{{$item->lang}}    </th>   
                        @endif
                        @if (in_array('email',$fields))
                        <td >{{$item->email}}    </th>   
                        @endif
                        @if (in_array('password',$fields))
                        <td >{{$item->view_password}}    </th>   
                        @endif
                        @if (in_array('class',$fields))
                        <td >{{$item->class_name}}    </th>   
                        @endif
                        @if (in_array('room',$fields))
                        <td >{{$item->name}}    </th>   
                        @endif

 

                    </tr>
                    @endforeach
                    

                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>


        var table_test = $('#table_xx').DataTable({
          "pageLength": 50,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'
                ],

            });




</script>

@endsection
