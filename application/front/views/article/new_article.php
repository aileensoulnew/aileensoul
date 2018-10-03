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
			<textarea id="artist_editor" name="artist_editor">Next, use our Get Started docs to setup Tiny!</textarea>
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
tinymce.init({
	selector: '#artist_editor',
	height: 400,
	menubar: false,
	// image_dimensions: true,
	plugins:  [//autoresize
		"advlist autolink lists link image charmap print preview anchor ",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste imagetools wordcount"
	],
	toolbar: 'link image | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify',
	// enable title field in the Image dialog
	image_title: false,
	image_caption: false, 
	// enable automatic uploads of images represented by blob or data URIs
	automatic_uploads: true,	
	image_description: false,
	image_dimensions: false,	
	image_title: false,
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
				cb(blobInfo.blobUri(), { title: file.name });				
			};
			reader.readAsDataURL(file);
		};
		input.click();
	}
});
</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</html>