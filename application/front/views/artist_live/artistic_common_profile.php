<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
$session_user_id = $this->session->userdata('aileenuser');
$main_id = "";
if($session_user_id != "")
{
    $main_id = "paddingtop_fixed";
}
?>

<?php if($artist_isregister == false){ ?>
<?php } ?>


<div class="container fw-991" id="<?php echo $main_id; ?>">
	<div class="row" id="row1" style="display:none;">
		<div class="col-md-12 text-center">
			<div id="upload-demo" ></div>
		</div>
		<div class="col-md-12 cover-pic" >
			<button class="btn btn-success cancel-result" onclick="">Cancel</button>
			<button class="btn btn-success upload-result fr" onclick="myFunction()">Save</button>
			<div id="message1" style="display:none;">
				<div id="floatBarsG">
					<div id="floatBarsG_1" class="floatBarsG"></div>
					<div id="floatBarsG_2" class="floatBarsG"></div>
					<div id="floatBarsG_3" class="floatBarsG"></div>
					<div id="floatBarsG_4" class="floatBarsG"></div>
					<div id="floatBarsG_5" class="floatBarsG"></div>
					<div id="floatBarsG_6" class="floatBarsG"></div>
					<div id="floatBarsG_7" class="floatBarsG"></div>
					<div id="floatBarsG_8" class="floatBarsG"></div>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="visibility: hidden;">
			<div id="upload-demo-i"></div>
		</div>
	</div>
	<div class="">
		<div id="row2">
			<?php
			/*$segment3 = explode('-', $this->uri->segment(3));
			$slugdata = array_reverse($segment3);
			$regid = $slugdata[0];     

			$userid = $this->db->select('user_id')->get_where('art_reg', array('art_id' => $regid))->row()->user_id;*/
			$regslug = $this->uri->segment(3);
			if($regslug){
				$userid = $this->db->select('user_id')->get_where('art_reg', array('slug' => $regslug))->row()->user_id;
			}else{
				$userid = $this->session->userdata('aileenuser');
			}
			
			$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
			$image = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

			$image_ori = $image[0]['profile_background'];
			?>
			<?php  

			if ($image_ori) { 
				?>                                                    
				<img src="<?php echo ART_BG_MAIN_UPLOAD_URL . $image[0]['profile_background'] ?>" name="image_src" id="image_src" alt="<?php echo  $image[0]['profile_background']; ?>"/>
				<?php
			} else { 
				?>
				<div class="bg-images no-cover-upload">
					<img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="NO IMAGE"/>
				</div>
			<?php } 
			?>
		</div>
	</div>
</div>
<div class="container tablate-container fw-991">
	<div class="profile-photo">
		<div class="buisness-menu other-profile-menu">
			<!--PROFILE PIC START-->
			<div class="profile-pho-bui">
				<div class="user-pic padd_img">
					<?php 
					if (IMAGEPATHFROM == 'upload') {
						if($artisticdata[0]['art_user_image']){
							if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>

								<img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">

							<?php } else { ?>
								<img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image'];?>">
							<?php } }else{ ?>
								<img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
							<?php }
						} else{
							$filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
							$s3 = new S3(awsAccessKey, awsSecretKey);
							$this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

							if ($info) { ?>
							 <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>" alt="<?php echo $artisticdata[0]['art_user_image']; ?>" >
							 <?php
						 } else { ?>
							<img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
						<?php } }?>
					</div>
				</div>
				<!--PROFILE PIC START-->
				<div class="business-profile-right">
					<div class="bui-menu-profile">
						<div class="profile-left">
							<h4 class="profile-head-text"><a href="javascript:void(0);" title="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>" onclick="login_profile();">
							 <?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?></a>
						 </h4>
						 <h4 class="profile-head-text_dg">
							<?php
							 if ($artisticdata[0]['designation'] == '') {
								?>

								<?php if ($artisticdata[0]['user_id'] == $userid) { ?>
									<a id="designation" class="designation" title="Designation" title="Current Work">Current Work </a>

								<?php } else{?>
									<a title="Current Work">Current Work </a>
								<?php }?>
							<?php } else { ?> 
								<?php if ($artisticdata[0]['user_id'] == $userid) { ?>
									<a id="designation" class="designation" title="<?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>">
										<?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>
									</a>
								<?php } else { ?>
									<a title="<?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>"><?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?></a>
								<?php } ?>
							<?php } ?>
						</h4>
					</div>
				</div>
				<!-- PICKUP -->
				<!-- menubar -->
				<div class="business-data-menu padding_less_right ">
					<div class="profile-main-box-buis-menu">  

					 <ul class="pro-fw4">               
						<li <?php if ($this->uri->segment(1) == 'artist' && $this->uri->segment(2) == 'p' && $this->uri->segment(4) == '') { ?> class="active" <?php } ?>><a title="Dashboard" href="javascript:void(0);" onclick="login_profile();"> Dashboard</a>
						</li>

						<li <?php if ($this->uri->segment(1) == 'artist' && $this->uri->segment(2) == 'p' && $this->uri->segment(4) == 'details') { ?> class="active" <?php } ?>><a title="Details" href="javascript:void(0);" onclick="login_profile();"> Details</a>
						</li>
						<?php
						$artregid = $artisticdata[0]['art_id'];
						$contition_array = array('follow_to' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
						$followerotherdata = $this->data['followerotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


						foreach ($followerotherdata as $followkey) {

							$contition_array = array('art_id' => $followkey['follow_from'], 'status' => '1');
							$artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
							if($artaval){

								$countdata[] =  $artaval;
							}
						}
						$count = count($countdata);


						?> 
						<li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'p' && $this->uri->segment(4) == 'followers') { ?> class="active" <?php } ?>><a  title="Followers" href="javascript:void(0);" onclick="login_profile();">Followers <br> (<?php echo ($count); ?>)</a>
						</li>
						<?php
						$artregid = $artisticdata[0]['art_id'];
						$contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
						$followingotherdata = $this->data['followingotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

						foreach ($followingotherdata as $followkey) {

							$contition_array = array('art_id' => $followkey['follow_to'], 'status' => '1');
							$artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
							if($artaval){

								$countfo[] =  $artaval;
							}
						}
						$countfo = count($countfo);


						?>
						<li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'p' && $this->uri->segment(4) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="javascript:void(0);" onclick="login_profile();">Following <br>  (<?php echo isset($countfo) ? $countfo : 0; ?>)</a>
						</li> 
					</ul>

					<div class="flw_msg_btn fr">
						<ul>
							<li class="<?php echo "fruser" . $artisticdata[0]['art_id']; ?>">
								<div id= "followdiv">
									<button id="<?php echo "follow" . $artisticdata[0]['art_id']; ?>" onclick="login_profile();">Follow</button>
								</div>
							</li>
							<li>
								<?php
								$userid = $this->session->userdata('aileenuser');
								if ($userid != $artisticdata[0]['user_id']) {
									?>
									<li> <a onclick="login_profile();" title="Message">Message</a> </li>
								<?php } ?>
							</ul>
						</div>

					</div>
				</div>
			</div>
			<!-- pickup -->
		</div>
	</div>
</div>

<!-- IF ARTIST NOT REGISTER & SIGN UP DONE -->
<?php if($artist_isregister == false && $session_user_id !=""){ ?>
	<div class="modal fade login register-model" id="register" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content inner-form1">
				<button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
				<div class="modal-body">
					<div class="clearfix">
						<div class="common-form">
							<div class="title">
								<h1 class="tlh1">Register in Artistic Profile</h1>
							</div>
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
							<fieldset>
								<label >First Name <font  color="red">*</font> :</label>                       
								<input type="text" name="firstname" id="firstname" tabindex="1" placeholder="Enter first name" style="text-transform: capitalize;" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="<?php echo $userdata['first_name']; ?>" maxlength="35">
								<?php echo form_error('firstname'); ?>
							</fieldset>
							<fieldset>
								<label >Last Name <font  color="red">*</font>:</label>
								<input type="text" name="lastname" id="lastname" tabindex="2" placeholder="Enter last name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name']; ?>" maxlength="35">
								<?php echo form_error('lastname'); ?>
							</fieldset>
							<fieldset class="vali_er">
								<label >Email Address <font  color="red">*</font> :</label>
								<input type="email" name="email" id="email" tabindex="3" placeholder="Enter email address" value="<?php echo $userdata['email'];?>" maxlength="255">
								<span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
								<?php echo form_error('email'); ?>
							</fieldset>
							<fieldset>
								<label >Phone number <font  color="red">*</font> :</label>
								<input type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Enter phone number" value="<?php echo $job[0]['user_email'];?>" maxlength="255">
								<?php echo form_error('phoneno'); ?>
							</fieldset>
							<fieldset class="full-width art-cat-custom vali_er <?php if($skills) {  ?> error-msg <?php } ?>">
								<label>Art category:<span style="color:red">*</span></label>
								<select name="skills[]" id="skills" multiple>
									<?php                             
									foreach($art_category as $cnt){ 
										if($art_category1)
										{ 
											$category = explode(',' , $art_category1);  
											?>
											<option value="<?php echo $cnt['category_id']; ?>"
												<?php if(in_array($cnt['category_id'], $category)) echo 'selected';?> onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>              
										<?php
											}
											else
											{  
										?>
												<option value="<?php echo $cnt['category_id']; ?>" onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>
										<?php  }       
									} ?>
								</select>
								<?php echo form_error('skills'); ?>
							</fieldset>
								<?php if($othercategory1){?>
									<div id="other_category" class="other_category" style="display: block;">
									<?php }else{ ?>
										<div id="other_category" class="other_category" style="display: none;">
										<?php }?>
										<fieldset class="full-width <?php if($artname) {  ?> error-msg <?php } ?>">
											<label>Other category:<span style="color:red">*</span></label>
											<input name="othercategory"  type="text" id="othercategory" tabindex="2" placeholder="Other category" value="<?php if($othercategory1){ echo $othercategory1; } ?>" onkeyup= "return removevalidation();"/>
											<?php echo form_error('othercategory'); ?>
										</div>
									</fieldset>
									<fieldset <?php if($country) {  ?> class="error-msg " <?php } ?>>
										<label>Country:<span style="color:red">*</span></label>    
										<select name="country" id="country" tabindex="5">
											<option value="">Select country</option>
											<?php
											if(count($countries) > 0){
												foreach($countries as $cnt){  ?>
													<option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name'];?></option>
													<?php                                            
												}       
											}
											?>
										</select>
										<span id="country-error"></span>
										<?php echo form_error('country'); ?>
									</fieldset> 
									<fieldset <?php if($state) {  ?> class="error-msg" <?php } ?>>
										<label>state:<span style="color:red">*</span></label>
										<select name="state" id="state" tabindex="6">
											<?php
											if($state1)
											{
												foreach($states as $cnt){  ?>
												 <option value="<?php echo $cnt['state_id']; ?>" <?php if($cnt['state_id']==$state1) echo 'selected';?>><?php echo $cnt['state_name'];?></option>
												 <?php
											 } }                                             
											 else
											 {
												?>
												<option value="">Select country first</option>
												<?php                                            
											}
											?>
										</select>
										<span id="state-error"></span>
										<?php echo form_error('state'); ?>
									</fieldset> 
									<fieldset class="full-width vali_er" <?php if($city) {  ?> class="error-msg" <?php } ?>>
										<label> City:<span style="color:red">*</label>
											<select name="city" id="city" tabindex="7">
												<?php
												if($city1)
												{
													foreach($cities as $cnt){                                              
														?>
														<option value="<?php echo $cnt['city_id']; ?>" <?php if($cnt['city_id']==$city1) echo 'selected';?>><?php echo $cnt['city_name'];?></option>
														<?php
													} }
													else if($state1)
													{
														?>
														<option value="">Select city</option>
														<?php
														foreach ($cities as $cnt) {
															?>
															<option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
															<?php
														}
													}                                              
													else
													{
														?>
														<option value="">Select state first</option>
														<?php                                          
													}
													?>
												</select>
												<span id="city-error"></span>
												<?php echo form_error('city'); ?>
											</fieldset>           
											<fieldset class=" full-width">
												<div class="job_reg">
													<button id="next" name="next" tabindex="9" onclick="return validate();" class="cus_btn_sub">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
												</div>
											</fieldset>
											<?php echo form_close();?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

<!-- IF DEACTIVATE REGISTER -->
		<?php if($isartistactivate == false && $artist_isregister == true && $session_user_id){ ?>
		<div class="modal fade login register-model" id="register" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content inner-form1">
					<button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
					<div class="modal-body">
						<div class="clearfix">
							<div class=" ">
								<div class="title">
									<h1 class="tlh1">Reactiavte Artistic Profile</h1>
								</div>
								<div class="reactivatebox">
									<div class="reactivate_header">
									 	<center><h2>Are you sure you want to reactive your artistic profile?</h2></center>
								 	</div>
								 	<div class="reactivate_btn_y">
									 	<a href="<?php echo base_url('artist/reactivate'); ?>" title="Yes">Yes</a>
								 	</div>
								 	<div class="reactivate_btn_n">
										<a href="javascript:void(0)" onclick="hidereactivepopup()" title="No">No</a>
									</div>
								 <script src="<?php echo base_url('assets/js_min/fb_login.js'); ?>"></script>
								</div>
						 	</div>
					 	</div>
			 		</div>
		 		</div>
				</div>
			</div>
		<?php } ?>
		 <script>
			var artist_deactive = '<?php echo $isartistactivate; ?>';
			var artist_isregister = '<?php echo $artist_isregister; ?>';
			var session_user_id = '<?php echo $this->session->userdata('aileenuser') ?>';
			var user_id = session_user_id;
			var profile_login = (session_user_id) ? 'login' : 'live';
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				if(!artist_isregister){
					// $('#register').modal('show');
				}
			});

			
			function hidereactivepopup(){
				$('#register').modal('hide');	
			}
			
		</script>

		