var isscroll = true;
app.controller('contactRequestController', function ($scope, $http,$window ) {
    $scope.today = new Date();
    $scope.title = "Contact Request | Aileensoul";
    $scope.user_id = user_id;
    pending_contact_request();
    var offset = "40";
    var processing = false;
    getContactSuggetion(1);
    contactRequestNotification();
    $scope.jobs = {};

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
            var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
            var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
            var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
            var times = hh+''+mm+''+ss;
            var all_html = '';            
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
                            data.mutual_friend.forEach(function(friends){
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
                            });

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
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip"><div class="fw text-center" style="padding-top:85px;min-height:200px"><img src="'+base_url+'assets/images/loader.gif" alt="Loader" style="width:auto;" /></div></div></div>';
    }

    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.4) {
            // isLoadingData = true;
            var page = $scope.jobs.page_number;
            var total_record = $scope.jobs.total_record;
            var perpage_record = $scope.jobs.perpage_record;
    
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.jobs.page_number + 1;
                    getContactSuggetion(pagenum);
                }
            }
        }
    });

    function getContactSuggetion(start) {
        if (isProcessing) {
            return false;
        }
        isProcessing = true;
        $(".sugg_post_load").show();

        // $http.get(base_url + "user_post/getContactAllSuggetion").then(function (success) {
        //     $scope.contactSuggetion = success.data;
        // }, function (error) {});
        $http({
            method: 'POST',
            url: base_url + 'user_post/getContactAllSuggetion?page='+start,            
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $(".sugg_post_load").hide();            
            
            if (success.data.con_sugg_data.length >0 ) {            
                if(start > 1)
                {
                    for (var i in success.data.con_sugg_data) {                            
                        //$scope.searchJob.push(data.latestJobs[i]);
                        //$scope.$apply(function () {
                            $scope.contactSuggetion.push(success.data.con_sugg_data[i]);
                        //});
                    }
                }
                else
                {
                    $scope.contactSuggetion = success.data.con_sugg_data;
                }

                
                isProcessing = false;

                // $scope.contactSuggetion = success.data.con_sugg_data;
                $scope.jobs.page_number = start;
                $scope.jobs.total_record = success.data.total_record;
                $scope.jobs.perpage_record = 40;

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
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
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
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                $scope.contactSuggetion = success.data.con_sugg_data;
                $scope.jobs.page_number = start;
                $scope.jobs.total_record = success.data.total_record;
                $scope.jobs.perpage_record = 40;
            }
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                getContactSuggetion(start);
            },500);
        }, 
        function (complete) {
            $(".sugg_post_load").hide();
        });
    }
    function pending_contact_request() {
        $(".req_post_load").show();
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/pending_contact_request',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $(".req_post_load").hide();
            $("#contactlist").show();
            pending_contact_request = success.data;
            $scope.pending_contact_request_data = pending_contact_request;            
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                pending_contact_request();
            },500);
        });
    }
    function contactRequestNotification() {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/contactRequestNotification',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            contactRequestNotification = success.data;
            $scope.contactRequestNotification = contactRequestNotification;
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                contactRequestNotification();
            },500);
        });
    }
    $scope.confirmContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
                if(socket)
                {
                    socket.emit('user notification',from_id);
                }
            }
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.confirmContact(from_id, index);
            },500);
        });
    }

    $scope.rejectContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=reject',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
                if(socket)
                {
                    socket.emit('user notification',from_id);
                }
            }
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.rejectContact(from_id, index);
            },500);
        });
    }
    $scope.addToContact = function (user_id, suggest) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                $('#item-' + user_id + ' a.btn3').html('Request Sent');
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
                //$('.owl-carousel').trigger('next.owl.carousel');
            }
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.addToContact(user_id, suggest);
            },500);
        });
    }
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
function follow_user(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
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
    if(status == 'confirm')
    {
        $("#pending-con-"+indexCon.slice(0,-6)).remove();
        $.ajax({
            url: base_url + "userprofile/contactRequestAction",        
            type: "POST",
            data: 'from_id='+to_id.slice(0,-6)+'&action=confirm',
            dataType:"JSON",
            success: function (data) {            
                // $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:all;');
                setTimeout(function(){
                    // $(".contact-btn-"+to_id.slice(0, -6)).html(data.button);
                },500);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                setTimeout(function(){
                    contact(elid);
                },500);
            }
        });
    }
    else
    {        
        $(".contact-btn-"+to_id.slice(0, -6)+' a').html('Request sent');
        $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:none;');

        $.ajax({
            url: base_url + "userprofile_page/addToContactNewTooltip",        
            type: "POST",
            data: 'contact_id='+id+'&status='+status+'&to_id='+to_id+'&indexCon='+indexCon+'&elid='+elid,
            dataType:"JSON",
            success: function (data) {            
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
    
}