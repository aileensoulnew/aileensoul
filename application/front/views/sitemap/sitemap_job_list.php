<div class="site-box">
	<h3>Member Name with Characters</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/jobs/'?>{{ alpha.name.toLowerCase() }}?page_id=1">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Member Name with Characters</h3>
		{{ currentPage }}
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
			<li ng-repeat="jobs in jobList track by $index">
				<a ng-href="<?php echo base_url()?>{{ jobs.string_post_name | slugify }}-job-vacancy-in-{{ jobs.city_name }}-{{ jobs.post_user_id }}-{{ jobs.post_id }}" target="_blank">
					{{ jobs.post_name | capitalize }} ( {{ jobs.re_comp_name | capitalize }} )
				</a>
			</li>								
		</ul>
	</div>

</div>