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
  </head>
  <body>
    
    <h2 id="login_user"></h2>

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
								<input type="text" placeholder="Search">
							</div>
							<ul class="user-msg-list">
							  <?php 
							  foreach ($contact_data as $key => $value)
							  {
								$slug = str_replace("-","_",$value['user_slug']);?>
								<li id="<?php echo $value['user_slug']."-".OPENFIRESERVERDASH; ?>">
									<div class="roster-contact offline">
										<div class="contact-img">
											<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
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
						<div class="contact-img">
							<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
						</div>
						<div class="contact-detail">
							<div class="roster-name"><?php echo ucwords($value['first_name']." ".$value['last_name']) ; ?></div>
							<div class="last-msg">online</div>
						</div>
					  </ul>
					  <div id="chat-messages"></div>
					</div>
				</div>
				
			</div>
			<div class="pt20 fw"></div>
			<div class="message-main-box demo-for-test">
				<div class="msg-box">
					<div id='roster-area'>
							<div class="msg-search">
								<input type="text" placeholder="Search">
							</div>
							<ul class="user-msg-list">
							  
								<li id="<?php echo $value['user_slug']."-".OPENFIRESERVERDASH; ?>">
									<div class="roster-contact offline">
										<div class="contact-img">
											<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
										</div>
										<div class="contact-detail">
											<div class="roster-name">Dhaval Shah</div>
											<div class="last-msg">hello how are you.</div>
											<div class="roster-jid"><?php echo $slug."@".OPENFIRESERVER; ?></div>
										</div>
										<div class="msg-time">
											<span>10:55 PM</span>
											
										</div>
									</div>
								</li> 
								<li id="<?php echo $value['user_slug']."-".OPENFIRESERVERDASH; ?>">
									<div class="roster-contact offline">
										<div class="contact-img">
											<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
										</div>
										<div class="contact-detail">
											<div class="roster-name">Dhaval Shah</div>
											<div class="last-msg">hello how are you.</div>
											<div class="roster-jid"><?php echo $slug."@".OPENFIRESERVER; ?></div>
										</div>
										<div class="msg-time">
											<span>10:55 PM</span>
											
										</div>
									</div>
								</li> 
							
							</ul>
					</div>
			
					<div id='chat-area'>
					  <div class="chat-event"></div>
					  <ul class="fw" style="padding:10px; border-bottom:1px solid #d2d2d2; height:70px;">
						<div class="contact-img">
							<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
						</div>
						<div class="contact-detail">
							<div class="roster-name"><?php echo ucwords($value['first_name']." ".$value['last_name']) ; ?></div>
							<div class="last-msg">online</div>
						</div>
					  </ul>
					  <div id="chat-messages">
						<div class="content custom-scroll">
							<div class="chat-message">
								<div class="chat-name me">
									<div class="contact-img">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
									</div>
									<div class="chat-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
									<div class="msg-send-time">24 june 2018, 11:45 AM </div>
								</div>
								
							</div>
							<div class="chat-message">
								<div class="chat-name">
									
									<div class="chat-text">Lorem Ipsum is simply dummy text of</div>
									<div class="msg-send-time">24 june 2018, 11:45 AM </div>
									<div class="contact-img">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
									</div>
								</div>
								
							</div>
							<div class="chat-message">
								<div class="chat-name me">
									
									<div class="chat-text">Lorem Ipsum is simply dummy text of</div>
									<div class="msg-send-time">24 june 2018, 11:45 AM </div>
									<div class="contact-img">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
									</div>
								</div>
								
							</div>
							<div class="chat-message">
								<div class="chat-name me">
									
									<div class="chat-text">Lorem Ipsum is simply dummy <br> text of</div>
									<div class="msg-send-time">24 june 2018, 11:45 AM </div>
									<div class="contact-img">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
									</div>
								</div>
								
							</div>
							<div class="chat-message">
								<div class="chat-name">
									
									<div class="chat-text">Lorem Ipsum is simply dummy <br> text of</div>
									<div class="msg-send-time">24 june 2018, 11:45 AM </div>
									<div class="contact-img">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1528362125.png">
									</div>
								</div>
								
							</div>
						</div>
					  </div>
					  <div class="btm-snd-msg">
							<div class="comment" name="comments" onpaste="OnPaste_StripFormatting(this, event);" placeholder="Type your message here..." style="position: relative;" contenteditable="true"></div>
							<span class="comment-submit"><button class="btn2">Send</button></span>
						</div>
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
    <script src="<?php echo base_url('assets/js/jquery.js?ver=' . time()) ?>"></script>
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