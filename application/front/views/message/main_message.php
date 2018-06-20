<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
          "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>Chat - Chapter 6</title>

    <!-- <link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/cupertino/jquery-ui.css'> -->
    <!-- <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js'></script> -->
    <!-- <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js'></script> -->

    <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
    <script src="<?php echo base_url('assets/js/jquery.js?ver=' . time()) ?>"></script>
    <!-- <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script> -->
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.register.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.chatstates.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.mam.js'></script>
    <script src='<?php echo base_url(); ?>assets/chatjs/strophe.rsm.js'></script>
    <!-- <script src='scripts/flXHR.js'></script>
    <script src='scripts/strophe.flxhr.js'></script> -->

    <link rel='stylesheet' href='<?php echo base_url(); ?>assets/chatjs/gab.css'>
    <script src='<?php echo base_url(); ?>assets/chatjs/gab.js'></script>
  </head>
  <body>
    <h1>Chat</h1>
    <h2 id="login_user"></h2>

    <div id='toolbar'>
      <!-- <span class='button' id='new-contact'>add contact...</span> ||
      <span class='button' id='new-chat'>chat with...</span> || -->
      <span class='button' id='disconnect'>disconnect</span>
    </div>

    <div id='chat-area'>
      <div class="chat-event"></div>
      <ul></ul>
      <div id="chat-messages"></div>
    </div>
    
    <div id='roster-area'>
      <ul></ul>
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
</html>