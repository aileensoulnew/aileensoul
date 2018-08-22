<?php $pages = $_GET['page']; ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?> 
        <?php if (IS_HIRE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
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
        <?php echo $header; ?>
        <?php echo $freelancer_hire_header2; ?>
        <section>
            <div>
                <div class="user-midd-section" id="paddingtop_fixed">
                    <div class="container mobp0">
							<div class="tab-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                            <h3 class="col-chang cus-chang text-center p15">Please Post your requirement of the work that you need, we will recommend the freelancers accordingly.</h3>
                            
                            <div class="custom-user-list">
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
                                <div class="common-form custom-form free-hire-cus">

                                    <div class="job-saved-box">

                                        <?php echo form_open(base_url('freelancer_hire/freelancer_add_post_insert'), array('id' => 'postinfo', 'name' => 'postinfo', 'class' => 'clearfix form_addedit', 'onsubmit' => "imgval()")); ?>

                                        <?php
                                        $post_name = form_error('post_name');
                                        $skills = form_error('skills');
                                        $post_desc = form_error('post_desc');
                                        $fields = form_error('fields_req');
                                        $lastdate = form_error('latdate');
//                                           $rate = form_error('rate');
//                                            $currency = form_error('currency');
                                        $rating = form_error('rating');
                                        ?>
                                        <div class="custom-add-box">
                                            <h3 class="freelancer_editpost_title"><?php echo $this->lang->line("project_description"); ?></h3>
                                            <div class="p15 fw">
                                                <fieldset  <?php if ($post_name) { ?> class="error-msg full-width" <?php } else { ?> class="full-width" <?php } ?>>
                                                    <label ><?php echo $this->lang->line("project_title"); ?>:<span style="color:red">*</span></label>                 
                                                    <input name="post_name" type="text" maxlength="100" id="post_name" autofocus tabindex="1" placeholder="Enter project name"/>
<!--                                                    <span id="fullname-error"></span>-->
                                                    <?php echo form_error('post_name'); ?>
                                                </fieldset>
                                                <fieldset  <?php if ($post_desc) { ?> class="error-msg full-width" <?php } else { ?> class="full-width" <?php } ?>>
                                                    <label><?php echo $this->lang->line("project_description"); ?> :<span style="color:red">*</span></label>
                                                    <textarea class="add-post-textarea" name="post_desc" id="post_desc" placeholder="Enter description" tabindex="2"></textarea>
                                                    <?php echo form_error('post_desc'); ?>
                                                </fieldset>
                                                <fieldset  <?php if ($skills) { ?> class="error-msg full-width" <?php } else { ?> class="full-width" <?php } ?>>
                                                    <label><?php echo $this->lang->line("skill_of_requirement"); ?>:<span style="color:red">*</span></label>
                                                    <input id="skills2" name="skills" tabindex="3" size="90" placeholder="Enter skills">
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('skills'); ?>
                                                </fieldset>
                                                <fieldset  <?php if ($fields) { ?> class="error-msg full-width" <?php } else { ?> class="full-width" <?php } ?>>
                                                    <label><?php echo $this->lang->line("field_of_requirement"); ?>:<span style="color:red">*</span></label>
                                                    <select tabindex="4" name="fields_req" id="fields_req" class="field_other">
                                                        <option  value="" selected option disabled><?php echo $this->lang->line("select_filed"); ?></option>
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
                                                        <option value="<?php echo $category_otherdata[0]['category_id']; ?> "><?php echo $category_otherdata[0]['category_name']; ?></option>
                                                    </select>
                                                    <?php echo form_error('fields_req'); ?>
                                                </fieldset>

                                                <fieldset class="full-width two-select-box fullwidth_experience" <?php if ($month) { ?> class="error-msg" <?php } ?> class="two-select-box"> 
                                                    <label><?php echo $this->lang->line("required_experiance"); ?>:<span class="optional">(optional)</span></label>
                                                    <select tabindex="5" name="year" id="year">
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
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('year'); ?>

                                                    <select class="margin-month " tabindex="6" name="month" id="month">
                                                        <option value="" selected option disabled><?php echo $this->lang->line("month"); ?></option>
                                                        <option value="0">0 Month</option>
                                                        <option value="1">1 Month</option>
                                                        <option value="2">2 Month</option>
                                                        <option value="3">3 Month</option>
                                                        <option value="4">4 Month</option>
                                                        <option value="5">5 Month</option>
                                                        <option value="6">6 Month</option>
                                                    </select>
                                                    <?php echo form_error('month'); ?>
                                                </fieldset>
                                                <fieldset class="col-md-6 pl10" <?php if ($est_time) { ?> class="error-msg" <?php } ?>>
                                                    <label><?php echo $this->lang->line("time_of_project"); ?>:<span class="optional">(optional)</span></label>
                                                    <input tabindex="7" name="est_time" type="text" id="est_time" placeholder="Enter estimated time in month/year" /><span id="fullname-error"></span>
                                                    <?php echo form_error('est_time'); ?>
                                                </fieldset>           
                                                <fieldset <?php if ($lastdate) { ?> class="error-msg" <?php } ?>>
                                                    <label><?php echo $this->lang->line("last_date_apply"); ?>:<span style="color:red">*</span></label>
                                                    <input type="hidden" id="example2" name="latdate">
                                                    <?php echo form_error('latdate'); ?> 
                                                </fieldset>


                                            </div>
                                        </div>
                                        <div class="custom-add-box">
                                            <h3 class="freelancer_editpost_title"><?php echo $this->lang->line("payment"); ?></h3>
                                            <div class="p15 fw">
                                                <fieldset  <?php if ($rating) { ?> class="error-msg col-md-3 pl10 work_type_custom" <?php } else { ?> class="col-md-12 fw pl10 work_type_custom" <?php } ?>>
                                                    <label class=""><?php echo $this->lang->line("work_type"); ?>:<span style="color:red">*</span></label>
                                                    <div class="cus_work" id="rating_div">
														<label class="control control--radio">
															Hourly
															<input type="radio" tabindex="11" class="worktype_minheight worktype" name="rating" value="0"> 
															<div class="control__indicator"></div>
														</label>
														<label class="control control--radio">
															Fixed
															<input type="radio" tabindex="12" class="worktype"  name="rating" value="1">
															<div class="control__indicator"></div>
														</label>
														<label class="control control--radio">
															Not Fixed
															<input type="radio" tabindex="13" class="worktype"  name="rating" value="2">
															<div class="control__indicator"></div>
														</label>
                                                    </div>
                                                    <?php echo form_error('rating'); ?>
                                                </fieldset>
                                                <fieldset  class="half-width pl10" >
                                                    <label  class="control-label"><?php echo $this->lang->line("rate"); ?>:<span class="optional">(optional)</span></label>
                                                    <input tabindex="14" name="rate" type="text" id="rate" placeholder="Enter your rate"/>
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('rate'); ?>
                                                </fieldset>
                                                <fieldset class="half-width two-select-box"> 
                                                    <label><?php echo $this->lang->line("currency"); ?>:<span class="optional">(optional)</span></label>
                                                    <select tabindex="15" name="currency" id="currency">
                                                        <option  value="" selected option disabled><?php echo $this->lang->line("select_currency"); ?></option>
                                                        <?php foreach ($currency as $cur) { ?>
                                                            <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('currency'); ?>
                                                </fieldset>

                                                <fieldset class="hs-submit full-width">
                                                    <input type="hidden" value="<?php echo $pages; ?>" name="page" id="page">
                                                    <?php if (($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'add-projects') || ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'edit-projects')) { ?>
                                                        <a title="cancel" class="add_post_btnc" tabindex="16"  onclick="return leave_page(9)"><?php echo $this->lang->line("cancel"); ?></a>
                                                    <?php } else { ?>
                                                        <a title="cancel" tabindex="16" class="add_post_btnc" <?php if ($pages == 'professional') { ?> href="<?php echo base_url('hire-freelancer'); ?>" <?php } else { ?> href="javascript:history.back()"  <?php } ?>>Cancel</a>
                                                    <?php } ?>
                                                    <input type="submit" tabindex="17" id="submit"  class="add_post_btns" name="submit" value="Post">    
                                                </fieldset>


                                            </div>
                                        </div>

                                        <?php echo form_close(); ?>
										<div class="banner-add">
											<?php $this->load->view('banner_add'); ?>
										</div>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="right-add">
								<?php $this->load->view('right_add_box'); ?>
							</div>
                      
                    </div>
                </div>
            </div>
        </section>

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
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a title="OK" id="field" class="btn">OK</a></div>
                </div>
            </div>
        </div>

        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
            <!-- Model Popup Close -->
            <!-- Calender JS Start-->
            <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
            <!-- Calender Js End-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <?php } else { ?>
            <!-- Model Popup Close -->
            <!-- Calender JS Start-->
            <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
            <!-- Calender Js End-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <?php } ?>

        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>

        <script>
                        var base_url = '<?php echo base_url(); ?>';
                        var header_all_profile = '<?php echo $header_all_profile; ?>';

                        // LEAVE PAGE ON ADD AND EDIT POST PAGE START
                        function leave_page(clicked_id)
                        {

                            var post_name = document.getElementById('post_name').value;
                            var post_desc = document.getElementById('post_desc').value;
                            var fields_req = document.getElementById('fields_req').value;
                            var skills = document.getElementById('skills2').value;
                            var year = document.getElementById('year').value;
                            var month = document.getElementById('month').value;
                            var rate = document.getElementById('rate').value;
                            var currency = document.getElementById('currency').value;
                            var est_time = document.getElementById('est_time').value;
                            var datepicker = document.getElementById('example2').value;
//                var country = document.getElementById('country').value;
//                var city = document.getElementById('city').value;
                            var searchkeyword = $.trim(document.getElementById('tags').value);
                            var searchplace = $.trim(document.getElementById('searchplace').value);
                            var page = document.getElementById('page').value;
                            if (post_name == "" && post_desc == "" && fields_req == "" && skills == "" && year == "" && month == "" && rate == "" && currency == "" && est_time == "" && datepicker == "")
                            {
                                if (clicked_id == 1)
                                {
                                    location.href = '<?php echo base_url('hire-freelancer'); ?>';
                                }
                                if (clicked_id == 2)
                                {
                                    location.href = '<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>';
                                }
                                if (clicked_id == 3)
                                {
                                    location.href = '<?php echo base_url('freelance-employer/basic-information'); ?>';
                                }
                                if (clicked_id == 4)
                                {
                                    if (searchkeyword == "" && searchplace == "")
                                    {
                                        return checkvalue_search;
                                    } else
                                    {

                                        if (searchkeyword == "")
                                        {
                                            location.href = '<?php echo base_url() ?>freelance-employer/search/' + 0 + '/' + searchplace;

                                        } else if (searchplace == "")
                                        {
                                            location.href = '<?php echo base_url() ?>freelance-employer/search/' + searchkeyword + '/' + 0;
                                        } else
                                        {
                                            location.href = '<?php echo base_url() ?>freelance-employer/search/' + searchkeyword + '/' + searchplace;
                                        }
                                    }
                                }
                                if (clicked_id == 5)
                                {
                                    document.getElementById('acon').style.display = 'block !important';
                                }
                                if (clicked_id == 6)
                                {
                                    location.href = '<?php echo base_url() . 'profile' ?>';
                                }
                                if (clicked_id == 7)
                                {
                                    location.href = '<?php echo base_url('change-password') ?>';
                                }
                                if (clicked_id == 8)
                                {
                                    location.href = '<?php echo base_url('logout') ?>';
                                }
                                if (clicked_id == 9)
                                {
                                    if (page == 'professional') {
                                        location.href = '<?php echo base_url('hire-freelancer'); ?>';
                                    } else {
                                        location.href = 'javascript:history.back()';
                                    }

                                }

                            } else
                            {

                                return home(clicked_id, searchkeyword, searchplace);


                            }
                        }


                        function home(clicked_id, searchkeyword, searchplace) {

                            if (clicked_id == 5)
                            {
                                $('.header ul li #abody ul li a').click(function () {

                                    var all_clicked_href = $(this).attr('href');
                                    $('.biderror .mes').html("<div class='pop_content'> Do you want to leave this page?<div class='model_ok_cancel'><a title='yes' class='okbtn' id=" + clicked_id + " onClick='home_profile(" + clicked_id + ',' + '"' + searchkeyword + '"' + ',' + '"' + searchplace + '"' + ',' + '"' + all_clicked_href + '"' + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a title='No' class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                    $('#bidmodal').modal('show');
                                    return false;

                                });
                            } else
                            {
                                $('.biderror .mes').html("<div class='pop_content'> Do you want to leave this page?<div class='model_ok_cancel'><a title='yes' class='okbtn' id=" + clicked_id + " onClick='home_profile(" + clicked_id + ',' + '"' + searchkeyword + '"' + ',' + '"' + searchplace + '"' + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a title='No' class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                $('#bidmodal').modal('show');
                                return false;
                            }


                        }

                        function home_profile(clicked_id, searchkeyword, searchplace, all_clicked_href) {
                            var url, data;
                            if (clicked_id == 4) {

                                url = '<?php echo base_url() . "freelance-employer/search" ?>';
                                data = 'id=' + clicked_id + '&skills=' + searchkeyword + '&searchplace=' + searchplace;
                            }
                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: data,
                                success: function (data) {
                                    if (clicked_id == 1)
                                    {
                                        window.location = "<?php echo base_url('hire-freelancer'); ?>";
                                    } else if (clicked_id == 2)
                                    {
                                        window.location = "<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>";
                                    } else if (clicked_id == 3)
                                    {
                                        window.location = "<?php echo base_url('freelance-employer/basic-information'); ?>";
                                    } else if (clicked_id == 4)
                                    {

                                        if (searchkeyword == "")
                                        {
                                            window.location = "<?php echo base_url() ?>freelance-employer/search/" + 0 + "/" + searchplace;

                                        } else if (searchplace == "")
                                        {

                                            window.location = "<?php echo base_url() ?>freelance-employer/search/" + searchkeyword + "/" + 0;
                                        } else
                                        {
                                            window.location = "<?php echo base_url() ?>freelance-employer/search/" + searchkeyword + "/" + searchplace;
                                        }
                                    } else if (clicked_id == 5)
                                    {
                                        window.location = all_clicked_href;
                                    } else if (clicked_id == 6)
                                    {
                                        window.location = "<?php echo base_url() . 'profile' ?>";
                                    } else if (clicked_id == 7)
                                    {
                                        window.location = "<?php echo base_url('change-password') ?>";
                                    } else if (clicked_id == 8)
                                    {
                                        window.location = "<?php echo base_url('logout') ?>";
                                    } else if (clicked_id == 9)
                                    {
                                        location.href = 'javascript:history.back()';
                                    } else
                                    {
                                        alert("edit profilw");
                                    }

                                }
                            });
                        }
                        // LEAVE PAGE ON ADD AND EDIT POST PAGE END 

                        var _onPaste_StripFormatting_IEPaste = false;

    function OnPaste_StripFormatting(elem, e) {

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
        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
            <!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_add_post.js?ver=' . time()); ?>"></script>-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
                <!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_add_post.js?ver=' . time()); ?>"></script>-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php } ?>


        <style type="text/css">
            #skills-error{margin-top: 42px;}
            #example2-error{margin-top: 41px;}
        </style>

    </body>
</html>