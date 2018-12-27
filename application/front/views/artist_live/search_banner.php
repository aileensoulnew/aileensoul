<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>"> 

<div class="search-banner" ng-controller="searchArtistController">
	<?php 
		if ($ismainregister === false && $artist_isregister === false) {
			$this->load->view('artist_live/login_header');
	    }
     ?>
	<div class="container">
		<div class="text-right pt20 create-profile-btn">
			<?php 
				//if ($ismainregister == true && $artist_isregister == true) { 
			?>
				<?php //if($artist_isregister == false){ ?>
					<!-- <a class="btn3" href="<?php //echo artist_registration ?>">Create Artist Profile</a> -->
				<?php //} else{ ?>
					<!-- <a class="btn3" href="<?php //echo artist_reactivateacc; ?>">Reactivate Artist Profile</a> -->
				<?php //} ?>
			<?php //} ?>
		</div>
		<div class="bnr-cus-sec">
		<div class="row">
			<div class="col-lg-6 col-md-7">
				<div class="search-bnr-text">					
					<?php if($this->uri->uri_string() == "find-artist"){
                    ?>   
                    <h1>Search and Connect with the Best Talented Artist from All over the World</h1>
                    <?php }
                    else{
                    ?>   
                    <h2 class="bnr-title">Search and Connect with the Best Talented Artist from All over the World</h2>
                    <?php
                    } ?>
				</div>
				<div class="search-box">
					<form onsubmit="return searchSubmitNew();" method="post" name="artist_search" action="javascript:void(0);">
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
			<div class="col-lg-6 col-md-5 hidden-sm hidden-xs right-bnr">
				<img src="<?php echo base_url('assets/n-images/art-bnr-img1.png') ?>">
			</div>
		</div>
		</div>
	</div>
</div>
<?php 
if ($ismainregister == true && $artist_isregister == false) {
?>
<div class="bottom-bnr-div">
	<div class="container">
		<p>Show Your Artistic Side
			<a class="btn-1 pull-right" href="<?php echo base_url('artist-profile/signup'); ?>" target="_self">Create Artist Profile</a>
		</p>
	</div>
</div>
<?php } ?>

<?php //$this->load->view('mobile_side_slide'); ?>
<script type="text/javascript">
	function searchSubmitNew() {
        var keyword = $("#q").val().toLowerCase().split(' ').join('+');
        var city = $("#l").val().toLowerCase().split(' ').join('+');
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
            window.location.href = base_url + 'artist/search/' + keyword;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'artist/search/artist-in-' + city;
        } else {
            window.location.href = base_url + 'artist/search/' + keyword + '-in-' + city;
        }
    }
</script>