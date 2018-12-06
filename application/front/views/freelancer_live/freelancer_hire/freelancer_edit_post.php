<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <style type="text/css">
            .autoposition{
                position: absolute!important;
                z-index: 999 !important;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    <?php $this->load->view('adsense'); ?>
</head>

    <body class="page-container-bg-solid page-boxed botton_footer freeh3">
        <?php //echo $header; ?>
        <?php echo $freelancer_hire_header2; ?>
        <div class="middle-section">
            <div class="container mob-plr0 post-job-new">
					<div class="tab-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
                    <div class="custom-user-list">
                        <div class="">
                            <div>
                                <?php
                                if ($this->session->flashdata('error')) {
                                    echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                }
                                if ($this->session->flashdata('success')) {
                                    echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                }
                                ?>
                            </div>
                            
                            <h3 class="col-chang cus-chang border-none"><?php echo $this->lang->line("edit_project"); ?></h3>
                            <?php //echo form_open(base_url('freelancer_hire/freelancer_edit_post_insert/' . $freelancerpostdata[0]['post_id']), array('id' => 'postinfo', 'name' => 'postinfo', 'class' => 'clearfix form_addedit')); ?>
                            <form action="<?php //echo base_url('freelancer_hire/freelancer_add_post_insert'); ?>" id="postinfo" name="postinfo" class="clearfix" onsubmit="imgval()" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="post_file_old" id="post_file_old" value="<?php echo $freelancerpostdata[0]['post_file']; ?>">
                            <?php
                            $post_name = form_error('post_name');
                            $skills = form_error('skills');
                            $post_desc = form_error('post_desc');
                            $fields = form_error('fields_req');
                           // $lastdate = form_error('latdate');
                           // $rate = form_error('rate');
                           // $currency = form_error('currency');
                            $rating = form_error('rating');
                            ?>
                            <div class="job_reg_main fw post-job-cus">
                                <h3>Post Project</h3>
                                <div class="fw p20">

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("project_title"); ?>:<span style="color:red">*</span></label>
                                        <input name="post_name" type="text" id="post_name" maxlength="100" tabindex="1" autofocus placeholder="Enter post name" value="<?php echo $freelancerpostdata[0]['post_name'] ?> " onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/>
                                        <span id="fullname-error"></span>                        
                                        <?php echo form_error('post_name'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("project_description"); ?>:<span style="color:red">*</span></label>
                                        <textarea row="8" style="resize: none; overflow: auto;" tabindex="2" name="post_desc" id="post_desc" placeholder="Enter description"><?php echo $freelancerpostdata[0]['post_description']; ?></textarea>
                                        <?php echo form_error('post_desc'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label>Category:<span style="color:red">*</span></label>
                                        <select tabindex="4" name="fields_req" id="fields_req" class="field_other">
                                            <option value="" selected option disabled><?php echo $this->lang->line("select_filed"); ?></option>
                                            <?php
                                            if (count($category_data) > 0) {
                                                foreach ($category_data as $cnt) {
                                                    if ($freelancerpostdata[0]['post_field_req']) {
                                                        ?>
                                                        <option value="<?php echo $cnt['category_id']; ?>" <?php if ($cnt['category_id'] == $freelancerpostdata[0]['post_field_req']) echo 'selected'; ?>><?php echo $cnt['category_name']; ?></option>
                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <option value="<?php echo $cnt['category_id']; ?>"><?php echo $cnt['category_name']; ?></option> 
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $category_otherdata[0]['category_id']; ?> "><?php echo $category_otherdata[0]['category_name']; ?></option>
                                        </select>
                                        <?php echo form_error('fields_req'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("skill_of_requirement"); ?>:<span style="color:red">*</span></label>
                                        <input id="skills2" name="skills"  tabindex="3"  size="90" placeholder="Enter skills" value="<?php if ($skill_2) { echo $skill_2; } ?>" maxlength="255">
                                        <?php echo form_error('skills'); ?>
                                    </div>

                                    <div class="row">
                                        <label class="col-md-12 fw">Required Experience:<span class="optional">(optional)</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select  class="form-control" name="year" id="year" tabindex="5">
                                                        <option value="" selected option disabled><?php echo $this->lang->line("year"); ?></option>
                                                        <option value="0" <?php if ($freelancerpostdata[0]['post_exp_year'] == "0") echo 'selected="selected"'; ?>>0 Year</option>
                                                        <option value="1" <?php if ($freelancerpostdata[0]['post_exp_year'] == "1") echo 'selected="selected"'; ?>>1 Year</option>
                                                        <option value="2" <?php if ($freelancerpostdata[0]['post_exp_year'] == "2") echo 'selected="selected"'; ?>>2 Year</option>
                                                        <option value="3" <?php if ($freelancerpostdata[0]['post_exp_year'] == "3") echo 'selected="selected"'; ?>>3 Year</option>
                                                        <option value="4" <?php if ($freelancerpostdata[0]['post_exp_year'] == "4") echo 'selected="selected"'; ?>>4 Year</option>
                                                        <option value="5" <?php if ($freelancerpostdata[0]['post_exp_year'] == "5") echo 'selected="selected"'; ?>>5 Year</option>
                                                        <option value="6" <?php if ($freelancerpostdata[0]['post_exp_year'] == "6") echo 'selected="selected"'; ?>>6 Year</option>
                                                        <option value="7" <?php if ($freelancerpostdata[0]['post_exp_year'] == "7") echo 'selected="selected"'; ?>>7 Year</option>
                                                        <option value="8" <?php if ($freelancerpostdata[0]['post_exp_year'] == "8") echo 'selected="selected"'; ?>>8 Year</option>
                                                        <option value="9" <?php if ($freelancerpostdata[0]['post_exp_year'] == "9") echo 'selected="selected"'; ?>>9 Year</option>
                                                        <option value="10" <?php if ($freelancerpostdata[0]['post_exp_year'] == "10") echo 'selected="selected"'; ?>>10 Year</option>
                                                        <option value="11" <?php if ($freelancerpostdata[0]['post_exp_year'] == "11") echo 'selected="selected"'; ?>>11 Year</option>
                                                        <option value="12" <?php if ($freelancerpostdata[0]['post_exp_year'] == "12") echo 'selected="selected"'; ?>>12 Year</option>
                                                        <option value="13" <?php if ($freelancerpostdata[0]['post_exp_year'] == "13") echo 'selected="selected"'; ?>>13 Year</option>
                                                        <option value="14" <?php if ($freelancerpostdata[0]['post_exp_year'] == "14") echo 'selected="selected"'; ?>>14 Year</option>
                                                        <option value="15" <?php if ($freelancerpostdata[0]['post_exp_year'] == "15") echo 'selected="selected"'; ?>>15 Year</option>
                                                        <option value="16" <?php if ($freelancerpostdata[0]['post_exp_year'] == "16") echo 'selected="selected"'; ?>>16 Year</option>
                                                        <option value="17" <?php if ($freelancerpostdata[0]['post_exp_year'] == "17") echo 'selected="selected"'; ?>>17 Year</option>
                                                        <option value="18" <?php if ($freelancerpostdata[0]['post_exp_year'] == "18") echo 'selected="selected"'; ?>>18 Year</option>
                                                        <option value="19" <?php if ($freelancerpostdata[0]['post_exp_year'] == "19") echo 'selected="selected"'; ?>>19 Year</option>
                                                        <option value="20" <?php if ($freelancerpostdata[0]['post_exp_year'] == "20") echo 'selected="selected"'; ?>>20 Year</option>
                                                    </select>
                                                </span>
                                                <?php echo form_error('year'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select class="form-control" name="month" tabindex="6" id="month">
                                                        <option value="" selected option disabled><?php echo $this->lang->line("month"); ?></option>
                                                        <option value="0" <?php if ($freelancerpostdata[0]['post_exp_month'] == "0") echo 'selected="selected"'; ?>>0 Month</option>
                                                        <option value="1" <?php if ($freelancerpostdata[0]['post_exp_month'] == "1") echo 'selected="selected"'; ?>>1 Month</option>
                                                        <option value="2" <?php if ($freelancerpostdata[0]['post_exp_month'] == "2") echo 'selected="selected"'; ?>>2 Month</option>
                                                        <option value="3" <?php if ($freelancerpostdata[0]['post_exp_month'] == "3") echo 'selected="selected"'; ?>>3 Month</option>
                                                        <option value="4" <?php if ($freelancerpostdata[0]['post_exp_month'] == "4") echo 'selected="selected"'; ?>>4 Month</option>
                                                        <option value="5" <?php if ($freelancerpostdata[0]['post_exp_month'] == "5") echo 'selected="selected"'; ?>>5 Month</option>
                                                        <option value="6"<?php if ($freelancerpostdata[0]['post_exp_month'] == "6") echo 'selected="selected"'; ?>>6 Month</option>
                                                    </select>
                                                </span>
                                                <?php echo form_error('month'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Last date to apply on this project:<span style="color:red">*</span></label>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="hidden" id="example2" name="latdate">
                                            </div>
                                            <?php echo form_error('latdate'); ?> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="upload-file">
                                            <label>Upload Reference File / Media</label>
                                            <input type="file" id="add_project_file" name="add_project_file" tabindex="10">
                                            <span id="add_project_file_error" class="error" style="display: none;"></span>
                                            <?php if($freelancerpostdata[0]['post_file'] != ""){ ?>
                                                <p class="screen-shot">
                                                    <a class="file-preview-cus" href="<?php echo FREE_HIRE_POST_FILE_UPLOAD_URL.$freelancerpostdata[0]['post_file'] ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/n-images/detail/file-up-cus.png"></a>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="job_reg_main fw post-job-cus">
                                <h3>Specific Description</h3>
                                <div class="fw p20">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>What type of project?</label>
                                                <span class="span-select">
                                                    <select class="form-control" id="add_project_type" name="add_project_type" tabindex="11">
                                                        <option value="1" <?php echo ($freelancerpostdata[0]['post_type'] == '1' ? 'selected="selected"' : ''); ?>>One-time</option>
                                                        <option value="2" <?php echo ($freelancerpostdata[0]['post_type'] == '2' ? 'selected="selected"' : ''); ?>>On-going</option>
                                                        <option value="3" <?php echo ($freelancerpostdata[0]['post_type'] == '3' ? 'selected="selected"' : ''); ?>>I'm not sure</option>
                                                    </select>
                                                </span>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>How long do you expect this project to last?</label>
                                                <span class="span-select">
                                                    <select class="form-control" id="add_project_duration" name="add_project_duration" tabindex="12">
                                                        <option value="1" <?php echo ($freelancerpostdata[0]['post_duration'] == '1' ? 'selected="selected"' : ''); ?>>1 Week</option>
                                                        <option value="2" <?php echo ($freelancerpostdata[0]['post_duration'] == '2' ? 'selected="selected"' : ''); ?>>2 Weeks</option>
                                                        <option value="3" <?php echo ($freelancerpostdata[0]['post_duration'] == '3' ? 'selected="selected"' : ''); ?>>1 Month</option>
                                                        <option value="4" <?php echo ($freelancerpostdata[0]['post_duration'] == '4' ? 'selected="selected"' : ''); ?>>1-3 Months</option>
                                                        <option value="5" <?php echo ($freelancerpostdata[0]['post_duration'] == '5' ? 'selected="selected"' : ''); ?>>3-6 Months</option>
                                                        <option value="6" <?php echo ($freelancerpostdata[0]['post_duration'] == '6' ? 'selected="selected"' : ''); ?>>Over 6 Months</option>
                                                    </select>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>How many hours per week will you require?</label>
                                                <span class="span-select">
                                                    <select class="form-control" id="add_project_hours" name="add_project_hours" tabindex="13">
                                                        <option value="1" <?php echo ($freelancerpostdata[0]['post_hours'] == '1' ? 'selected="selected"' : ''); ?>>0 to 25 hrs/week</option>
                                                        <option value="2" <?php echo ($freelancerpostdata[0]['post_hours'] == '2' ? 'selected="selected"' : ''); ?>>B/w 25 to 50 hrs/week</option>
                                                        <option value="3" <?php echo ($freelancerpostdata[0]['post_hours'] == '3' ? 'selected="selected"' : ''); ?>>More than 50 hrs/week</option>
                                                        <option value="4" <?php echo ($freelancerpostdata[0]['post_hours'] == '4' ? 'selected="selected"' : ''); ?>>Not fixed</option>
                                                    </select>
                                                </span>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-6 col-sm-6">                                        
                                            <div class="form-group">
                                                <label>Freelancer Type</label>
                                                <span class="span-select">
                                                    <select class="form-control" id="add_project_freelancer_type" name="add_project_freelancer_type" tabindex="14">
                                                        <option value="1" <?php echo ($freelancerpostdata[0]['post_freelancer_type'] == '1' ? 'selected="selected"' : ''); ?>>Anyone</option>
                                                        <option value="2" <?php echo ($freelancerpostdata[0]['post_freelancer_type'] == '2' ? 'selected="selected"' : ''); ?>>Individual</option>
                                                        <option value="3" <?php echo ($freelancerpostdata[0]['post_freelancer_type'] == '3' ? 'selected="selected"' : ''); ?>>Company</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>How many freelancers will you need for this project?</label>
                                                <input type="text" placeholder="How many freelancers will you need for this project" id="add_project_freelancer" name="add_project_freelancer" maxlength="255" tabindex="15" value="<?php echo ($freelancerpostdata[0]['post_freelancer']); ?>">
                                            </div>                                        
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Reference Website URL</label>
                                                <input type="text" placeholder="Reference Website URL" id="add_project_website" name="add_project_website" maxlength="255" tabindex="16" value="<?php echo ($freelancerpostdata[0]['post_website']); ?>">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>English Level</label>
                                                <span class="span-select">
                                                    <select class="form-control" id="add_project_eng_level" name="add_project_eng_level" tabindex="17">
                                                        <option value="1" <?php echo ($freelancerpostdata[0]['post_eng_level'] == '1' ? 'selected="selected"' : ''); ?>>Basic</option>
                                                        <option value="2" <?php echo ($freelancerpostdata[0]['post_eng_level'] == '2' ? 'selected="selected"' : ''); ?>>Intermediate</option>
                                                        <option value="3" <?php echo ($freelancerpostdata[0]['post_eng_level'] == '3' ? 'selected="selected"' : ''); ?>>Expert</option>
                                                    </select>
                                                </span>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <span class="span-select">
                                                    <select class="form-control" id="add_project_location" name="add_project_location" tabindex="18">
                                                        <option value="1" <?php echo ($freelancerpostdata[0]['post_location_type'] == '1' ? 'selected="selected"' : ''); ?>>Can work from anywhere</option>
                                                        <option value="2" <?php echo ($freelancerpostdata[0]['post_location_type'] == '2' ? 'selected="selected"' : ''); ?>>Should be from specific country</option>
                                                        <option value="3" <?php echo ($freelancerpostdata[0]['post_location_type'] == '3' ? 'selected="selected"' : ''); ?>>On-site (specific location)</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Ask any Question to Freelancer?</label>
                                        <input type="text" placeholder="Ask any Question to Freelancer?" id="add_project_askque" name="add_project_askque" maxlength="255" tabindex="19" value="<?php echo ($freelancerpostdata[0]['post_askque']); ?>">
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="job_reg_main fw post-job-cus">
                                <h3 class="freelancer_editpost_title"><?php echo $this->lang->line("payment"); ?></h3>
                                <div class="fw p20">                                    
                                    <label class="">Work Type:<span style="color:red">*</span></label>
                                    <div class="cus_work fw form-group">
                                        <label class="control control--radio">
                                            Hourly
                                            <input type="radio" name="rating" tabindex="11" <?php if ($freelancerpostdata[0]['post_rating_type'] == '0') { ?> checked <?php } ?> value="0" > 
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">
                                            Fixed
                                            <input type="radio" name="rating" tabindex="12"  <?php if ($freelancerpostdata[0]['post_rating_type'] == '1') { ?> checked <?php } ?> value ="1"> 
                                            <div class="control__indicator"></div>
                                        </label>
                                        <label id="rating_div" class="control control--radio">
                                            Not Fixed
                                            <input type="radio" tabindex="13" class="worktype"  name="rating" value="2" <?php if ($freelancerpostdata[0]['post_rating_type'] == '2') { ?> checked <?php } ?>> 
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                    <?php echo form_error('rating'); ?>                                    
                                </div>
                                <div class="row p20">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("currency"); ?></label>
                                            <span class="span-select">
                                                <select name="currency" id="currency" tabindex="15">
                                                    <option value="" selected option><?php echo $this->lang->line("select_currency"); ?></option>
                                                    <?php
                                                    if (count($currency) > 0) {
                                                        foreach ($currency as $cur) {
                                                            if ($freelancerpostdata[0]['post_currency']) {
                                                                ?>
                                                                <option value="<?php echo $cur['currency_id']; ?>" <?php if ($cur['currency_id'] == $freelancerpostdata[0]['post_currency']) echo 'selected'; ?>><?php echo $cur['currency_name']; ?></option>
                                                            <?php }else {
                                                                ?>
                                                                <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </span>
                                            <?php echo form_error('currency'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo $this->lang->line("rate"); ?></label>
                                            <input name="rate" type="number" id="rate" tabindex="14" placeholder="Enter your rate" value="<?php echo $freelancerpostdata[0]['post_rate']; ?>" />
                                            <?php echo form_error('rate'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="fw text-center pt5 pb15">                                
                                    <button type="submit" tabindex="25" id="submit" class="btn3" name="submit">Save</button>
                                    <div id="post_loader" class="dtl-popup-loader" style="display: none;">
                                        <img src="<?php echo base_url("assets/images/loader.gif"); ?>" alt="Loader">
                                    </div>
                                </div>
                            </div>
                            </form>
                            <?php //echo form_close(); ?>
                           
    						<div class="banner-add">
    							<?php $this->load->view('banner_add'); ?>
    						</div>
                        </div>
                    </div>
					<div class="right-add">
						<?php $this->load->view('right_add_box'); ?>
					</div>               
            </div>
        </div>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
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
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror custom-message" id="bidmodal2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <!--                    <div class="message" style="width:300px;">-->
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a title="Ok" id="field" class="btn">OK</a></div>
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->

        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script  src="<?php echo base_url('assets/js/jquery.date-dropdowns.js?ver=' . time()); ?>">
        </script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var date_picker1 = '<?php echo date('Y-m-d', strtotime($freelancerpostdata[0]['post_last_date'])); ?>';
            var post_id = "<?php echo $freelancerpostdata[0]['post_id']; ?>"
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_edit_post.js?ver=' . time()); ?>"></script>

        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        

        <style type="text/css">
            #example2-error{margin-top: 42px!important;}
        </style>
        <script>

            var SearchTextarea = $('#post_desc');
            var strLength = SearchTextarea.val().length;
            SearchTextarea[0].setSelectionRange(strLength, strLength);
        </script>
        <script>
             var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    </body>
</html>