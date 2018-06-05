<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    </head>
    <Style>
    .profile_edit h3{text-align: center;}
    .common-form fieldset select:focus{ border: 1px solid #1b8ab9 !important;
color: #1b8ab9 !important;}
     </Style>
    
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header_inner_profile; ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row">
                        <div class="">
                            <div class="col-lg-3 col-md-4 col-sm-4">
                                <div class="">
                                    <div class="left-side-bar" id="bs-collapse" >
                                        <ul class="left-form-each">
                                            <li  <?php if ($this->uri->segment(1) == 'profile') { ?> class="active init" <?php } ?>>  <a href="<?php echo base_url() . 'profile' ?>" data-toggle="collapse" data-parent="#bs-collapse" id="toggle">Edit</a></li>
                                            <li> <a href="<?php echo base_url('registration/changepassword') ?>">Change Password</a></li>
                                             <!-- <li> <a href="#">Edit Basic Information</a></li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-8 edit-pr-custom">
								<div class="panel with-nav-tabs panel-default">
									<div class="panel-heading">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#edit-profile" data-toggle="tab">General Info</a></li>
												<li><a href="#edit-basic-info" data-toggle="tab">Basic Info</a></li>
												
											</ul>
									</div>
									<div class="panel-body">
										<div class="tab-content">
											<div class="tab-pane fade in active" id="edit-profile">
												<div class="common-form profile_edit main_form change-password-box">
                                
													<?php echo form_open_multipart(base_url('profile/edit_profile'), array('id' => 'basicinfo', 'name' => 'basicinfo', 'class' => "clearfix common-form_border")); ?>
													<fieldset class="">
														<label >First Name </label>
														<input tabindex="1" name="first_name" type="text" placeholder="Firstname..." id="first_name" value="<?php echo $userdata['first_name'] ?>" onblur="return full_name();"/><span id="fullname-error"></span><?php echo form_error('first_name'); ?>
													</fieldset>
													<fieldset class="">
														<label>Last Name</label>
														<input tabindex="2" name="last_name" placeholder="Lastname...." type="text" id="last_name" value="<?php echo $userdata['last_name'] ?>" onblur="return full_name();"/><span id="fullname-error"></span>
														<?php echo form_error('last_name'); ?>
													</fieldset>
													<fieldset>           
														<label >E-mail Address:</label>
														<input name="email_profile" tabindex="4"  type="email" id="email_profile" placeholder="EmailAddress..."  value="<?php echo $userdata['email'] ?>"/><span id="email-error"></span> <?php echo form_error('email'); ?>
													</fieldset>
													<fieldset>        
														<label>Birthday:</label>
														<select tabindex="5" class="day" name="selday" id="selday">
															<option value="" disabled selected value>Day</option>
															<?php
															for ($i = 1; $i <= 31; $i++) {
																?>
																<option value="<?php echo $i; ?>" <?php
																if ($i == $usrd) {
																	echo "selected";
																}
																?>><?php echo $i; ?></option>
																		<?php
																	}
																	?>
														</select>
														<select tabindex="6" class="month" name="selmonth" id="selmonth">
															<option value="" disabled selected value>Month</option>
															<option value="1" <?php
															if ($usrm == 1) {
																echo "selected";
															}
															?>>Jan</option>
															<option value="2" <?php
															if ($usrm == 2) {
																echo "selected";
															}
															?>>Feb</option>
															<option value="3" <?php
															if ($usrm == 3) {
																echo "selected";
															}
															?>>Mar</option>
															<option value="4" <?php
															if ($usrm == 4) {
																echo "selected";
															}
															?>>Apr</option>
															<option value="5" <?php
															if ($usrm == 5) {
																echo "selected";
															}
															?>>May</option>
															<option value="6" <?php
															if ($usrm == 6) {
																echo "selected";
															}
															?>>Jun</option>
															<option value="7" <?php
															if ($usrm == 7) {
																echo "selected";
															}
															?>>Jul</option>
															<option value="8" <?php
															if ($usrm == 8) {
																echo "selected";
															}
															?>>Aug</option>
															<option value="9" <?php
															if ($usrm == 9) {
																echo "selected";
															}
															?>>Sep</option>
															<option value="10" <?php
															if ($usrm == 10) {
																echo "selected";
															}
															?>>Oct</option>
															<option value="11" <?php
															if ($usrm == 11) {
																echo "selected";
															}
															?>>Nov</option>
															<option value="12" <?php
															if ($usrm == 12) {
																echo "selected";
															}
															?>>Dec</option>
															?>
														</select>
														<select tabindex="7" class="year" name="selyear" id="selyear">
															<option value="" disabled selected value>Year</option>
															<?php
															for ($i = date('Y'); $i >= 1900; $i--) {
																?>
																<option value="<?php echo $i; ?>" <?php
																if ($usry == $i) {
																	echo "selected";
																}
																?>><?php echo $i; ?></option>
																		<?php
																	}
																	?>
														</select>
														<div class="dateerror" style="color:#f00; display: block;"></div>

													</fieldset>

													<fieldset>
														<label>Gender</label>
														<input class="gen-male" tabindex="8" type="radio" id="gen" name="gender" value="M" <?php
														if ($userdata['user_gender'] == M) {
															echo 'checked';
														}
														?>>Male
														<input type="radio" id="gen" name="gender" value="F" <?php
														if ($userdata['user_gender'] == F) {
															echo 'checked';
														}
														?>>Female

														<?php echo form_error('gender'); ?>
													</fieldset>
													<fieldset class="hs-submit full-width">
														<input type="submit" tabindex="9" value="submit" name="submit" id="submit">
													</fieldset>
													<?php echo form_close();?>
												</div>
											</div>
											
											<div class="tab-pane fade" id="edit-basic-info">
												<?php
													$is_user = 0;
													if(isset($professionData) && !empty($professionData))
														$is_user = 1;
													if(isset($studentData) && !empty($studentData))
														$is_user = 2;?>
													
												<div id="basic_info" class="common-form profile_edit main_form change-password-box" <?php echo $is_user == 2 ? 'display: none;' : ''; ?>">
													<form id="basic_info_frm" name="basic_info_frm" action="<?php echo base_url(); ?>profile/edit_basic_info" method="post">
														<p class="student-or-not">If you are a student then <a href="javascript:void(0);" id="is_basic">Click Here.</a></p>
														<fieldset class="fw">
															<label >Who are you?</label>
															<input tabindex="10" name="job_title" type="text" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, Developer, HR, BDE, CA, Doctor.." id="job_title" value="<?php echo $professionData['name']; ?>"/><span id="fullname-error"></span><?php echo form_error('job_title'); ?>
														</fieldset>
														<fieldset class="fw">
															<label>Where are you from?</label>
															<input tabindex="11" name="city" placeholder="Enter your city name" type="text" id="cities2" value="<?php echo $professionData['city_name']; ?>"/><span id="fullname-error"></span>
															<?php echo form_error('city'); ?>
														</fieldset>
														<?php $getFieldList = $this->data_model->getFieldList();?>
														<fieldset class="fw">           
															<label >What is your field?</label>
															<select tabindex="12" name="field" id="field" onchange="other_field_fnc(this)">
																<option value="" selected="selected">Select your field</option>
																<?php foreach ($getFieldList as $key => $value) { ?>
																	<option value="<?php echo $value['industry_id']; ?>" <?php echo $value['industry_id'] == $professionData['field'] ? "selected='selected'" : ""; ?>"><?php echo $value['industry_name']; ?></option>
																<?php } ?>
																<option value="0" <?php echo $professionData['field'] == "0" ? "selected='selected'" : ""; ?>>Other</option>
															</select>
															<?php echo form_error('field'); ?>
														</fieldset>
														<fieldset class="fw" id="other_field_div" style="<?php echo $professionData['field'] == '0' ? '' : 'display: none;'; ?>;">
															<label>Enter other field</label>
															<input tabindex="13" name="other_field" placeholder="Enter your field name" type="text" id="other_field" value="<?php echo $professionData['other_field'];?>"/><span id="fullname-error"></span>
															<?php echo form_error('other_field'); ?>
														</fieldset>

														<fieldset class="hs-submit full-width">
															<input type="submit" tabindex="14" value="submit" name="submit" id="submit_basicinfo">
														</fieldset>
													</form>
												</div>
												
												<div id="stud_info" class="common-form profile_edit main_form change-password-box" style="<?php echo $is_user == 1 ? 'display: none;' : ''; ?>">
													<h5>Edit Student Information</h5>
													<form id="stud_info_frm" name="stud_info_frm" action="<?php echo base_url(); ?>profile/edit_stud_info" method="post">
														

														<fieldset class="fw">
															<label >What are you studying right now?</label>
															<input tabindex="10" name="currentStudy" type="text" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 5th, 10th, 12th .." id="currentStudy" value="<?php echo $studentData['degree_name']; ?>"/><span id="fullname-error"></span><?php echo form_error('currentStudy'); ?>
														</fieldset>
														<fieldset class="fw">
															<label>Where are you from?</label>
															<input tabindex="11" name="studcity" placeholder="Enter your city name" type="text" id="studcity" value="<?php echo $studentData['city_name']; ?>"/><span id="fullname-error"></span>
															<?php echo form_error('studcity'); ?>
														</fieldset>
														<fieldset class="fw">
															<label >University / Collage / School</label>
															<input tabindex="10" name="university" type="text" placeholder="Enter your University / Collage / school " id="university" value="<?php echo $studentData['university_name']; ?>"/><span id="fullname-error"></span><?php echo form_error('university'); ?>
														</fieldset>
														<fieldset class="fw">
															<label >Interested field</label>
															<input tabindex="10" name="studjob_title" type="text" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, Developer, HR, BDE, CA, Doctor.." id="studjob_title" value="<?php echo $studentData['name']; ?>"/><span id="fullname-error"></span><?php echo form_error('studjob_title'); ?>
														</fieldset>
														<fieldset class="hs-submit full-width">
															<a class="btn3" href="javascript:void(0);" id="is_stud">Back</a>
															<input type="submit" tabindex="14" value="submit" name="submit" id="submit_studinfo">
														</fieldset>
													</form>
												</div>
												
											</div>
											
										</div>
									</div>
								</div>
							</div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Calender JS Start-->
         <footer> 
            <?php echo $login_footer ?>
            <?php echo $footer; ?>
        </footer> 
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <?php
        if(IS_OUTSIDE_JS_MINIFY == '0'){
        ?>
            <!-- <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script> -->
            <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
            </script>
        <?php } else{ ?>
            <!-- <script src="<?php echo base_url('assets/js_min/jquery.js'); ?>"></script> -->

            <script type="text/javascript" src="<?php echo base_url() ?>assets/js_min/jquery.validate.min.js"></script>
            </script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/additional-methods1.15.0.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <!-- POST BOX JAVASCRIPT END --> 
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <?php
        if(IS_OUTSIDE_JS_MINIFY == '0'){
        ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/profile/profile.js'); ?>"></script>
        <?php } else{ ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/profile/profile.js'); ?>"></script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>

        <script type="text/javascript">
            $("#is_basic").click(function(){                
                $("#basic_info").hide();
                $("#stud_info").show();
            });
            $("#is_stud").click(function(){                
                $("#basic_info").show();
                $("#stud_info").hide();
            });

            $(function() {
                function split( val ) {
                    return val.split( /,\s*/ );
                }
                function extractLast( term ) {
                    return split( term ).pop();
                }

                $( "#job_title" ).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 2,
                    source: function( request, response ) { 
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_jobtitle", { term : extractLast( request.term )},response);
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },

                    select: function(event, ui) {
                        event.preventDefault();
                        $("#job_title").val(ui.item.label);
                        //$("#selected-tag").val(ui.item.label);
                    },
                });

                $( "#cities2" ).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 2,
                    source: function( request, response ) { 
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url +"general/get_location", { term : extractLast( request.term )},response);
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#cities2").val(ui.item.label);
                    }
                });

                $.validator.addMethod("regx1", function(value, element, regexpr) {
                    if (!value) {
                        return true;
                    } else {
                        return regexpr.test(value);
                    }
                }, "Only space, only number and only special characters are not allow");
                $("#basic_info_frm").validate({
                    rules: {
                        job_title: {
                            required: true,
                            regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                        },                    
                        city: {
                            required: true,
                            regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                        },
                        field: {
                            required: true,
                        },
                    },
                    messages: {
                        job_title: {
                            required: "This field is required.",
                        },                    
                        city: {
                            required: "This field is required.",
                        },
                        field: {
                            required: "This field is required.",
                        },
                    },
                });

                $( "#currentStudy" ).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 2,
                    source: function( request, response ) { 
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url +"general_data/searchDegreeListNew", { q : extractLast( request.term )},response);
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#currentStudy").val(ui.item.label);
                    }
                });


                $( "#studcity" ).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 2,
                    source: function( request, response ) { 
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url +"general/get_location", { term : extractLast( request.term )},response);
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#studcity").val(ui.item.label);
                    }
                });

                $( "#university" ).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 2,
                    source: function( request, response ) { 
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url +"general_data/searchUniversityListNew", { q : extractLast( request.term )},response);
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#university").val(ui.item.label);
                    }
                });

                $( "#studjob_title" ).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 2,
                    source: function( request, response ) { 
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_jobtitle", { term : extractLast( request.term )},response);
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },

                    select: function(event, ui) {
                        event.preventDefault();
                        $("#studjob_title").val(ui.item.label);
                        //$("#selected-tag").val(ui.item.label);
                    },
                });

                $("#stud_info_frm").validate({
                    rules: {
                        currentStudy: {
                            required: true,
                        },
                        studcity: {
                            required: true,
                        },
                        university: {
                            required: true,
                        },
                        studjob_title: {
                            required: true,
                        }
                    },
                    messages: {
                        currentStudy: {
                            required: "Current study is required.",
                        },
                        studcity: {
                            required: "City is required.",
                        },
                        university: {
                            required: "University name is required.",
                        },
                        studjob_title: {
                            required:  "Interested field is required.",
                        }
                    }

                });

            });
            function other_field_fnc(id)
            {
                if(id.value == 0)
                {
                    $("#other_field_div").show();
                }
                else
                {
                    $("#other_field_div").hide();
                }
            }
        </script>
    </body>
</html>