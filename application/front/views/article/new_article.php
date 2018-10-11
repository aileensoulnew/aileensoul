<!DOCTYPE html>
<?php
$userid_login = $this->session->userdata('aileenuser');
$article_featured_upload_path = $this->config->item('article_featured_upload_path');?>
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
			.error {
			    border: 1px solid #ff0000 !important;
			}
        </style>
    <?php $this->load->view('adsense'); ?>
</head>
<body class="profile-main-page">
	<?php echo $header_inner_profile; ?>
	<div class="middle-section">
		<div class="container">
			<div id="save_post" style="display: none;">				
			</div>
			<div class="fw" id="upload_loader" style="text-align: center;position: absolute;display: none;z-index: 99999;top: 47%;">
                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="LOADERIMAGE">
            </div>
            <form id="article_frm" method="post" name="article_frm" action="javascript:void(0);" onsubmit="return submitArticle();">
				<input type="text" name="title_txt" id="title_txt" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_title'] : ''); ?>" placeholder="Enter title of Article">
				<label class="error" id="err_title" style="display: none;">Please Enter Title.</label>
				<?php
					if(isset($articleData) && !empty($articleData) && $articleData['article_featured_image'] != ""){
						$article_featured_image = $articleData['article_featured_image'];
						$article_cls = "";
					}
					else{
						$article_featured_image = $articleData['article_featured_image'];
						$article_cls = "display: none;";
					} ?>
				<input type="file" name="featured_img" id="featured_img">
				<div id="img_preview_div" class="text-center" style="display: none;position: relative;">
                    <div id="img_preview" style="width:100%;position: relative;"></div>
                	<button type="button" title="Save" class="btn btn-success set-btn upload-result pull-right" style="position: absolute;right: 0;bottom: 0;">Save</button>
                	<button type="button" title="Save" class="btn btn-success set-btn cancel-result pull-right" style="position: absolute;right: 40px;bottom: 0;">Cancel</button>
                </div>
                <img id="featured_img_src" style="<?php echo $article_cls; ?>" src="<?php echo base_url().$article_featured_upload_path.$article_featured_image; ?>">
				<!-- <div id="img_preview" style="display: none;position: relative;">					
					<i onclick="remove_img();" class="fa fa-close" aria-hidden="true" style="position: absolute;right: 0;cursor: pointer;"></i>
					<img id="featured_img_src" style="width: 15%;">
				</div> -->
				<textarea id="article_editor" name="article_editor"><?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_desc'] : ''); ?></textarea>
				<label class="error" id="err_desc" style="display: none;">Please Enter Some Content.</label>

				<input type="text" name="article_meta_title" id="article_meta_title" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_meta_title'] : ''); ?>" placeholder="Enter meta title" maxlength="70">
				<input type="text" name="article_meta_description" id="article_meta_description" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_meta_description'] : ''); ?>" placeholder="Enter meta description" maxlength="200">
				<?php $getFieldList = $this->data_model->getFieldList();?>
				<fieldset class="fw">           
					<label >What is your field?</label>
					<select name="article_main_category" id="article_main_category" onchange="other_field_fnc(this)">
						<option value="" selected="selected">Select your field</option>
						<?php foreach ($getFieldList as $key => $value) { ?>
							<option value="<?php echo $value['industry_id']; ?>" <?php echo $value['industry_id'] == $articleData['article_main_category'] ? "selected='selected'" : ""; ?>"><?php echo $value['industry_name']; ?></option>
						<?php } ?>
						<option value="0" <?php echo $articleData['article_main_category'] == "0" ? "selected='selected'" : ""; ?>>Other</option>
					</select>
				</fieldset>
				<fieldset class="fw" id="other_field_div" style="<?php echo $articleData['article_main_category'] == '0' ? '' : 'display: none;'; ?>;">
					<label>Enter other field</label>
					<input name="article_other_category" placeholder="Enter other field name" type="text" id="article_other_category" value="<?php echo $articleData['article_other_category'];?>"/>
					<span id="fullname-error"></span>
					<?php echo form_error('other_field'); ?>
				</fieldset>


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
	var article_slug = "";
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
<script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
<script src="<?php echo base_url('assets/js/webpage/article/article_new.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</html>