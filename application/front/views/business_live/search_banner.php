<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>"> 
<!-- NEW HTML DESIGN -->
<div class="search-banner" ng-controller="searchBusinessController">
	<?php  
		if($ismainregister == false){
		    $this->load->view('business_live/login_header');
		}
	?>
	<div class="container">
		<?php /*if($ismainregister == true){ ?>
			<div class="text-right pt20 create-profile-btn">				
				<?php if($isbusinessdeactivate == false || !($isbusinessdeactivate)){ ?>
				<a class="btn3" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
				<?php }else{ ?>
				<a class="btn3" href="<?php echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a>
				<?php } ?>
			</div>
		<?php }*/ ?>
		<div class="bnr-cus-sec">
		<div class="row">
			<div class="col-lg-6 col-md-7">
				<div class="search-bnr-text">
					<?php if($this->uri->uri_string() == "business-search"){
                    ?>   
                    <h1>Find the business that best suits your requirement</h1>
                    <?php }
                    else{
                    ?>   
                    <h2 class="bnr-title">Find the business that best suits your requirement</h2>
                    <?php
                    } ?>					
				</div>
				<div class="search-box">
					<form onsubmit="return searchSubmit();" method="post" action="javascript:void(0);">
						<div class="pb20 search-input">
							<input type="text" ng-model="keyword" id="q" name="q" placeholder="Company, Category, or Products" autocomplete="off" class="business_category">
							<input type="text" class="city-input business_location" ng-model="city" id="l" name="l" placeholder="City, State or Country" autocomplete="off">
						</div>
						<div class="fw pt20">
							<input type="submit" name="searchbusinessSubmit" class="btn1" value="Search" id="btnBusinessSubmit">
							<!-- <a href="#" class="btn1">Search</a> -->
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-6 col-md-5 hidden-sm hidden-xs right-bnr">
				<img src="<?php echo base_url('assets/n-images/business-bnr.png') ?>">
			</div>
		</div>
		</div>
	</div>
</div>

<?php if($ismainregister == true){ ?>
	<div class="bottom-bnr-div">
		<div class="container">
			<p>Got a Business? Be Found by Your Audience
				<a class="btn-1 pull-right" href="<?php echo base_url('business-profile/registration/business-information'); ?>" target="_self">Create Business Profile</a>
			</p>
		</div>
	</div>
<?php } ?>
<script type="text/javascript">
	function searchSubmit() {		
        var keyword = $("#q").val().toLowerCase().split(' ').join('+');
        var city = $("#l").val().toLowerCase().split(' ').join('+');
        var keyworddata = [];
        var base_url = "<?php echo base_url(); ?>";
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
        // alert(base_url);return false;
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location = base_url + 'business/search/' + keyword;
        } else if (keyword == '' && city != '') {
            window.location = base_url + 'business/search/business-in-' + city;
        } else {
            window.location = base_url + 'business/search/' + keyword + '-in-' + city;
        }
    }
</script>