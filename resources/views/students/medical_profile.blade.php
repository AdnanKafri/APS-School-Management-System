@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
@endsection

    
	
	
@section('content')


<div class="main-panel" style="background: #f8f9fb;">
  <div class="content-wrapper pb-0">
    <!--content -->
      <!--card of subjects-->
        <div class="container" style="padding-bottom: 100px;">
          <div class="row wrow">
			    {{-- <div id="container">
					
					<textarea id="editor" name="message">
					</textarea>
				</div>
        <div id="container">
					
					<textarea id="editor2" name="message">
					</textarea>
				</div> --}}
				
 				
			 

      <div class="col-md-3 coll" style="padding-bottom: 20px;"><!--start col-->
        <div class="card" style="text-align:center;"><!--start card-->
          <div class="card-body p-0">
            <img class="img-fluid w-100" src="{{ asset('assets/students/vaccines_images/1.jpg') }}" alt="" style="height:130px"/>
          </div>
          <div class="card-body px-3 text-dark">
            <h5 class="font-weight-semibold">اللقاحات قبل المدرسة </h5>
            <div class="row" style="justify-content: center;">
              <div class="col-md-12">
                <!--p class="mb-0">$5,267/night</p-->
                <div class="buttons">
                  <a href="{{route('dashboard.student.medical_profile_details','1')}}"   class="blob-btn">
                    التفاصيل
                    <span class="blob-btn__inner">
                      <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                      </span>
                    </span>
                  </a>
                  <br/>
              </div>
             
            </div>
          </div>
        </div>
      </div><!--end card-->
    </div>
    
    
    
          <div class="col-md-3 coll" style="padding-bottom: 20px;"><!--start col-->
        <div class="card" style="text-align:center;"><!--start card-->
          <div class="card-body p-0" >
            <img class="img-fluid w-100" src="{{ asset('assets/students/vaccines_images/3.jpg') }}" alt=""style="height:130px" />
          </div>
          <div class="card-body px-3 text-dark">
            <h5 class="font-weight-semibold">اللقاحات خلال المدرسة</h5>
            <div class="row" style="justify-content: center;">
              <div class="col-md-12">
                <!--p class="mb-0">$5,267/night</p-->
                <div class="buttons">
                  <a href="{{route('dashboard.student.medical_profile_details','2')}}"   class="blob-btn">
                    التفاصيل
                    <span class="blob-btn__inner">
                      <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                      </span>
                    </span>
                  </a>
                  <br/>
              </div>
             
            </div>
          </div>
        </div>
      </div><!--end card-->
    </div>
    
    
    
          <div class="col-md-3 coll" style="padding-bottom: 20px;"><!--start col-->
        <div class="card" style="text-align:center;"><!--start card-->
          <div class="card-body p-0">
            <img class="img-fluid w-100" src="{{ asset('assets/students/vaccines_images/4.jpg') }}" alt=""  style="height:130px"/>
          </div>
          <div class="card-body px-3 text-dark">
            <h5 class="font-weight-semibold"> الامرض و الاوبئة السابقة </h5>
            <div class="row" style="justify-content: center;">
              <div class="col-md-12">
                <!--p class="mb-0">$5,267/night</p-->
                <div class="buttons">
                  <a href="{{route('dashboard.student.medical_profile_details','3')}}"   class="blob-btn">
                    التفاصيل
                    <span class="blob-btn__inner">
                      <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                      </span>
                    </span>
                  </a>
                  <br/>
              </div>
             
            </div>
          </div>
        </div>
      </div><!--end card-->
    </div>
    
    
    
          <div class="col-md-3 coll" style="padding-bottom: 20px;"><!--start col-->
        <div class="card" style="text-align:center;"><!--start card-->
          <div class="card-body p-0">
            <img class="img-fluid w-100" src="{{ asset('assets/students/vaccines_images/4.jpg') }}" alt="" style="height:130px"/>
          </div>
          <div class="card-body px-3 text-dark">
            <h5 class="font-weight-semibold">الأمرض و الحوادث الطارئة </h5>
            <div class="row" style="justify-content: center;">
              <div class="col-md-12">
                <!--p class="mb-0">$5,267/night</p-->
                <div class="buttons">
                  <a href="{{route('dashboard.student.medical_profile_details','4')}}"   class="blob-btn">
                    التفاصيل
                    <span class="blob-btn__inner">
                      <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                      </span>
                    </span>
                  </a>
                  <br/>
              </div>
             
            </div>
          </div>
        </div>
      </div><!--end card-->
    </div>
    
    
 			  
			
   {{-- <button class="boo">xx</button> --}}
   
	<!-- partial -->
  </div>
  <!-- main-panel ends -->
</div><!--end container of cards-->
<!-- page-body-wrapper ends -->
</div>
</div>
@endsection
@section('js')
{{-- <script src="
https://cdn.jsdelivr.net/npm/ckeditor5-mathtype@1.0.4/build/ckeditor.min.js
"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
     $( document ).ready(function(){
  $('.lesson11').addClass('active') ;
     })
  let editor1;
  ClassicEditor.create( document.querySelector( '#editor' ) )
  
 .then(editor => {
    window.editor = editor;
   
  })
 .catch(error => {
    console.error( 'There was a problem initializing the editor.', error );
 });
 
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
<script>
  let editor2;
               CKEDITOR.ClassicEditor.create(document.getElementById("editor2"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor 5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    'MathType'
                ]
            })
			.then( newEditor => {
        editor2 = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );;
			
			function getDataFromTheEditor() {
    return editor.getData();
}

        </script> --}}
<script>
    $(document).ready(function(){
		$(document).on('click', '.boo', function () {	
			getDataFromTheEditor();
          console.log( editor.getData() );
})})

</script>

	@endsection
