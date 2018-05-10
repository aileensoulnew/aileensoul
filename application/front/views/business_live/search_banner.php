<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>"> 
<!-- NEW HTML DESIGN -->
<div class="search-banner" ng-controller="searchBusinessController">
	<div class="container">
		<div class="text-right pt20">
			<?php if($isbusinessdeactivate == false || !($isbusinessdeactivate)){ ?>
			<a class="btn5" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
			<?php }else{ ?>
			<a class="btn5" href="<?php echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
				<div class="search-bnr-text">
					<h1>Find the business that best suits your requirement</h1>
				</div>
				<div class="search-box">
					<form ng-submit="searchSubmit()">
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
			<div class="col-md-6 right-bnr">
				<img src="<?php echo base_url('assets/n-images/business-bnr.png') ?>">
			</div>
		</div>
	</div>
</div>

