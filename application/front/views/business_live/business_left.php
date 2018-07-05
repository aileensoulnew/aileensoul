<form name="job-company-filter" id="job-company-filter" class="frm-job-company-filter" method="POST">
    <div class="left-search-box list-type-bullet">
        <div class="">
            <h3>Top Categories</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php
            if(isset($businessCategory) && !empty($businessCategory)):
                foreach($businessCategory as $_businessCategory): ?>
                <li>
                    <label class="control control--checkbox">
                        <span><?php echo ucwords($_businessCategory['industry_name']); ?>
                            <span class="pull-right hide">(<?php echo $_businessCategory['count']; ?>)</span>
                        </span>
                            <input class="categorycheckbox" type="checkbox" name="industry_name[]" value="<?php echo $_businessCategory['industry_id']; ?>" <?php echo in_array($_businessCategory['industry_id'], $industry_name) ? "checked='checked'" : ""; ?> style="height: 12px;" onchange="applyJobFilter()">
                        <div class="control__indicator"></div>
                    </label>
                </li>
            <?php
                endforeach;
            endif;?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url('business-by-categories') ?>">View More Categories</a></p>
    </div>
    <!-- TOP Location -->
    <div class="left-search-box list-type-bullet">
        <div class="">
            <h3>Top Location</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php
            if(isset($businessLocation) && !empty($businessLocation)):
                foreach($businessLocation as $_businessLocation): ?>
                <li>
                    <label class="control control--checkbox">
                        <span><?php echo ucwords($_businessLocation['city_name']); ?>
                            <span class="pull-right hide">(<?php echo $_businessLocation['count']; ?>)</span>
                        </span>
                            <input class="locationcheckbox" type="checkbox" name="city_name[]" value="<?php echo $_businessLocation['city_id']; ?>" <?php echo in_array($_businessLocation['city_id'], $city_name) ? "checked='checked'" : ""; ?> style="height: 12px;" onchange="applyJobFilter()">
                        <div class="control__indicator"></div>
                    </label>
                </li>
            <?php
                endforeach;
            endif;?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url('business-by-location') ?>">View More Location</a></p>
    </div>

    <!-- <div class="custom_footer_left fw">
        <div class="">
            <ul>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> About Us 
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Contact Us
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Blogs 
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Privacy Policy 
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Send Us Feedback
                    </a>
                </li>
            </ul>
        </div>
    </div> -->
</form>