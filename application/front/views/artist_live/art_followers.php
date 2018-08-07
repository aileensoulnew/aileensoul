<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<?php echo $head; ?>
 <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">

<?php }else{?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">

<?php }?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
<?php $this->load->view('adsense'); ?>
</head>
<body  class="page-container-bg-solid page-boxed botton_footer  body-loader">
  <?php $this->load->view('page_loader'); ?>
    <div id="main_page_load" style="display: block;">

<?php echo $header; ?>
<?php echo $artistic_header2; ?>

   <section class="custom-row">
      <?php echo $artistic_common; ?>
       <div class="user-midd-section art-inner">
           <div class="container mobp0">
   
      <div class="custom-user-list bus-art-cus-left">
		<div class="tab-add-991">
			<?php $this->load->view('banner_add'); ?>
		</div>
      <div>
         <?php
            if ($this->session->flashdata('error')) {
                echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
            }
            if ($this->session->flashdata('success')) {
                echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
            }?>
      </div>
      <div class="common-form">
         <div class="job-saved-box">
            <h3 class="border-bottom0">Followers</h3>
            <div class="contact-frnd-post">
                    <div class="job-contact-frnd ">
                    </div>  
                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>         
                  <div class="col-md-1">
                  </div>
            </div>
         </div>
      </div>
		<div class="banner-add">
			<?php $this->load->view('banner_add'); ?>
		</div>
      </div>
		<div class="right-add">
			<?php $this->load->view('right_add_box'); ?>
		</div>
      </div>
           </div>
   </section>   
     <!-- Bid-modal-2  -->
   <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                             <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                               <div class=" ">
                                <div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>

                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display: none"></div>
                                    </div>
                                <input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                </form>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
   <!-- Model Popup Close -->
    <!-- Bid-modal  -->
   <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
      <div class="modal-dialog modal-lm">
         <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
               <span class="mes"></span>
            </div>
         </div>
      </div>
   </div>
   <!-- Model Popup Close -->
  </div>
  <?php echo $login_footer ?>
    <?php echo $footer;  ?>
 <?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>

<?php }else{?>

<script src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>

<?php }?>
<script>
var base_url = '<?php echo base_url(); ?>';   
var data= <?php echo json_encode($demo); ?>;   
var data1 = <?php echo json_encode($city_data); ?>;
var slug_id = '<?php echo $artisticdata[0]['user_id'] ?>';
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/followers.js?ver='.time()); ?>"></script>
<?php
  /*if (IS_ART_JS_MINIFY == '0') { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/followers.js?ver='.time()); ?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/followers.js?ver='.time()); ?>"></script>

<?php } */?>
<script>
     var header_all_profile = '<?php echo $header_all_profile; ?>';
</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</body>
</html>