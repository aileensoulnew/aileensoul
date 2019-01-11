<?php $pages = $_GET['page']; ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <noscript><meta http-equiv="refresh" content="0; URL=<?php echo base_url('noscript'); ?>"/></noscript>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .last_date_error{
                background: none;
                color: red !important;
                padding: 0px 10px !important;
                position: absolute;
                right: 8px;
                z-index: 8;
                line-height: 15px;
                padding-right: 0px!important;
                font-size: 11px!important;
            }
            .autoposition{
                position: absolute!important;
                z-index: 999 !important;

            }
        </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="pushmenu-push botton_footer freeh3">
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

                        <form action="<?php //echo base_url('freelancer_hire/freelancer_add_post_insert'); ?>" id="postinfo" name="postinfo" class="clearfix" onsubmit="imgval()" method="post" enctype="multipart/form-data">

                        <?php
                        $post_name = form_error('post_name');
                        $skills = form_error('skills');
                        $post_desc = form_error('post_desc');
                        $fields = form_error('fields_req');
                        $lastdate = form_error('latdate');                            
                        $rating = form_error('rating');
                        ?>
                        <div class="job_reg_main fw post-job-cus">
                            <h3>Post Project</h3>
                            <div class="fw p20">

                                <div class="form-group">
                                    <label ><?php echo $this->lang->line("project_title"); ?>:<span style="color:red">*</span></label>                 
                                    <input name="post_name" type="text" maxlength="100" id="post_name" autofocus tabindex="1" placeholder="Enter project name"/>
                                    <!--<span id="fullname-error"></span>-->
                                    <?php echo form_error('post_name'); ?>
                                </div>
                                <div class="form-group big-textarea">
                                    <label><?php echo $this->lang->line("project_description"); ?> :<span style="color:red">*</span></label>
                                    <textarea class="add-post-textarea" name="post_desc" id="post_desc" placeholder="Enter description" tabindex="2" maxlength="1500"></textarea>
                                    <?php echo form_error('post_desc'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Category:<span style="color:red">*</span></label>
                                    <select tabindex="3" name="fields_req" id="fields_req" class="field_other" onchange="category_other_field(this.value);">
                                        <option  value="" selected option><?php echo $this->lang->line("select_filed"); ?></option>
                                        <?php
                                        if (count($category_data) > 0) {
                                            foreach ($category_data as $cnt) {
                                                if ($fields_req1) {
                                                    ?>
                                                    <option value="<?php echo $cnt['category_id']; ?>" <?php if ($cnt['category_id'] == $fields_req1) echo 'selected'; ?>><?php echo $cnt['category_name']; ?></option>
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
                                        <!-- <option value="0">Other</option> -->
                                    </select>
                                    <?php echo form_error('fields_req'); ?>
                                </div>
                                <div id="other_field_div" class="form-group" style="display: none;">
                                    <label>Other Category</label>
                                    <input id="other_field" name="other_field" tabindex="4" size="90" placeholder="Enter skills" maxlength="255">
                                </div>
                                <div class="form-group autocomplete-cus">
                                    <label><?php echo $this->lang->line("skill_of_requirement"); ?>:<span style="color:red">*</span></label>
                                    <input id="skills2" name="skills" tabindex="4" size="90" placeholder="Enter skills" maxlength="255">
                                    <span id="fullname-error"></span>
                                    <?php echo form_error('skills'); ?>
                                    <div id="skills_result"></div>
                                </div>  
                                <div class="row">
                                    <label class="col-md-12 fw">Required Experience:<span class="optional">(optional)</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select class="form-control" tabindex="5" name="year" id="year">
                                                    <option value="" selected option disabled><?php echo $this->lang->line("year"); ?></option>
                                                    <option value="0">0 Year</option>
                                                    <option value="1">1 Year</option>
                                                    <option value="2">2 Year</option>
                                                    <option value="3">3 Year</option>
                                                    <option value="4">4 Year</option>
                                                    <option value="5">5 Year</option>
                                                    <option value="6">6 Year</option>
                                                    <option value="7">7 Year</option>
                                                    <option value="8">8 Year</option>
                                                    <option value="9">9 Year</option>
                                                    <option value="10">10 Year</option>
                                                    <option value="11">11 Year</option>
                                                    <option value="12">12 Year</option>
                                                    <option value="13">13 Year</option>
                                                    <option value="14">14 Year</option>
                                                    <option value="15">15 Year</option>
                                                    <option value="16">16 Year</option>
                                                    <option value="17">17 Year</option>
                                                    <option value="18">18 Year</option>
                                                    <option value="19">19 Year</option>
                                                    <option value="20">20 Year</option>
                                                </select>
                                            </span>
                                            <?php echo form_error('year'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select class="form-control" tabindex="6" name="month" id="month">
                                                    <option value="" selected option disabled><?php echo $this->lang->line("month"); ?></option>
                                                    <option value="0">0 Month</option>
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Month</option>
                                                    <option value="3">3 Month</option>
                                                    <option value="4">4 Month</option>
                                                    <option value="5">5 Month</option>
                                                    <option value="6">6 Month</option>
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
                                                    <option value="1">One-time</option>
                                                    <option value="2">On-going</option>
                                                    <option value="3">I'm not sure</option>
                                                </select>
                                            </span>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>How long do you expect this project to last?</label>
                                            <span class="span-select">
                                                <select class="form-control" id="add_project_duration" name="add_project_duration" tabindex="12">
                                                    <option value="1">1 Week</option>
                                                    <option value="2">2 Weeks</option>
                                                    <option value="3">1 Month</option>
                                                    <option value="4">1-3 Months</option>
                                                    <option value="5">3-6 Months</option>
                                                    <option value="6">Over 6 Months</option>
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
                                                    <option value="1">0 to 25 hrs/week</option>
                                                    <option value="2">B/w 25 to 50 hrs/week</option>
                                                    <option value="3">More than 50 hrs/week</option>
                                                    <option value="4">Not fixed</option>
                                                </select>
                                            </span>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6">                                        
                                        <div class="form-group">
                                            <label>Freelancer Type</label>
                                            <span class="span-select">
                                                <select class="form-control" id="add_project_freelancer_type" name="add_project_freelancer_type" tabindex="14">
                                                    <option value="1">Anyone</option>
                                                    <option value="2">Individual</option>
                                                    <option value="3">Company</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>How many freelancers will you need for this project?</label>
                                            <input type="text" placeholder="How many freelancers will you need for this project" id="add_project_freelancer" name="add_project_freelancer" maxlength="255" tabindex="15">
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Reference Website URL</label>
                                            <input type="text" placeholder="Reference Website URL" id="add_project_website" name="add_project_website" maxlength="255" tabindex="16">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>English Level</label>
                                            <span class="span-select">
                                                <select class="form-control" id="add_project_eng_level" name="add_project_eng_level" tabindex="17">
                                                    <option value="1">Basic</option>
                                                    <option value="2">Intermediate</option>
                                                    <option value="3">Expert</option>
                                                </select>
                                            </span>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <span class="span-select">
                                                <select class="form-control" id="add_project_location" name="add_project_location" tabindex="18">
                                                    <option value="1">Can work from anywhere</option>
                                                    <option value="2">Should be from specific country</option>
                                                    <option value="3">On-site (specific location)</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <label>Ask any Question to Freelancer?</label>
                                    <input type="text" placeholder="Ask any Question to Freelancer?" id="add_project_askque" name="add_project_askque" maxlength="255" tabindex="19">
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
										<input type="radio" tabindex="20" class="worktype_minheight worktype" name="rating" value="0"> 
										<div class="control__indicator"></div>
									</label>
									<label class="control control--radio">
										Fixed
										<input type="radio" tabindex="21" class="worktype"  name="rating" value="1">
										<div class="control__indicator"></div>
									</label>
									<label id="rating_div" class="control control--radio">
										Not Fixed
										<input type="radio" tabindex="22" class="worktype"  name="rating" value="2">
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
                                            <select tabindex="23" name="currency" id="currency">
                                                <option  value="" selected option><?php echo $this->lang->line("select_currency"); ?></option>
                                                <?php foreach ($currency as $cur) { ?>
                                                    <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </span>
                                        <?php echo form_error('currency'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label  class="control-label"><?php echo $this->lang->line("rate"); ?></label>
                                        <input tabindex="24" name="rate" type="text" id="rate" placeholder="Enter your rate"/>
                                        <?php echo form_error('rate'); ?>
                                    </div>
                                </div>                                    
                            </div>
                            
                            <div class="fw text-center pt5 pb15">                                
                                <button type="submit" tabindex="25" id="submit" class="btn3" name="submit">Post</button>
                                <div id="post_loader" class="dtl-popup-loader" style="display: none;">
                                    <img src="<?php echo base_url("assets/images/loader.gif"); ?>" alt="Loader">
                                </div>
                            </div>
                        </div>

                        </form>
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
        
        <!-- Calender JS Start-->
        <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
        <!-- Calender Js End-->
        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>

        <script>
        var base_url = '<?php echo base_url(); ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';

        var _onPaste_StripFormatting_IEPaste = false;

        function OnPaste_StripFormatting(elem, e)
        {
            if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
                e.preventDefault();
                var text = e.originalEvent.clipboardData.getData('text/plain');
                window.document.execCommand('insertText', false, text);
            } else if (e.clipboardData && e.clipboardData.getData) {
                e.preventDefault();
                var text = e.clipboardData.getData('text/plain');
                window.document.execCommand('insertText', false, text);
            } else if (window.clipboardData && window.clipboardData.getData) {
                // Stop stack overflow
                if (!_onPaste_StripFormatting_IEPaste) {
                    _onPaste_StripFormatting_IEPaste = true;
                    e.preventDefault();
                    window.document.execCommand('ms-pasteTextOnly', false);
                }
                _onPaste_StripFormatting_IEPaste = false;
            }
        }
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_add_post.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>

        <style type="text/css">
            #skills-error{margin-top: 42px;}
            #example2-error{margin-top: 41px;}
        </style>

    </body>
</html>