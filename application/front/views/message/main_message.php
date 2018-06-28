<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>Chat</title>

    <!-- <link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/cupertino/jquery-ui.css'> -->
    <!-- <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js'></script> -->
    <!-- <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js'></script> -->

    <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
    <link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/jquery.mCustomScrollbar.css'>    
    <link rel='stylesheet' href='<?php echo base_url(); ?>assets/chatjs/gab.css'>    
    <link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/common-style.css'>    
    <link rel='stylesheet' href='<?php echo base_url(); ?>assets/n-css/n-commen.css'>    
    <link rel='stylesheet' href='<?php echo base_url(); ?>assets/n-css/n-style.css'>    
    <script src="<?php echo base_url('assets/js/jquery.js?ver=' . time()) ?>"></script>
  </head>
  <body>
  	<?php echo $header_profile; ?>
    
    <!-- <h2 id="login_user"></h2> -->

    <div id='toolbar'>
      <!-- <span class='button' id='new-contact'>add contact...</span> ||
      <span class='button' id='new-chat'>chat with...</span> || 
      <span class='button' id='disconnect'>disconnect</span>-->
    </div>
	<div class="middle-section custom-mob-pd">
		<div class="container">
			<div class="message-main-box">
				<div class="msg-box">
					<div id='roster-area'>
							<div class="msg-search">
								<!-- <input type="text" placeholder="Search"> -->
								<h2>Message</h2>
							</div>
							<ul class="user-msg-list">
							  <?php 
							  foreach ($contact_data as $key => $value)
							  {

								$slug = str_replace("-","_",$value['user_slug']);?>
								<li id="<?php echo $value['user_slug']."-".OPENFIRESERVERDASH; ?>">
									<div class="roster-contact offline">
										<div class="contact-img">
											<?php
											if ($value['user_image'] != '')
			                                { ?> 
			                                    <img src="<?php echo USER_THUMB_UPLOAD_URL . $value['user_image'] . '' ?>" alt="<?php echo $value['first_name'] ?>">
			                                <?php
			                                }
			                                else
			                                {
			                                    if($value['user_gender'] == "M")
			                                    {?>                                
			                                        <img src="<?php echo base_url('assets/img/man-user.jpg') ?>">
			                                    <?php
			                                    }
			                                    if($value['user_gender'] == "F")
			                                    {
			                                    ?>
			                                        <img src="<?php echo base_url('assets/img/female-user.jpg') ?>">
			                                    <?php
			                                    }                                
			                                } ?>
										</div>
										<div class="contact-detail">
											<div class="roster-name"><?php echo ucwords($value['first_name']." ".$value['last_name']) ; ?></div>
											<div class="last-msg">hello how are you.</div>
											<div class="roster-jid"><?php echo $slug."@".OPENFIRESERVER; ?></div>
										</div>
										<div class="msg-time">
											<span>10:55 PM</span>
											
										</div>
									</div>
								</li> 
							  <?php
							  }
							  ?>
							</ul>
					</div>
			
					<div id='chat-area'>
					  <div class="chat-event"></div>
					  <ul>						
					  </ul>
					  <div id="chat-messages"></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
    <!-- login dialog -->
    <div id='login_dialog' class='hidden'>
      <label>JID:</label><input type='text' id='jid' value="p@127.0.0.1">
      <label>Password:</label><input type='password' id='password' value="p">
    </div>

    <!-- contact dialog -->
    <div id='contact_dialog' class='hidden'>
      <label>JID:</label><input type='text' id='contact-jid'>
      <label>Name:</label><input type='text' id='contact-name'>
    </div>

    <!-- chat dialog -->
    <div id='chat_dialog' class='hidden'>
      <label>JID:</label><input type='text' id='chat-jid'>
    </div>

    <!-- approval dialog -->
    <div id='approve_dialog' class='hidden'>
      <p><span id='approve-jid'></span> has requested a subscription
        to your presence.  Approve or deny?</p>
    </div>
  </body>
    <script type="text/javascript">
      var base_url = '<?php echo base_url(); ?>';
      var openfirelink = '<?php echo OPENFIRELINK; ?>';
      var openfireserver = '<?php echo OPENFIRESERVER; ?>';
      var username = '<?php echo str_replace('-','_', $login_userdata['user_slug']); ?>';
    </script>
    <!-- <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script> -->    
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.js'></script>
    <script src='<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.register.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.chatstates.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.mam.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.rsm.js'></script>
    <!-- <script src='scripts/flXHR.js'></script>
    <script src='scripts/strophe.flxhr.js'></script> -->

    <script src='<?php echo base_url(); ?>assets/chatjs/gab.js'></script>
	<script>
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
</html>