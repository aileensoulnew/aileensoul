<form name="job-company-filter" id="job-company-filter" class="frm-job-company-filter" method="POST">
    <div class="left-search-box list-type-bullet">
        <div class="">
            <h3>Top Categories</h3>
        </div>
        <ul class="search-listing">
            <?php 
            if(isset($artistCategory) && !empty($artistCategory)):
                foreach($artistCategory as $_artistCategory): ?>
            <li>
                <label class="control control--checkbox">
                    <span><?php echo ucwords($_artistCategory['art_category']); ?>
                        <span class="pull-right hide">(<?php echo $_artistCategory['count']; ?>)</span>
                    </span>
                    <input class="categorycheckbox" type="checkbox" name="art_category[]" value="<?php echo $_artistCategory['category_id']; ?>" style="height: 12px;" <?php echo in_array($_artistCategory['category_id'], $art_category) ? "checked='checked'" : ""; ?> style="height: 12px;" onchange="applyJobFilter()">
                    <div class="control__indicator"></div>
                </label>
            </li>
        <?php   endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo artist_category_list ?>">View More Categories</a></p>
    </div>

    <div class="left-search-box list-type-bullet">
        <div class="">
            <h3>Top Locations</h3>
        </div>                        
        <ul class="search-listing" style="list-style: none;">
            <?php 
            if(isset($artistLocation) && !empty($artistLocation)):
                foreach($artistLocation as $_artistLocation): ?>
            <li>
                <label class="control control--checkbox">
                    <span><?php echo ucwords($_artistLocation['art_location']); ?>
                        <span class="pull-right hide">(<?php echo $_artistLocation['total']; ?>)</span>
                    </span>
                    <input class="locationcheckbox" type="checkbox" name="art_location[]" value="<?php echo $_artistLocation['location_id']; ?>" style="height: 12px;" <?php echo in_array($_artistLocation['location_id'], $art_location) ? "checked='checked'" : ""; ?> style="height: 12px;" onchange="applyJobFilter()">
                    <div class="control__indicator"></div>
                </label>
            </li>
            <?php   endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo artist_location_list ?>">View More Locations</a></p>
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