

 <!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <?php echo $head; ?>
   
  
     <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
              <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
                 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
        <?php } ?>
   
   </head>
   <body>


 <?php echo $header; ?>

 <?php echo $recruiter_header2_border; ?>
 <div class="user-midd-section" id="paddingtop_fixed">    <div class="container" id="paddingtop_fixed">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="text_center">
    				<div class="sory_image">
    					<img src="<?php echo base_url('assets/img/sorry_img.png'); ?>" alt="<?php echo 'SORRYIMAGE'; ?>">
    				</div>
    				<div class="not_founde_head">Sorry !</div>
    				<div class="not_founde_head2">we coundn’t find any matches with your input.</div>
    			</div>
    		</div>
    	</div>
    </div>
    </div>
      </body>
      </html>