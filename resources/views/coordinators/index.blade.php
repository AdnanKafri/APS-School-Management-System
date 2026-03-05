<!doctype html>
<html lang="en">
  <head>
  	<title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{  asset('profile/css/style.css')}}">
      <style>
		 .panel { max-width: 500px; text-align: center; font-size: large;}
.button_outer {background: #4972a8; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
.btn_upload {padding: 10px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none;}
.processing_bar {position: absolute; left: 0; top: 0; width: 0;
    height: 100%; border-radius: 30px; background:#f38639; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0; width: 50px; background:#3a3b7c; height: 50px;}
.uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}
	  </style>
	</head>
	<body>
	<section class="ftco-section">
		<div class="container" >
			<div class="row justify-content-center" >
				<div class="col-md-6 text-center mb-5" >
					<h2 class="heading-section"></h2>
				</div>
			</div>
			<div class="row justify-content-center"
			 style="direction: rtl; text-align:right;" >
				<div class="col-md-10" >
					<div class="wrapper" >
                        <form class="form-horizontal" method="POST" action="{{ route('dashboard.update_profile_coor',$coordinator->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

						<div class="row no-gutters" style="border-radius: 20px;">
							<div class="col-md-6">
								<div class="contact-wrap w-100 p-lg-5 p-4" style="height: 540px;">

									<h3 class="mb-4">تعديل كلمة المرور</h3>

										<br>
										<br>



				      		{{-- <div id="form-message-success" class="mb-4">
				                                  تم تغير كلمة المرور بنجاح
				      		</div> --}}

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<input type="password" class="form-control" name="old_password"  placeholder="كلمة المرور القديمة ">
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<input type="password" class="form-control" name="password"  placeholder="كلمة المرور الجديدة ">
												</div>
											</div>

											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>


											<div class="col-md-12">

													<button type="submit" value="حفظ التعديل " class="btn btn-primary">حفظ التعديل </button>


											</div>
										</div>


								</div>
							</div>
							<div class="col-md-6 d-flex align-items-stretch" style="height: 540px;">
								<div class="info-wrap w-100 p-lg-5 p-4 img">
									<h3>الصورة الشخصية  </h3>
									<br>
				        	<div class="dbox w-100 d-flex align-items-start">
				        		<div class="icon d-flex align-items-center justify-content-center">
				        			<span class="fa fa-upload" style="color: #f38639;"></span>
				        		</div>&nbsp;&nbsp;
				        		<div class="text pl-3">
					            <p style="margin-top: 12px;"><span  style="color: #094e89;">تحميل الصورة الشخصية  :</span> </p>
					          </div>
				          </div>
						  <div>
							<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
						 <main class="main_full" >
						  <div class="container">
						   <div class="panel">
							 <div class="button_outer">
							   <div class="btn_upload">
								 <input type="file" id="upload_file" name="image"  accept="image/*">
									تحميل صورة
								 </div>
									  <div class="processing_bar"></div>
										 <div class="success_box"></div>
								  </div>
										 </div>
							 <div class="error_msg"></div>
								 <div class="uploaded_file_view" id="uploaded_view">
									 <span class="file_remove">X</span>
								  </div>
							  </div>
                              <img src="{{ asset('storage/'.$coordinator->image) }}" id="old_image" width="100px" height="100px">
						</main>
						</div>




			          </div>
							</div>

						</div>
                    </form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script>

		var btnUpload = $("#upload_file"),
			 btnOuter = $(".button_outer");
		 btnUpload.on("change", function(e){
			 var ext = btnUpload.val().split('.').pop().toLowerCase();
			 if($.inArray(ext, ['jpg','png','jpeg']) == -1) {
				 $(".error_msg").text("Not an image ...");
			 } else {
				 $(".error_msg").text("");
				 btnOuter.addClass("file_uploading");
				 setTimeout(function(){
					 btnOuter.addClass("file_uploaded");
				 },3000);
				 var uploadedFile = URL.createObjectURL(e.target.files[0]);
				 setTimeout(function(){
					 $("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
				 },3500);
			 }
		 });
		 $(".file_remove").on("click", function(e){
			 $("#uploaded_view").removeClass("show");
			 $("#uploaded_view").find("img").remove();
			 btnOuter.removeClass("file_uploading");
			 btnOuter.removeClass("file_uploaded");
		 });


		 </script>

	<script src="{{  asset('profile/js/jquery.min.js')}}"></script>
  <script src="{{  asset('profile/js/popper.js')}}"></script>
  <script src="{{  asset('profile/js/bootstrap.min.js')}}"></script>
  <!--script src="js/jquery.validate.min.js"></script-->
  <script src="{{  asset('profile/js/main.js')}}"></script>

	</body>
</html>

