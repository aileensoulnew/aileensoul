<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
<?php
$userid = $this->session->userdata('aileenuser');
$session_user = $this->session->userdata();
$userData = $this->user_model->getUserData($session_user['aileenuser']);
$browser = $this->agent->browser();
$browserVersion = $this->agent->version();
if($browser == "Internet Explorer")
{
    if(explode(".", $browserVersion)[0] < 11)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Chrome")
{            
    if(explode(".", $browserVersion)[0] < 65)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Firefox")
{            
    if(explode(".", $browserVersion)[0] < 55)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
?>
<div class="web-header">
    <?php echo $header_inner_profile ?>
    <?php if ($business_common_data[0]['business_step'] == 4) { ?>
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mob-p0">
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('business-profile/home'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Business Profile</a>
                        </li>
                        <li class="dropdown" id="Inbox_link">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"  onclick="return getmsgNotification()"><i class="fa fa-envelope" aria-hidden="true"></i> Message
                                <span class="noti-box" id="message_count"></span>
                            </a>
                            <div class="dropdown-menu InboxContainer">
                                <div class="dropdown-title">
                                    Messages <a href="#" class="pull-right" id="seemsg">See All</a>
                                </div>
                                <div class="content custom-scroll">
                                    <ul class="dropdown-data msg-dropdown notification_data_in_h2">
                                        
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li id="add-contact" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick="return Notification_contact()"><i class="fa fa-users" aria-hidden="true"></i> Contact
                                <span class="<?php echo ($bus_con_request != '' && $bus_con_request > 0 ? 'noti-box' : '' ); ?>" id="addcontactLink"><?php echo $bus_con_request; ?></span>
                            </a>

                            <div class="dropdown-menu">
                                <div class="dropdown-title">
                                    Contact Request
                                    <a href="contact-list" class="pull-right" id="seecontact">See All</a>
                                    <!-- <a href="all-contact.html" class="pull-right" id="seecontact">See All</a> -->
                                </div>
                                <div class="content custom-scroll">
                                    <ul class="dropdown-data add-dropdown notification_data_in_con">
                                      
                                    </ul>
                                </div>
                            </div>
                        </li>
			            <li class="dropdown user-id">
                            <a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="pr-name">Account</span></a>

                            <ul class="dropdown-menu account">
                                <li>Account</li>
                                <li><a href="<?php echo base_url('business-profile/details/' . $business_login_slug); ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
                                <li><a href="<?php echo base_url('business-profile/registration/business-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
                                <li><a onclick="deactivate(<?php echo $userid; ?>)"><span class="icon-delete edit_data"></span> Deactive Profile</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
                    <div class="job-search-box1 clearfix">
                        <form action="<?php echo base_url('business-profile/search'); ?>" method="get">
                            <fieldset class="sec_h2">
                                <input id="tags" class="tags ui-autocomplete-input" name="skills" placeholder="Companies, Category, Products" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="sec_h2">
                                <input id="searchplace" class="searchplace ui-autocomplete-input" name="searchplace" placeholder="Find Location" autocomplete="off" type="text">
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
     <?php } ?>
</div>
<div class="mobile-header">
    <header class="">
        <div class="animated fadeInDownBig">
            <div class="container">

                <div class="left-header">
                    <h2 class="logo"><a href="#"><img src="<?php echo base_url('assets/n-images/mob-logo.png?ver=' . time()) ?>"></a></h2>
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
                                <a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                        if ($session_user['aileenuser_userimage'] != '')
                                        { ?>
                                            <span class="usr-img profile-brd" id="header-main-profile-pic">
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $session_user['aileenuser_userimage'] ?>" alt="<?php echo $session_user['aileenuser_firstname'] ?>">
                                            </span>
                                        <?php
                                        }
                                        else
                                        { ?>
                                            <span class="usr-img">
                                            <?php
                                            if($userData['user_gender'] == "M")
                                            {?>
                                                <img ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <?php
                                            }
                                            if($userData['user_gender'] == "F")
                                            {
                                            ?>
                                                <img ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            <?php
                                            }?>
                                            </span>
                                            <?php
                                        } ?>
                                    <span class="pr-name"></span>
                                </a>

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

    <?php if ($business_common_data[0]['business_step'] == 4) { ?>
    <div class="sub-header bus-only">
        <div class="container">
            <div class="row">

                <ul class="sub-menu">

                    <li>
                        <a href="<?php echo base_url('business-profile/home'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Business Profile</a>
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

    <?php } ?>


    <div class="mob-bottom-menu">
        <ul>
            <li>
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/n-images/op-bottom.png?ver=' . time()) ?>"></a>
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
     <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right mob-side-menu" id="cbp-spmenu-s2">
        <div class="all-profile-box content custom-scroll">
            <ul class="all-pr-list">
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i1.png?ver=1517557803" alt="Job Profile">
                        </div>
                        <span>Job Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i2.jpg?ver=1517557803" alt="Recruiter Profile">
                        </div>
                        <span>Recruiter Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i3.jpg?ver=1517557803" alt="Freelance Profile">
                        </div>
                        <span>Freelance Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i4.jpg?ver=1517557803" alt="Business Profile">
                        </div>
                        <span>Business Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="all-pr-img">
                            <img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
                        </div>
                        <span>Artistic Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

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
<script type="text/javascript">
    function deactivate(clicked_id) {
        $('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your business profile?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
    function deactivate_profile(clicked_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/deactivate" ?>',
            data: 'id=' + clicked_id,
            success: function (data) {
                window.location = "<?php echo base_url() ?>";
            }
        });
    }
</script>
<script type="text/javascript">
    function Notification_contact() {
        contactperson();
        update_contact_count();
    }
    function contactperson() {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/contact_notification",
            type: "POST",
            dataType: 'json',
            data: '',
            success: function (data) {
                $('.notification_data_in_con').html(data.contactdata);
                $('#seecontact').html(data.seeall);
            }
        });
    }
    function update_contact_count() {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/update_contact_count",
            type: "POST",
            success: function (data) {
                /*$('span[id^=addcontact_count]').html('');
                $('span[id^=addcontact_count]').css({
                    "background-color": "",
                    "padding": "0px"
                });*/
                $('#addcontactLink').html("");
                if (parseInt(data) > 0) {                    
                    $('#addcontactLink').html(data);
                }
                $('#addcontactLink').removeClass('noti-box');
            }
        });
    }
    function contactapprove(toid, status) {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/contact_approve",
            type: "POST",
            data: 'toid=' + toid + '&status=' + status,
            dataType: "json",
            success: function (data) {
                //$('.mCS_no_scrollbar').html(data.contactdata);
                $('.mCustomScrollbar').html(data.contactdata);
                $('.contactcount').html(data.contactcount);
                var segment = '<?php echo $this->uri->segment(2); ?>';
                if (segment == 'contacts') {
                    var slug = '<?php echo $slug_id; ?>';
                    $('.art-img-nn').hide();
                    business_contacts_header(slug);
                }
                var not_contact_count = $('.addcontact-left').length;
                if (not_contact_count == 0) {
                    var data_html = "<li><div class='art-img-nn' id='art-blank'><div class='art_no_post_img'><img src='<?php echo base_url('img/No_Contact_Request.png?ver=' . time()); ?>' alt='No Contact Request'></div><div class='art_no_post_text'>No Contact Request Available.</div></div></li>";
                    $('#notification_main_in').html(data_html);
                    $('#seecontact').hide();
                }
                if (data.co_notification.co_notification_count != 0) {
                    var co_notification_count = data.co_notification.co_notification_count;
                    var co_to_id = data.co_notification.co_to_id;
                    show_contact_notification(co_notification_count, co_to_id);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('#bidmodal').modal('hide');
        }
    });
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#dropdown-content_hover").hide();
        }
    });
</script>
<script type="text/javascript" charset="utf-8">
    function addmsg1(type, msg)
    {
        if (msg == 0)
        {
            $("#message_count").html('');
            $("#message_count").removeAttr("style");
            $('#message_count').removeClass('count_add');
            $('#InboxLink').removeClass('msg_notification_available');
            document.getElementById('message_count').style.display = "none";
        } else
        {
            $('#message_count').html(msg);
            $('#InboxLink').addClass('msg_notification_available');
            $('#message_count').addClass('count_add');
            document.getElementById('message_count').style.display = "block";
        }
    }
    function waitForMsg1()
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>notification/select_msg_noti/6",
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
<script type="text/javascript">
    $(document).ready(function () {
        var InboxContainer = $('#InboxContainer').attr('class');
        if (InboxContainer == 'dropdown2_content show') {
            var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
            if (segment != "chat") {
                chatmsg();
            }
        }
        $('#Inbox_link').on('click', function () {
            chatmsg();
        });
    });
    function chatmsg()
    {
        /*$.ajax({
         type: 'POST',
         url: '<?php //echo base_url() . "chat/userajax/5/5" ?>',
         dataType: 'json',
         data: '',
         success: function (data) {
         
         $('#userlist').html(data.leftbar);
         $('.notification_data_in_h2').html(data.headertwo);
         $('#seemsg').html(data.seeall);
         setTimeout(
         chatmsg,
         25000
         );
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
         }
         });*/

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "chat/userajax/5/5" ?>',
            dataType: 'json',
            data: '',
            success: function (data) {
                $('#userlist').html(data.leftbar);
                $('.notification_data_in_h2').html(data.headertwo);
                $('#seemsg').html(data.seeall);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });

    };
    function getmsgNotification() {
        msgNotification();
    }

    function msgNotification() {
        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_msg_noti/6",
            type: "POST",
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
            data: 'message_from_profile=5&message_to_profile=5',
            success: function (data) {
                $('#' + 'notificationsmsgBody').html(data);
            }
        });

    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        document.getElementById('tags1').value = null;
        document.getElementById('searchplace1').value = null;
    });
</script>
<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
