@extends('students.layouts.app4')
@section('title')
    School
@endsection
@section('css')
<style>
.cards {
  position: relative;
  height: 150px;
  transition-duration: 0.5s;
  background: none;
  overflow: hidden;
  width: 100%;

}

.cards:hover {
  height: 270px;
}

.cards:hover .outlinePage {
  box-shadow: 0 10px 15px #a2c7fe;
}

.cards:hover .detailPage {
  display: flex;
}

.outlinePage {
  position: relative;
  background: linear-gradient(45deg, #a5c9ff, #f8f9fb);
  width: 100%;
  height: 150px;
  border-radius: 25px;
  transition-duration: 0.5s;
  z-index: 2;

}

.detailPage {
  position: relative;
  display: none;
  width: 100%;
  height: 120px;
  background: white;
  top: -20px;
  z-index: 1;
  transition-duration: 1s;
  border-radius: 0 0 25px 25px;
  overflow: hidden;
  align-items: center;
  justify-content: flex-start;
}

.splitLine {
  position: absolute;
  width: 200px;
  height: 10px;
  top: 100px;
  background-image: linear-gradient( to right, transparent 10%, #f8f9fb 20%, #152c4f 50%, #f8f9fb 70%, transparent 90% );
  z-index: 1;
}

.trophy {
  position: absolute;
  right: 5px;
  top: 35px;
  z-index: 2;
}

.ranking_number {
    word-wrap: break-word;
  white-space: pre-wrap;
    text-align: center;
    position: relative;
    color: #ffc64b;
    /* font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; */
    right: 15%;
    font-weight: 700;
    font-size: 80px;
    margin: auto;
    /* left: 20px; */
    /* padding: 0; */
    /* margin: 0; */
    top: -5px;
}

.ranking_word {
  position: relative;
  font-size: 19px;
  color: #424c50;
}

.userAvatar {
  position: absolute;
  bottom: 6px;
  left: 20px;
}

.userName {
  position: relative;
  font-weight: 600;
  color: #6b7578;
  left: 55px;
  font-size: 18px;
  top: -2px;
}

.medals {
  position: absolute;
  top: 30px;
  right: 5px;
}

.gradesBox {
  position: relative;
  height: 75px;
  top: 10px;
  margin-right: 10px;
  margin-left: 15px;
}

.gradesIcon {
  position: absolute;
  top: 10px;
}

.gradesBoxLabel {
  position: relative;
  display: block;
  margin-left: 60px;
  color: #424c50;
  letter-spacing: 6px;
  font-family: Arial, Helvetica, sans-serif;
  margin-top: 20px;
  font-weight: 800;
  font-size: 13px;
}

.gradesBoxNum {
  position: relative;
  font-family: Arial, Helvetica, sans-serif;
  display: block;
  font-size: 25px;
  font-weight: 800;
  margin-left: 60px;
  color: #ea9518;
  top: -5px;
}

.timeNum {
  color: #6cabf6;
}

.slide-in-top {
  animation: slide-in-top 1s cubic-bezier(0.65, 0.05, 0.36, 1) both;
}

@keyframes slide-in-top {
  0% {
    transform: translateY(-100px);
    opacity: 0;
  }

  100% {
    transform: translateY(0);
    opacity: 1;
  }
}
.file{
    color: #007bff !important;
    text-decoration: none !important;
    background-color: transparent !important;
    letter-spacing: 0 !important;
    font-size: 20px !important;

}
</style>
@endsection




@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#">الملفات الالكترونية</a></li>
        </ul>
      <div class="content-wrapper pb-0">
        <div class="container" style="padding-bottom: 100px;">
        <div class="row">
            <!--start card-->
            @foreach ($electronic_sections as $item)


            <div class="col-md-4">
                <div class="cards">
                    <div class="outlinePage">
                     <svg class="icon trophy" fill="#6e90c4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-48.19 -48.19 578.26 578.26" xml:space="preserve" width="80px" height="80px" stroke="#6e90c4" transform="rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M256.696,86.091c-4.66,0-8.453,3.793-8.453,8.453v173.038c2.632-1.056,5.49-1.636,8.453-1.636H369.58V86.091H256.696z M350.867,233.078h-83.914v-14.603h83.914V233.078z M350.867,197.36h-83.914v-14.603h83.914V197.36z M350.867,161.638h-83.914 v-14.603h83.914V161.638z M350.867,125.92h-83.914v-14.603h83.914V125.92z"></path> </g> </g> <g> <g> <polygon points="321.212,443.249 160.667,443.249 133.604,443.249 133.604,466.144 348.274,466.144 348.274,443.249 "></polygon> </g> </g> <g> <g> <rect x="167.966" y="391.145" width="145.943" height="37.504"></rect> </g> </g> <g> <g> <path d="M38.389,54.127v254.492h405.102V54.127H38.389z M384.182,273.245c0,4.033-3.269,7.301-7.301,7.301H256.696 c-4.136,0-7.708,3.116-8.303,7.248c-0.52,3.59-3.597,6.257-7.226,6.257c-0.04,0-0.074-0.023-0.114-0.023 c-0.039,0.001-0.072,0.023-0.111,0.023c-3.629,0-6.938-2.667-7.454-6.26c-0.596-4.128-4.165-7.245-8.303-7.245H105.002 c-4.032,0-7.301-3.269-7.301-7.301V78.789c0-4.032,3.269-7.301,7.301-7.301h120.181c6.106,0,11.627,2.428,15.757,6.315 c4.129-3.887,9.65-6.315,15.755-6.315h120.185c4.032,0,7.301,3.269,7.301,7.301V273.245z"></path> </g> </g> <g> <g> <path d="M225.184,86.091h-112.88v179.854h112.88c2.967,0,5.822,0.581,8.456,1.636V94.543 C233.64,89.884,229.847,86.091,225.184,86.091z M214.927,233.078h-83.915v-14.603h83.915V233.078z M214.927,197.36h-83.915 v-14.603h83.915V197.36z M214.927,161.638h-83.915v-14.603h83.915V161.638z M214.927,125.92h-83.915v-14.603h83.915V125.92z"></path> </g> </g> <g> <g> <path d="M474.043,15.738H7.84c-4.324,0-7.84,3.515-7.84,7.836V368.7c0,4.324,3.516,7.84,7.84,7.84h152.828h160.545h152.831 c4.325,0,7.84-3.516,7.84-7.84V23.574C481.882,19.253,478.368,15.738,474.043,15.738z M240.943,367.324 c-9.874,0-17.878-8.003-17.878-17.876c0-9.874,8.004-17.879,17.878-17.879c9.873,0,17.878,8.005,17.878,17.879 C258.821,359.321,250.816,367.324,240.943,367.324z M458.093,315.92c0,4.032-3.269,7.301-7.301,7.301H31.087 c-4.032,0-7.301-3.269-7.301-7.301V46.825c0-4.033,3.269-7.301,7.301-7.301h419.704c4.032,0,7.301,3.269,7.301,7.301V315.92z"></path> </g> </g> </g></svg>

                      <p class="ranking_number"><span class="ranking_word">{{$item->name_section}}</span></p>
                      <div class="splitLine"></div>

                    </div>
                    <div class="detailPage">
                     <svg class="icon medals slide-in-top" height="64px" width="64px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#152c4f" stroke="#152c4f"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#152c4f;} </style> <g> <path class="st0" d="M463.29,305.295v-84.777h-9.38c-39.71,0-75.128,6.873-104.271,15.713c-3.467-7.023-7.264-14.182-10.956-20.92 c1.59-1.441,3.166-2.919,4.682-4.435c22.331-22.316,36.183-53.253,36.168-87.343c0.016-34.089-13.837-65.026-36.168-87.336 C321.035,13.837,290.089,0,256.007,0c-34.082,0-65.027,13.837-87.343,36.198c-22.331,22.309-36.182,53.246-36.182,87.336 c0,34.09,13.851,65.027,36.182,87.343c1.516,1.516,3.076,3.017,4.682,4.435c-3.706,6.738-7.503,13.897-10.97,20.92 c-29.159-8.84-64.547-15.713-104.257-15.713h-9.38v84.777c-28.318,0.526-39.154,23.877-39.154,52.631 c0,28.754,10.836,52.106,39.154,52.631v67.481l9.035,0.315h0.255c2.836,0.098,28.634,1.208,63.586,5.89 c34.938,4.667,79.044,12.958,118.244,27.193l1.545,0.563h29.22l1.545-0.563c40.445-14.692,86.158-23.044,121.59-27.629 c17.739-2.288,32.896-3.661,43.611-4.456c5.358-0.398,9.604-0.646,12.501-0.811c1.441-0.068,2.536-0.128,3.286-0.15 c0.36-0.023,0.646-0.038,0.811-0.038h0.27l9.049-0.315v-67.481c28.319-0.548,39.124-23.877,39.124-52.631 C502.414,329.172,491.609,305.836,463.29,305.295z M49.746,391.821c-0.315,0-0.646,0-1.006-0.015 c-6.438-0.068-20.395-1.756-20.395-33.879c0-32.131,13.957-33.819,20.395-33.88c0.36-0.022,0.691-0.022,1.006-0.022 c6.498,0,12.576,1.861,17.739,5.043c9.694,5.958,16.147,16.673,16.147,28.859c0,12.186-6.453,22.894-16.147,28.852 C62.322,389.967,56.244,391.821,49.746,391.821z M230.63,286.259v202.262c-38.089-12.126-78.069-19.15-109.974-23.314 c-23.502-3.046-42.576-4.48-53.171-5.125V407.51c20.365-7.293,34.906-26.728,34.906-49.584c0-22.856-14.542-42.299-34.906-49.584 v-68.921c48.863,1.395,90.494,13.536,120.389,25.73c15.893,6.453,28.469,12.914,36.978,17.731c2.192,1.246,4.127,2.371,5.778,3.37 V286.259z M268.884,492.708c-0.495,0.165-1.006,0.353-1.501,0.541h-22.736c-0.495-0.188-0.99-0.376-1.516-0.541V292.396h25.753 V492.708z M256.007,228.682c-28.574,0-54.402-11.353-73.341-29.812c-0.33-0.33-0.66-0.646-1.006-0.975 c-10.28-10.296-18.414-22.669-23.742-36.46c18.459-3.482,35.418-10.445,50.545-19.03c25.498-14.452,45.923-33.459,60.09-48.849 c6.123-6.649,11.061-12.629,14.723-17.296c5.898,7.602,14.797,18.752,24.942,30.315c9.11,10.378,19.21,21.086,29.235,29.978 c4.997,4.458,9.995,8.464,14.947,11.773c1.681,1.103,3.347,2.108,5.013,3.061c-4.878,17.836-14.317,33.774-27.043,46.508 c-0.346,0.33-0.675,0.668-1.021,0.998C310.379,217.352,284.552,228.682,256.007,228.682z M444.545,460.082 c-10.595,0.645-29.67,2.079-53.201,5.125c-31.875,4.142-71.856,11.188-109.944,23.314c0,0,0,0-0.014,0V286.236 c0.014,0,0.014,0,0.014,0c8.164-4.899,23.157-13.168,43.492-21.4c29.834-12.066,71.18-24.042,119.654-25.415v68.921 c-20.365,7.286-34.922,26.728-34.922,49.584c0,22.856,14.557,42.291,34.922,49.584V460.082z M463.29,391.806 c-0.375,0.015-0.705,0.015-1.02,0.015c-6.498,0-12.562-1.831-17.724-5.02c-9.695-5.98-16.178-16.688-16.178-28.874 c0-12.186,6.483-22.901,16.178-28.882c5.162-3.181,11.226-5.02,17.724-5.02c0.315,0,0.646,0,1.02,0.022 c6.453,0.083,20.38,1.794,20.38,33.88C483.669,390.012,469.743,391.723,463.29,391.806z"></path> <circle class="st0" cx="215.383" cy="161.037" r="12.502"></circle> <circle class="st0" cx="296.632" cy="161.037" r="12.502"></circle> </g> </g></svg>
                      <div class="gradesBox">
                        <svg class="icon gradesIcon" fill="#152c4f" height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 481.882 481.882" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="2.891292"></g><g id="SVGRepo_iconCarrier"> <g> <g> <polygon points="370.364,63.514 370.364,116.314 423.164,116.314 "></polygon> </g> </g> <g> <g> <path d="M47.361,0v429.734h37.431v-31.349h-9.898v-16.063h9.898v-21.874h-9.898v-16.063h9.898V322.51h-9.898v-16.063h9.898 v-21.882h-9.898v-16.063h9.898v-21.874h-9.898v-16.063h9.898v-21.883h-9.898V192.62h9.898v-21.874h-9.898v-16.062h9.898v-21.875 h-9.898v-16.063h9.898v-72.62c0-4.439,3.596-8.031,8.032-8.031h207.984V0H47.361z"></path> </g> </g> <g> <g> <polygon points="316.87,11.359 316.87,36.094 341.603,36.094 "></polygon> </g> </g> <g> <g> <path d="M362.333,132.377c-4.436,0-8.032-3.592-8.032-8.032V52.157h-45.463H100.854v385.607v44.118h333.667V132.377H362.333z M128.388,282.722h187.232v16.063H128.388V282.722z M267.69,450.541H128.388v-16.063H267.69V450.541z M406.992,412.604H128.388 v-16.063h278.604V412.604z M406.992,374.667H128.388v-16.062h278.604V374.667z M406.992,336.721H128.388v-16.063h278.604V336.721z M406.992,260.839H128.388v-16.063h278.604V260.839z M406.992,222.902H128.388v-16.063h278.604V222.902z M406.992,184.964H128.388 v-16.062h278.604V184.964z"></path> </g> </g> </g></svg>
                        <p class="gradesBoxLabel"><a href="{{ route('student_electronic_files', ['id' => $item->id]) }}" class="file">ملفات القسم</a></p>

                      </div>
                    </div>
                  </div>
            </div>
            <!--end card-->
            @endforeach
        </div>
        </div>
      </div>
    </div>

@endsection
