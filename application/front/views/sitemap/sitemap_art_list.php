<div class="site-box">
	<h3>Member Name with Characters</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/artist/'?>{{ alpha.name.toLowerCase() }}?page_id=1" target="_self">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Member Name with Characters</h3>
		<div ng-show="artistList.length > 0">
			<pagination 
				ng-model="currentPage"
				total-items="total_record"
				max-size="maxSize" 
				items-per-page="limit"
				boundary-links="true"
				>
			</pagination>
		</div>
		<div ng-show="artistList.length <= 0">
			<p class="text-center"> No data </p>
		</div>
	</div>
	<div class="fw pt20" ng-show="isPaginationShow">
		<ul class="mid-listing">
			<li ng-repeat="artist in artistList track by $index">
				<a ng-href="<?php echo base_url(). 'artist/p/'?>{{ artist.slug }}" target="_blank">
					{{ artist.art_fullname | capitalize }} ( {{ artist.category_name | capitalize }} )
				</a>
			</li>								
		</ul>
	</div>

</div>