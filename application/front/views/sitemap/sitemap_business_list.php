<div class="site-box">
	<h3>Member Name with Characters</h3>
	<ul class="alphabet">
		<li ng-repeat="alpha in alphabetList track by $index">
			<a class="{{ alpha.isactive }}" ng-href="<?php echo base_url(). 'sitemap/companies/'?>{{ alpha.name.toLowerCase() }}?page_id=1" target="_self">{{ alpha.name }}</a>
		</li>
	</ul>
	<div class="fw pt20" ng-show="isPaginationShow">
		<h3>Member Name with Characters</h3>
		<pagination 
			ng-model="currentPage"
			total-items="total_record"
			max-size="maxSize" 
			items-per-page="limit"
			boundary-links="true"
			>
		</pagination>
	</div>
	<div class="fw pt20" ng-show="isPaginationShow">
		<ul class="mid-listing">
			<li ng-repeat="company in companyList track by $index">
				<a ng-href="<?php echo base_url(). 'company/'?>{{ company.business_slug }}" target="_blank">
					{{ company.company_name | capitalize }} 
					<span ng-if="company.bus_industry_name != '' && company.bus_industry_name != null">
						( {{ company.bus_industry_name | capitalize }} )
					</span>
				</a>
			</li>								
		</ul>
	</div>

</div>