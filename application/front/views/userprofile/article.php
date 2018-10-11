<div class="container pt15 main-dashboard">

	<div class="full-box">

		<div class="row ">
			<div class="media-tab">
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#" ><i class="fa fa-newspaper-o" aria-hidden="true"></i> Article</a></li>
						<li><a href="<?php echo base_url(); ?>{{user_slug}}/photos" ng-click='makeActive("dashboard")'><i class="fa fa-camera" aria-hidden="true"></i> Photo</a></li>
						<li><a href="<?php echo base_url(); ?>{{user_slug}}/videos" ng-click='makeActive("dashboard")'><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
						<li><a href="<?php echo base_url(); ?>{{user_slug}}/audios" ng-click='makeActive("dashboard")'><i class="fa fa-music" aria-hidden="true"></i> Audio</a></li>
						<li><a href="<?php echo base_url(); ?>{{user_slug}}/pdf" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> PDF</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="article">
							<input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_number}}">
			                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.total_record}}">
			                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.perpage_record}}">
							<ul class="all-tab article-tab">
								<li ng-repeat="_articleData in articleData">
									<a href="{{_articleData.article_slug}}" target="_blank">
										<div class="rel-art-box">
											<div ng-class="_articleData.article_featured_image == '' ? 'art-list-img default-img1' : 'art-list-img'">
												<img ng-if="_articleData.article_featured_image == ''" src="<?php echo base_url() ?>assets/img/art-default.jpg">
                            					<img ng-if="_articleData.article_featured_image != ''" src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{_articleData.article_featured_image}}">
											</div>
											<div class="rel-art-name">
												<a href="{{_articleData.article_slug}}" target="_blank" dd-text-collapse dd-text-collapse-max-length="40" dd-text-collapse-text="{{_articleData.article_title != '' ? _articleData.article_title : 'Untitled'}}" dd-text-collapse-cond="false"></a>
											</div>
										</div>
									</a>
								</li>
								<li ng-class="pagecntctData.pagedata.total_record == 0 ? 'no-data' : ''" ng-if="pagecntctData.pagedata.total_record == 0">
									<div class="custom-user-box no-data-available">
					                    <div class='art-img-nn'>
					                        <div class='art_no_post_img'>
					                            <img src="<?php echo base_url('assets/img/no-article.png'); ?>" alt="No Article">
					                        </div>
					                        <div class='art_no_post_text'>No Article Available. </div>
					                    </div>
					                </div>									
								</li>								
							</ul>
							<div class="fw post_loader load_more_post" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>