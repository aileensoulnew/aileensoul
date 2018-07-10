<?php
    $userid = $this->session->userdata('aileenuser');
?>
<!-- NEW DESIGN -->
<div class="search-banner"><!-- ng-controller="searchFreelancerApplyController" -->
    <?php
    if($userid == "")
    {
    ?>
	<header>
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
					<?php $this->load->view('main_logo'); ?>
				</div>
				<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
					<div class="btn-right other-hdr">
						<?php if (!$this->session->userdata('aileenuser')) { ?>
						<ul class="nav navbar-nav navbar-right test-cus drop-down">
							<?php $this->load->view('profile-dropdown'); ?>
							<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn8">Login</a></li>
							<li class="hidden-991"><a href="<?php echo base_url('freelancer/create-account'); ?>" class="btn9">Create Freelancer Profile</a></li>
							<li class="mob-bar-li">
								<span class="mob-right-bar">
									<?php $this->load->view('mobile_right_bar'); ?>
								</span>
							</li>
											
						</ul>
						<?php } ?>
					</div>
				</div>
               
            </div>
        </div>
    </div>
</header>
   <div class="ld-sub-header">
					<div class="container">
						<div class="web-ld-sub">
							<ul class="">
								<li><a href="<?php echo base_url('freelance-jobs'); ?>">Freelancer Profile</a></li>
								<li><a href="<?php echo base_url('freelance-jobs-by-fields'); ?>">Freelance Job by Fields</a></li>
								<li><a href="<?php echo base_url('freelance-jobs-by-categories'); ?>">Freelance Job by Categories</a></li>
								<li><a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">How Freelancer Profile Works</a></li>
								<li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
							</ul>
						</div>
						<div class="mob-ld-sub">
							<ul class="">
								<li class="tab-first-li">
									<a href="javascript:void(0);">Freelance Jobs</a>
									<ul>
										<li><a href="<?php echo base_url('freelance-jobs'); ?>">Freelancer Profile</a></li>
										<li><a href="<?php echo base_url('freelance-jobs-by-fields'); ?>">Freelance Job by Fields</a></li>
										<li><a href="<?php echo base_url('freelance-jobs-by-categories'); ?>">Freelance Job by Categories</a></li>
										<li><a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">How Freelancer Profile Works</a></li>
										<li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
									</ul>
									
								</li>
								<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
								<li><a href="<?php echo base_url('business-profile/create-account'); ?>"><span class="hidden-479">Create Freelancer Profile</span><span class="visible-479">Sign Up</span></a></li>
							</ul>
						</div>
					</div>
				</div>
    <?php
    }
    ?>
    <div class="container">
        <?php /*if($this->freelance_apply_profile_set == 0 && $userid != ""){ ?>
            <div class="text-right pt20">
                <a class="btn5" href="<?php echo base_url('freelancer/signup') ?>">Create Freelance Apply Profile</a>
                <!-- <a class="btn5" href="<?php echo base_url('freelancer/freelancer_post') ?>">Reactivate Freelance Apply Profile</a> -->
            </div>
        <?php }*/ ?>
		<div class="bnr-cus-sec">
        <div class="row">
            <div class="col-lg-6 col-md-7">
                <div class="search-bnr-text">
                    <h1>Work from Anywhere at Any Time</h1>
                    <p>Get the work you love</p>
                </div>
                <div class="search-box">
                    <form onsubmit="searchSubmit()" name="serch_freelance" method="post" action="javascript:void(0);">
                        <div class="pb20 search-input">
                            <input type="text" ng-model="keyword" id="freelance_keyword" name="freelance_keyword" placeholder="Keywords, Title, Or Company" autocomplete="off">
                            <input type="text" ng-model="city" id="freelance_location" name="freelance_location" placeholder="City, State or Country" autocomplete="off">
                        </div>
                        <div class="pt5 fw pb20 hide">
                            <ul class="work-timing fw">
                                <li>
                                    <label class="control control--checkbox">Hourly
                                      <input type="checkbox" ng-model="hourly" name="work_timing[]" class="work_timing-filter" value="1" />
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Fixed
                                      <input class="work_timing-filter" ng-model="fixed" name="work_timing[]" value="2" type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="fw pt20">
                            <!-- <a href="#" class="btn1">Search Jobs</a> -->
                            <input type="submit" class="btn1" name="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-5 hidden-sm hidden-xs right-bnr">
                <img src="<?php echo base_url('assets/n-images/free-apply.png') ?>">
            </div>
        </div>
		</div>
	</div>
</div>
<?php if($this->freelance_apply_profile_set == 0 && $userid != ""){ ?>

    <div class="bottom-bnr-div">
        <div class="container">
            <p>Get Work from Home Opportunities
                <a target="_self" class="btn-1 pull-right" href="<?php echo base_url('freelancer/signup') ?>">Create Freelancer Profile</a>
            </p>
        </div>
    </div>
<?php } ?>
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
    } else if (keyword == '' && city != '') {
        window.location.href = base_url + 'freelancer/search/projects-in-' + city;
    } else {
        window.location.href = base_url + 'freelancer/search/' + keyword + '-projects-in-' + city;
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
<?php $this->load->view('mobile_side_slide'); ?>