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
			<div id="save_post" style="display: none;">				
			</div>
			<div class="fw" id="upload_loader" style="text-align: center;position: absolute;display: none;z-index: 99999;top: 47%;">
                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="LOADERIMAGE">
            </div>
            <form id="article_frm" name="article_frm" action="javascript:void(0);">
				<input type="text" name="title_txt" id="title_txt" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_title'] : ''); ?>" placeholder="Enter title of Article">
				<textarea id="article_editor" name="article_editor"><?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_desc'] : ''); ?></textarea>
				<input type="submit" name="publish" value="Publish" id="publish">
			</form>
		</div>
	</div>

	<!-- Model Popup Start -->
	<div class="modal fade message-box biderror" id="publishmodal" role="dialog" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lm">
	        <div class="modal-content message">	            
	            <div class="modal-body">
	                <span class="mes">
	                	<div class="msg"></div>
		                <div class="pop_content">
		                	<div class="model_ok_cancel">
		                		<a class="btn1" id="okbtn" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
		                	</div>
		                </div>
		            </span>
	            </div>	            
	        </div>
	    </div>
	</div>
	<!-- Model Popup End -->
</body>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<!-- <script src="<?php //echo base_url('assets/js/jquery.min.js?ver=' . time()); ?>"></script> -->
<script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
<!-- <script src="<?php //echo base_url('assets/js/ckeditor.js?ver='.time()); ?>"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script> 
<script type="text/javascript">
	var user_id = '<?php echo $this->session->userdata('aileenuser');?>';
	var header_all_profile = '<?php echo $header_all_profile; ?>';
	var app = angular.module('', ['ui.bootstrap']);
	var unique_key = "<?php echo(isset($articleData) && !empty($articleData) ? $articleData['unique_key'] : $unique_key); ?>"
	var base_url = "<?php echo base_url(); ?>"
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
	selector: '#article_editor',	
	body_class: 'editor-body',
	content_css : base_url+'assets/n-css/editor-style.css',
	height: 300,
	relative_urls : false,
	remove_script_host : false,
	document_base_url : base_url,
	menubar: false,
	theme: 'modern',
	resize: false,
	// image_dimensions: true,
	plugins:  [//autoresize
		"advlist autolink lists link image charmap print preview anchor ",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste imagetools wordcount textcolor hr charmap"
	],
	toolbar: 'link image | undo redo |  formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | hr charmap blockquote',
	imagetools_toolbar: "alignleft aligncenter alignright | rotateleft rotateright | flipv fliph | editimage imageoptions| removeimage",
	setup: function(editor) {

		function insertDate() {
			
			editor.insertContent('');
		}

		editor.addButton('removeimage', {
			icon: 'removeimage',
			image: base_url+'assets/n-images/trash.png',
			tooltip: "Insert Current Date",
			onclick: insertDate
		});

		editor.on('change', function (e) {	      
	      	//console.log('Content changed to:  ' + editor.getContent());
			var title = $("#title_txt").val();
			var descr = editor.getContent();
			// console.log('title',title,'content',editor.getContent());
			if(title.trim() == "" && descr.trim() == "")
			{
				return false;
			}
			else
			{
				$("#save_post").show();
				$("#save_post").text("Saving...");
				$.ajax({
				    type: 'POST',
				    url: base_url + "article/add_article",
				    data: {"article_title":title,"article_content":descr,"unique_key":unique_key},
				    dataType: "JSON",	        
				    success: function (data) {
				    	if(data.add_new_article == 1)
			        	{
			        		var title = "Edit Article"
		                    var url = base_url +"edit-article/"+unique_key;
		                    var obj = {
		                        Title: title,
		                        Url: url
		                    };
		                    history.pushState(obj, obj.Title, obj.Url);
			        	}
				    	$("#save_post").text("Saved");
				    }
				});
			}
	    });
	},
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
		        	var descr = editor.getContent();
	    			// console.log('title',title,'content',editor.getContent());
	    			if(title.trim() == "" && descr.trim() == "")
	    			{
	    				return false;
	    			}
	    			else
					{
						$("#save_post").show();
						$("#save_post").text("Saving...");
		    			$.ajax({
					        type: 'POST',
					        url: base_url + "article/add_article",
					        data: {"article_title":title,"article_content":descr,"unique_key":unique_key},
					        dataType: "JSON",	        
					        success: function (data) {
					        	if(data.add_new_article == 1)
					        	{
					        		var title = "Edit Article"
			                        var url = base_url +"edit-article/"+unique_key;
			                        var obj = {
			                            Title: title,
			                            Url: url
			                        };
			                        history.pushState(obj, obj.Title, obj.Url);
					        	}
					        	$("#save_post").text("Saved");
					        }
					    });
					}
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
		if (meta.filetype == 'image') {			
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
				    xhr.open('POST', base_url+'article/upload_image');

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

						$("#upload_loader").hide();
						$("#save_post").text("Saved");
						var location = json.location;
						cb(location,json.filename);
						if(json.add_new_article == 1)
						{
							var title = "Edit Article"
							var url = base_url +"edit-article/"+unique_key;
							var obj = {
								Title: title,
								Url: url
							};
							history.pushState(obj, obj.Title, obj.Url);
						}
						// upload_success();
				    };
				    var title = $("#title_txt").val();
				    tinyMCE.activeEditor.getContent();
					// Get the raw contents of the currently active editor
					tinyMCE.activeEditor.getContent({format : 'raw'});
					// Get content of a specific editor:
					var descr =  tinyMCE.get('article_editor').getContent();

				    formData = new FormData();
				    formData.append('file', blobInfo.blob(), blobInfo.filename());			    
				    formData.append('unique_key',unique_key);			    
				    formData.append('article_title',title);			    
				    formData.append('article_content',descr);			    
				    $("#upload_loader").show();
				    $("#save_post").show();
					$("#save_post").text("Saving...");
				    xhr.send(formData);
				};
				reader.readAsDataURL(file);
			};
			input.click();
		}
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
            upload_success();
            // console.log('title',title,'content',descr);
             // $("#out").html(v);
        }, doneTypingInterval1);
    }
});
function upload_success()
{
	var title = $("#title_txt").val();
    tinyMCE.activeEditor.getContent();
	// Get the raw contents of the currently active editor
	tinyMCE.activeEditor.getContent({format : 'raw'});
	// Get content of a specific editor:
	var descr =  tinyMCE.get('article_editor').getContent();
	if(title.trim() == "" && descr.trim() == "")
	{
		return false;
	}
	else
	{
		$("#save_post").show();
		$("#save_post").text("Saving...");
		$.ajax({
	        type: 'POST',
	        url: base_url + "article/add_article",
	        data: {"article_title":title,"article_content":descr,"unique_key":unique_key},
	        dataType: "JSON",	        
	        success: function (data) {
	        	if(data.add_new_article == 1)
	        	{
	        		var title = "Edit Article"
                    var url = base_url +"edit-article/"+unique_key;
                    var obj = {
                        Title: title,
                        Url: url
                    };
                    history.pushState(obj, obj.Title, obj.Url);
	        	}
	        	$("#save_post").text("Saved");
	        }
	    });
	}

}

$(document).ready(function () {
    $("#article_frm").validate({
        rules: {
            title_txt: {
                required: true,
            },
            article_editor: {
                required: true,
            },
            
        },                   
        messages:
        {
            title_txt: {
                required: "Please enter article title",
            },
            article_editor: {
                required: "Please enter article description",
            },
        },                   
        submitHandler: submitArticle
    });
    /* register submit */
    function submitArticle()
    {
        var title = $("#title_txt").val();
	    tinyMCE.activeEditor.getContent();
		// Get the raw contents of the currently active editor
		tinyMCE.activeEditor.getContent({format : 'raw'});
		// Get content of a specific editor:
		var descr =  tinyMCE.get('article_editor').getContent();

        var post_data = {
            'article_title': title,
            'article_content': descr,
            'unique_key': unique_key,
        }
        $("#publish").val('Publishing ...');
        $("#publish").attr('disabled','disabled');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>article/publish_article',
            dataType: 'json',
            data: post_data,            
            success: function (response)
            {
            	if(response.status == 1)
            	{
            		$("#publishmodal .mes .msg").html("Congratulations, your post has been successfully submitted and sent for approval. We'll send you notifications once it's live.");
            		$("#publishmodal").modal("show");
	            	$("#publish").val('Publish');  
	                $("#publish").removeAttr('disabled');
            	}
            	else
            	{
            		$("#publishmodal .mes .msg").html("Congratulations, your post has been successfully submitted and sent for approval. We'll send you notifications once it's live.");
            		$("#publishmodal").modal("show");
            		$("#publish").val('Publish');  
	                $("#publish").removeAttr('disabled');	
            	}            	
            }
        });
        return false;
    }
    /*$("#okbtn").click(function(){
    	location.href = "<?php //echo base_url(); ?>";
    });*/
});

</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</html>