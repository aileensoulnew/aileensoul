<input class="page_number" type="hidden" value="<?php echo $page; ?>"/>
<input class="total_record" type="hidden" value="<?php echo $total_record; ?>"/>
<input class="perpage_record" type="hidden" value="<?php echo $perpage; ?>"/>
<?php
if (isset($seach_data) && !empty($seach_data)) {
	$counter = 1;
	foreach ($seach_data as $row) {
	?>
	<div class="profile-job-post-detail clearfix">
	    <div class="profile-job-post-title-inside clearfix">
	        <div class="profile-job-profile-button clearfix">
	            <div class="overlay" id="popup1">
	                <div class="popup">
	                    <div class="pop_content">
	                        Your User is Successfully Saved.
	                        <p class="okk">
	                            <a class="okbtn" href="javascript:void(0)">
	                                Ok
	                            </a>
	                        </p>
	                    </div>
	                </div>
	            </div>
	            <div class="profile-job-post-location-name-rec">
	                <div style="display: inline-block; float: left;">
	                    <div class="buisness-profile-pic-candidate">
	                    	<?php
	                    	$imagee = $this->config->item('job_profile_thumb_upload_path') . $row['job_user_image'];
	                    	if (file_exists($imagee) && $row['job_user_image'] != '') {
	                    		?>
	                    		<a href="<?php echo base_url() . 'job-profile/' . $row['slug']; ?>" title="<?php echo $row['fname'] . ' ' . $row['lname']; ?>">
	                            	<img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $row['job_user_image']; ?>" alt="<?php $row[0]['fname'] . ' ' . $row[0]['lname'] ?>">
	                        	</a>
	                        <?php
	                    	}
	                    	else
	                    	{
	                    		$a = $row['fname'];
								$acr = substr($a, 0, 1);

								$b = $row['lname'];
								$acr1 = substr($b, 0, 1);
	                    	?>
	                        <a href="<?php echo base_url() . 'job-profile/' . $row['slug']; ?>" title="<?php echo $row['fname'] . ' ' . $row['lname']; ?>">
	                        	<div class="post-img-profile">
	                        		<?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>
	                        	</div>
	                        </a>
	                    <?php } ?>
	                    </div>
	                </div>
	                <div class="designation_rec fl">
	                    <ul>
	                        <li>
	                            <a class="post_name" href="<?php echo base_url() . 'job-profile/' . $row['slug']; ?>" title="<?php echo $row['fname'] . ' ' . $row['lname']; ?>">
	                                <?php echo ucfirst(strtolower($row['fname'])) . ' ' . ucfirst(strtolower($row['lname'])); ?>
	                            </a>
	                        </li>
	                        <li style="display: block;">
	                            <a class="post_designation" href="javascript:void(0)" title="<?php echo $row['designation']; ?>">
	                                <?php echo (trim($row['designation']) != "" ? $row['designation'] : "Current Work"); ?>
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="profile-job-post-title clearfix">
	        <div class="profile-job-profile-menu">
	            <ul class="clearfix">
	            	<?php
	            	if ($row['work_job_title']) {
	            		$contition_array = array('title_id' => $row['work_job_title']);
						$jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
						if ($jobtitle != "") {?>
	                	<li>
	                		<b>Job Title</b><span><?php echo $jobtitle[0]['name']; ?></span>
	                	</li>
		            	<?php }
		        	}
		        	if ($row['keyskill']) {
	            		$detailes = array();
						$work_skill = explode(',', $row['keyskill']);
						foreach ($work_skill as $skill) {
							$contition_array = array('skill_id' => $skill);
							$skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
							$detailes[] = $skilldata[0]['skill'];
						} ?>
	                	<li>
	                		<b>Skills</b><span><?php echo implode(',', $detailes); ?></span>
	                	</li>
	                	<?php                 	
		        	}
		        	if ($row['work_job_industry']) {

	            		$contition_array = array('industry_id' => $row['work_job_industry']);
						$industry = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');?>
		                <li><b>Industry</b><span><?php echo $industry[0]['industry_name']; ?></span>
		                </li>
		                <?php
		            }
		            if ($row['work_job_city']) {
	            		$cities = array();
						$work_city = explode(',', $row['work_job_city']);
						foreach ($work_city as $city) {
							$contition_array = array('city_id' => $city);
							$citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
							if ($citydata) {
								$cities[] = $citydata[0]['city_name'];
							}
						} ?>
		                <li>
		                	<b>Preferred Cites</b><span><?php echo implode(',', $cities); ?></span>
		                </li>
		                <?php
		            }
	        		$contition_array = array('user_id' => $row['iduser'], 'experience' => 'Experience', 'status' => '1');
					$experiance = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');?>
		                <li>
		                	<b>Total Experience</b><span>
							<?php
							if ($experiance[0]['experience_year'] != '') {
								$total_work_year = 0;
								$total_work_month = 0;
								foreach ($experiance as $work1) {
									$total_work_year += $work1['experience_year'];
									$total_work_month += $work1['experience_month'];
								}
								if ($total_work_month == '12 month' && $total_work_year == '0 year') {
									echo $postdata = '1 year';
								} else {
									$month = explode(' ', $total_work_year);
									$year = $month[0];
									$y = 0;
									for ($i = 0; $i <= $y; $i++) {
										if ($total_work_month >= 12) {
											$year = $year + 1;
											$total_work_month = $total_work_month - 12;
											$y++;
										} else {
											$y = 0;
										}
									}
									$postdata = '' . $year . '';
									$postdata .= '&nbsp';
									$postdata .= 'Year';
									$postdata .= '&nbsp';
									if ($total_work_month != 0) {
										$postdata .= '' . $total_work_month . '';
										$postdata .= '&nbsp';
										$postdata .= 'Month';
									}									
								}
							}
							else {
								if ($row[0]['experience'] == 'Experience') {
									if ($row[0]['exp_y'] != " " && $row[0]['exp_m'] != " ") {
										if ($row[0]['exp_m'] == '12 month' && $row[0]['exp_y'] == '0 year') {
											$postdata = "1 year";
										} else {

											if ($row[0]['exp_y'] != '0 year') {
												$postdata = $row[0]['exp_y'];
											}
											if ($row[0]['exp_m'] != '0 month') {
												$postdata = ' ' . $row[0]['exp_m'];
											}
										}
									}
								}
								if ($row['experience'] == 'Fresher') {							
									$postdata = $row['experience'];							
								}								
							}
							if(trim($postdata) != "")
							{
								echo $postdata;
							}
							else
							{
								$y = explode(" year", $row['exp_y'])[0];
								$m = explode(" month", $row['exp_m'])[0];
								if($m == 12)
								{
									$y = $y + 1;
									echo $y." Year";
								}
								else if($y == 0 && $m > 0)
								{
									echo $m." Month";
								}
								else if($m == 0 && $y > 0)
								{
									echo $y." Year";
								}
								else if($y > 0 && $m > 0)
								{
									echo $y." Year ".$m." Month";
								}
								else
								{
									echo "Fresher";
								}
							}

								?>
		                	</span>
		                </li>
		                <?php
		                $contition_array = array('user_id' => $row['iduser']);
						$jobGraduation = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = '*', $sortby = 'degree_count', $orderby = 'desc', $limit = '1', $offset = '', $join_str = array(), $groupby = '');					
						if(isset($jobGraduation) && !empty($jobGraduation))
						{
							$degree_tag = "Degree";
							$stream_tag = "Stream";

							$degree_name = $this->db->get_where('degree', array('degree_id' => $jobGraduation[0]['degree']))->row()->degree_name;
							$stream_name = $this->db->get_where('stream', array('stream_id' => $jobGraduation[0]['stream']))->row()->stream_name;
						}
						elseif($row['board_higher_secondary'] != "")
						{
							$degree_tag = "Board of Higher Secondary";
							$stream_tag = "Percentage of Higher Secondary";
							$degree_name = $row['board_higher_secondary'];
							$stream_name = $row['percentage_higher_secondary'];
						}
						elseif($row['board_secondary'] != "")
						{
							$degree_tag = "Board of Secondary";
							$stream_tag = "Percentage of Secondary";
							$degree_name = $row['board_secondary'];
							$stream_name = $row['percentage_secondary'];
						}
						elseif($row['board_primary'] != "")
						{
							$degree_tag = "Board of Primary";
							$stream_tag = "Percentage of Primary";
							$degree_name = $row['board_primary'];
							$stream_name = $row['percentage_primary'];
						}
						if($degree_name != "" && $stream_name != ""){
						?>
		                <li>
		                	<b><?php echo $degree_tag; ?></b><span><?php echo $degree_name; ?></span>
		                </li>
	                	<li>
	                		<b><?php echo $stream_tag; ?></b><span><?php echo $stream_name; ?></span>
	                	</li>
	                	<?php } ?>
	                	<li>
	                		<b>E-mail</b><span><?php echo ($row['email'] != "" ? $row['email'] : PROFILENA); ?></span>
	                	</li>
	                	<?php 
	                	if ($row['phnno']) { ?>
	                	<li>
	                		<b>Mobile Number</b><span><?php echo $row['phnno']; ?></span>
	                	</li>
	                	<?php } ?>
	            </ul>
	        </div>
	        <div class="profile-job-profile-button clearfix">
	            <div class="apply-btn fr">
	            	<?php
	            	$userid = $this->session->userdata('aileenuser');
					$contition_array = array('from_id' => $userid, 'to_id' => $row['iduser'], 'save_type' => 1, 'status' => '0');
					$data = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

					if ($userid != $row['iduser'])
					{
						if (!$data)
						{
						?>
		                	<a href="<?php echo base_url() . 'chat/abc/2/1/' . $row['iduser']; ?>" title="Message">Message</a>
		                	<input id="hideenuser<?php echo $row['iduser']; ?>" type="hidden" value="<?php echo $data[0]['save_id']; ?>" />
		                	<a class="saveduser<?php echo $row['iduser']; ?>" href="javascript:void(0);" id="<?php echo $row['iduser']; ?>" onclick="savepopup(<?php echo $row['iduser']; ?>)" title="Save">Save</a>                
		            	<?php 
		            	}
		            	else
		            	{ ?>
							<a href="<?php echo base_url() . 'chat/abc/2/1/' . $row['iduser']; ?>" title="Message">Message</a>
							<a class="saved">Saved</a>
						<?php 
						}
					}
					?>
	            </div>
	        </div>
	    </div>
	</div>
<?php 
		if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") { 
			if($counter % ADS_BREAK == 0)
			{
				?>
				<div class="tab-add">
					<?php $this->load->view('infeed_add'); ?>
				</div>
				<?php
			}
			$counter++;
		}
	}
}
elseif($total_record == 0)
{ ?>
	<div class="text-center rio" style="border: none;">
		<div class="no-post-title">
			<h4 class="page-heading  product-listing" style="border:0px;">Lets create your job post.</h4>
			<h4 class="page-heading  product-listing" style="border:0px;"> It will takes only few minutes.</h4>
		</div>
		<div  class="add-post-button add-post-custom">
			<a title="Post a Job" class="btn btn-3 btn-3b"  href="' . base_url() . 'post-job"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
		</div>
	</div>
<?php
}
elseif($isfilterapply == false && $page == 1)
{ ?>
	<div class="art-img-nn border1">
	    <div class="art_no_post_img">
			<img src="' . base_url() . 'assets/img/job-no1.png" alt="nojobimage">
		</div>
		<div class="art_no_post_text">
			No Recommended  Candidate  Available.
		</div>
	</div>
<?php
} ?>
<div class="col-md-1"></div>