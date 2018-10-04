<!DOCTYPE html>
<?php $userid_login = $this->session->userdata('aileenuser');?>
<html lang="en">
    <head>
        <title><?php echo $meta_title; ?></title>
        <meta name="description" content="<?php echo $meta_desc; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>        
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">  
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .ui-autocomplete {
                background: #fff;
                z-index: 999999!important;
            }
            .mce-widget.mce-notification.mce-notification-warning.mce-has-close.mce-in{
            	display: none !important;
            }
            .mce-container.mce-menubar.mce-toolbar.mce-first{
            	display: none;
            }
            .mce-branding.mce-widget.mce-label.mce-flow-layout-item.mce-last{
            	display: none !important;
            }
            
            .mce-content-body img[.data-mce-selected] {
			    width: 100% !important;
			    height: 100% !important;
			}
			/*#tinymce .img-responsive{
				width: 100% !important;
			    height: 100% !important;
			}*/
			img {
			 max-width: 100%;
			 height: auto;
			}
        </style>
    <?php $this->load->view('adsense'); ?>
</head>
<body class="profile-main-page body-loader">
	<?php echo $header_inner_profile; ?>
	<div class="middle-section">
		<div class="container">
			<div class="fw" id="upload_loader" style="text-align: center;position: absolute;display: none;z-index: 99999;top: 47%;">
                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="LOADERIMAGE">
            </div>
            <form id="article_frm" name="article_frm" action="javascript:void(0);">
			<input type="text" name="title_txt" id="title_txt" placeholder="Enter title of Article">
			<textarea id="artist_editor" name="artist_editor"></textarea>
			<input type="submit" name="publish" value="Publish">
			</form>
		</div>
	</div>
</body>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<!-- <script src="<?php //echo base_url('assets/js/ckeditor.js?ver='.time()); ?>"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script> 
<script type="text/javascript">
	var user_id = '<?php echo $this->session->userdata('aileenuser');?>';
	var header_all_profile = '<?php echo $header_all_profile; ?>';
	var app = angular.module('', ['ui.bootstrap']);
</script>
<script>
    /*ClassicEditor
        .create( document.querySelector( '#editor' ), {
			image: {
				// You need to configure the image toolbar too, so it uses the new style buttons.
				toolbar: [ 'imageTextAlternative', '|', 'imageStyleAlignLeft', 'imageStyleFull', 'imageStyleAlignRight' ],

				styles: [
					// This option is equal to a situation where no style is applied.
					'imageStyleFull',

					// This represents an image aligned to left.
					'imageStyleAlignLeft',

					// This represents an image aligned to right.
					'imageStyleAlignRight'
				]
			}
		} )
        .catch( error => {
            console.error( error );
        } );*/
</script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script type="text/javascript">//tinymce.init({ selector:'textarea' });
//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var maineditor;

maineditor = tinymce.init({
	selector: '#artist_editor',	
	body_class: 'editor-body',
	content_css : 'assets/n-css/editor-style.css',
	height: 400,
	menubar: false,
	theme: 'modern',
	resize: false,
	// image_dimensions: true,
	plugins:  [//autoresize
		"advlist autolink lists link image charmap print preview anchor ",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste imagetools wordcount textcolor hr charmap"
	],
	toolbar: 'link image | undo redo |  formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | hr charmap blockquote ',
	// enable title field in the Image dialog
	image_title: false,
	image_caption: false, 
	// enable automatic uploads of images represented by blob or data URIs
	automatic_uploads: true,	
	image_description: false,
	// image_dimensions: false,	
	image_title: false,

	init_instance_callback: function (editor) {
	    editor.on('KeyUp', function (e) {
	    	clearTimeout(typingTimer);
	    	if (editor.getContent()) {
		        typingTimer = setTimeout(function(){
		        	var title = $("#title_txt").val();
	    			console.log('title',title,'content',editor.getContent());
		        }, doneTypingInterval);
		    }
	      // console.log('Editor contents was KeyUp.');
	    });
	},

	// URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
	// images_upload_url: 'postAcceptor.php',
	// here we add custom filepicker only to Image dialog
	file_picker_types: 'image', 
	// and here's our custom image picker
	file_picker_callback: function(cb, value, meta) {
		
		// console.log(meta);
		var input = document.createElement('input');
		input.setAttribute('type', 'file');
		input.setAttribute('accept', 'image/*');

		// Note: In modern browsers input[type="file"] is functional without 
		// even adding it to the DOM, but that might not be the case in some older
		// or quirky browsers like IE, so you might want to add it to the DOM
		// just in case, and visually hide it. And do not forget do remove it
		// once you do not need it anymore.
		input.onchange = function() {
			var file = this.files[0];
			var reader = new FileReader();
			reader.onload = function () {
				// Note: Now we need to register the blob in TinyMCEs image blob
				// registry. In the next release this part hopefully won't be
				// necessary, as we are looking to handle it internally.
				var id = 'blobid' + (new Date()).getTime();
				var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
				var base64 = reader.result.split(',')[1];
				var blobInfo = blobCache.create(id, file, base64);
				blobCache.add(blobInfo);
				// call the callback and populate the Title field with the file name
				// cb(blobInfo.blobUri(), { title: file.name });
				var xhr, formData;

			    xhr = new XMLHttpRequest();
			    xhr.withCredentials = false;
			    xhr.open('POST', '<?php echo base_url("article/upload_image") ?>');

			    xhr.onload = function() {
			      var json;

			      if (xhr.status != 200) {
			        failure('HTTP Error: ' + xhr.status);
			        return;
			      }

			      json = JSON.parse(xhr.responseText);			      

			      /*if (!json || typeof json.location != 'string') {
			        failure('Invalid JSON: ' + xhr.responseText);
			        return;
			      }*/

			      // success(json.location);
			      $("#upload_loader").hide();
			      var location = '<?php echo base_url() ?>'+json.location;
			      cb(location,json.filename)
			    };

			    formData = new FormData();
			    formData.append('file', blobInfo.blob(), blobInfo.filename());
			    $("#upload_loader").show();
			    xhr.send(formData);
			};
			reader.readAsDataURL(file);
		};
		input.click();
	}
});
//setup before functions
var typingTimer1;                //timer identifier
var doneTypingInterval1 = 1000;  //time in ms, 5 second for example

//on keyup, start the countdown
$('#title_txt').keyup(function(){
    clearTimeout(typingTimer1);
    if ($('#title_txt').val()) {    	
        typingTimer1 = setTimeout(function(){
           	//do stuff here e.g ajax call etc....
            var title = $("#title_txt").val();
            tinyMCE.activeEditor.getContent();
			// Get the raw contents of the currently active editor
			tinyMCE.activeEditor.getContent({format : 'raw'});
			// Get content of a specific editor:
			var descr =  tinyMCE.get('artist_editor').getContent();

            console.log('title',title,'content',descr);
             // $("#out").html(v);
        }, doneTypingInterval1);
    }
});

</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</html>