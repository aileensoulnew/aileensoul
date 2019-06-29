app.controller('userListController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.businessLocation = {};
    function businessCategory(){
        $http.get(base_url + "business_live/businessCategory?limit=5").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();
    
    // Top 5 Location for filter
    function businessLocation(){
        $http.get(base_url + "business_live/businessLocation?limit=5").then(function (success) {
            $scope.businessLocation = success.data;
        }, function (error) {});
    }
    businessLocation();

    // get list of company based on category or locations
    $scope.getfilterbusinessdata = function(){
        business_userlist(0, "filter");        
    }
});



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

function details_in_popup(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
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

                        all_html += '<h4>'+data.user_data.fullname+'</h4>';
                        all_html += '<p>';
                            if(data.user_data.title_name != '' && data.user_data.degree_name == ''){
                                all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                            }
                            else if(data.user_data.title_name == '' && data.user_data.degree_name != ''){
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

$(document).ready(function () {
    business_userlist();

    $(window).scroll(function () {
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
                    business_userlist(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
var userAjax;
function business_userlist(pagenum, from = "") {
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }

    isProcessing = true;
    var reqdata = getLocationCategoryId();
    userAjax = $.ajax({
        type: 'POST',
        url: base_url + "business_profile/ajax_userlist/?page=" + pagenum + reqdata,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if(from == "filter"){
                $('.contact-frnd-post').html("");
                $('.loader').show();
            }
            if (pagenum == 'undefined') {
                //  $(".contact-frnd-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function () {
            $('#loader').hide();
            $('.loader').remove();
        },
        success: function (data) {
            if(from == "filter"){
                $('.contact-frnd-post').html("");
            }
            $('.contact-frnd-post').append(data);

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
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
                        return details_in_popup(uid,$scope.user_id,utype,div_id);
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
            isProcessing = false;
        }
    });
}


function followuser(id,status,to_id)
{
    $.ajax({
        type: 'POST',
        // url: base_url + "business_profile/follow",
        url: base_url + "user_post/add_business_follow",
        dataType: 'json',
        data: 'follow_id=' + id + '&status=' + status + '&to_id=' + to_id,
        success: function (data) {
            // $('.' + 'fruser' + clicked_id).html(data.follow);
            $('#follow' + to_id).html('Following');
            $('#follow' + to_id).attr('readonly','readonly');
            $('#follow' + to_id).attr('disabled','disabled');
            $('#follow' + to_id).attr('style','pointer-events:none;');
            $('#follow' + to_id).removeAttr('onClick');
            // $('#countfollow').html(data.count);
        }
    });
}

function unfollowuser(clicked_id)
{

    $.ajax({
        type: 'POST',
        //url: '<?php echo base_url() . "business_profile/unfollow" ?>',
        url: base_url + "business_profile/unfollow",

        dataType: 'json',

        data: 'follow_to=' + clicked_id,
        success: function (data) {

            $('.' + 'fruser' + clicked_id).html(data.follow);
            $('#countfollow').html(data.count);

        }
    });
}


$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    if(isProcessing){
        userAjax.abort();
        isProcessing = false;
    }
    angular.element(self).scope().getfilterbusinessdata();
});

function getLocationCategoryId(){
    var location = "";
    // Get Checked Category of filter and make data value for ajax call
    var category = "";
    $('.categorycheckbox').each(function(){
        if(this.checked){
            var currentid = $(this).val();
            category += (category == "") ? currentid : "," + currentid;
        }
    });
    // Get Checked Location of filter and make data value for ajax call
    $('.locationcheckbox').each(function(){
        if(this.checked){
            var currentid = $(this).val();
            location += (location == "") ? currentid : "," + currentid;
        }
    });
    var result = (category != "") ? ("&category_id=" + category) : "";
    result += (location != "") ? ("&location_id=" + location) : "";
    return result;
}

function follow_user_bus(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $.ajax({
        url: base_url + "userprofile_page/business_follow_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-bus-" + uid.slice(0, -6)).html(data);
            },500);
        }
    });
}

function unfollow_user_bus(id) {
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $.ajax({
        url: base_url + "userprofile_page/business_unfollow_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-bus-" + uid.slice(0, -6)).html(data);
            },500);
        }
    });
}