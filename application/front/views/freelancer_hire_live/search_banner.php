<div class="search-banner cus-search-bnr" >
    <div class="container">
        <div class="row banner-main-div">
            <div class="col-md-6 col-sm-6 banner-left">
                <h1 class="pb15">Smart People Are Secret Behind Successful Business</h1>
                <p class="pb20">Find and get the work done by skilled freelancer from across the world through collaborative platform</p>
                <!--img class="pt20" src="n-images/free-hire-bnr.png"-->
            </div>
            <div class="col-md-6 col-sm-6 banner-right">
                <div class="reg-form-box">
                    <div class="reg-form">
                        <h3>Register in Freelance Employer Profile <span class="db">It's free and hardly takes a minute</span></h3>
                        <?php echo form_open(base_url('freelancer_hire/hire_registation_insert'), array('id' => 'freelancerhire_regform', 'name' => 'freelancerhire_regform', 'class' => 'clearfix')); ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="firstname" id="firstname" tabindex="1" placeholder="First Name*" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" value="<?php echo $userdata['first_name']; ?>" maxlength="35">
                                        <?php echo form_error('firstname'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="lastname" id="lastname" tabindex="2" placeholder="Last Name*" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name']; ?>" maxlength="35">
                                        <?php echo form_error('lastname'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 email-cus">
                                        <input type="email" name="email_reg1" id="email_reg1" tabindex="3" placeholder="Company Email*" value="<?php echo $userdata['email']; ?>" maxlength="255">
                                        <?php echo form_error('email_reg1'); ?>
                                        <span class="email-tooltip">
                                            <a href="#">
                                                <img src="<?php echo base_url('assets/n-images/tooltip.png') ?>">
                                            </a>
                                        </span>
                                    </div>                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Company Number(optional)">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="select-field-custom">
                                            <select name="country" id="country" tabindex="5">
                                                <option value="">Select country</option>
                                                <?php
                                                if (count($countries) > 0) {
                                                    foreach ($countries as $cnt) {
                                                        ?>
                                                        <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="country-error"></span>
                                            <?php echo form_error('country'); ?>
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="select-field-custom">
                                            <select name="state" id="state" tabindex="6">
                                                <?php
                                                if ($state1) {
                                                    foreach ($states as $cnt) {
                                                        ?>
                                                        <option value="<?php echo $cnt['state_id']; ?>" <?php if ($cnt['state_id'] == $state1) echo 'selected'; ?>><?php echo $cnt['state_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                else {
                                                    ?>
                                                    <option value="">Select country first</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <span id="state-error"></span>
                                            <?php echo form_error('state'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="select-field-custom">
                                            <select name="city" id="city" tabindex="7">
                                                <?php
                                                if ($city1) {
                                                    foreach ($cities as $cnt) {
                                                        ?>
                                                        <option value="<?php echo $cnt['city_id']; ?>" <?php if ($cnt['city_id'] == $city1) echo 'selected'; ?>><?php echo $cnt['city_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                else if ($state1) {
                                                    ?>
                                                    <option value="">Select city</option>
                                                    <?php
                                                    foreach ($cities as $cnt) {
                                                        ?>
                                                        <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value="">Select state first</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <span id="city-error"></span>
                                            <?php echo form_error('city'); ?>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea placeholder="Professional Information(optional)"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <a href="" class="btn1">Register</a> -->
                                        <button class="btn1" id="submit" name="submit" tabindex="9" onclick="return validate();" class="cus_btn_sub">Register
                                            <span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;">
                                                <i aria-hidden="true" class="fa fa-spin fa-refresh"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>