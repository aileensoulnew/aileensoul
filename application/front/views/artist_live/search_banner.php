<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>"> 

<div class="search-banner" ng-controller="searchArtistController">
	<?php 
		if ($ismainregister == false) {
	        $this->load->view('artist_live/login_header');
	    }
     ?>
	<div class="container">
		<div class="text-right pt20 create-profile-btn">
			<?php 
				if ($ismainregister == true) { 
			?>
				<?php if($artist_isregister == false){ ?>
					<a class="btn3" href="<?php echo artist_registration ?>">Create Artist Profile</a>
				<?php } else{ ?>
					<a class="btn3" href="<?php echo artist_reactivateacc; ?>">Reactivate Artist Profile</a>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
				<div class="search-bnr-text">
					<h1>Search and Connect with the Best Talented Artist from All over the World</h1>
				</div>
				<div class="search-box">
					<form ng-submit="searchSubmit()">
						<div class="pb20 search-input">
							<input type="text" ng-model="keyword" id="q" class="artist_search_category" name="q" placeholder="Search by Category and Keyword" autocomplete="off">
							<input type="text" ng-model="city" id="l" class="artist_search_location" name="l" placeholder="City, State or Country" autocomplete="off" class="city-input">
						</div>
						<div class="fw pt20">
							<input type="submit" name="searchSubmit" class="btn1" value="Search" id="btnSubmit"/>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-6 right-bnr">
				<img src="<?php echo base_url('assets/n-images/art-bnr-img1.png') ?>">
			</div>
		</div>
	</div>
</div>

