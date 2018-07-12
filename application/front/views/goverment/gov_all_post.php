<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  

         <?php if (IS_OUTSIDE_CSS_MINIFY == '0'){?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">     
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
         <?php }else{?>
         <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">     
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">
         <?php }?>  
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed gov-all-post">
    <?php echo $header; ?>
     <?php echo $job_header2_border;?>   
     

	<div class="user-midd-section" id="paddingtop_fixed">
		<div class="container padding-360">
			<div class="gov-job-detail-left">
			<div class="gov-job-saved-box">
				<h3>All Government Jobs</h3>
				<div class="contact-frnd-post">
					<ul class="all-job-cat">

						<?php

							foreach ($govjob_category as $gov_key => $gov_value) { ?>
							<li>
							<a href="<?php echo base_url('goverment/allpostdetail/'.$gov_value['id']); ?>">
								<div class="all-job-box">
									<div class="job-box-left">
										<?php if($gov_value['image']){ ?>
										<img src="<?php echo GOV_CATE_IMAGE . $gov_value['image']; ?>">
										<?php }else{?>
										<img src="<?php echo GOV_CATE_NOIMAGE; ?>">
										<?php }?>
									</div>
									<div class="all-job-right">
										<span class="job-name"><?php echo $gov_value['name']?></span>
									</div>
								</div>
							</a>
						</li>							
							<?php } ?>						
					</ul>
				</div>
			</div>
			
			</div>
		
			<div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
					
						
						
						
                </div>
				
		</div>
		
	</div>

  <?php echo $footer;  ?>
</body>
</html>