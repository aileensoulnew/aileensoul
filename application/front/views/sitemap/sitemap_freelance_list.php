<div class="site-box">
	<h3>Member Name with Characters</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/freelance-jobs/'?>{{ alpha.name.toLowerCase() }}" target="_self">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Member Name with Characters</h3>
		<div ng-show="freelancerList.length > 0">
			<pagination 
				ng-model="currentPage"
				total-items="total_record"
				max-size="maxSize" 
				items-per-page="limit"
				boundary-links="true"
				ng-change="pageChanged()"
				>
			</pagination>
		</div>
		<div ng-show="freelancerList.length <= 0">
			<p class="text-center"> No data </p>
		</div>
	</div>
	<div class="fw pt20" ng-show="isPaginationShow">
		<ul class="mid-listing">
			<li ng-repeat="freelancer in freelancerList track by $index">
				<a ng-href="<?php echo base_url(). 'freelance-jobs/'?>{{ freelancer.category_name }}/{{ freelancer.post_slug }}-{{ freelancer.post_user_id }}-{{ freelancer.post_id }}" target="_blank">
					{{ freelancer.post_name | capitalize }} ( {{ freelancer.category_name | capitalize }} )
				</a>
			</li>								
		</ul>
	</div>

</div>