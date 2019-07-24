app.directive('ddTextCollapse', ['$compile', function($compile) {
    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {
            // start collapsed
            scope.collapsed = false;
            // create the function to toggle the collapse
            scope.toggle = function() {
                scope.collapsed = !scope.collapsed;
            };
            // wait for changes on the text            
            attrs.$observe('ddTextCollapseText', function(text) {
                // get the length from the attributes
                var all_html = $.parseHTML(text);
                var maxLength = scope.$eval(attrs.ddTextCollapseMaxLength);
                if ($(all_html).text().length > maxLength) {
                    // split the text in two parts, the first always showing
                    var firstPart = String($(all_html).text()).substring(0, maxLength);
                    var secondPart = String(text).substring(maxLength, text.length);
                    // create some new html elements to hold the separate info
                    var firstSpan = $compile('<span ng-if="!collapsed">' + firstPart + '</span>')(scope);
                    var secondSpan = $compile('<span ng-if="collapsed">' + text + '</span>')(scope);
                    var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                    var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                    var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : "View more"}}</span>')(scope); //{{collapsed ? "View less" : "View more"}}
                    // remove the current contents of the element
                    // and add the new ones we created
                    element.empty();
                    element.append(firstSpan);
                    element.append(secondSpan);
                    element.append(moreIndicatorSpan);
                    element.append(lineBreak);
                    element.append(toggleButton);
                } else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);
// AUTO SCROLL MESSAGE DIV FIRST TIME END
app.directive('ngEnter', function() { // custom directive for sending message on enter click
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if (event.which === 13 && !event.shiftKey) {
                scope.$apply(function() {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
app.filter('removeLastCharacter', function () {
    return function (text) {
        return text.substr(0, text.lastIndexOf(".") + 1);
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('removeFirstCharacter', function() {
    return function(text) {
        return text.substr(1).toLowerCase();
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.directive("editableText", function() {
    return {
        controller: 'EditorController',
        restrict: 'C',
        replace: true,
        transclude: true,
    };
});
app.filter('parseUrl', function($sce) {
    var urls = /(\b(https:\/\/?|http:\/\/?|ftp:\/\/)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
    var urlswww = /(\b(www.?)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
    var emails = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim
    return function(text, asTrusted) {
        if (text.match(urls)) {
            text = text.replace(urls, "<a href=\"$1\" target=\"_self\">$1</a>")
        } else if (text.match(urlswww)) {
            text = text.replace(urlswww, "<a href=\"//$1\" target=\"_self\">$1</a>")
        }
        if (text.match(emails)) {
            text = text.replace(emails, "<a href=\"mailto:$1\">$1</a>")
        }
        if (asTrusted) {
            return $sce.trustAsHtml(text);
        }
        return text;
    }
});
app.filter('slugify', function() {
    return function(input) {
        if (!input) return;
        // make lower case and trim
        var slug = input.toLowerCase().trim();
        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');
        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');
        return slug;
    };
});
app.controller('EditorController', ['$scope', function($scope) {
    $scope.title = title;
    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
    };
}]);
app.controller('questionDetailsController', function($scope, $http, $window, $filter, $location, $route) {
    $scope.today = new Date();
    $scope.ask = {};
    $scope.user_id = user_id;
    $scope.title = title;
    $scope.live_slug = live_slug;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
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

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
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
    questionData();

    function questionData() {
        $('#main_loader').show();
        $('#loader').show();
        $http.get(base_url + "userprofile_page/question_data/?question=" + question + "&user_slug=" + user_slug).then(function(success) {
            $('#loader').hide();
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            $scope.postData = success.data;
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
        }, function(error) {});
    }
    getFieldList();

    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function(success) {
            $scope.fieldList = success.data;
        }, function(error) {});
    }
    //$scope.category = [];
    $scope.loadCategory = function($query) {
        return $http.get(base_url + 'user_post/get_category', {
            cache: true
        }).then(function(response) {
            var category_data = response.data;
            return category_data.filter(function(category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.openModal2 = function(myModal2Id) {
        document.getElementById(myModal2Id).style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal2 = function(myModal2Id) {
        document.getElementById(myModal2Id).style.display = "none";
        $("body").removeClass("modal-open");
    };
    $scope.plusSlides2 = function(n, myModal2Id) {
        showSlides2(slideIndex += n, myModal2Id);
    };
    $scope.currentSlide2 = function(n, myModal2Id) {
        showSlides2(slideIndex = n, myModal2Id);
    };

    function showSlides2(n, myModal2Id) {
        var i;
        var slides = document.getElementsByClassName("mySlides2" + myModal2Id);
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        var elem = $("#element_load_" + slideIndex);
        $("#myModal" + myModal2Id + " #all_image_loader").hide();
        if (!elem.prop('complete')) {
            $("#myModal" + myModal2Id + " #all_image_loader").show();
            elem.on('load', function() {
                $("#myModal" + myModal2Id + " #all_image_loader").hide();
                // console.log("Loaded!");
                // console.log(this.complete);
            });
        }
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }
    $scope.post_like = function(post_id,parent_index, user_id) {
        $('#post-like-' + post_id).attr('style', 'pointer-events: none;');
        if($('#post-like-' + post_id).hasClass('like'))
        {
            $('#post-like-' + post_id).removeClass('like');
            var like_cnt = $('#post-like-count-' + post_id).html();
            if(parseInt(like_cnt) - 1 < 1)
            {
                $('#post-like-count-' + post_id).hide();
            }
            else
            {
                $('#post-like-count-' + post_id).html(parseInt(like_cnt) - 1);
            }
        }
        else
        {
            $('#post-like-' + post_id).addClass('like');
            $('#post-like-count-' + post_id).show();
            var like_cnt = $('#post-like-count-' + post_id).html();
            $('#post-like-count-' + post_id).html(parseInt(like_cnt) + 1);

        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data.message == 1) {
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }

                $('#post-like-' + post_id).removeAttr('style');
                
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
                        $('#post-like-count-' + post_id).show();
                    }
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }

                $scope.postData[parent_index].user_like_list = success.data.user_like_list;
            }
        });
    }
    $scope.cmt_handle_paste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count = function(post_id, e) {
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.cmt_handle_paste_edit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count_edit = function(cmt_id, e) {
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.sendComment = function(post_id, index, post) {
        $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
        $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
        $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
        $("#cmt-btn-" + post_id).attr("disabled", "disabled");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            var data = $.param({comment:comment,post_id:post_id});
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: data,//'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;                
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }

                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function() {
                    $("#cmt-btn-mob-" + post_id).removeAttr("style");
                    $("#cmt-btn-mob-" + post_id).removeAttr("disabled");
                    $("#cmt-btn-" + post_id).removeAttr("style");
                    $("#cmt-btn-" + post_id).removeAttr("disabled");
                    
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
                
                }, 1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.viewAllComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
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
        });
    }
    $scope.viewLastComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
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
        });
    }
    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    }
    $scope.deleteComment = function(comment_id, post_id, parent_index, index, post) {
        parent_index = 0;
        $(".del_comment").attr("style", "pointer-events:none");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            setTimeout(function() {
                $(".del_comment").removeAttr("style");
            }, 1000);
            // $("#cmt-"+comment_id).hide();
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if (data.comment_count <= 0) {
                $scope.postData[parent_index].post_comment_data = [];
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    }
    $scope.likePostComment = function(comment_id, post_id, comment_user_id) {
        $('#cmt-like-fnc-' + comment_id).attr("style", "pointer-events:none;")
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',comment_user_id);
                }

                $('#cmt-like-fnc-' + comment_id).removeAttr("style");
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    }
    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        /*var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();*/
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        editContent = editContent.substring(0, cmt_maxlength);
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    }

    $scope.edit_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index) {       
        $(".comment-for-post-"+post_id+" .edit-reply-comment").hide();
        $(".comment-for-post-"+post_id+" li[id^=cancel-reply-comment-li-]").hide();
        $(".comment-for-post-"+post_id+" li[id^=edit-reply-comment--]").show();
        // $(".comment-for-post-"+post_id+" .comment-reply-dis-inner").show();

        var editContent = $scope.postData[parent_index].post_comment_data[cmt_index].comment_reply_data[cmt_rpl_index].comment;
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-reply-comment-' + comment_id).show();
        $('#edit-comment-reply-textbox-' + comment_id).html(editContent);
        $('#comment-reply-dis-inner-' + comment_id).hide();
        $('#edit-reply-comment-li-' + comment_id).hide();
        $('#cancel-reply-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.cancel_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index) {
        $('#edit-reply-comment-' + comment_id).hide();        
        $('#comment-reply-dis-inner-' + comment_id).show();
        $('#edit-reply-comment-li-' + comment_id).show();
        $('#cancel-reply-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }

    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj){
        $scope.comment_reply_data = cmt_reply_obj;
        if(login_user_id == 0 && comment_user_id == 0)
        {
            $("#reply-comment-"+post_index+"-"+comment_id).html('');            
        }
        else
        {
            if(login_user_id == comment_user_id)
            {
                $("#reply-comment-"+post_index+"-"+comment_id).html('');                
            }
            else
            {
                var content = '<a class="mention-'+post_index+'-'+comment_id+'" href="'+base_url+cmt_reply_obj.user_slug+'" data-mention="'+window.btoa(cmt_reply_obj.user_slug)+'">'+cmt_reply_obj.username+'</a>&nbsp;';                
                $("#reply-comment-"+post_index+"-"+comment_id).html(content);
            }
        }
        $("#comment-reply-"+post_index+"-"+comment_id).show();   
    };

    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    }    
    $scope.l_page = 0;
    $scope.l_total_record = 0;
    $scope.l_perpage = 7;
    
    $scope.like_post_id = 0;

    $scope.like_user_list = function(post_id) {
        $scope.like_post_id = post_id;
        pagenum = 1;
        
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if($scope.count_likeUser > 0)
            {
                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                $('#likeusermodal').modal('show');
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
        });
    }

    var is_processing = false;

    $scope.like_user_list_loadmore = function(post_id,pagenum) {
        if(is_processing)
        {
            return false;
        }
        is_processing = true;
        $('#like_loader').show();
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $('#like_loader').hide();
            if(success.data.likeuserlist)
            {
                for (var i in success.data.likeuserlist) {
                    $scope.get_like_user_list.push(success.data.likeuserlist[i]);
                }

                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                
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
                is_processing = false;
            }
            
        });
    }

    $('.like-popup-scroll').on('scroll', function () {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var page = $scope.l_page;
            var total_record = $scope.l_total_record;
            var perpage_record = $scope.l_perpage;
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.l_page) + 1;
                    $scope.like_user_list_loadmore($scope.like_post_id,pagenum);
                }
            }
        }
    });

    $scope.IsVisible = false;
    $scope.ShowHide = function() {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }

    $scope.getHashTags = function(inputText) {  
        var regex = /(?:^|\s)(?:#)([a-zA-Z\d]+)/gm;
        var matches = [];
        var match;

        while ((match = regex.exec(inputText))) {
            matches.push(match[1]);
        }

        return matches;
    };
    
    $scope.sendEditComment = function(comment_id, post_id, user_id) {
        var comment = $('#editCommentTaxBox-' + comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentUpdate',
                data: 'comment=' + comment + '&comment_id=' + comment_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',user_id);
                    }

                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-' + post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#reply-comment-'+postIndex+'-'+commentIndex).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        
        var mention = 0;
        var mention_id = 0;

        if($("a.mention-"+postIndex+"-"+commentIndex).data('mention') != undefined && $("a.mention-"+postIndex+"-"+commentIndex).data('mention') != '')
        {
            var cmt_mention = window.atob($("a.mention-"+postIndex+"-"+commentIndex).data('mention'));            
            if(cmt_mention == $scope.comment_reply_data.user_slug){
                mention = 1;
                mention_id = $scope.comment_reply_data.commented_user_id;
            }
        }
        // data: {comment:comment,comment_id:comment_id,post_id:post_id,mention:mention,mention_id:$scope.comment_reply_data.commented_user_id},
        if (comment) {
            $http({
                method: 'POST',
                url: base_url + 'user_post/add_post_comment_reply',
                data: 'comment=' + comment + '&comment_id=' + comment_id + '&post_id=' + post_id + '&mention=' + mention + '&mention_id=' + mention_id+'&comment_reply_id='+$scope.comment_reply_data.comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                // console.log(success.data);
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[postIndex].post_comment_data[commentIndex].commented_user_id);
                    }
                    
                    if (commentClassName == 'last-comment') {
                        // $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data.splice(commentIndex, 1);
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                        
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                        
                        $('.editable_text').html('');
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
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.send_edit_comment_reply = function (reply_comment_id,post_id) {
        var comment = $('#edit-comment-reply-textbox-' + reply_comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $http({
                method: 'POST',
                url: base_url + 'user_post/edit_post_comment_reply',
                data: 'comment=' + comment + '&reply_comment_id=' + reply_comment_id + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {                
                data = success.data;
                if (data.message == '1') {
                    $('#comment-reply-dis-inner-' + reply_comment_id).show();
                    $('#comment-reply-dis-inner-' + reply_comment_id).html(comment);
                    $('#edit-comment-reply-textbox-' + reply_comment_id).html();
                    $('#edit-comment-reply-textbox-' + reply_comment_id).hide();
                    $('#edit-comment-li-' + reply_comment_id).show();
                    $('#cancel-reply-comment-li-' + reply_comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }                
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    
    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    }
    $scope.deletedPost = function(post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                $scope.postData.splice(index, 1);
            }
        });
    }
    $scope.no_login_pop = function() {
        $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Never miss out any opportunities, news, and updates.</h2>Join Now!<p class='poppup-btns'><a class='btn1' href='" + base_url + "login'>Login</a> or <a class='btn1' href='" + base_url + "job-profile/create-account'>Register</a></p></div>");
        $('#bidmodal').modal('show');
    };

    $scope.save_post = function(post_id,index,postData){
        $('.save-post-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/save_user_post',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;
            if(result.status == '1')
            {
                $scope.postData[index].is_user_saved_post = result.status;                
            }
            else
            {
                $scope.postData[index].is_user_saved_post = result.status;
            }
        });
    };
});
$(window).on("load", function() {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
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
        }
    });
}

function follow_user_bus(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-bus-" + uid.slice(0, -6) + ' a').html('Following');
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
    $(".follow-btn-bus-" + uid.slice(0, -6) + ' a').html('Follow');
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
        }
    });
}