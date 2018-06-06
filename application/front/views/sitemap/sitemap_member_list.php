<div class="site-box">
	<h3>Member Name with Characters</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a target="_self" class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/people/'?>{{ alpha.name.toLowerCase() }}?page_id=1">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Member Name with Characters</h3>
		<div ng-show="memberList.length > 0">
			<pagination 
				ng-model="currentPage"
				total-items="total_record"
				max-size="maxSize" 
				items-per-page="limit"
				boundary-links="true"
				>
			</pagination>
		</div>
		<div ng-show="memberList.length <= 0">
			<p class="text-center"> No data </p>
		</div>
	</div>
	<div class="fw pt20" ng-show="isPaginationShow">
		<ul class="mid-listing">
			<li ng-repeat="member in memberList track by $index">
				<a ng-href="<?php echo base_url() ?>{{ member.user_slug }}" target="_blank">
					{{ member.fullname | capitalize }} 
					<span ng-if="member.designaation">
						( {{ member.designaation | capitalize }} )
					</span>
					<span ng-if="member.degree_name">
						( {{ member.degree_name | capitalize }} )
					</span>
				</a>
			</li>								
		</ul>
	</div>

</div>