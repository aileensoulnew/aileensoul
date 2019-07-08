$(document).ready(function () {
    business_followers(slug_id);

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
       // if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){

            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }                
                //if ($(".page_number:last").val() <= $(".total_record").val()) {
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    business_followers(slug_id, pagenum);
                }
            }
        }
    });
});
var isProcessing = false;

function details_in_popup(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                var today = new Date();
                var hh = today.getHours() < 10 ? '0'+today.getHours() : today.getHours();
                var mm = today.getMinutes() < 10 ? '0'+today.getMinutes() : today.getMinutes();
                var ss = today.getSeconds() < 10 ? '0'+today.getSeconds() : today.getSeconds();
                var times = hh+''+mm+''+ss;
                // var times = today.getHours()+''+today.getMinutes()+''+today.getSeconds();
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }
                // console.log(data);
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip"><div class="fw text-center" style="padding-top:85px;min-height:200px"><img src="'+base_url+'assets/images/loader.gif" alt="Loader" style="width:auto;" /></div></div></div>';
}
function business_followers(slug_id, pagenum)
{
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/ajax_followers/" + slug_id + '?page=' + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                $(".contact-frnd-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.contact-frnd-post').append(data);

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
            $('#main_loader').hide();
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return details_in_popup(uid,user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });
            },500);
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                business_followers(slug_id, pagenum);
            },500);
        }
    });
}

function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}
function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}

/* FOLLOW USER START */
function followuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            var res = JSON.parse(data);
            $('.' + 'fr' + clicked_id).html(res.follow_html);
            $('#' + 'frfollow' + clicked_id).html(res.follow_html);
            $('.contactcount').html(res.contacts_count);
            if(my_profile == 1)
            {
                $('#countfollower').html("("+res.follower_count+")");
                $('#countfollow').html("("+res.following_count+")");
                // $('#' + 'frfollow' + clicked_id).html(data);
               // $('.' + 'fr' + clicked_id).html(data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                followuser_two(clicked_id);
            },500);
        }
    });
}

function followuser_list_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            var res = JSON.parse(data);
            $('#' + 'frfollow' + clicked_id).html(res.follow_html);
            $('.contactcount').html(res.contacts_count);
            if(my_profile == 1)
            {
                $('#countfollower').html("("+res.follower_count+")");
                $('#countfollow').html("("+res.following_count+")");
                // $('#' + 'frfollow' + clicked_id).html(data);
               // $('.' + 'fr' + clicked_id).html(data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                followuser_list_two(clicked_id);
            },500);
        }
    });
}
/* FOLLOW USER END */

/* UNFOLLOW USER START */
function unfollowuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            var res = JSON.parse(data);
            $('.' + 'fr' + clicked_id).html(res.unfollow_html);
            $('#' + 'frfollow' + clicked_id).html(res.unfollow_html);
            $('.contactcount').html(res.uncontacts_count);
            if(my_profile == 1)
            {
                $('#countfollower').html("("+res.unfollower_count+")");
                $('#countfollow').html("("+res.unfollowing_count+")");
               // $('.' + 'fr' + clicked_id).html(data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                unfollowuser_two(clicked_id);
            },500);
        }
    });
}
function unfollowuser_list_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            var res = JSON.parse(data);
            $('#' + 'frfollow' + clicked_id).html(res.unfollow_html);
            $('.contactcount').html(res.uncontacts_count);
            if(my_profile == 1)
            {
                $('#countfollower').html("("+res.unfollower_count+")");
                $('#countfollow').html("("+res.unfollowing_count+")");
               // $('.' + 'fr' + clicked_id).html(data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                unfollowuser_list_two(clicked_id);
            },500);
        }
    });
}
/* UNFOLLOW USER END */
$(document).ready(function () {
    $('html,body').animate({scrollTop: 330}, 500);
});
//For Scroll page at perticular position js End
// scroll page script end 
// contact person script start 

function contact_person_menu(clicked_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/contact_person_menu",
        data: 'toid=' + clicked_id,
        success: function (data) {
            $('#' + 'statuschange' + clicked_id).html(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                contact_person_menu(clicked_id);
            },500);
        }
    });
}
// contact person script end 

function removecontactuser(clicked_id) {
    var showdata = window.location.href.split("/").pop();
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/removecontactuser",
        dataType: 'json',
        data: 'contact_id=' + clicked_id + '&showdata=' + showdata,
        success: function (data) {
            $('#' + 'statuschange' + clicked_id).html(data.contactdata);
            if (data.notfound == 1) {
                if (data.notcount == 0) {
                    $('.' + 'contact-frnd-post').html(data.nomsg);
                } else {
                    $('#' + 'removecontact' + clicked_id).fadeOut(4000);
                }
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                removecontactuser(clicked_id);
            },500);
        }
    });
}

function contact_person_cancle(clicked_id, status) {
    if (status == 'confirm') {
        $('.biderror .mes').html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='removecontactuser(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    } else if (status == 'pending') {
        $('.biderror .mes').html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person_menu(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
}

function contact_person_query(clicked_id, status) {
    $.ajax({
        type: 'POST',
        //url: '<?php echo base_url() . "business_profile/contact_person_query" ?>',
        url: base_url + "business_profile/contact_person_query",
        data: 'toid=' + clicked_id + '&status=' + status,
        success: function (data) { //alert(data);
            // return data;
            contact_person_model(clicked_id, status, data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                contact_person_query(clicked_id, status);
            },500);
        }
    });
}

function contact_person_model(clicked_id, status, data) {
    if (data == 1) {
        if (status == 'pending') {
            $('.biderror .mes').html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
        } else if (status == 'confirm') {
            $('.biderror .mes').html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
        } else {
            contact_person(clicked_id);
        }
    } else {
        $('#query .mes').html("<div class='pop_content'>Sorry, we can't process this request at this time.");
        $('#query').modal('show');
    }
}

function contact_person(clicked_id) {

    $.ajax({
        type: 'POST',
        //url: '<?php echo base_url() . "business_profile/contact_person" ?>',
        url: base_url + "business_profile/contact_person",

        data: 'toid=' + clicked_id,
        success: function (data) {
            //   alert(data);
            $('#contact_per').html(data);

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                contact_person(clicked_id);
            },500);
        }
    });
}

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#query').modal('hide');
        //$('.modal-post').show();
    }
});

function follow_user(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-user-" + uid.slice(0, -6) + ' a').html('Following');
    $.ajax({
        url: base_url + "userprofile_page/follow_user_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-user-" + uid.slice(0, -6)).html(data);
            },500);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                follow_user(id);
            },500);
        }
    });
}

function unfollow_user(id) {
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-user-" + uid.slice(0, -6) + ' a').html('Follow');
    $.ajax({
        url: base_url + "userprofile_page/unfollow_user_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-user-" + uid.slice(0, -6)).html(data);
            },500);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                unfollow_user(id);
            },500);
        }
    });
}
function contact(elid)
{
    var params = $("#"+elid).data('param').split(",");
    var id = params[0];
    var status = params[1];
    var to_id = params[2];
    var indexCon = params[3];
    var confirm = params[4];

    
    $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:none;');

    $.ajax({
        url: base_url + "userprofile_page/addToContactNewTooltip",        
        type: "POST",
        data: 'contact_id='+id+'&status='+status+'&to_id='+to_id+'&indexCon='+indexCon+'&elid='+elid,
        dataType:"JSON",
        success: function (data) {
            console.log(data);
            $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".contact-btn-"+to_id.slice(0, -6)).html(data.button);
            },500);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                contact(elid);
            },500);
        }
    });
}