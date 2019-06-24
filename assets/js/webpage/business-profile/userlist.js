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
                        return $($(this).data('tooltip-content')).html();                        
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