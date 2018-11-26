<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
        <?php echo $header; ?>
        <?php echo $business_header2; ?>
        <section>
           <?php echo $business_common; ?>
            <div class="user-midd-section">
                <div class="container tab-plr0 pt20">
                    <div class="all-detail-custom">
                        <div class="custom-user-list">
							<div class="tab-add-991">
								<?php $this->load->view('banner_add'); ?>
							</div>
					<div class="gallery" id="gallery">
						<!-- 01 Basic information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Basic Information</span><a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<ul class="dis-list">
										<li>
											<span>Business Type </span>
											Lorem Ipsum
										</li>
										<li>
											<span>Business Description</span>
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. <a href="#">Read More</a>
										</li>
										<li>
											<span>Total Employees</span>
											150
										</li>
										<li>
											<span>Year Founded / Established</span>
											2018
										</li>
										<li>
											<span>Specialties / Extra Benefits / Ambience/ Facilities Tags</span>
											Lorem ipsum
										</li>
										
										<li>
											<span>Payment Mode Accepted</span>
											Lorem ipsum
										</li>
										<li>
											<span>Business Keywords</span>
											Lorem ipsum
										</li>
										<li>
											<span>Mission</span>
											Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. <a href="#">Read More</a>
										</li>
										<li>
											<span>Legal Name</span>
											Lorem ipsum
										</li>
										<li>
											<span>Services / Products you offer (Tags)</span>
											Lorem ipsum
										</li>
										<li>
											<span>Area Served</span>
											Ahmedabad, Gandhinagar, Rajkot
										</li>
										<li>
											<span>Tagline</span>
											Aliquam feugiat turpis a erat sagittis pharetra.
										</li>
										<li>
											<span>Formerly Knowns as</span>
											Lorem ipsum
										</li>
										
										
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
								
							</div>
						</div>
						
						<!-- 02 Address Information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/address-info.png?ver=' . time()) ?>"><span>Address Information</span><a href="#" data-target="#add-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<ul class="dis-list">
										
										<li>
											<span>Street Address</span>
											E-912, titanium city centr,
											120 ft ring road, nr.shyamal cross road,
											ahmedabad.
										</li>
										<li>
											<span>Location</span>
											Ahmedabad, Gujarat, India
										</li>
										<li>
											<span>Pincode</span>
											380015
										</li>
										<li>
											<span>Map Coordinates</span>
											Lorem ipsum
										</li>
										
										<li>
											<span>Location</span>
											Lorem ipsum
										</li>
										
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
								
							</div>
						</div>
						
						<!-- 03 Contact Information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/contact.png?ver=' . time()) ?>"><span>Contact Information</span><a href="#" data-target="#contact-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<ul class="dis-list">
										
										<li>
											<span>Contact Person Name / Owner Name</span>
											Yatin Belani
										</li>
										<li>
											<span>Designation / Role</span>
											MD
										</li>
										<li>
											<span>Contact Number (Add)</span>
											+91 9874563210
										</li>
										<li>
											<span>Fax Number</span>
											65412398
										</li>
										
										<li>
											<span>Toll Free Number</span>
											1800 00 1122
										</li>
										<li>
											<span>Email Id</span>
											Loremipsum@gmail.com
										</li>
										
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
								
							</div>
						</div>
						
						<!-- 04 Business Portfolio  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-portfolio.png?ver=' . time()) ?>"><span>Business Portfolio</span><a href="#" data-target="#bus-portfolio" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="project-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="projectOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>A</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Aileensoul (project name)</h4>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#bus-portfolio" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project1" aria-expanded="false" aria-controls="project1" class="collapsed">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="project1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="projectOne" aria-expanded="false" style="height: 0px;">
												<div class="panel-body">
													<ul class="dis-list">
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Project File</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
															</p>
														</li>
													
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="projecttwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>H</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>health jump</h4>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#bus-portfolio" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project2" aria-expanded="false" aria-controls="project2" class="collapsed">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="project2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="projecttwo" aria-expanded="false">
												<div class="panel-body">
													<ul class="dis-list">
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Project File</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
															</p>
														</li>
														
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- 05 hour of opration  -->
						
						<!-- 06 Key Members Information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Key Members Information</span><a href="#" data-target="#member-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="exp-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="expOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img img-cus">
															<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
														</div>
													</div>
													<div class="dis-middle">
														<h4>Yatin Belani</h4>
														<p>Working as Sr.multimedia dsigner </p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#member-info" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>n-images/detail/detial-edit.png"></a>
														<a role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp1" aria-expanded="false" aria-controls="exp1" class="collapsed up-down">
															<img src="<?php echo base_url('assets/n-images/detail/
															down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="exp1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="expOne" aria-expanded="false" style="height: 0px;">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Gender</span>
															Male
															
														</li>
														<li>
															<span>Social Links</span>
															<ul class="social-link-list pt5">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/fb.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/in.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pin.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/insta.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/you.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/git.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
								</ul>
															
														</li>
														
														<li>
															<span>Biography</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
													
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="exptwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img img-cus">
															<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
														</div>
													</div>
													<div class="dis-middle">
														<h4>Verv System PVT LTD</h4>
														<p>Working as Sr.multimedia dsigner </p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#member-info" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp2" aria-expanded="false" aria-controls="exp2" class="collapsed up-down">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="exp2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="exptwo" aria-expanded="false">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Gender</span>
															Male
															
														</li>
														<li>
															<span>Social Links</span>
															<ul class="social-link-list pt5">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/fb.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/in.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pin.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/insta.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/you.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/git.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
								</ul>
															
														</li>
														
														<li>
															<span>Biography</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
													
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- 07 Reviews  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/review.png?ver=' . time()) ?>"><span>Reviews</span>
									
									<a href="#" data-target="#reviews" data-toggle="modal" class="pull-right write-review"><img src="<?php echo base_url('assets/n-images/detail/write.png?ver=' . time()) ?>"> <span>Write a review</span></a>
								</div>
								<div class="dtl-dis">
									<div class="total-rev">
										<span class="total-rat">4.8</span> <span class="rating-star">
			<input id="input-21b" value="4" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
												</span>
												<span class="rev-count">59 Reviews</span>
												
												
									</div>
									<ul class="review-list">
										<li>
											<div class="review-left">
												<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>user-pic.jpg">
											</div>
											<div class="review-right">
												<h4>Yatin Belani</h4>
												<div class="rating-star-cus">
													<span class="rating-star">
			<input id="input-21b" value="2" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
												</span>
												</div>
												<div class="review-dis">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. Aenean commodo vitae felis ut dictum.
												</div>
											</div>
										</li>
										
									</ul>
									<div class="form-group">
										
									</div>
									
								</div>
							</div>
						</div>
						
						<!-- 08 How Business Name Started?  -->
						<div class="gallery-item bus-name-started">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>How Business Name Started?</span><a href="#" data-target="#bus-name-started" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<div class="bus-story">
										<img src="<?php echo base_url('assets/n-images/detail/14.jpg?ver=' . time()) ?>">
									</div>
									<ul class="dis-list">
										<li>
											<span>Description</span>
											Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
											<a class="dis-more" href="#"><b>See More..</b> </a>
										</li>
									
										<li>
											<span>What differentiate you from your competitiors</span>
											Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
											<a class="dis-more" href="#"><b>See More..</b> </a>
										</li>
								
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
								
							</div>
						</div>
						
						<!-- 09 Job Openings  -->
						<div class="gallery-item">
							<div class="dtl-box job-opening">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/job-opning.png?ver=' . time()) ?>"><span>Job Openings </span><a href="#" data-target="#" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group">
			<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<a href="#">
				<div class="dis-left">
					<div class="dis-left-img img-cus">
						<img src="<?php echo base_url('assets/n-images/detail/job-def.png?ver=' . time()) ?>">
					</div>
				</div>
				<div class="dis-middle">
					<h4>Digital marketing executive</h4>
					<p>Conception I Technology</p>
				</div>
				</a>
				<div class="dis-right">
					<a href="#"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
				</div>
            </div>
		</div>
											
			</div>
			<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<a href="#">
				<div class="dis-left">
					<div class="dis-left-img img-cus">
						<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
					</div>
				</div>
				<div class="dis-middle">
					<h4>Digital marketing executive</h4>
					<p>Conception I Technology</p>
				</div>
				</a>
				<div class="dis-right">
					<a href="#"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
				</div>
            </div>
		</div>
			</div>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- 10 menu  -->
						
						<!-- 11 News / Press Release  -->
						<div class="gallery-item">
							<div class="dtl-box press-rel">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/news.png?ver=' . time()) ?>"><span>News / Press Release</span><a href="#" data-target="#press-release" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group">
			<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<a href="#">
				<div class="dis-left">
					<div class="dis-left-img img-cus">
						<img src="<?php echo base_url('assets/n-images/detail/press-rel.png?ver=' . time()) ?>">
					</div>
				</div>
				<div class="dis-middle">
					<h4>Digital marketing executive</h4>
				</div>
				</a>
				<div class="dis-right">
					<a href="#" href="#" data-target="#press-release" data-toggle="modal"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
				</div>
            </div>
		</div>
											
			</div>
			<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<a href="#">
				<div class="dis-left">
					<div class="dis-left-img img-cus">
						<img src="<?php echo base_url('assets/n-images/detail/press-rel.png?ver=' . time()) ?>">
					</div>
				</div>
				<div class="dis-middle">
					<h4>Digital marketing executive</h4>
				</div>
				</a>
				<div class="dis-right">
					<a href="#" href="#" data-target="#press-release" data-toggle="modal"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
				</div>
            </div>
		</div>
			</div>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- 12 Achievements and Awards  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/achi-awards.png?ver=' . time()) ?>"><span>Achievements & Awards</span><a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="awards-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="awardsOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>G</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Gujrat yang talant awards</h4>
														<p>Gujrat Sarkar</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#awards-accordion" href="#awards1" aria-expanded="true" aria-controls="awards1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="awards1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="awardsOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Date</span>
															24 June 2018
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="awardstwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>B</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Best Employe of the year</h4>
														<p>Aileensoul pvt ltd</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#awards-accordion" href="#awards2" aria-expanded="true" aria-controls="awards2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="awards2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="awardstwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Date</span>
															24 June 2018
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					
					</div>
                            <div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        </div>
						<div class="right-add">
							<div class="dtl-box p10 dtl-adv">
								<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
							</div>
							<!-- Social Link  -->
					<div class="rsp-dtl-box">
					
						<div class="dtl-box">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/website.png?ver=' . time()) ?>"><span>Social Profile</span><a href="#" data-target="#social-link" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
							</div>
							<div class="dtl-dis">
								<h4>Social</h4>
								<ul class="social-link-list">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/fb.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/in.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pin.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/insta.png?ver=' . time()) ?>.png"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/you.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/git.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
								</ul>
								<h4 class="pt20 fw">Personal</h4>
								<ul class="social-link-list">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- Timeline  -->
						<div class="rsp-dtl-box">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/timeline.png?ver=' . time()) ?>"><span>Timeline</span><a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<div class="no-info">
										<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
										<span>Lorem ipsum its a dummy text and its user to for all.</span>
									</div>
									<div class="fw dtl-more-add">
										<a href="#" data-target="#timeline-cus" data-toggle="modal"><span class="pr10">Add Timeline </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
									</div>
								</div>
								
							</div>
						</div>
					
					<!-- Hours of Operation  -->
					<div class="rsp-dtl-box">
						<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Hours of Operation</span><a href="#" data-target="#hours-opration" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										
										<li>
											<span>Hours of Operation</span>
											 Mon - Sun : 9:00 AM
										</li>
										<li>
											<span>Select opening hours</span>
											Always open
										</li>
										
									</ul>
								</div>
								
							</div>
					</div>
					
					<!-- Add Menu  -->
					<div class="rsp-dtl-box">
						<div class="dtl-box add-menu">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/menu.png?ver=' . time()) ?>"><span>Add Menu</span><a href="#" data-target="#add-menu" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										<li>
											
											<p class="screen-shot">
												<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
											</p>
										</li>
									</ul>
								</div>
								
							</div>
					</div>
							
							
						</div>
					</div>
				</div>
			</div>
        </section>
		</div>
		
	<!---  model basic information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Basic Information</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Business Name</label>
							<input type="text" placeholder="Business Name">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Business Type </label>
									<span class="span-select">
										<select>
											<option>Business Type </option>
											<option>Business Type </option>
											<option>Business Type </option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Business Category / Industry </label>
									<span class="span-select">
										<select>
											<option>Business Category</option>
											<option>Business Category</option>
											<option>Business Category</option>
										</select>
									</span>
								</div>
							</div>
							
						</div>
						
						
						<div class="form-group">
							<label>Business Description </label>
							<textarea type="text" placeholder="Business Description" class="big-"></textarea>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Total Employees </label>
									<span class="span-select">
										<select>
											<option>1 to 10</option>
											<option>10 to 30</option>
											<option>30 to 50</option>
											<option>More than 50</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Year Founded / Established</label>
									<span class="span-select">
										<select>
											<option>2014 </option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Specialties / Extra Benefits<span class="hidden-xs"> / Facilities</span></label>
									<input type="text" placeholder="Extra Benefits-tags">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Payment Mode Accepted</label>
									<span class="span-select">
										<select>
											<option>Cash  </option>
											<option>Online </option>
											<option>Card </option>
											<option>Wallate</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Business Keywords</label>
							<input type="text" placeholder="Business Keywords">
						</div>
						<div class="form-group">
							<label>Mission</label>
							<textarea type="text" placeholder="Mission"></textarea>
						</div>
						<div class="form-group">
							<label>Legal Name</label>
							<input type="text" placeholder="Legal Name">
						</div>
						<div class="form-group">
							<label>Services / Products you offer (Tags)</label>
							<input type="text" placeholder="Services / Products you offer (Tags)">
						</div>
						<div class="form-group">
							<label>Area Served (City)</label>
							<input type="text" placeholder="Area Served">
						</div>
						<div class="form-group">
							<label>Tagline</label>
							<input type="text" placeholder="Tagline">
						</div>
						<div class="form-group">
							<label>Formerly Knowns as</label>
							<input type="text" placeholder="Formerly Knowns as">
						</div>
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Business Portfolio  -->
	<div style="display:none;" class="modal fade dtl-modal" id="bus-portfolio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Business Portfolio</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Title</label>
							<input type="text" placeholder="Title">
						</div>
						<div class="form-group big-textarea">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File () <input type="file">
							</label>
						</div>
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Key Members Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="member-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Key Members Information</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Name</label>
							<input type="text" placeholder="Name">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Job Title</label>
									<input type="text" placeholder="Job Title">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Gender </label>
									<span class="span-select">
										<select>
											<option>Male</option>
											<option>Female</option>
											<option>Other</option>
										</select>
									</span>
								</div>
							</div>
							
						</div>
						<div class="form-group">
							<label>Biography</label>
							<textarea type="text" placeholder="Biography"></textarea>
						</div>
						
						<div class="row pb20">
							<div class="">
								<div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
									<div class="form-group">
										<label>Website</label>
										<span class="span-select">
											<select>
												<option>Facebook</option>
												<option>Google</option>
												<option>Instagram</option>
											</select>
										</span>
									</div>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-7">
									<div class="form-group">
										<label>URL</label>
										<input type="text" placeholder="URL">
									</div>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-1 pl0">
									<label></label>
									<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
										
								</div>
								<div class="fw dtl-more-add">
									<a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload Photo of key member <input type="file">
							</label>
						</div>
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Address Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="add-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Address Information</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Street Address</label>
							<textarea type="text" placeholder="Street Address"></textarea>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<label>Country</label>
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<label>State</label>
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<label>City</label>
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Pincode</label>
							<input type="text" placeholder="Pincode">
						</div>
						<div class="form-group">
							<label>Map Coordinates</label>
							<input type="text" placeholder="Map Coordinates">
						</div>
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">Customers visit my business at my street address.
								<div class="control__indicator">
								</div>
							</label>
						</div>
						<div class="form-group">
							<label>No. of locations 1-5 locations 5+ locations None-online only None-I travel to my customers </label>
							<input type="text" placeholder="Business Type ">
						</div>
						<div class="form-group">
							<label>Differentiate Headquaters and Other location</label>
							<input type="text" placeholder="Business Type ">
						</div>
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Contact Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="contact-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Contact Information</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Contact Person Name / Owner Name</label>
							<input type="text" placeholder="Contact Person Name / Owner Name">
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Designation / Role </label>
									<input type="text" placeholder="Designation / Role">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Contact Number (Add) </label>
									<input type="text" placeholder="Contact Number (Add)">
								</div>
							</div>
							
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Email Id</label>
									<input type="text" placeholder="Email Id">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Website</label>
									<input type="text" placeholder="Website">
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Fax Number</label>
									<input type="text" placeholder="Fax Number">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Toll Free Number</label>
									<input type="text" placeholder="Toll Free Number">
								</div>
							</div>
							
						</div>
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Social Profile  -->
	<div style="display: none;" class="modal fade dtl-modal" id="social-link" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Social Profile</span>
					</div>
					<div class="dtl-dis">
						<div class="fw pb20">
							
							<div class="row">
								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
										<div class="form-group">
											<label>Website</label>
											<span class="span-select">
												<select>
													<option>Facebook</option>
													<option>Google</option>
													<option>Instagram</option>
												</select>
											</span>
										</div>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-7">
										<div class="form-group">
											<label>URL</label>
											<input type="text" placeholder="URL">
										</div>
									</div>
									
									<div class="col-md-1 col-sm-1 col-xs-1 pl0">
										<label></label>
										<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
										
									</div>
									<div class="fw dtl-more-add">
										<a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-11 col-sm-11 col-xs-11">
								<div class="form-group">
									<label>Add Personal Website</label>
									<input type="text" placeholder="Add Personal Website">
								</div>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-1 pl0">
								<label></label>
									<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
							</div>
							<div class="fw dtl-more-add pt15">
										<a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
									</div>
						</div>
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Hours of Operation  -->
	<div style="display:none;" class="modal fade dtl-modal" id="hours-opration" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Hours of Operation</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Select opening hours</label>
							<span class="span-select">
								<select>
									<option>Always open</option>
									<option>On Specified Days</option>
									<option>Appointment needed</option>
								</select>
							</span>
						</div>
						<div class="row">
							<div class="col-md-5 col-sm-5 col-xs-5 fw-479">
								<div class="form-group">
									<label>Hours of Operation </label>
									<span class="span-select">
										<select>
											<option>Sunday</option>
											<option>Monday</option>
											<option>Tuesday</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-5">
								<div class="form-group">
									<label>Time</label>
									<span class="span-select">
										<select>
											<option>9:00 AM </option>
											<option>1:00 PM</option>
											<option>5:00 PM</option>
											<option>7:00 PM</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-5">
								<div class="form-group">
									<label>Time</label>
									<span class="span-select">
										<select>
											<option>9:00 AM </option>
											<option>1:00 PM</option>
											<option>5:00 PM</option>
											<option>7:00 PM</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-2">
								<div class="form-group">
									
									<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
								</div>
							</div>
							<div class="fw dtl-more-add">
								<a href="#"><span class="pr10">Add More Days </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
							</div>
						</div>
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">I am willing to relocate
								<div class="control__indicator">
								</div>
							</label>
						</div>
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Add Menu  -->
	<div style="display:none;" class="modal fade dtl-modal" id="add-menu" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Add Menu</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label class="upload-file">
								Upload File () <input type="file">
							</label>
						</div>
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- modal Reviews  -->
	<div style="display:none;" class="modal fade dtl-modal" id="reviews" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Reviews</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<div class="rev-img">
								<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
							</div>
							<div class="total-rev-top">
								<h4>Harshad Patoliya</h4>
								<span class="rating-star">
			<input id="input-21b" value="4" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
								</span>
							</div>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								<span class="fw">Upload Photo</span> <input type="file">
							</label>
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	<!---  model How Business Name Started?  -->
	<div style="display:none;" class="modal fade dtl-modal" id="bus-name-started" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>How Business Name Started?</span>
					</div>
					<div class="dtl-dis">
						<a href="#"><div class="bus-story no-img-upload">
							<label class="upload-file">
								<img src="<?php echo base_url('assets/n-images/detail/bus-story-upload.png?ver=' . time()) ?>">
							</label>
						</div></a>
						<div class="bus-story">
							<img src="<?php echo base_url('assets/n-images/detail/14.jpg?ver=' . time()) ?>">
						</div>
						<div class="form-group">
									<label>Description</label>
									<textarea type="text" placeholder="Describe your business struggle story"></textarea>
								</div>
						<div class="form-group">
									<label>What differentiate you from your competitiors</label>
									<textarea type="text" placeholder="What differentiate you from your competitiors"></textarea>
								</div>
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	
	<!---  model Timeline custom  -->
	<div style="display:none;" class="modal fade dtl-modal timeline-cus" id="timeline-cus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						
						<a href="#" data-target="#timeline" data-toggle="modal" class=""><img src="<?php echo base_url('assets/n-images/detail/detail-add1.png?ver=' . time()) ?>"><span class="timeline-tital"> Add Timeline</soan></a>
					</div>
					<div class="dtl-dis">
						<section class="cd-horizontal-timeline">
		<div class="timeline">
			<div class="events-wrapper">
				<div class="events">
					<ol>
						<li><a href="#0" data-date="16/01/2014" class="selected">16 Jan<span> </span></a> </li>
						<li><a href="#0" data-date="16/02/2014">16 Feb<span> </span></a></li>
						<li><a href="#0" data-date="16/03/2014">16 Mar<span> </span></a></li>
						<li><a href="#0" data-date="16/04/2014">16 April<span> </span></a></li>
						<li><a href="#0" data-date="16/05/2014">16 May<span></span></a></li>
						<li><a href="#0" data-date="16/06/2014">16 June<span> </span></a></li>
						<li><a href="#0" data-date="16/07/2014">16 July<span> </span></a></li>
						<li><a href="#0" data-date="16/08/2014">16 August<span> </span></a></li>
						<li><a href="#0" data-date="16/09/2014">16 September<span></span></a></li>
						<li><a href="#0" data-date="16/10/2014">16 Octomber<span> </span></a></li>
						<li><a href="#0" data-date="16/11/2014">16 November<span> </span></a></li>
						
					</ol>

					<span class="filling-line" aria-hidden="true"></span>
				</div> <!-- .events -->
			</div> <!-- .events-wrapper -->
				
			<ul class="cd-timeline-navigation">
				<li><a href="#0" class="prev inactive"></a></li>
				<li><a href="#0" class="next"></a></li>
			</ul> <!-- .cd-timeline-navigation -->
		</div> <!-- .timeline -->

		<div class="events-content">
			<ol>
				<li class="selected" data-date="16/01/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/def-timeline.png?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/02/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2015</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/03/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/def-timeline.png?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/04/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/def-timeline.png?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/05/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/06/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/07/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/def-timeline.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/08/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/09/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/def-timeline.png?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/10/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>

				<li data-date="16/11/2014">
					<div class="fw pb20">
						<div class="timeline-left">
							<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
						</div>
						<div class="timeline-right">
							<h2>Horizontal Timeline <a href="#" data-target="#timeline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
							<em>January 16th, 2014</em>
						</div>
						
					</div>
					<p>	
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
					</p>
				</li>
			</ol>
		</div> <!-- .events-content -->
	</section>
						
					</div>	
				</div>	
            </div>
        </div>
    </div>
	
	<!---  model Timeline  -->
	<div style="display:none;" class="modal fade dtl-modal " id="timeline" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Timeline</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Achievements Title</label>
							<input type="text" placeholder="Achievements  Title">
						</div>
						
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<label>Day</label>
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<label>Nonth</label>
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<label>year</label>
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group big-textarea">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File () <input type="file">
							</label>
						</div>
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model News / Press Release  -->
	<div style="display:none;" class="modal fade dtl-modal" id="press-release" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>News / Press Release</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="fw">
							<div class="col-md-11 col-sm-11 col-xs-11">
								<div class="form-group">
									<label>Title</label>
									<input type="text" placeholder="News Title">
								</div>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-1 pl0">
								<label></label>
									<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
							</div>
							</div>
							<div class="fw">
							<div class="col-md-11 col-sm-11 col-xs-11">
								<div class="form-group">
									<label>Add Link</label>
									<input type="text" placeholder="Add Website">
								</div>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-1 pl0">
								<label></label>
									<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
							</div>
							</div>
							
						</div>
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Achievements & Awards  -->
	<div style="display:none;" class="modal fade dtl-modal" id="Achiv-awards" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Achievements & Awards</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Title</label>
							<input type="text" placeholder="Title">
						</div>
						<div class="form-group">
							<label>Organization</label>
							<input type="text" placeholder="Organization">
						</div>
						<div class="row">
							<label class="col-md-12 fw">Awards Date</label>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload File (Achievements & Awards Certificate) <input type="file">
							</label>
						</div>
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
		
            <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
                            <span class="mes"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade message-box" id="query" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="profile-modal-close" id="query" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        $('#main_loader').hide();
        // $('#main_page_load').show();
        $('body').removeClass("body-loader");
    </script>
   
    <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/details.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    <?php } else { ?>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/details.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    <?php } ?>
	<script src="<?php echo base_url('assets/js/timeline.js?ver=' . time()); ?>"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>	
<script src="<?php echo base_url('assets/js/star-rating.js?ver=' . time()); ?>"></script>
	<script>
		var masonryLayout = function masonryLayout(containerElem, itemsElems, columns) {
  containerElem.classList.add('masonry-layout', 'columns-' + columns);
  var columnsElements = [];

  for (var i = 1; i <= columns; i++) {
    var column = document.createElement('div');
    column.classList.add('masonry-column', 'column-' + i);
    containerElem.appendChild(column);
    columnsElements.push(column);
  }

  for (var m = 0; m < Math.ceil(itemsElems.length / columns); m++) {
    for (var n = 0; n < columns; n++) {
      var item = itemsElems[m * columns + n];
      columnsElements[n].appendChild(item);
      item.classList.add('masonry-item');
    }
  }
};

masonryLayout(document.getElementById('gallery'),
document.querySelectorAll('.gallery-item'), 2);



		// mcustom scroll bar
			(function($){
				$(window).on("load",function(){
					
					$(".custom-scroll").mCustomScrollbar({
						autoHideScrollbar:true,
						theme:"minimal"
					});
					
				});
			})(jQuery);
			
			
    </script>
	<script>
        jQuery(document).ready(function () {
            $("#input-21f").rating({
                starCaptions: function (val) {
                    if (val < 3) {
                        return val;
                    } else {
                        return 'high';
                    }
                },
                starCaptionClasses: function (val) {
                    if (val < 3) {
                        return 'label label-danger';
                    } else {
                        return 'label label-success';
                    }
                },
                hoverOnClear: false
            });
            var $inp = $('#rating-input');

            $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'lg',
                showClear: false
            });

            $('#btn-rating-input').on('click', function () {
                $inp.rating('refresh', {
                    showClear: true,
                    disabled: !$inp.attr('disabled')
                });
            });


            $inp.on('rating.change', function () {
                alert($('#rating-input').val());
            });


            $('.rb-rating').rating({
                'showCaption': true,
                'stars': '3',
                'min': '0',
                'max': '3',
                'step': '1',
                'size': 'xs',
                'starCaptions': {0: 'status:nix', 1: 'status:wackelt', 2: 'status:geht', 3: 'status:laeuft'}
            });
            $("#input-21c").rating({
                min: 0, max: 8, step: 0.5, size: "xl", stars: "8"
            });
        });
    </script>

    </body>
</html>
