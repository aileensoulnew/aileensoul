<!DOCTYPE html>
<?php
$userid_login = $this->session->userdata('aileenuser');
$article_featured_upload_path = $this->config->item('article_featured_upload_path');
?>
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
        <!--link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>"--> 
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
<body class="new-article edit-article">
	<?php echo $header_inner_profile; ?>
	<div class="sub-header">
		<div class="container">
			<div class="pull-left">
				<p class="pt5">Publish your Article</p>
			</div>
			<div class="pull-right">
				<span id="save_post" style="display: none;">				
				</span>
				<a id="publish" href="javascript:void(0)" onclick="return submitArticle();" class="btn3">Publish</a>
			</div>
		</div>
	</div>
	<div class="middle-section">
		<div class="container">
			<div class="right-part">
				<div class="arti-profile-box">
					<div class="user-cover-img">
						<a href="<?php echo base_url().$user_data['user_slug']; ?>">
							<?php 
							if($user_data['profile_background'] != "")
							{ ?>							    
								<img src="<?php echo USER_BG_MAIN_UPLOAD_URL.$user_data['profile_background'];?>">
							<?php
							}else{ ?>
								<div class="gradient-bg"></div>
							<?php
							} ?>
						</a>
					</div>
					<div class="user-pr-img">
						<?php
							if ($user_data['user_image'] != "")
							{
							    $pro_img = USER_THUMB_UPLOAD_URL . $user_data['user_image'];
							}
							else
							{
							    if ($user_data['user_gender'] == "M") {
							        $pro_img = base_url('assets/img/man-user.jpg');
							    } elseif ($user_data['user_gender'] == "F") {
							        $pro_img = base_url('assets/img/female-user.jpg');
							    } else {
							        $pro_img = base_url('assets/img/man-user.jpg');
							    }

							}
						?>
						<a href="<?php echo base_url().$user_data['user_slug']; ?>"><img src="<?php echo $pro_img; ?>"></a>
					</div>
					<div class="user-info-text text-center">
						<h3>
							<a href="<?php echo base_url().$user_data['user_slug']; ?>">
							<?php echo ucwords($user_data['first_name']." ".$user_data['last_name']); ?>
							</a>
						</h3>
						<p>
							<a href="<?php echo base_url().$user_data['user_slug']; ?>">
								<?php 
								if($user_data['title_name'] != "")
									echo $user_data['title_name'];
								elseif($user_data['degree_name'] != "")
									echo $user_data['degree_name'];
								else
									echo "Current Work"; ?>
							</a>
						</p>
					</div>
				</div>
				<div class="meta-detail-box">
					<p>
						<a href="javascript:void(0);" data-target="#article-cetegory" data-toggle="modal" class="pull-left"><img src="<?php echo base_url(); ?>assets/n-images/edit.png"> </a>
						<span id="cat-selected" class="cat-field-cus">Select Category</span>
					</p>
					<p>
						<a href="#" data-target="#article-hashtag" data-toggle="modal" class="pull-left">
							<img src="<?php echo base_url(); ?>assets/n-images/edit.png">
						</a>
						<span id="article-hashtag-txt" class="cat-field-cus">
							<?php 
							if($articleData['hashtag'] != ''){
								echo $articleData['hashtag'];
							}
							else{
								echo "Article Hashtags";
							} ?>
						</span>
					</p>

					<p><a href="" data-target="#meta-detail" data-toggle="modal"><img src="<?php echo base_url(); ?>assets/n-images/edit.png"></a>Meta Title and Description</p>
				</div>
			</div>
			<div class="custom-user-list">				
				<div class="fw" id="upload_loader" style="text-align: center;position: absolute;display: none;z-index: 99999;top: 47%;">
					<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="LOADERIMAGE">
				</div>
				<div id="article_frm" method="post" name="article_frm" action="javascript:void(0);" onsubmit="">
					<input type="text" name="title_txt" id="title_txt" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_title'] : ''); ?>" placeholder="Enter Title of Article">
					<!-- <label class="error" id="err_title" style="display: none;">Please Enter Title.</label> -->
					<?php
						if(isset($articleData) && !empty($articleData) && $articleData['article_featured_image'] != ""){
							$article_featured_image = $articleData['article_featured_image'];
							$article_cls = "";
						}
						else{
							$article_featured_image = $articleData['article_featured_image'];
							$article_cls = "display: none;";
						} ?>
						<div class="image-upload">
							<label for="featured_img">
								<img src="<?php echo base_url('assets/n-images/article-bnr.png') . '' ?>"/>
							</label>

							<input id="featured_img" type="file"/>
							<div class="arti-preview-img">	
								<div id="img_preview_div" class="text-center" style="display: none;position: relative;">
									<div id="img_preview" style="width:100%;position: relative;"></div>
									<button type="button" title="Save" class="btn btn-success set-btn upload-result pull-right" style="position: absolute;right: 0;bottom: 0;">Save</button>
									<button type="button" title="Save" class="btn btn-success set-btn cancel-result pull-right" style="position: absolute;right: 40px;bottom: 0;">Cancel</button>
								</div>
								<img id="featured_img_src" style="<?php echo $article_cls; ?>" src="<?php echo base_url().$article_featured_upload_path.$article_featured_image; ?>">
								<a id="featured_img_remove" class="remove-featured-img" style="<?php echo $article_cls; ?>" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
							</div>
						</div>
					
					<!-- <div id="img_preview" style="display: none;position: relative;">					
						<i onclick="remove_img();" class="fa fa-close" aria-hidden="true" style="position: absolute;right: 0;cursor: pointer;"></i>
						<img id="featured_img_src" style="width: 15%;">
					</div> -->
					<textarea id="article_editor" name="article_editor"><?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_desc'] : ''); ?></textarea>
					<!-- <label class="error" id="err_desc" style="display: none;">Please Enter Some Content.</label> -->
				</div>
			</div>
			
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
		                		<a class="btn1" id="okbtn" onclick="change_url();" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>		                		
		                	</div>
		                </div>
		            </span>
	            </div>	            
	        </div>
	    </div>
	</div>
	<div class="modal fade message-box biderror" id="article-cetegory" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">                    
                <div class="modal-body">
                    <div class="article-popup">
						<?php $getFieldList = $this->data_model->getNewFieldList();?>
						<fieldset class="fw">
							<b>Select Category For Your Article</b>
							<span class="span-select">
							<select name="article_main_category" id="article_main_category" onchange="other_field_fnc(this)">
								<?php foreach ($getFieldList as $key => $value) { ?>
									<option value="<?php echo $value['industry_id']; ?>" <?php echo $value['industry_id'] == $articleData['article_main_category'] ? "selected='selected'" : ""; ?>><?php echo $value['industry_name']; ?></option>
								<?php } ?>
								<option value="0" <?php echo $articleData['article_main_category'] == "0" ? "selected='selected'" : ""; ?>>Other</option>
							</select>
							</span>
						</fieldset>
						<fieldset class="fw" id="other_field_div" style="<?php echo $articleData['article_main_category'] == '0' ? '' : 'display: none;'; ?>;">
							
							<input name="article_other_category" placeholder="Enter other field name" type="text" id="article_other_category" value="<?php echo $articleData['article_other_category'];?>"/>
							<span id="fullname-error"></span>
							<?php echo form_error('other_field'); ?>
						</fieldset>							
						<div class="mes">
							<div class="model_ok_cancel">
		                		<a class="btn1" id="okcategory" href="javascript:void(0);" title="OK">OK</a>
		                		<img id="cat_load_img" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="LOADERIMAGE" style="display: none;">
		                	</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade message-box biderror" id="meta-detail" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;
                </button>       
                <div class="modal-body">
					<div class="article-popup">
                        <input type="text" name="article_meta_title" id="article_meta_title" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_meta_title'] : ''); ?>" placeholder="Enter meta title" maxlength="70">
						<input type="text" name="article_meta_description" id="article_meta_description" value="<?php echo(isset($articleData) && !empty($articleData) ? $articleData['article_meta_description'] : ''); ?>" placeholder="Enter meta description" maxlength="200">
						<div class="mes">
							<div class="model_ok_cancel">
		                		<a class="btn1" id="okmeta" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
		                	</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="article-hashtag" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;
                </button>       
                <div class="modal-body">
					<div class="article-popup">
                        
                        <div class="form-group">
                            <label>Add hashtag (Topic)</label>                            
                            <textarea id="article_hashtag" type="text" class="hashtag-textarea"  placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);" style="min-height: auto;"><?php if($articleData['hashtag'] != ''){ echo trim($articleData['hashtag']);}?></textarea>
                            <div class="article_hashtag all-hashtags-list"></div>
							<div id="article-post-hashtag" class="tooltip-custom" style="display: none;">Add topic regarding your post that describes your post.</div>
                        </div>

						<div class="mes">
							<div class="model_ok_cancel">
		                		<a class="btn1" id="okhashtag" onclick="save_article_hashtag()" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
		                	</div>
						</div>
					</div>
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
<script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
<script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
<script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script> 
<script src="<?php echo base_url('assets/js/jquery-ui-1.12.1.js') ?>"></script>
<script src="<?php echo base_url('assets/js/autosize.js') ?>"></script>
<script type="text/javascript">
	var user_id = '<?php echo $this->session->userdata('aileenuser');?>';
	var header_all_profile = '<?php echo $header_all_profile; ?>';
	var app = angular.module('', ['ui.bootstrap']);
	var unique_key = "<?php echo(isset($articleData) && !empty($articleData) ? $articleData['unique_key'] : $unique_key); ?>"
	var base_url = "<?php echo base_url(); ?>"
	var edit_art_published = "<?php echo $edit_art_published; ?>"
	var new_article = "<?php echo $new_article; ?>"
	var article_slug = "";
	var user_type = "1";
	if(new_article == 1)
	{
		$("#article-cetegory").modal('show');
	}
	autosize(document.getElementsByClassName('hashtag-textarea'));
</script>
<script src="http://chat.aileensoul.localhost/socket.io/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect("<?php echo SOCKETSERVER; ?>");
</script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
<script src="<?php echo base_url('assets/js/webpage/article/article_new.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
<script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
</html>