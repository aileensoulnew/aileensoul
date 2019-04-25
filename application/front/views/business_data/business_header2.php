<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
<div id="business_mob_search" class="modal fade mob-search-popup" role="dialog">
    <form onsubmit="businesssearchMobileSubmit()" method="get" action="javascript:void(0)">
        <div class="new-search-input1">
        	<input id="m_tags" class="tags ui-autocomplete-input ccp_search" name="skills" placeholder="Search by Company, Category, or Products" autocomplete="off" type="text">
			<input id="m_searchplace" class="searchplace ui-autocomplete-input" name="searchplace" placeholder="City, State or Country" autocomplete="off" type="text">
        </div>
		<div class="new-search-btn">
			<button type="button" class="close-new btn" data-dismiss="modal">Cancel</button>
			<button type="submit" id="m_search_btn" class="btn btn-primary" onclick="return m_checval();">Search</button>
		</div>
	</form>
</div>
<?php
$userid = $this->session->userdata('aileenuser');
$session_user = $this->session->userdata();
$userData = $this->user_model->getUserData($session_user['aileenuser']);
$browser = $this->agent->browser();
$browserVersion = $this->agent->version();

if($browser == "Internet Explorer")
{
    if(explode(".", $browserVersion)[0] < 11)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Chrome")
{            
    if(explode(".", $browserVersion)[0] < 65)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Firefox")
{            
    if(explode(".", $browserVersion)[0] < 55)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}

echo $header_inner_profile ?>
<div class="web-header">
    
    <?php //if ($business_common_data[0]['business_step'] == 4) { ?>
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mob-p0">
                    <ul class="sub-menu">
                        <li class="profile">
                        	<?php if($isbusiness_deactive == false && $isbusiness_register == true){
                        		$bus_pro_url = base_url('company/' . $business_login_slug_with_location);
                        	}
                        	else{
                        		$bus_pro_url = base_url("business-search");
                        	} ?>
                            <a href="<?php echo $bus_pro_url;// base_url('business-profile');//$business_right_profile_link; ?>">
								<div class="sub-menu-icon">
									
										<!-- <svg class="not-hover" viewBox="0 0 486.988 486.988" width="17px" height="17px">
											<path d="M16.822,284.968h39.667v158.667c0,9.35,7.65,17,17,17h116.167c9.35,0,17-7.65,17-17V327.468h70.833v116.167    c0,9.35,7.65,17,17,17h110.5c9.35,0,17-7.65,17-17V284.968h48.167c6.8,0,13.033-4.25,15.583-10.483    c2.55-6.233,1.133-13.6-3.683-18.417L260.489,31.385c-6.517-6.517-17.283-6.8-23.8-0.283L5.206,255.785    c-5.1,4.817-6.517,12.183-3.967,18.7C3.789,281.001,10.022,284.968,16.822,284.968z M248.022,67.368l181.333,183.6h-24.367    c-9.35,0-17,7.65-17,17v158.667h-76.5V310.468c0-9.35-7.65-17-17-17H189.656c-9.35,0-17,7.65-17,17v116.167H90.489V267.968    c0-9.35-7.65-17-17-17H58.756L248.022,67.368z" />
											
										</svg>
										<svg class="on-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">
											<g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
												<path d="M10715 20165 c-84 -19 -233 -90 -295 -142 -66 -55 -10218 -9911
												-10262 -9962 -53 -62 -115 -187 -138 -277 -27 -106 -27 -282 -1 -387 68 -263
												260 -456 531 -533 61 -17 129 -19 992 -22 l928 -3 2 -3542 3 -3542 23 -70 c85
												-252 255 -422 507 -507 l70 -23 2640 -3 c1953 -2 2660 0 2715 8 278 43 513
												254 602 540 l23 75 3 2603 2 2602 1545 0 1545 0 2 -2613 3 -2612 23 -70 c86
												-255 261 -428 512 -507 l75 -23 2555 0 2555 0 75 23 c252 79 448 280 517 532
												17 62 18 250 20 3597 l3 3532 1113 3 1112 4 75 22 c132 41 225 97 326 197 75
												75 98 106 136 182 65 129 82 213 75 377 -4 105 -10 145 -30 203 -46 133 -88
												193 -265 378 -92 96 -2303 2340 -4914 4987 -3317 3363 -4767 4826 -4810 4855
												-76 51 -152 86 -233 108 -85 24 -273 28 -360 10z"/>
											</g>
										</svg> -->

									<span>Business Profile</span>
								</div>
							</a>
                        </li>                        
                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
                    <div class="job-search-box1 clearfix">
                        <form onsubmit="businesssearchSubmit()" method="get" action="javascript:void(0)">
                            <fieldset class="sec_h2">
                                <input id="tags" class="tags ui-autocomplete-input ccp_search" name="skills" placeholder="Company, Category, or Products" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="sec_h2">
                                <input id="searchplace" class="searchplace ui-autocomplete-input" name="searchplace" placeholder="City, State or Country" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="new-search-btn">
                                <label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
                                <input id="search_btn" style="display: none;" name="search_submit" value="Search" onclick="return checkvalue()" type="submit">
                            </fieldset>
                        </form>    
                    </div>
                </div>
            </div>
        </div>

    </div>
     <?php //} ?>
</div>
<div class="mobile-header">
    <?php //if ($business_common_data[0]['business_step'] == 4) { ?>
    <div class="sub-header bus-only">
		<div class="container">
			<div class="row">
				
					<ul class="sub-menu">
					<li class="profile">
						<?php if($isbusiness_deactive == false && $isbusiness_register == true){
                    		$bus_pro_url = base_url('company/' . $business_login_slug_with_location);
                    	}
                    	else{
                    		$bus_pro_url = base_url("business-profile/registration/business-information");
                    	} ?>
						<a href="<?php echo $bus_pro_url; ?>" target="_self">
							<div class="sub-menu-icon">
								<span>Business Profile</span>
							</div>
							
						</a>
					</li>					
				</ul>
			</div>
		</div>
	
	</div>

    <?php //} ?>
	
</div>

<div class="sub-header-search">
	<div class="container">
		<div class="search-mob-block">
		    <a href="#" data-toggle="modal" data-target="#business_mob_search">
		        <input type="search" readonly="true" id="tags1" class="tags ccp_search" name="skills" value="" placeholder="Search..." />
		    </a>        
		</div>
	</div>
</div>

<div class="modal fade message-box biderror" id="bidmodal" role="dialog">
    <div class="modal-dialog modal-lm deactive">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deactivate(clicked_id) {
        $('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your business profile?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
    function deactivate_profile(clicked_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/deactivate" ?>',
            data: 'id=' + clicked_id,
            success: function (data) {
                window.location = "<?php echo base_url() ?>";
            }
        });
    }
</script>
<script type="text/javascript">
    function Notification_contact() {
        contactperson();
        update_contact_count();
    }
    function contactperson() {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/contact_notification",
            type: "POST",
            dataType: 'json',
            data: '',
            success: function (data) {
                $('.notification_data_in_con').html(data.contactdata);
                $('#seecontact').html(data.seeall);
            }
        });
    }
    function update_contact_count() {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/update_contact_count",
            type: "POST",
            success: function (data) {
                /*$('span[id^=addcontact_count]').html('');
                $('span[id^=addcontact_count]').css({
                    "background-color": "",
                    "padding": "0px"
                });*/
                $('#addcontactLink').html("");
                if (parseInt(data) > 0) {                    
                    $('#addcontactLink').html(data);
                }
                $('#addcontactLink').removeClass('noti-box');
            }
        });
    }
    function contactapprove(toid, status) {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/contact_approve",
            type: "POST",
            data: 'toid=' + toid + '&status=' + status,
            dataType: "json",
            success: function (data) {
                //$('.mCS_no_scrollbar').html(data.contactdata);
                $('.mCustomScrollbar').html(data.contactdata);
                $('.contactcount').html(data.contactcount);
                var segment = '<?php echo $this->uri->segment(2); ?>';
                if (segment == 'contacts') {
                    var slug = '<?php echo $slug_id; ?>';
                    $('.art-img-nn').hide();
                    business_contacts_header(slug);
                }
                var not_contact_count = $('.addcontact-left').length;
                if (not_contact_count == 0) {
                    var data_html = "<li><div class='art-img-nn' id='art-blank'><div class='art_no_post_img'><img src='<?php echo base_url('img/No_Contact_Request.png?ver=' . time()); ?>' alt='No Contact Request'></div><div class='art_no_post_text'>No Contact Request Available.</div></div></li>";
                    $('#notification_main_in').html(data_html);
                    $('#seecontact').hide();
                }
                if (data.co_notification.co_notification_count != 0) {
                    var co_notification_count = data.co_notification.co_notification_count;
                    var co_to_id = data.co_notification.co_to_id;
                    show_contact_notification(co_notification_count, co_to_id);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('#bidmodal').modal('hide');
        }
    });
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#dropdown-content_hover").hide();
        }
    });
</script>
<script type="text/javascript" charset="utf-8">
    function addmsg1(type, msg)
    {
        if (msg == 0)
        {
            $(".message_count").html('');
            $(".message_count").removeAttr("style");
            $('.message_count').removeClass('count_add');
            $('#InboxLink').removeClass('msg_notification_available');
            $(".message_count").hide();
            // document.getElementById('message_count').style.display = "none";
        } else
        {
            $('.message_count').html(msg);
            $('#InboxLink').addClass('msg_notification_available');
            $('.message_count').addClass('count_add');
            $('.message_count').show();
            // document.getElementById('message_count').style.display = "block";
        }
    }
    function waitForMsg1()
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>notification/select_msg_noti/6",
            async: true,
            cache: false,
            timeout: 50000,
            success: function (data) {
                addmsg1("new", data);
                setTimeout(
                        waitForMsg1,
                        10000
                        );
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
    ;
    $(document).ready(function () {
        // waitForMsg1();
    });
    $(document).ready(function () {
        $menuLeft = $('.pushmenu-left');
        $nav_list = $('#nav_list');
        $nav_list.click(function () {
            $(this).toggleClass('active');
            $('.pushmenu-push').toggleClass('pushmenu-push-toright');
            $menuLeft.toggleClass('pushmenu-open');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var InboxContainer = $('#InboxContainer').attr('class');
        if (InboxContainer == 'dropdown2_content show') {
            var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
            if (segment != "chat") {
                // chatmsg();
            }
        }
        $('.Inbox_link').on('click', function () {
            // chatmsg();
        });
    });
    function chatmsg()
    {
        /*$.ajax({
         type: 'POST',
         url: '<?php //echo base_url() . "chat/userajax/5/5" ?>',
         dataType: 'json',
         data: '',
         success: function (data) {
         
         $('#userlist').html(data.leftbar);
         $('.notification_data_in_h2').html(data.headertwo);
         $('#seemsg').html(data.seeall);
         setTimeout(
         chatmsg,
         25000
         );
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
         }
         });*/

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "chat/userajax/5/5" ?>',
            dataType: 'json',
            data: '',
            success: function (data) {
                $('#userlist').html(data.leftbar);
                $('.notification_data_in_h2').html(data.headertwo);
                $('.seemsg').html(data.seeall);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });

    };
    function getmsgNotification() {
        msgNotification();
    }

    function msgNotification() {
        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_msg_noti/6",
            type: "POST",
            success: function (data) {
                data = JSON.parse(data);
            }
        });
    }
    function msgheader()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "notification/msg_header/" . $this->uri->segment(3) . "" ?>',
            data: 'message_from_profile=5&message_to_profile=5',
            success: function (data) {
                $('#' + 'notificationsmsgBody').html(data);
            }
        });

    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        document.getElementById('tags1').value = null;
        // document.getElementById('searchplace1').value = null;
    });
</script>

<script>
    function businesssearchSubmit(){
        var keyword = $("#tags").val().toLowerCase().split(' ').join('+');
        var city = $("#searchplace").val().toLowerCase().split(' ').join('+');
        // REPLACE , WITH - AND REMOVE IN FROM KEYWORD ARRAY
        var keyworddata = [];
        if(keyword != ""){
            keyworddata = keyword.split(",");
            // remove in from array
            if(keyworddata.indexOf("in") > -1 && city != ""){
                keyworddata.splice(keyworddata.indexOf("in"),1);
            }
            keyword = keyworddata.join('-').toString();
        }
        var citydata = [];
        if(city != ""){
            citydata = city.split(",");
            // remove in from array
            // if(citydata.indexOf("in") > -1 && city != ""){
            //     citydata.splice(citydata.indexOf("in"),1);
            // }
            city = citydata.join('-').toString();
        }
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'business/search/' + keyword;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'business/search/business-in-' + city;
        } else {
            window.location.href = base_url + 'business/search/' + keyword + '-business-in-' + city;
        }
    }

    function businesssearchMobileSubmit(){
        var keyword = $("#m_tags").val().toLowerCase().split(' ').join('+');
        var city = $("#m_searchplace").val().toLowerCase().split(' ').join('+');
        // REPLACE , WITH - AND REMOVE IN FROM KEYWORD ARRAY
        var keyworddata = [];
        if(keyword != ""){
            keyworddata = keyword.split(",");
            // remove in from array
            if(keyworddata.indexOf("in") > -1 && city != ""){
                keyworddata.splice(keyworddata.indexOf("in"),1);
            }
            keyword = keyworddata.join('-').toString();
        }
        var citydata = [];
        if(city != ""){
            citydata = city.split(",");
            // remove in from array
            // if(citydata.indexOf("in") > -1 && city != ""){
            //     citydata.splice(citydata.indexOf("in"),1);
            // }
            city = citydata.join('-').toString();
        }
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'business/search/' + keyword;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'business/search/business-in-' + city;
        } else {
            window.location.href = base_url + 'business/search/' + keyword + '-business-in-' + city;
        }
    }

    function m_checval(){
    	var keyword = $("#m_tags").val();
    	var city = $("#m_searchplace").val();
    	if(keyword == "" && city == ""){
    		return false;
    	}
    }

    $(document).on('click','.mob_close', function (event) {
    	if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $('#search').removeClass('open');
        }
    });
    function unread_message_count_business()
	{
	    var url = '<?php echo base_url() . "notification/unread_message_count_business" ?>';
	    $.get(url, function(data, status){
	        data = JSON.parse(data);
	        if(data.unread_user > 0)
	        {
	            $(".message_count").show();
	            $(".message_count").text(data.unread_user);
	        }
	        else
	        {
	            $(".message_count").hide();
	            $(".message_count").text('');   
	        }

	        setTimeout(function(){
	            //unread_message_count_business();
	        }, 5000);
	    })
	    .fail(function() {
	        setTimeout(function(){
	            //unread_message_count_business();
	        }, 5000);
	    });	    
	}
	setTimeout(function(){
	    //unread_message_count_business();
	}, 1000);
</script>

<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
