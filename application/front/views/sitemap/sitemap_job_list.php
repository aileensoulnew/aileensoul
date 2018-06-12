<div class="site-box">
	<h3>Jobs Directory</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/jobs/'?>{{ alpha.name.toLowerCase() }}" target="_self">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Jobs Starting with Letter A</h3>
		<div ng-show="jobList.length > 0">
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
		<div ng-show="jobList.length <= 0">
			<p class="text-center"> No data </p>
		</div>
	</div>
	<div class="fw pt20" ng-show="isPaginationShow">
		<ul class="mid-listing">
			<li ng-repeat="jobs in jobList track by $index">
				<a ng-href="<?php echo base_url()?>{{ jobs.string_post_name | slugify }}-job-vacancy-in-{{ jobs.city_name | slugify }}-{{ jobs.post_user_id }}-{{ jobs.post_id }}" target="_blank">
					{{ jobs.post_name | capitalize }} ( {{ jobs.re_comp_name | capitalize }} )
				</a>
			</li>								
		</ul>
	</div>

</div>