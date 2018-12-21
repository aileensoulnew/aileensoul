<!DOCTYPE html>
<html ng-app="artistRegister">
   <head>
      <!-- start head -->
      <?php echo $head; ?>
      <title>Registration | Artistic Profile - Aileensoul</title>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
      <!-- This Css is used for call popup -->
      <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()) ?>">
      <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
      <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
      <?php $this->load->view('adsense'); ?>
   </head>
   <!-- END HEAD -->
   <!-- start header -->
   <?php echo $header; ?>
   <!-- END HEADER -->
   <?php 
   $userid = $this->session->userdata('aileenuser');
   if($userid){ ?>
      <body class="cus-no-login botton_footer registerbody">
      <?php echo $header_profile;
   }
   else
   { ?>
      <body class="cus-no-login botton_footer model-open no-login registerbody">
         <?php echo $header_profile; ?>
         <header>
            <div class="container">
               <div class="row">
                  <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                     <?php $this->load->view('main_logo'); ?>
                  </div>
                  <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                     <div class="btn-right pull-right">
                        <a href="javascript:void(0);" onclick="login_data();" class="btn2" title="Login">Login</a>
                        <a href="javascript:void(0);" onclick="register_profile();" class="btn3" title="Create an account">Create an account</a>
                     </div>
                  </div>
               </div>
            </div>
         </header>
   <?php 
   }?>
   <div class="middle-section">
      <div class="container mob-plr0">
         <div class="job_reg_page_fprm">
            <div class="common-form job_reg_main">
               <h3>Welcome in Artistic Profile</h3>
               <?php echo form_open(base_url('artist/profile_insert'), array('id' => 'artinfo','name' => 'artinfo','class' => 'clearfix', 'onsubmit' => "return validation_other(event)")); ?>
               <?php
               $firstname =  form_error('firstname');
               $lastname = form_error('lastname');
               $email =  form_error('email');
               $phoneno =  form_error('phoneno');
               $skills =  form_error('skills');
               $country = form_error('country');
               $state = form_error('state');
               $city = form_error('city');
               ?>
               <div class="fw p20">
                  <div class="row">
                     <div class="col-md-6 mx-auto">
                        <div class="form-group">
                           <label >First Name <font  color="red">*</font> :</label>
                           <input type="text" name="firstname" id="firstname" tabindex="1" placeholder="Enter first name" style="text-transform: capitalize;" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="<?php echo $userdata['first_name']; ?>" maxlength="35" class="form-control">
                           <?php echo form_error('firstname'); ?>
                        </div>
                     </div>
                     <div class="col-md-6 mx-auto">
                        <div class="form-group">
                           <label >Last Name <font  color="red">*</font>:</label>
                           <input type="text" name="lastname" id="lastname" tabindex="2" placeholder="Enter last name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name']; ?>" maxlength="35">
                           <?php echo form_error('lastname'); ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 col-sm-6">
                           <div class="form-group vali_er">                     
                              <label >Email Address <font  color="red">*</font> :</label>
                              <input type="email" name="email" id="email" tabindex="3" placeholder="Enter email address" value="<?php echo $userdata['email'];?>" maxlength="255">
                               <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                              <?php echo form_error('email'); ?>
                           </div>
                     </div>
                     <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label >Phone number <font  color="red">*</font> :</label>
                           <input type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Enter phone number" value="<?php echo $job[0]['user_email'];?>" maxlength="255">
                           <?php echo form_error('phoneno'); ?>
                        </div>
                     </div>
                  </div>                  
                  <div class="form-group <?php if($skills) {  ?> error-msg <?php } ?>">
                     <label>Art category:<span style="color:red">*</span></label>
                     <span class="span-select">
                        <select name="skills[]" id="skills" multiple>
                           <?php
                           foreach($art_category as $cnt){
                              if($art_category1)
                              {
                                 $category = explode(',' , $art_category1);
                                 ?>
                                 <option value="<?php echo $cnt['category_id']; ?>" <?php if(in_array($cnt['category_id'], $category)) echo 'selected';?> onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>
                                 <?php
                              }
                              else
                              { ?>
                                 <option value="<?php echo $cnt['category_id']; ?>" onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>
                              <?php
                              }
                           }
                           ?>
                        </select>
                     </span>
                     <?php echo form_error('skills'); ?>
                  </div>
                  <div id="other_category" class="other_category" style="<?php echo($othercategory1 ? 'display: block;' : 'display: none;');?>">
                     <div class="form-group <?php if($artname) {  ?> error-msg <?php } ?>">
                        <label>Other category:<span style="color:red">*</span></label>
                        <input name="othercategory"  type="text" id="othercategory" tabindex="2" placeholder="Other category" value="<?php if($othercategory1){ echo $othercategory1; } ?>" onkeyup= "return removevalidation();"/>
                        <?php echo form_error('othercategory'); ?>
                     </div>
                  </div>
                  <div class="row total-exp">
                     <div class="col-md-12">
                        Location:
                     </div>                     
                     <div class="col-md-4 col-sm-4 col-xs-4 <?php if($country) { echo 'error-msg';} ?>">
                        <div class="form-group">
                           <label>Country:<span style="color:red">*</span></label>
                           <span class="span-select">
                              <select class="form-control" name="country" id="country" tabindex="5">
                                 <option value="">Select country</option>
                                 <?php
                                 if(count($countries) > 0){
                                    foreach($countries as $cnt){ ?>
                                       <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name'];?></option>
                                       <?php
                                    }
                                 } ?>
                              </select>
                              <span id="country-error"></span>
                           </span>
                           <?php echo form_error('country'); ?>
                           </div>
                     </div>
                     
                     <div class="col-md-4 col-sm-4 col-xs-4 <?php if($state) {   echo 'error-msg'; } ?>">
                        <div class="form-group">
                           <label>state:<span style="color:red">*</span></label>
                           <span class="span-select">
                              <select class="form-control" name="state" id="state" tabindex="6">
                                 <?php
                                 if($state1)
                                 {
                                    foreach($states as $cnt){ ?>
                                       <option value="<?php echo $cnt['state_id']; ?>" <?php if($cnt['state_id']==$state1) echo 'selected';?>><?php echo $cnt['state_name'];?></option>
                                       <?php
                                    }
                                 }
                                 else
                                 {
                                    ?>
                                    <option value="">Select country first</option>
                                    <?php
                                 }
                                 ?>
                              </select>
                              <span id="state-error"></span>
                           </span>
                           <?php echo form_error('state'); ?>
                        </div>
                     </div>

                     <div class="col-md-4 col-sm-4 col-xs-4 <?php if($city) { echo 'error-msg'; } ?>">
                        <div class="form-group">
                           <label> City:<span style="color:red">*</span></label>
                              <select name="city" id="city" tabindex="7">
                                 <?php
                                 if($city1)
                                 {
                                    foreach($cities as $cnt){
                                       ?>
                                       <option value="<?php echo $cnt['city_id']; ?>" <?php if($cnt['city_id']==$city1) echo 'selected';?>><?php echo $cnt['city_name'];?></option>
                                       <?php
                                    }
                                 }
                                 else if($state1)
                                 {
                                    ?>
                                    <option value="">Select city</option>
                                    <?php
                                    foreach ($cities as $cnt) { ?>
                                       <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                       <?php
                                    }
                                 }
                                 else
                                 { ?>
                                    <option value="">Select state first</option>
                                    <?php
                                 }
                              ?>
                           </select>
                           <span id="city-error"></span>
                           <?php echo form_error('city'); ?>
                        </div>
                     </div>
                  </div>

                  <div class="fw text-center pt5">
                     <button id="next" name="next" tabindex="9" onclick="return validate();" class=" btn3">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span>
                     </button>
                  </div>
                  
               </div>
               <?php echo form_close();?>
            </div>
         </div>
      </div>
   </div>
   <!-- END CONTAINER -->

   <!-- Bid-modal  -->
   <div class="modal fade message-box biderror custom-message in" id="bidmodal" role="dialog"  >
      <div class="modal-dialog modal-lm" >
         <div class="modal-content message">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
               <span class="mes"></span>
            </div>
         </div>
      </div>
   </div>
   <!-- Model Popup Close -->

   <!-- <footer>        -->
   <?php echo $login_footer ?> 
   <?php echo $footer;  ?>
   <!-- </footer> -->

   <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
   <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
   <script src="<?php echo base_url('assets/js/jquery.multi-select.js?ver=' . time()); ?>"></script>
   <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist-live/artistic_common.js?ver='.time()); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist-live/profile.js?ver='.time()); ?>"></script>

   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
   <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
   <script>
      var base_url = '<?php echo base_url(); ?>';
      var profile_login = '<?php echo $profile_login; ?>';
      var user_id = '<?php echo $this->session->userdata('aileenuser');?>';
      var header_all_profile = '<?php echo $header_all_profile; ?>';
      var app = angular.module('artistRegister', ['ui.bootstrap']);
   </script>
   <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
</body>
</html>