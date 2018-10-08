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
            <h2 style="text-align: center;" data-mce-style="text-align: center;"><span style="color: #ff0000;" data-mce-style="color: #ff0000;"><strong>Duis tortor elit, porta ut erat vel, fermentum finibus urna.</strong></span></h2><h3 style="text-align: center;" data-mce-style="text-align: center;"><span style="text-decoration: underline; color: #0000ff;" data-mce-style="text-decoration: underline; color: #0000ff;"><strong>Duis tortor elit, porta ut erat vel, fermentum finibus urna.</strong></span></h3><h4 style="text-align: center;" data-mce-style="text-align: center;"><span style="color: #ff00ff;" data-mce-style="color: #ff00ff;"><strong>Duis tortor elit, porta ut erat vel, fermentum finibus urna.</strong></span></h4><h5 style="text-align: center;" data-mce-style="text-align: center;"><span style="text-decoration: underline; color: #339966;" data-mce-style="text-decoration: underline; color: #339966;"><strong>Duis tortor elit, porta ut erat vel, fermentum finibus urna.</strong></span></h5><h6 style="text-align: center;" data-mce-style="text-align: center;"><span style="color: #00ccff;" data-mce-style="color: #00ccff;"><strong>Duis tortor elit, porta ut erat vel, fermentum finibus urna.</strong></span></h6><pre style="text-align: center;" data-mce-style="text-align: center;"><span style="text-decoration: underline; color: #003366;" data-mce-style="text-decoration: underline; color: #003366;"><strong>Duis tortor elit, porta ut erat vel, fermentum finibus urna.</strong></span></pre><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec. Sed faucibus, ex quis mollis fringilla, mi ipsum fermentum leo, eget congue arcu ipsum vel justo. Pellentesque bibendum interdum leo. Maecenas fringilla pellentesque rhoncus. Phasellus eget nulla mi. Aliquam erat volutpat. Aenean facilisis tellus sed ipsum dapibus eleifend. Praesent sodales elementum suscipit. Pellentesque hendrerit arcu eu lorem mattis, id suscipit nisi dapibus.</p><blockquote><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec.</p></blockquote><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec. Sed faucibus, ex quis mollis fringilla, mi ipsum fermentum leo, eget congue arcu ipsum vel justo. Pellentesque bibendum interdum leo. Maecenas fringilla pellentesque rhoncus. Phasellus eget nulla mi. Aliquam erat volutpat. Aenean facilisis tellus sed ipsum dapibus eleifend. Praesent sodales elementum suscipit. Pellentesque hendrerit arcu eu lorem mattis, id suscipit nisi dapibus.</p><p><img style="float: left;" src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_1542.png" alt="" width="209" height="133" data-mce-src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_1542.png" data-mce-style="float: left;"></p><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec. Sed faucibus, ex quis mollis fringilla, mi ipsum fermentum leo, eget congue arcu ipsum vel justo. Pellentesque bibendum interdum leo. Maecenas fringilla pellentesque rhoncus. Phasellus eget nulla mi. Aliquam erat volutpat. Aenean facilisis tellus sed ipsum dapibus eleifend. Praesent sodales elementum suscipit. Pellentesque hendrerit arcu eu lorem mattis, id suscipit nisi dapibus.</p><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec. Sed faucibus, ex quis mollis fringilla, mi ipsum fermentum leo, eget congue arcu ipsum vel justo. Pellentesque bibendum interdum leo. Maecenas fringilla pellentesque rhoncus. Phasellus eget nulla mi. Aliquam erat volutpat. Aenean facilisis tellus sed ipsum dapibus eleifend. Praesent sodales elementum suscipit. Pellentesque hendrerit arcu eu lorem mattis, id suscipit nisi dapibus.<img style="display: block; margin-left: auto; margin-right: auto;" src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_7416.jpg" alt="" width="514" height="261" data-mce-src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_7416.jpg" data-mce-style="display: block; margin-left: auto; margin-right: auto;"></p><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec. Sed faucibus, ex quis mollis fringilla, mi ipsum fermentum leo, eget congue arcu ipsum vel justo. Pellentesque bibendum interdum leo. Maecenas fringilla pellentesque rhoncus. Phasellus eget nulla mi. Aliquam erat volutpat. Aenean facilisis tellus sed ipsum dapibus eleifend. Praesent sodales elementum suscipit. Pellentesque hendrerit arcu eu lorem mattis, id suscipit nisi dapibus.</p><hr><p><img style="float: right;" src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_7430.jpg" alt="" width="189" height="138" data-mce-src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_7430.jpg" data-mce-style="float: right;"></p><p style="text-align: justify;" data-mce-style="text-align: justify;">Morbi posuere dui vel porta rhoncus. Phasellus imperdiet lorem at elit scelerisque condimentum. Duis bibendum dolor vel lectus porttitor semper. Praesent accumsan enim lacus, ut ultrices sapien gravida luctus. Etiam sit amet ante ipsum. Sed scelerisque ligula ut mi facilisis, sed porttitor elit iaculis. Pellentesque consequat pellentesque sapien. Phasellus sollicitudin velit risus, pellentesque interdum massa ornare nec. Sed faucibus, ex quis mollis fringilla, mi ipsum fermentum leo, eget congue arcu ipsum vel justo. Pellentesque bibendum interdum leo. Maecenas fringilla pellentesque rhoncus. Phasellus eget nulla mi. Aliquam erat volutpat. Aenean facilisis tellus sed ipsum dapibus eleifend. Praesent sodales elementum suscipit. Pellentesque hendrerit arcu eu lorem mattis, id suscipit nisi dapibus.</p><hr><p>Nullam egestas urna a orci cursus, vitae rutrum ipsum ullamcorper. Cras neque magna, porttitor non neque eu, fermentum vehicula nunc. Integer tincidunt fringilla urna sit amet egestas. Quisque elementum quam nec mauris tincidunt mattis. Ut tempor odio lobortis maximus scelerisque. Nullam volutpat elit sit amet dui pretium tincidunt. Donec quis aliquet orci, eu tempus mi. Sed elementum, urna sit amet elementum finibus, purus ante sodales eros, non facilisis est elit a dui. Donec sit amet orci et tortor malesuada aliquam nec nec erat. Nam fermentum aliquam venenatis. Donec nisi nisl, accumsan in felis quis, viverra viverra nunc. In scelerisque enim sed velit dictum, at fringilla sem egestas. Fusce feugiat ullamcorper sapien non ornare. Nullam in elit nec lectus porta varius. Etiam nec lobortis diam, non vestibulum sem.</p><p><img style="float: left;" src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_6542.jpg" alt="" width="243" height="128" data-mce-src="http://localhost/aileensoulnew/aileensoul/uploads/article/file_6542.jpg" data-mce-style="float: left;"></p><p style="text-align: justify;" data-mce-style="text-align: justify;">Nullam egestas urna a orci cursus, vitae rutrum ipsum ullamcorper. Cras neque magna, porttitor non neque eu, fermentum vehicula nunc. Integer tincidunt fringilla urna sit amet egestas. Quisque elementum quam nec mauris tincidunt mattis. Ut tempor odio lobortis maximus scelerisque. Nullam volutpat elit sit amet dui pretium tincidunt. Donec quis aliquet orci, eu tempus mi. Sed elementum, urna sit amet elementum finibus, purus ante sodales eros, non facilisis est elit a dui. Donec sit amet orci et tortor malesuada aliquam nec nec erat. Nam fermentum aliquam venenatis. Donec nisi nisl, accumsan in felis quis, viverra viverra nunc. In scelerisque enim sed velit dictum, at fringilla sem egestas. Fusce feugiat ullamcorper sapien non ornare. Nullam in elit nec lectus porta varius. Etiam nec lobortis diam, non vestibulum sem.</p>
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
	var base_url = "<?php echo base_url(); ?>"
</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</html>