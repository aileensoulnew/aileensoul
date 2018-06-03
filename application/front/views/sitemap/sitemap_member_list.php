<div class="site-box">
	<h3>Member Name with Characters</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/people/'?>{{ alpha.name.toLowerCase() }}?page_id=1">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Member Name with Characters</h3>
		
		<pagination 
			ng-model="currentPage"
			total-items="total_record"
			max-size="maxSize" 
			items-per-page="5"
			boundary-links="true"
			>
		</pagination>
	</div>
	<div class="fw pt20" ng-show="isPaginationShow">
		<ul class="mid-listing">
			<li ng-repeat="member in memberList track by $index">
				<a ng-href="<?php echo base_url() ?>{{ member.user_slug }}" target="_blank">
					{{ member.fullname | capitalize }} ( {{ member.user_slug | capitalize }} )
				</a>
			</li>								
		</ul>
	</div>

</div>