app.directive('onErrorSrc', function() {
    return {
        link: function(scope, element, attrs) {
          element.bind('error', function() {
            if (attrs.src != attrs.onErrorSrc) {
              attrs.$set('src', attrs.onErrorSrc);
            }
          });
        }
    }
});
app.controller('businessSearchListController', function ($scope, $http,$compile,$window) {
    $scope.today = new Date();
    
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.businessLocation = {};
    $scope.searchtitle = '';
    $scope.categorysearch = '';
    $scope.locationsearch = '';
    $scope.business = {};
    pagenum = 1;
    var search_data_url = '';
    var isProcessing = false;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
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

                        all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                        // all_html += '<h4>'+data.user_data.fullname+'</h4>';
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

    searchBusiness();

    function load_add(){        
        setTimeout(function(){        
        /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
            $compile($el)($scope);*/
        /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
            $compile($el)($scope);*/
        },2000);
    }

    function businessCategory() {
        $http.get(base_url + "business_live/businessCategory?limit=5").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();

    function otherCategoryCount() {
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();

    // ARTIST CITY FILTER
    function businessLocation(){
        $http.get(base_url + "business_live/businessLocation?limit=5").then(function (success) {
            $(success.data).each(function(i,d){
                d.isselected = false;
            });
            $scope.businessLocation = success.data;
        }, function (error) {});
    }
    businessLocation();

    function searchBusiness() {        
        if (q != '' && l == '') {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'business_live/searchBusinessData?l=' + l;
        } else {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q + '&l=' + l;
        }
        getsearchresultlist(search_data_url,'pageload', pagenum);
    }
    

    // Search result text
    function searchResultText(){
        $scope.categorysearch = q.replace(/,/gi,' And ');
        $scope.locationsearch = l.replace(/,/gi,' And ');
        $scope.searchtitle = ($scope.categorysearch && $scope.locationsearch) ? (' for ' + $scope.categorysearch + ' and ' + $scope.locationsearch) : (($scope.categorysearch) ? $scope.categorysearch : $scope.locationsearch); 
    }
    searchResultText();

    $scope.getfilterbusinessdata = function(){
        var location = "";
        // Get Checked Location of filter and make data value for ajax call
        $('.locationcheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urllocation_id = l.split(",");
                if (urllocation_id.indexOf(currentid) === -1) {
                    location += (location == "") ? currentid : "," + currentid;
                }
            }
        });

        // Get Checked Category of filter and make data value for ajax call
        var category = "";
        $('.categorycheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urlcategory_id = q.split(",");
                if (urlcategory_id.indexOf(currentid) === -1) {
                    category += (category == "") ? currentid : "," + currentid;
                }
            }
        });
        
        if (q != '' && l == '') {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'business_live/searchBusinessData?l=' + l;
        } else {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q + '&l=' + l;
        }

        // if filter apply append id of category and location
        if(location != ""){
            search_data_url += "&location_id=" + location;
        }
        if(category != ""){
            search_data_url += "&category_id=" + category;
        }
        // getsearchresultlist(search_data_url,'filter');
        pagenum = 1;
        isProcessing = false;
        $scope.businessList = {};
        $("#load-more").show();
        $http.get(search_data_url+'&page='+pagenum).then(function (success) {
            $("#load-more").hide();
            $('#main_loader').hide();
            // $('#main_page_load').show();
            //load_add();
            $('body').removeClass("body-loader");
            $scope.businessList = success.data.seach_business;
            $scope.business.page_number = pagenum;
            $scope.business.total_record = success.data.total_record;
            $scope.business.perpage_record = 5;            
            isProcessing = false;
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
        }, function (error) {});
    }

    function getsearchresultlist(search_url, from, pagenum){
        if (isProcessing) {            
            return;
        }
        isProcessing = true;
        $("#load-more").show();
        if(pagenum == 1){            
            $('#main_loader').show();
        }
        $http.get(search_url+'&page='+pagenum).then(function (success) {
            result = success.data;
            $("#load-more").hide();
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");

            if(result.seach_business.length > 0)
            {
                if(pagenum > 1)
                {
                    for (var i in result.seach_business) {
                        // $scope.$apply(function () {
                            $scope.businessList.push(result.seach_business[i]);
                        // });
                    }
                }
                else
                {
                    $scope.businessList = result.seach_business;
                }                    
                $scope.business.page_number = pagenum;
                $scope.business.total_record = result.total_record;
                $scope.business.perpage_record = 5;            
                isProcessing = false;

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
                if(pagenum == 1)
                {                    
                    $scope.businessList = result.seach_business;
                }
                $scope.showLoadmore = false;                
            }
        }, function (error) {});
    }

    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {            
            var page = $scope.business.page_number;
            var total_record = $scope.business.total_record;
            var perpage_record = $scope.business.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.business.page_number + 1;
                    getsearchresultlist(search_data_url, "", pagenum);
                }
            }
        }
    });
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
    $('#q').val(q);
    $('#l').val(l);
});

// change location and category
$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    angular.element(self).scope().getfilterbusinessdata();
});

