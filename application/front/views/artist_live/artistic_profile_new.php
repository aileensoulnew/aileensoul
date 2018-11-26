<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<?php echo $head; ?>
		<?php
		if (IS_ART_CSS_MINIFY == '0') {
			?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
			
		<?php }else{?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
			
		<?php }?>  
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
		<!-- END HEADER -->
	<?php $this->load->view('adsense'); ?>
</head>
	<body class="page-container-bg-solid page-boxed botton_footer body-loader">
		<?php $this->load->view('page_loader'); ?>
		<div id="main_page_load" style="display: block;">
			<?php echo $header; ?>
			<?php //echo $art_header2_border; ?>
			<?php echo $artistic_header2; ?>
			<section class="custom-row">
				<?php echo $artistic_common; ?>
				<div class="container mobp0">
					<div class="all-detail-custom">
					
						<div class="custom-user-list">
							<div class="edit-profile-mob">
								
							</div>
					<div class="all-detail-custom">
					<div class="gallery" id="gallery">
						
						<!--  01 Bio  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bio.png?ver=' . time()) ?>"><span>Bio</span><a href="#" data-target="#bio" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<h4>About</h4>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took Lorem Ipsum has been the industry's standard dummy text of. standard dummy text ever since the 1500s<a href="#"><b>See More..</b></a></p>
								</div>
							</div>
						</div>
						
						<!--  02 Edit profile  -->
						<div class="gallery-item">
						</div>
						
						<!--  03 Basic information  -->
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
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. <a href="#">Read More</a>
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
											<span>Specialties / Extra Benefits / Ambience / Facilities Tags</span>
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
						
						<!--  04 Language  -->
						<div class="gallery-item">
						</div>
						
						<!--  05 Type of talant  -->
						<div class="gallery-item">
						</div>
						
						<!--  06 Educational Info  -->
						<div class="gallery-item">
							<div class="dtl-box edu-info">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Educational Info</span><a href="#" data-target="#educational-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="edu-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="eduOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Vinay mandir high school</h4>
														<p>Bechalr of engineering</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#educational-info" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu1" aria-expanded="true" aria-controls="project1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
												</div>
											</div>
											<div id="edu1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="eduOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
																Feb 2015 to June 2017
														</li>
														<li>
															<span>Board / University</span>
																Gujrat University
																
														</li>
														<li>
															<span>Course / Field of Study / Stream</span>
																Coputer Science
														</li>
														<li>
															<span>Degree Certificate</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="edutwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Vivekanand high school</h4>
														<p>Gseb board</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#educational-info" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu2" aria-expanded="true" aria-controls="project2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
					 
												</div>
											</div>
											<div id="edu2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="edutwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
																Feb 2015 to June 2017
														</li>
														<li>
															<span>Board / University</span>
																Gujrat University
																
														</li>
														<li>
															<span>Course / Field of Study / Stream</span>
																Coputer Science
														</li>
															
															
														<li>
															<span>Degree Certificate</span>
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
						
						<!--  07  Experience  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/exp.png?ver=' . time()) ?>"><span>Experience (4year 5month)</span><a href="#" data-target="#experience" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="exp-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="expOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Verv System PVT LTD</h4>
														<p>Working as Sr.multimedia dsigner </p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#experience" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp1" aria-expanded="true" aria-controls="exp1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="exp1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="expOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Time Period</span>
															Jun 2015 to March 2015
															
														</li>
														<li>
															<span>Company Location</span>
															Ahmedabad, India
															
														</li>
														<li>
															<span>Website</span>
															<a href="#">www.vervsystem.com</a>
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
											<div class="panel-heading" role="tab" id="exptwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Verv System PVT LTD</h4>
														<p>Working as Sr.multimedia dsigner </p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#experience" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp2" aria-expanded="true" aria-controls="exp2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="exp2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="exptwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Time Period</span>
															Jun 2015 to March 2015
															
														</li>
														<li>
															<span>Company Location</span>
															Ahmedabad, India
														</li>
														<li>
															<span>Website</span>
															<a href="#">www.vervsystem.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.png?ver=' . time()) ?>">
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
						
						<!--  08 Portfolio  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-portfolio.png?ver=' . time()) ?>"><span>Art Portfolio</span><a href="#" data-target="#art-portfolio" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
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
														<a href="#" data-target="#dtl-project" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
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
																<img src="n-images/art-img.jpg">
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
														<a href="#" data-target="#dtl-project" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
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
						
						<!--  09 social profile  -->
						<div class="gallery-item">
						</div>
						
						<!--  10 Preferred Work   -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/pre-work.png?ver=' . time()) ?>"><span>Preferred Work </span><a href="#" data-target="#preferred-work" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										<li class="select-preview">
											<span>Work Type</span>
											<label>Category</label>
										</li>
										<li class="fw">
											<span>Skills</span>
											<ul	class="skill-list">
												<li>HTML</li>
												<li>HTML</li>
												<li>HTML</li>
											</ul>
										</li>
										<li>
											<span>Preferred Location</span>
											Ahmedabad , Gujarat , India
										</li>
										<li class="select-preview">
											<span>Availability</span>
											<label>Full Time</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						<!--  11 Specialities  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/speci.png?ver=' . time()) ?>"><span>Specialities</span><a href="#" data-target="#specialities" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										
										<li class="fw">
											<span>Tags</span>
											<ul	class="skill-list">
												<li>HTML</li>
												<li>HTML</li>
												<li>HTML</li>
											</ul>
										</li>
										<li>
											<span>Description</span>
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. <b><a href="#">Read More...</a></b>
										</li>
									
									</ul>
								</div>
								
							</div>
						</div>
						
						<!--  12 software  -->
						<div class="gallery-item">
						</div>
						
						<!--  13 Achievements and Awards  -->
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.png?ver=' . time()) ?>">
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.png?ver=' . time()) ?>">
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
						
						<!--  14 Additional Course  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/add-course.png?ver=' . time()) ?>"><span>Additional Course</span><a href="#" data-target="#additional-course" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detial-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="course-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="courseOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>M</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Master of performing art</h4>
														<p>Upasna Technology</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#additional-course" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#course-accordion" href="#course1" aria-expanded="true" aria-controls="course1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="course1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="courseOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															June 2016 to april 2018
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.loremipsum.com</a>
														</li>
														
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="<?php echo base_url('assets/n-images/detail/art-img.png?ver=' . time()) ?>">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="coursetwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>I</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Indian Air force</h4>
														<p>Air force india</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#additional-course" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#course-accordion" href="#course2" aria-expanded="true" aria-controls="course2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="course2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="coursetwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															June 2016 to april 2018
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.loremipsum.com</a>
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
					</div>
					</div>
					<div class="right-add">
					<!-- Availability  -->
						<div class="rsp-dtl-box">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/availability.png?ver=' . time()) ?>"><span>Availability</span><a href="#" data-target="#availability" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
								</div>
							</div>
						</div>
							
						<div class="dtl-box p10 dtl-adv">
								<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
						</div>
							
					<!-- edit profile  -->
					<div class="rsp-dtl-box">
						<div class="dtl-box">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>"><span>Edit Profile</span>
							</div>
							<div class="dtl-dis dtl-edit-p">
								<div class="dtl-edit-top"></div>
								<div class="profile-status">
									<ul>
										<li><span class=""></span>Profile pic</li>
										<li class="pl20"><span class=""><img src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Cover pic</li>
										
										<li><span class=""></span>Experience</li>
										<li class="pl20"><span class=""><img src="n-images/detail/c.png"></span>About</li>
										<li><span class=""><img src="n-images/detail/c.png"></span>skills</li>
										
										<li class="pl20"><span class=""></span>Social</li>
										<li><span class=""><img src="n-images/detail/c.png"></span>Idol</li>
										<li class="fw"><span class=""><img src="n-images/detail/c.png"></span>Educational info</li>
										<li class="fw"><span class=""></span>Profile overview</li>
									</ul>
								</div>
								<div class="dtl-edit-bottom"></div>
								<div class="p20">
								<img src="<?php echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>">
								</div>
								
							</div>
						</div>
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
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/insta.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/you.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/git.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
								</ul>
								<h4 class="pt20 fw">Personal</h4>
								<ul class="social-link-list">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?><?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- language  -->
					<div class="rsp-dtl-box">
						<div class="rsp-dtl-box ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/language.png?ver=' . time()) ?>"><span>Language</span><a href="#" data-target="#language" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="known-language">
										<li><span class="pr5">Hindi</span> - <span class="pl5">Basic</span></li>
										<li><span class="pr5">English</span> - <span class="pl5">Intermediate</span></li>
										<li><span class="pr5">Gujrati</span> - <span class="pl5">Expert</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Software / Instrument/ Skills  -->
						<div class="rsp-dtl-box">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/software.png?ver=' . time()) ?>"><span>Software / Instrument/ Skills</span><a href="#" data-target="#art-sof" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										<li class="fw">
											<span>Tags</span>
											<ul	class="skill-list">
												<li>HTML</li>
												<li>HTML</li>
												<li>HTML</li>
											</ul>
										</li>
									</ul>
								</div>
								
							</div>
						</div>
					
					<!-- Type of Talent / Category  -->
						<div class="rsp-dtl-box">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/talent.png?ver=' . time()) ?>"><span>Type of Talent / Category</span><a href="#" data-target="#talent" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										<li class="fw">
											<span>Skills</span>
											<ul	class="skill-list">
												<li>HTML</li>
												<li>HTML</li>
												<li>HTML</li>
											</ul>
										</li>
									</ul>
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
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Name</label>
									<input type="text" placeholder="Name">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" placeholder="Last Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Art category</label>
									<span class="span-select">
										<select>
											<option>IT Sector </option>
											<option>Female </option>
											<option>Other </option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Gender</label>
									<span class="span-select">
										<select>
											<option>Male </option>
											<option>Female </option>
											<option>Other </option>
										</select>
									</span>
								</div>
							</div>
							
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Email</label>
									<input type="text" placeholder="Email">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Phone number</label>
									<input type="text" placeholder="Phone number">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Date of Birth</label>
							</div>
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
											<option>year</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
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
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!--  model tagline  -->
	<div style="display: none;" class="modal fade dtl-modal" id="tagline" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Tagline</span>
					</div>
					<div class="dtl-dis">
						<label>Enter tagline</label>
						<textarea type="text" placeholder="Enter tagline"></textarea>
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!--  model bio  -->
	<div style="display: none;" class="modal fade dtl-modal" id="bio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Bio</span>
					</div>
					<div class="dtl-dis">
						<label>About</label>
						<textarea type="text" placeholder="Enter tagline"></textarea>
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!--  model Type of Talent / Category  -->
	<div style="display: none;" class="modal fade dtl-modal" id="talent" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Type of Talent / Category</span>
					</div>
					<div class="dtl-dis">
						<label>Tags</label>
						<input type="text" placeholder="Enter category">
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	
	<!---  model Art Portfolio  -->
	<div style="display:none;" class="modal fade dtl-modal" id="art-portfolio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Art Portfolio</span>
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
	
	<!--  Availability  -->
	<div style="display: none;" id="availability" class="modal fade dtl-modal in" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Availability</span>
                        </div>
                        <div class="dtl-dis">                                
                            <div class="form-group">
                                <!-- Use This! #just fix width+height IMG  -->
                                <div class="mm-dropdown">
                                  <div class="textfirst">
                                    <span ng-if="job_basic_info.job_active_status == '1'">
                                        <span class="job-active"></span>Open for Work
                                    </span>
                                    <span ng-if="job_basic_info.job_active_status == '2'">
                                        <span class="job-passive"></span>Open for Collaboration
                                    </span>
                                    <span ng-if="job_basic_info.job_active_status == '3'">
                                        <span class="job-not"></span>Not Now
                                    </span>
                                    <span ng-if="job_basic_info.job_active_status != '1' && job_basic_info.job_active_status != '2' && job_basic_info.job_active_status != '3'">
                                        Select Status
                                    </span>
                                  </div>
                                  <ul>
                                    <li class="input-option" data-value="1">
                                        <span class="job-active"></span>Currently Looking for Job
                                    </li>
                                    <li class="input-option" data-value="2">
                                        <span class="job-passive"></span>Passively Looking for Job
                                    </li>
                                    <li class="input-option" data-value="3">
                                        <span class="job-not"></span>Not Open for Opportunities
                                    </li>
                                  </ul>
                                  <input id="job_status" type="hidden" class="option" name="namesubmit" value="{{job_basic_info.job_active_status}}" />
                                </div>
                                <!-- End This -->
                            </div>
                            
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="job_imp_save" href="#" ng-click="job_imp_save()" class="save"><span>Save</span></a>
                            <div id="job_imp_save_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="http://localhost/aileensoulnew/aileensoul/assets/images/loader.gif" alt="Loader">
                            </div>
                        </div>
                    </div>  


                </div>
            </div>
        </div>
	
	
	<!--  model Preferred Work  -->
	<div style="display: none;" class="modal fade dtl-modal" id="preferred-work" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Preferred Work</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Work Type</label>
							<span class="span-select">
								<select>
									<option>Category</option>
									<option>IT Sector</option>
									<option>IT Sector</option>
									<option>IT Sector</option>
									<option>IT Sector</option>
								</select>
							</span>
						</div>
						<div class="form-group">
							<label>Skills</label>
							<input type="text" placeholder="Skills">
						</div>
						<div class="row">
							<div class="col-md-12 fw">
								<label>Preferred Location</label>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Country</option>
											<option>India</option>
											<option>Pakistan</option>
											<option>Nepal</option>
											<option>Bhutan</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>State</option>
											<option>Gujarat</option>
											<option>Rajastan</option>
											<option>Delhi</option>
											<option>Panjab</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>City</option>
											<option>Ahmedabad</option>
											<option>Rajkot</option>
											<option>Baroda</option>
											<option>Rajkot</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Availability</label>
							<span class="span-select">
								<select>
									<option>Full time</option>
									<option>Part time</option>
									<option>Contract</option>
									<option>Freelance</option>
								</select>
							</span>
						</div>
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Educational Info  -->
	<div style="display: none;" class="modal fade dtl-modal" id="educational-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Educational Info</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>School / College Name</label>
							<input type="text" placeholder="School / College Name">
						</div>
						<div class="form-group">
							<label>Board / University</label>
							<input type="text" placeholder="Board / University">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Degree / Qualification </label>
									<input type="text" placeholder="Degree / Qualification ">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Course / Field of Study / Stream </label>
									<input type="text" placeholder="Course / Field of Study / Stream">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
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
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
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
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">If You are not graduate click here.
								<div class="control__indicator"></div>
							</label>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File (Educational Certificate)<input type="file">
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
	
	<!---  model Experience  -->
	<div style="display: none;" class="modal fade dtl-modal" id="experience" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Experience</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Name</label>
									<input type="text" placeholder="Enter Company Name">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Designation / Role</label>
									<input type="text" placeholder="Enter Designation">
								</div>
							</div>
						</div>
						<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Company Website</label>
											<input type="text" placeholder="Enter Company Website">
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Field </label>
											<span class="span-select">
												<select>
													<option>Select Field</option>
													<option>It Field</option>
													<option>Design</option>
													<option>Advertizing</option>
												</select>
											</span>
										</div>
									</div>
								</div>
					
						<div class="form-group">
							<label>Company Location</label>
							<input type="text" placeholder="Enter Company Location">
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
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
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
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
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">I currently work here.
								<div class="control__indicator">
								</div>
							</label>
						</div>
						<div class="form-group">
							<label>Description/Roles and Responsibilities</label>
							<textarea row="4" type="text" placeholder="Description">							</textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File (work experience certificate) <input type="file">
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
	
	<!---  model specialities  -->
	<div style="display:none;" class="modal fade dtl-modal" id="specialities" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Specialities</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Tags</label>
							<input type="text" placeholder="Tags">
						</div>
						<div class="form-group big-textarea">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						
						
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Software / Instrument/ Skills  -->
	<div style="display:none;" class="modal fade dtl-modal" id="art-sof" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Software / Instrument/ Skills</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Tags</label>
							<input type="text" placeholder="tags">
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
	
	<!---  model Additional Course  -->
	<div style="display: none;" class="modal fade dtl-modal" id="additional-course" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Additional Course</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Course Name</label>
							<input type="text" placeholder="Course Name">
						</div>
						<div class="form-group">
							<label>Organization</label>
							<input type="text" placeholder="Organization">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
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
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
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
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>URL</label>
							<input type="text" placeholder="Enter URL">
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload File (Additional Course Certificate) <input type="file">
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
		
	<!---  model language  -->
	<div style="display: none;" class="modal fade dtl-modal in" id="language" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Language</span>
					</div>
					<div class="dtl-dis">
						<div class="fw pb20">
							
							<div class="row">
								<div class="">
									<div class="width-45">
										<div class="form-group">
											<label>Language</label>
											<input placeholder="language" type="text">
										</div>
									</div>
									<div class="width-45">
										<div class="form-group">
											<label>Proficiency</label>
											<span class="span-select">
												<select>
													<option>Basic</option>
													<option>Intermediate</option>
													<option>Expert</option>
												</select>
											</span>
										</div>
									</div>
									<div class="width-10">
										<label></label>
										<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
										
									</div>
									<div class="fw dtl-more-add">
										<a href="#"><span class="pr10">Add More languages </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
									</div>
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
		
			<!-- Bid-modal  -->
			<div class="modal fade message-box biderror" id="bidmodal" role="dialog">
				<div class="modal-dialog modal-lm">
					<div class="modal-content">
						<button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
						<div class="modal-body">
							<span class="mes"></span>
						</div>
					</div>
				</div>
			</div>
			<!-- Model Popup Close -->
			<!-- Bid-modal-2  -->
			<div class="modal fade message-box" id="bidmodal-2" role="dialog">
				<div class="modal-dialog modal-lm">
					<div class="modal-content">
						<button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
						<div class="modal-body">
							<span class="mes">
								<div id="popup-form">
									<form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
										<div class=" ">

											<div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>

											<input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
										</div>
										<div class="col-md-7 text-center">
											<div id="upload-demo-one" style="width:350px; display: none"></div>
										</div>
										<input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
									</form>
								</div>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!-- Model Popup Close -->

			<?php echo $login_footer ?>
			<?php echo $footer; ?>

			<!-- script for skill textbox automatic start (option 2)-->
			<?php
			if (IS_ART_JS_MINIFY == '0') { ?>
				<script  src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
				<script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
				<script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
			<?php }else{?>

				<script src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
				<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
				<script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>

			<?php }?>
			
			
			<script>
				var base_url = '<?php echo base_url(); ?>';   
				var data= <?php echo json_encode($demo); ?>;
				var data1 = <?php echo json_encode($de); ?>;
				var data= <?php echo json_encode($demo); ?>;
				var data1 = <?php echo json_encode($city_data); ?>;
				var slug = '<?php echo $artid; ?>';
								
				$('#main_loader').hide();
				$('#main_page_load').show();
				$('body').removeClass("body-loader");
			</script>
			<script>
    // page scroll top 
            $(document).ready(function () {
                $('html,body').animate({scrollTop: 300}, 500);
            });
</script>

			<?php
			if (IS_ART_JS_MINIFY == '0') { ?>
				<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
				<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/details.js?ver='.time()); ?>"></script>

			<?php }else{?>
				<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
				<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/details.js?ver='.time()); ?>"></script>
			<?php }?>
			<script>
				var header_all_profile = '<?php echo $header_all_profile; ?>';
			</script>
			
			<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>
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


			
    </script>
	<script type="text/javascript">
            $(function() {
              // Set
              var main = $('div.mm-dropdown .textfirst')
              var li = $('div.mm-dropdown > ul > li.input-option')
              var inputoption = $("div.mm-dropdown .option")
              var default_text = 'Select Status';

              // Animation
              main.click(function() {
                main.html(default_text);
                li.toggle();
              });

              // Insert Data
              li.click(function() {
                // hide
                li.toggle();
                var livalue = $(this).data('value');
                var lihtml = $(this).html();
                main.html(lihtml);
                inputoption.val(livalue);
              });
            });

        </script>
		
	</body>
</html>
