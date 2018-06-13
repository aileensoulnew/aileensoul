<?php
$userid = $this->session->userdata('aileenuser');
$fa_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $userid, 'status' => '1'))->row()->freelancer_apply_slug;
?>
<div id="fa_mob_search" class="modal fade mob-search-popup" role="dialog">			
	<form method="get">
		<div class="new-search-input">
			<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Title, Keywords, or Skills" />
			<input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="City, State or Country" />
		</div>
		<div class="new-search-btn">
			<button type="button" class="close-new btn">Cancel</button>
			<button type="submit" id="search_btn_res" class="btn btn-primary" onclick="return check();">Search</button>
		</div>
	</form>
</div>
<?php echo $header_inner_profile ?>
<div class="web-header">
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6 mob-p0">
					<ul class="sub-menu">
						<li class="profile">
							<a target="_self" href="<?php echo base_url('recommended-freelance-work'); ?>">
								<div class="sub-menu-icon">
									
										<svg class="not-hover" viewBox="0 0 486.988 486.988" width="17px" height="17px">
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
										</svg>

									<span>Freelance Profile</span>
								</div>
							</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick="return getmsgNotification()">
								<div class="sub-menu-icon">
									<svg class="not-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">
										<g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
											<path d="M1660 18783 c-94 -10 -265 -48 -373 -83 -271 -90 -508 -233 -716
											-434 -278 -270 -456 -591 -539 -975 l-27 -126 0 -6500 0 -6500 27 -126 c83
											-382 260 -703 535 -970 111 -107 164 -150 283 -229 192 -126 434 -224 671
											-272 l114 -23 9030 0 9030 0 114 23 c388 79 725 262 996 543 234 242 385 511
											470 832 60 228 56 -298 53 6772 l-3 6460 -27 121 c-113 503 -396 916 -818
											1194 -188 123 -427 221 -666 272 l-109 23 -9005 1 c-4953 0 -9021 -1 -9040 -3z
											m13280 -5488 l-4235 -4235 -105 104 c-229 225 -7176 7111 -7787 7718 l-652
											648 8507 0 8507 0 -4235 -4235z m-9145 -1150 c1920 -1902 3720 -3686 4000
											-3965 281 -279 524 -517 542 -528 110 -76 229 -112 370 -112 117 0 191 17 293
											67 74 36 156 117 4578 4537 l4502 4501 0 -5985 c0 -5796 -1 -5988 -19 -6075
											-41 -199 -120 -344 -271 -495 -151 -151 -296 -230 -495 -271 -87 -18 -343 -19
											-8630 -19 -8287 0 -8543 1 -8630 19 -199 41 -344 120 -495 271 -151 151 -230
											296 -271 495 -18 87 -19 279 -19 6080 l0 5990 528 -526 c290 -289 2097 -2082
											4017 -3984z"/>
										</g>
									</svg>
									<svg class="on-hover" width="17" height="17" viewBox="0 0 2133.000000 2133.000000">
										<g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
											<path d="M1660 18783 c-150 -16 -402 -84 -539 -145 l-53 -24 1423 -1416 c783
											-779 2952 -2931 4819 -4782 l3395 -3365 4778 4777 c2627 2627 4777 4780 4777
											4783 0 9 -190 83 -279 109 -40 12 -117 31 -170 43 l-96 21 -9010 2 c-4955 0
											-9026 -1 -9045 -3z"/>
											<path d="M132 17618 c-54 -138 -77 -217 -104 -351 l-23 -112 0 -6495 0 -6495
											27 -126 c83 -382 260 -703 535 -970 111 -107 164 -150 283 -229 192 -126 434
											-224 671 -272 l114 -23 9030 0 9030 0 114 23 c388 79 725 262 996 543 234 242
											385 511 470 832 60 228 56 -298 53 6772 l-3 6460 -27 121 c-27 120 -77 276
											-121 376 l-23 53 -4965 -4969 c-2730 -2732 -5002 -5002 -5049 -5044 -136 -120
											-267 -172 -435 -172 -108 0 -184 18 -285 67 -89 43 135 -175 -2284 2223 -4484
											4444 -6484 6425 -7193 7128 l-771 762 -40 -102z"/>
										</g>
									</svg>
									<span class="none-sub-menu"> Message</span>
									<span class="noti-box message_count" id="message_count"></span>
								</div>
							</a>
							<div class="dropdown-menu">
								<div class="dropdown-title">
									Messages <a href="javascript:void(0)" class="pull-right seemsg" id="seemsg"></a>
								</div>
								<div class="content custom-scroll">
									<ul class="dropdown-data msg-dropdown notification_data_in_h2">
										
									</ul>
								</div>
							</div>
						</li>
						<li class="dropdown user-id">
							<a href="javascript:void(0);" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<svg class="not-hover" viewBox="0 0 384.97 384.97" width="17px" height="17px">
									<g>
										<g id="Chevron_Down_Circle">
											<path d="M192.485,0C86.185,0,0,86.173,0,192.485c0,106.3,86.185,192.485,192.485,192.485    c106.312,0,192.485-86.185,192.485-192.485C384.97,86.173,298.797,0,192.485,0z M192.485,360.909    c-92.874,0-168.424-75.55-168.424-168.424S99.611,24.061,192.485,24.061s168.797,75.55,168.797,168.424    S285.359,360.909,192.485,360.909z" fill="#5c5c5c"/>
											<path d="M268.276,149.092l-75.61,74.528l-75.61-74.54c-4.74-4.704-12.439-4.704-17.191,0c-4.74,4.704-4.74,12.319,0,17.011    l84.2,83.009c4.62,4.572,12.56,4.584,17.191,0l84.2-82.997c4.74-4.704,4.74-12.319,0-17.011    C280.715,144.4,273.028,144.4,268.276,149.092z" fill="#5c5c5c"/>
										</g>
									</g>

								</svg>
						
								<svg class="on-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">

									<g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
										<path d="M10055 21319 c-2633 -154 -5074 -1248 -6935 -3109 -1870 -1870 -2958
										-4308 -3110 -6964 -13 -230 -13 -932 0 -1162 109 -1918 698 -3704 1745 -5294
										836 -1270 1973 -2378 3265 -3182 604 -376 1257 -699 1900 -938 1017 -379 2061
										-597 3164 -660 230 -13 932 -13 1162 0 2656 152 5094 1240 6964 3110 1782
										1782 2869 4112 3085 6610 27 319 35 528 35 935 0 528 -18 844 -76 1320 -373
										3068 -2093 5847 -4684 7570 -1591 1058 -3393 1655 -5324 1765 -206 12 -984 11
										-1191 -1z m-3840 -8083 c85 -27 174 -76 234 -128 20 -17 976 -959 2126 -2092
										1149 -1134 2094 -2061 2100 -2061 6 0 965 941 2131 2090 2285 2253 2162 2137
										2329 2192 69 23 97 26 205 26 108 0 136 -3 205 -26 108 -36 194 -89 274 -168
										79 -80 132 -166 168 -274 33 -101 37 -262 9 -365 -37 -136 -87 -212 -246 -372
										-80 -81 -1155 -1142 -2390 -2359 -1601 -1578 -2264 -2224 -2310 -2254 -133
										-87 -307 -127 -457 -106 -105 15 -224 57 -297 106 -82 54 -4789 4697 -4846
										4779 -179 258 -149 608 70 836 178 185 451 254 695 176z"/>
									</g>
								</svg>

								<span class="pr-name"><span class="none-sub-menu"> Account</span></span>
							</a>

							<ul class="dropdown-menu account">
								<li>Freelancer Account</li>
								<li><a href="<?php echo base_url('freelancer/').$fa_slug; ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
								<li><a href="<?php echo base_url('freelancer/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
								<!-- <li><a href="#" onclick="deactivate(<?php echo $userid; ?>)"><span class="icon-delete edit_data"></span> Deactive Profile</a></li> -->
							</ul>
						</li>
					</ul>
				</div>
				<div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
					<div class="job-search-box1 clearfix">
						<!-- <form action="<?php //echo base_url('freelance-employer/search'); ?>" method="get"> -->
						<form method="post" name="f-fearch" onsubmit="return searchSubmit()"><!--  onsubmit="searchSubmit()"> -->
							<fieldset class="sec_h2">
								<input id="freelance_keyword" class="tags ui-autocomplete-input skill_keyword" name="freelance_keyword" placeholder="Title, Keywords, or Skills" autocomplete="off" ng-model="keyword" type="text">
							</fieldset>
							<fieldset class="sec_h2">
								<input id="freelance_location" ng-model="city" class="searchplace ui-autocomplete-input skill_keyword" name="freelance_location" placeholder="City, State or Country" autocomplete="off" type="text">
							</fieldset>
							<fieldset class="new-search-btn">
								<label for="search_btn_main" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
								<input id="search_btn_main" style="display: none;" name="search_submit" value="Search" type="submit">
							</fieldset>
						</form>    
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<div class="mobile-header">	
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<ul class="sub-menu">
					<li class="profile">
						<a target="_self" href="<?php echo base_url('recommended-freelance-work'); ?>">
							<span>Freelance Profile</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick="return getmsgNotification()">
							<span>Message</span>
							<span class="noti-box message_count" id="message_count"></span>
						</a>
						<div class="dropdown-menu">
							<div class="dropdown-title">
								Messages <a href="javascript:void(0)" class="pull-right seemsg" id="seemsg"></a>
							</div>
							<div class="content custom-scroll">
								<ul class="dropdown-data msg-dropdown notification_data_in_h2">
									
								</ul>
							</div>
						</div>
					</li>
					<li class="dropdown user-id">
						<a href="javascript:void(0);" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="pr-name"> Account</span>
						</a>
						<ul class="dropdown-menu account">
							<li>Freelancer Account</li>
							<li><a href="<?php echo base_url('freelancer/').$fa_slug; ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
							<li><a href="<?php echo base_url('freelancer/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>	
	</div>	
</div>
<div class="sub-header-search">
	<div class="container">
		<div class="search-mob-block">					
			<a href="#" data-toggle="modal" data-target="#fa_mob_search">
				<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Search..." />
			</a>
		</div>
	</div>
</div>
<!-- Bid-modal  -->
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
<!-- Model Popup Close -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>" ></script>
<script type="text/javascript">
	function deactivate(clicked_id) {
	 
		$('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your Freelancer Hire profile?<div class='model_ok_cancel'><a title='yes' class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a title='No' class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
		$('#bidmodal').modal('show');
	}
	function deactivate_profile(clicked_id) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . "freelance-work/deactivate" ?>',
			data: 'id=' + clicked_id,
			success: function (data) {
				window.location = "<?php echo base_url() ?>";

			}
		});
	}
</script>


<!-- all popup close close using esc start -->
<script type="text/javascript">
	$(document).on('keydown', function (e) {
		if (e.keyCode === 27) {
			$("#dropdown-content_hover").hide();
		}
	});
	$(document).on('keydown', function (e) {
		if (e.keyCode === 27) {

			$('#bidmodal').modal('hide');
		}
	});

</script>
<!-- all popup close close using esc end -->
<script type="text/javascript" charset="utf-8">

	function addmsg1(type, msg)
	{
		if (msg == 0)
		{ 
			$(".message_count").html('');
			$(".message_count").removeAttr("style");
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
			//alert("welcome");
		}
	}

	function waitForMsg1()
	{
		$.ajax({
			type: "GET",
			url: "<?php echo base_url(); ?>notification/select_msg_noti/5",

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
		waitForMsg1();

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
<!-- script for fetch all unread message notification end-->

<!-- script for update all read msg notification start-->
<script type="text/javascript">
	
   $(document).ready(function () {
	  
	 var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
	 if(segment != "chat"){ chatmsg(); };
		   });  // khyati chnages  start
   function chatmsg()
   {             
			 // khyati chnages  start
			 
			 $.ajax({
				type: 'POST',
				url: '<?php echo base_url() . "chat/userajax/4/3" ?>',
				dataType: 'json',
				data: '',
				success: function (data) { //alert(data);

					$('#userlist').html(data.leftbar);
					$('.notification_data_in_h2').html(data.headertwo);
					$('.seemsg').html(data.seeall);
					setTimeout(
						chatmsg,
						10000000000000
						);
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
				}           
			});
			 
		 };

		 function getmsgNotification() {
			msgNotification();
		//msgheader();
	}

	function msgNotification() {
		// first click alert('here'); 
		$.ajax({
			url: "<?php echo base_url(); ?>notification/update_msg_noti/5",
			type: "POST",
			//data: {uid: 12341234}, //this sends the user-id to php as a post variable, in php it can be accessed as $_POST['uid']
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
			data: 'message_from_profile=3&message_to_profile=4',
			success: function (data) {
				$('.' + 'notification_data_in_h2').html(data);
			}
		});

	}
</script>
 <!-- all message notification header end -->
 <script type="text/javascript" charset="utf-8">
function searchSubmit(){    
    var keyword = $("#freelance_keyword").val().toLowerCase().split(' ').join('+');
    var city = $("#freelance_location").val().toLowerCase().split(' ').join('+');

    /*var work_timing_fil = "";
    $('.work_timing-filter').each(function(){
        if(this.checked){
            var currentid = $(this).val();
            work_timing_fil += (work_timing_fil == "") ? currentid : "-" + currentid;
        }
    }); */       
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

    if(keyword[keyword.length - 1] == "-")
    {            
        keyword = keyword.slice(0,-1);
    }    
    
    if (keyword == '' && city == '') {    	
        return false;
    } else if (keyword != '' && city == '') {    	
         window.location.href = base_url + 'freelancer/search/' + keyword;
         return false;
    } else if (keyword == '' && city != '') {    	
         window.location.href = base_url + 'freelancer/search/projects-in-' + city;
         return false;
    } else {
         window.location.href = base_url + 'freelancer/search/' + keyword + '-projects-in-' + city;
         return false;
    }
}

$(function() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) { 
        return split( term ).pop();
    }

    $( "#freelance_keyword" ).focusout(function() {
        if($( "#freelance_keyword" ).val() != "")
        {
            var ser_val = $( "#freelance_keyword" ).val();
            if(ser_val[ser_val.length - 1] == ",")
            {                
                ser_val_ = ser_val.substring(0, ser_val.length-1);            
                $( "#freelance_keyword" ).val(ser_val_)
            }
        }
    });
    $( "#freelance_keyword" ).focusin(function() {
        if($( "#freelance_keyword" ).val() != "")
        {
            var ser_val = $( "#freelance_keyword" ).val();            
            ser_val_ = ser_val+",";
            $( "#freelance_keyword" ).val(ser_val_)
        }
    });
    $( "#freelance_keyword" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 2,
        source: function( request, response ) { 
            // delegate back to autocomplete, but extract the last term
            terms = extractLast( request.term );                
            if(terms != "")
            {                    
                $.getJSON(base_url + "freelancer_apply_live/freelancer_apply_search_keyword", { term : terms},response);
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {

            var terms = split( this.value.toLowerCase() );
            // remove the current input
            terms.pop();
            // add the selected item

            var uniqueNames = [];
            $.each(terms, function(i, el){
                if($.inArray(el.toLowerCase(), uniqueNames) === -1) uniqueNames.push(el);
            });

            uniqueNames.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            uniqueNames.push( "" );
            this.value = uniqueNames.join( "," );
            return false;                
        }
    });

    $( "#freelance_location" ).focusout(function() {
        if($( "#freelance_location" ).val() != "")
        {
            var ser_val = $( "#freelance_location" ).val();
            if(ser_val[ser_val.length - 1] == ",")
            {
                ser_val_ = ser_val.substring(0, ser_val.length-1);            
                $( "#freelance_location" ).val(ser_val_)
            }
        }
    });
    $( "#freelance_location" ).focusin(function() {
        if($( "#freelance_location" ).val() != "")
        {
            var ser_val = $( "#freelance_location" ).val();            
            ser_val_ = ser_val+",";
            $( "#freelance_location" ).val(ser_val_)
        }
    });
    $( "#freelance_location" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 2,
        source: function( request, response ) { 
            // delegate back to autocomplete, but extract the last term
            terms = extractLast( request.term );                
            if(terms != "")
            {                    
                $.getJSON(base_url + "freelancer_apply_live/freelancer_apply_search_city", { term : terms},response);
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {

            var terms = split( this.value.toLowerCase() );
            // remove the current input
            terms.pop();
            // add the selected item

            var uniqueNames = [];
            $.each(terms, function(i, el){
                if($.inArray(el.toLowerCase(), uniqueNames) === -1) uniqueNames.push(el);
            });

            uniqueNames.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            uniqueNames.push( "" );
            this.value = uniqueNames.join( "," ).toLowerCase();
            return false;                
        }
    });
});
</script>