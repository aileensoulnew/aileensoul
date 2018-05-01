<?php
$userid = $this->session->userdata('aileenuser');
?>
<div class="web-header">
	<?php echo $header_inner_profile ?>
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6 mob-p0">
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url('freelance-work/home'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Freelance Profile</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope" aria-hidden="true" onclick="return getmsgNotification()"></i> Message
								<span class="noti-box" id="message_count">1</span>
							</a>
							<div class="dropdown-menu">
								<div class="dropdown-title">
									Messages <a href="#" class="pull-right" id="seemsg">See All</a>
								</div>
								<div class="content custom-scroll">
									<ul class="dropdown-data msg-dropdown notification_data_in_h2">
										
									</ul>
								</div>
							</div>
						</li>
						<li class="dropdown user-id">
							<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="pr-name">Account</span></a>

							<ul class="dropdown-menu account">
								<li>Account</li>
								<li><a href="<?php echo base_url('freelance-work/freelancer-details'); ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
								<li><a href="<?php echo base_url('freelance-work/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
								<li><a href="#" onclick="deactivate(<?php echo $userid; ?>)"><span class="icon-delete edit_data"></span> Deactive Profile</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
					<div class="job-search-box1 clearfix">
						<form action="<?php echo base_url('freelance-hire/search'); ?>" method="get">
							<fieldset class="sec_h2">
								<input id="tags" class="tags ui-autocomplete-input skill_keyword" name="skills" placeholder="Companies, Category, Products" autocomplete="off" type="text">
							</fieldset>
							<fieldset class="sec_h2">
								<input id="searchplace" class="searchplace ui-autocomplete-input skill_keyword" name="searchplace" placeholder="Find Location" autocomplete="off" type="text">
							</fieldset>
							<fieldset class="new-search-btn">
								<label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
								<input id="search_btn" style="display: none;" name="search_submit" value="Search" onclick="return checkvalue()" type="submit">
							</fieldset>
						</form>    
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<div class="mobile-header">
	<header class="">
		<div class="animated fadeInDownBig">
			<div class="container">

				<div class="left-header">
					<h2 class="logo">
						<a href="#">
							<img src="<?php echo base_url('assets/n-images/mob-logo.png?ver=' . time()) ?>">
						</a>
					</h2>
					<div class="search-mob-block">
						
						<a href="#search">
							<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
						</a>
						
						<div id="search">
							
							<form method="get">
								<div class="new-search-input">
									<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
									<input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="Find Location" />
								</div>
								<div class="new-search-btn">
									<button type="button" class="close-new btn">Cancel</button>
									<button type="submit" id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
								</div>
							</form>
						</div>
					</div>
					<div class="right-header">
						<ul>
							<li class="dropdown user-id">
								<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="usr-img"><img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>"></span><span class="pr-name"></span></a>

								<ul class="dropdown-menu profile-dropdown">
									<li>Account</li>
									<li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
									<li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>


			</div>
		</div>

	</header>


	<div class="sub-header bus-only">
		<div class="container">
			<div class="row">

				<ul class="sub-menu">

					<li>
						<a href="#"><i class="fa fa-home" aria-hidden="true"></i> Artistic Profile</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope" aria-hidden="true"></i><span class="none-sub-menu"> Message</span>
							<span class="noti-box">1</span>
						</a>

					</li>

					<li id="add-contact" class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i> <span class="none-sub-menu">Contact</span>
							<span class="noti-box">1</span>
						</a>


					</li>
					<li class="dropdown user-id">
						<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="pr-name"><span class="none-sub-menu"> Account</span></span></a>

						<ul class="dropdown-menu account">
							<li>Account</li>
							<li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
							<li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>


			</div>
		</div>

	</div>




	<div class="mob-bottom-menu">
		<ul>
			<li>
				<a href="opportunities.html"><img src="<?php echo base_url('assets/n-images/op-bottom.png?ver=' . time()) ?>"></a>
			</li>
			<li id="add-contact" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('assets/n-images/add-contact-bottom.png?ver=' . time()) ?>">
					<span class="noti-box">1</span>
				</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('assets/n-images/message-bottom.png?ver=' . time()) ?>">
					<span class="noti-box">1</span>
				</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('assets/n-images/noti-bottom.png?ver=' . time()) ?>">
					<span class="noti-box">1</span>
				</a>
			</li>
			<li>
				<button id="showRight"><img src="<?php echo base_url('assets/n-images/mob-menu.png?ver=' . time()) ?>"></button>
			</li>


		</ul>
	</div>
</div>

<!-- Bid-modal  -->
<div class="modal fade message-box biderror" id="bidmodal" role="dialog">
	<div class="modal-dialog modal-lm deactive">
		<div class="modal-content">
			<button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
			<div class="modal-body">
			 
				<span class="mes"></span>
			</div>
		</div>
	</div>
</div>
<!-- Model Popup Close -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>" ></script>
<script type="text/javascript">
	function deactivate(clicked_id) {
	 
		$('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your Freelancer Hire profile?<div class='model_ok_cancel'><a title='yes' class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a title='No' class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
		$('#bidmodal').modal('show');
	}
	function deactivate_profile(clicked_id) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . "freelance-work/deactivate" ?>',
			data: 'id=' + clicked_id,
			success: function (data) {
				window.location = "<?php echo base_url() ?>";

			}
		});
	}
</script>


<!-- all popup close close using esc start -->
<script type="text/javascript">
	$(document).on('keydown', function (e) {
		if (e.keyCode === 27) {
			$("#dropdown-content_hover").hide();
		}
	});
	$(document).on('keydown', function (e) {
		if (e.keyCode === 27) {

			$('#bidmodal').modal('hide');
		}
	});

</script>
<!-- all popup close close using esc end -->
<script type="text/javascript" charset="utf-8">

	function addmsg1(type, msg)
	{
		if (msg == 0)
		{ 
			$("#message_count").html('');
			$("#message_count").removeAttr("style");
			$('#InboxLink').removeClass('msg_notification_available');
			document.getElementById('message_count').style.display = "none";
		} else
		{
			$('#message_count').html(msg);
			$('#InboxLink').addClass('msg_notification_available');
			$('#message_count').addClass('count_add');
			document.getElementById('message_count').style.display = "block";
			//alert("welcome");
		}
	}

	function waitForMsg1()
	{
		$.ajax({
			type: "GET",
			url: "<?php echo base_url(); ?>notification/select_msg_noti/4",

			async: true,
			cache: false,
			timeout: 50000,

			success: function (data) {
				addmsg1("new", data);
				setTimeout(
					waitForMsg1,
					10000
					);
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			}
		});
	}
	;

	$(document).ready(function () {
		waitForMsg1();

	});
	$(document).ready(function () {
		$menuLeft = $('.pushmenu-left');
		$nav_list = $('#nav_list');

		$nav_list.click(function () {
			$(this).toggleClass('active');
			$('.pushmenu-push').toggleClass('pushmenu-push-toright');
			$menuLeft.toggleClass('pushmenu-open');
		});
	});

</script>
<!-- script for fetch all unread message notification end-->

<!-- script for update all read msg notification start-->
<script type="text/javascript">
	
   $(document).ready(function () {
	  
	 var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
	 if(segment != "chat"){ chatmsg(); };
		   });  // khyati chnages  start
   function chatmsg()
   {             
			 // khyati chnages  start
			 
			 $.ajax({
				type: 'POST',
				url: '<?php echo base_url() . "chat/userajax/3/4" ?>',
				dataType: 'json',
				data: '',
				success: function (data) { //alert(data);

					$('#userlist').html(data.leftbar);
					$('.notification_data_in_h2').html(data.headertwo);
					$('#seemsg').html(data.seeall);
					setTimeout(
						chatmsg,
						10000000000000
						);
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
				}           
			});
			 
		 };

		 function getmsgNotification() {
			msgNotification();
		//msgheader();
	}

	function msgNotification() {
		// first click alert('here'); 
		$.ajax({
			url: "<?php echo base_url(); ?>notification/update_msg_noti/4",
			type: "POST",
			//data: {uid: 12341234}, //this sends the user-id to php as a post variable, in php it can be accessed as $_POST['uid']
			success: function (data) {
				data = JSON.parse(data);
			}
		});
	}
	function msgheader()
	{
		
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . "notification/msg_header/" . $this->uri->segment(3) . "" ?>',
			data: 'message_from_profile=3&message_to_profile=4',
			success: function (data) {
				$('.' + 'notification_data_in_h2').html(data);
			}
		});

	}
</script>
 <!-- all message notification header end -->