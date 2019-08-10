<div class="left-section filter-fix">
    <div class="search-box">
        <div class="search-left-box">
            <h3>Title</h3>
            <div class="form-group">                
                <tags-input id="search_job_title" name="search_job_title" ng-model="search_job_title" display-property="name" placeholder="Search by Title" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" max-tags="5">
                    <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                </tags-input>
                <div id="jobtitletooltip" class="tooltip-custom" style="display: none;">Type the designation which best matches for given opportunity.</div>
                <script type="text/ng-template" id="title-template">
                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                </script>
                <script type="text/ng-template" id="title-autocomplete-template">
                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                </script>
            </div>
        </div>
        <?php $getFieldList = $this->data_model->getFieldList();?>
        <div class="search-left-box">
            <h3>Industry</h3>
            <div class="form-group">
                <span class="span-select select-cus">
                    <select placeholder="Search by Industry" name="search_field" id="search_field" ng-model="search_field" data-minimum-results-for-search="Infinity">
                        <option value="">Select Industry</option>
                        <?php foreach ($getFieldList as $key => $value) { ?>
                            <option value="<?php echo $value['industry_id']; ?>"><?php echo $value['industry_name']; ?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
        </div>
        <div class="search-left-box">
            <h3>Location</h3>
            <div class="form-group">                
                <tags-input id="search_city" ng-model="search_city" name="search_city" display-property="city_name" placeholder="Search by Location" replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()" max-tags="5">
                    <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                </tags-input>
                <div id="locationtooltip" class="tooltip-custom" style="display: none;">Enter a word or two then select the location for the opportunity.</div>
                <script type="text/ng-template" id="location-template">
                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                </script>
                <script type="text/ng-template" id="location-autocomplete-template">
                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                </script>
            </div>            
        </div>        
        <div class="search-left-box">
            <h3>Gender</h3>
            <div class="form-group search-gender">
                <label class="control control--radio">
                    Male
                    <input type="radio" value="M" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                    <div class="control__indicator"></div>
                </label>
                <label class="control control--radio">
                    Female
                    <input type="radio" value="F" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>        
        <div class="search-left-box pt15">
            <div class="form-group">
                <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search</a> 
                <a class="pull-right btn-new-1" ng-click="clearData();"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
            </div>
        </div>
    </div> 
    <div class="pull-left pt15">
        <?php echo $left_footer; ?>
    </div>
</div>
<div class="middle-section">
    <div class="availabel-data-box">
        <div ng-if="people_data.length != '0'">
            <div class="search-profiles" ng-repeat="people in people_data">
                <div class="profile-img post-img">
                    <a href="<?php echo base_url() ?>{{people.user_slug}}" target="_self" data-popover data-uid="{{people.user_id}}" data-utype="1">
                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{people.user_image}}" alt="{{people.fullname}}" ng-if="people.user_image">                                    
                        <img ng-if="!people.user_image && people.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                        <img ng-if="!people.user_image && people.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                    </a>
                </div>
                <div class="profile-data">
                    <p><a href="<?php echo base_url() ?>{{people.user_slug}}" ng-bind="people.fullname | capitalize" target="_self" data-popover data-uid="{{people.user_id}}" data-utype="1"></a></p>
                    <span ng-if="people.degree_name == null && people.title_name != null">{{people.title_name.length < 30 ? people.title_name : ((people.title_name | limitTo:30)+'...') }}</span>
                    <span ng-if="people.degree_name != null && people.title_name == null">{{people.degree_name.length < 30 ? people.degree_name : ((people.degree_name | limitTo:30)+'...') }}</span>
                    <span ng-if="people.degree_name == null && people.title_name == null">Current work</span>
                    
                </div>
                <div id="contact-btn-{{$index + 1}}" ng-if="people.user_id != user_id" class="profile-btns contact-btn-{{people.user_id}}">
                    <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'new'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Add to contact</a>
                                        
                    <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'confirm'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},1" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">In Contacts</a>
                    
                    <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'pending'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Request sent</a>
                    
                    <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'cancel'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Add to contact</a>
                    
                    <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'reject'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Add to contact</a>
                </div>
                <div class="modal fade message-box" id="remove-contact-conform-{{$index + 1}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lm">
                        <div class="modal-content">
                            <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                            <div class="modal-body">
                                <span class="mes">
                                    <div class="pop_content">Do you want to remove this contact?<div class="model_ok_cancel"><a class="okbtn" ng-click="remove_contact(people.contact_detail.contact_id, 'cancel', people.user_id,$index + 1)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
        <div ng-if="people_data.length == 0 && total_record == 0" ng-class="total_record == 0 ? 'no-search-data' : ''">
            <div class="custom-user-box no-data-available">
                <div class='art-img-nn'>
                    <div class='art_no_post_img'>
                        <img src="<?php echo base_url('assets/img/no-post.png'); ?>" alt="No People">
                    </div>
                    <div class='art_no_post_text'>No People Available. </div>
                </div>
            </div>
        </div>
        <div id="people-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
            <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
        </div>
    </div>
</div>
<div class="mob-filter" data-target="#filter" data-toggle="modal">
    <svg width="25.000000pt" height="25.000000pt" viewBox="0 0 300.000000 300.000000">
        <g transform="translate(0.000000,300.000000) scale(0.100000,-0.100000)" fill="#1b8ab9" stroke="none">
            <path d="M489 2781 l-29 -29 0 -221 0 -221 -110 0 c-115 0 -161 -12 -174 -45
        -3 -9 -6 -163 -6 -341 l0 -325 25 -24 c23 -24 30 -25 144 -25 l121 0 2 -646 3
        -646 24 -19 c33 -27 92 -25 119 4 l22 23 0 642 0 642 124 0 c107 0 127 3 147
        19 l24 19 3 331 3 332 -30 29 c-29 30 -30 30 -150 30 l-121 0 0 225 0 226 -25
        24 c-34 35 -78 33 -116 -4z m271 -851 l0 -210 -210 0 -210 0 0 210 0 210 210
        0 210 0 0 -210z"></path>
            <path d="M1445 2785 l-25 -24 0 -641 0 -640 -119 0 c-105 0 -121 -2 -145 -21
        l-26 -20 0 -338 0 -338 23 -21 c21 -20 34 -22 145 -22 l122 0 0 -224 c0 -211
        1 -225 21 -250 16 -21 29 -26 64 -26 35 0 48 5 64 26 20 25 21 39 21 250 l0
        224 123 0 c181 0 167 -33 167 382 l0 337 -26 20 c-24 19 -40 21 -145 21 l-119
        0 0 640 0 641 -25 24 c-33 34 -87 34 -120 0z m275 -1685 l0 -210 -215 0 -215
        0 0 210 0 210 215 0 215 0 0 -210z"></path>
            <path d="M2405 2785 l-25 -24 0 -226 0 -225 -121 0 c-120 0 -121 0 -150 -30
        l-30 -29 3 -332 3 -331 24 -19 c20 -16 40 -19 147 -19 l124 0 0 -643 0 -644
        23 -21 c29 -28 86 -29 118 -3 l24 19 3 646 2 646 121 0 c114 0 121 1 144 25
        l25 24 0 325 c0 178 -3 332 -6 341 -13 33 -59 45 -174 45 l-110 0 0 221 0 221
        -29 29 c-38 37 -82 39 -116 4z m265 -855 l0 -210 -210 0 -210 0 0 210 0 210
        210 0 210 0 0 -210z"></path>
        </g>
    </svg>
</div>
<div id="filter" class="modal mob-modal fade" role="dialog">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>         
            <div class="mid-modal-body">
                <div class="mid-modal-body">
                    <div class="search-box">
                        <div class="search-left-box">
                            <h3>Title</h3>
                            <div class="form-group">                
                                <tags-input id="search_job_title" name="search_job_title" ng-model="search_job_title" display-property="name" placeholder="Search by Title" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" max-tags="5">
                                    <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                </tags-input>
                                <div id="jobtitletooltip" class="tooltip-custom" style="display: none;">Type the designation which best matches for given opportunity.</div>
                                <script type="text/ng-template" id="title-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="title-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                            </div>
                        </div>
                        <?php $getFieldList = $this->data_model->getFieldList();?>
                        <div class="search-left-box">
                            <h3>Industry</h3>
                            <div class="form-group">
                                <span class="span-select">
                                    <select placeholder="Search by Industry" name="search_field" id="search_field" ng-model="search_field">
                                        <option value="">Select Industry</option>
                                        <?php foreach ($getFieldList as $key => $value) { ?>
                                            <option value="<?php echo $value['industry_id']; ?>"><?php echo $value['industry_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="search-left-box">
                            <h3>Location</h3>
                            <div class="form-group">                
                                <tags-input id="search_city" ng-model="search_city" name="search_city" display-property="city_name" placeholder="Search by Location" replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()" max-tags="5">
                                    <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                                </tags-input>
                                <div id="locationtooltip" class="tooltip-custom" style="display: none;">Enter a word or two then select the location for the opportunity.</div>
                                <script type="text/ng-template" id="location-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="location-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                            </div>            
                        </div>        
                        <div class="search-left-box">
                            <h3>Gender</h3>
                            <div class="form-group search-gender">
                                <label class="control control--radio">
                                    Male
                                    <input type="radio" value="M" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                                    <div class="control__indicator"></div>
                                </label>
                                <label class="control control--radio">
                                    Female
                                    <input type="radio" value="F" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                                    <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>        
                        <div class="search-left-box pt15">
                            <div class="form-group">
                                <a data-dismiss="modal" class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search</a> 
                                <a data-dismiss="modal" class="pull-right btn-new-1" ng-click="clearData();"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        var $window = $(window);
        var lastScrollTop = $window.scrollTop();
        var wasScrollingDown = true;

        var $sidebar = $("#left-fixed");
        if ($sidebar.length > 0) {

            var initialSidebarTop = $sidebar.position().top;

            $window.scroll(function(event) {

                var windowHeight = $window.height();
                var sidebarHeight = $sidebar.outerHeight();

                var scrollTop = $window.scrollTop();
                var scrollBottom = scrollTop + windowHeight;

                var sidebarTop = $sidebar.position().top;
                var sidebarBottom = sidebarTop + sidebarHeight;

                var heightDelta = Math.abs(windowHeight - sidebarHeight);
                var scrollDelta = lastScrollTop - scrollTop;

                var isScrollingDown = (scrollTop > lastScrollTop);
                var isWindowLarger = (windowHeight > sidebarHeight);

                if ((isWindowLarger && scrollTop > initialSidebarTop) || (!isWindowLarger && scrollTop > initialSidebarTop + heightDelta)) {
                    $sidebar.addClass('fixed-cus');
                } else if (!isScrollingDown && scrollTop <= initialSidebarTop) {
                    $sidebar.removeClass('fixed-cus');
                }

                var dragBottomDown = (sidebarBottom <= scrollBottom && isScrollingDown);
                var dragTopUp = (sidebarTop >= scrollTop && !isScrollingDown);

                if (dragBottomDown) {
                    if (isWindowLarger) {
                        $sidebar.css('top', 0);
                    } else {
                        $sidebar.css('top', -heightDelta );
                    }
                } else if (dragTopUp) {
                    $sidebar.css('top', 0);
                } else if ($sidebar.hasClass('fixed-cus')) {
                    var currentTop = parseInt($sidebar.css('top'), 10);
                    
                    var minTop = -heightDelta;
                    //var scrolledTop = currentTop + scrollDelta;
                    
                    //var isPageAtBottom = (scrollTop + windowHeight >= $(document).height());
                    //var newTop = (isPageAtBottom) ? minTop : scrolledTop;
                    
                    // $sidebar.css('top', newTop);
                }

                lastScrollTop = scrollTop;
                wasScrollingDown = isScrollingDown;
            });
        }
    });
    $('#search_field').select2({
        placeholder: 'Search by Industry',
        dropdownParent: $('.select-cus')
    });
    </script>