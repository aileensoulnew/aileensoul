 <div class="search-banner hidden" >
		<div class="container">
			<div class="text-right pt20">
				<?php if(!$isartistactivate || $isartistactivate == false){ ?>
					<a class="btn5" href="<?php echo $artist_profile_link ?>">Create Artist Profile</a>
				<?php } else{ ?>
					<a class="btn5" href="<?php echo base_url('artist/reactivateacc'); ?>">Reactivate Artist Profile</a>
				<?php } ?>
			</div>
		 <div class="row">
			<div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
			 <div class="search-bnr-text">
				<h1>Find The Artist That Fits Your Life</h1>
			 </div>
			 <div class="search-box">
				<form ng-submit="searchSubmit()">
				 <div class="pb20 search-input">
					<input type="text" ng-model="keyword" id="q" name="q" placeholder="Company, Cat, Products" autocomplete="off">
					<input ng-model="city" id="l" name="l" placeholder="Location" autocomplete="off">
				 </div>
				 <div class="pt5 fw pb20">
					<ul class="work-timing fw">
					 <li>
						<label class="control control--checkbox">Full-Time
							<input type="checkbox"/>
							<div class="control__indicator"></div>
						</label>
					 </li>
					 <li>
						<label class="control control--checkbox">Part-Time
							<input type="checkbox"/>
							<div class="control__indicator"></div>
						</label>
					 </li>
					 <li>
						<label class="control control--checkbox">Internship
							<input type="checkbox"/>
							<div class="control__indicator"></div>
						</label>
					 </li>
					</ul>
				 </div>
				 <div class="fw pt20">
					<a href="#" class="btn1">Find Artist</a>
				 </div>
				</form>
			 </div>
			</div>
		 </div>
		</div>
	 </div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>"> 

<div class="search-banner" ng-controller="searchArtistController">

	<div class="container">
		<div class="text-right pt20">
			<?php if(!$isartistactivate || $isartistactivate == false){ ?>
				<a class="btn5" href="<?php echo $artist_profile_link ?>">Create Artist Profile</a>
			<?php } else{ ?>
				<a class="btn5" href="<?php echo base_url('artist/reactivateacc'); ?>">Reactivate Artist Profile</a>
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
							<!-- <a href="#" class="btn1">Search</a> -->
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

