/*app.run(['$route', '$rootScope', '$location', function ($route, $rootScope, $location) {
    var original = $location.path;
    $location.path = function (path, reload) {
        if (reload === false) {
            var lastRoute = $route.current;
            var un = $rootScope.$on('$locationChangeSuccess', function () {
                $route.current = lastRoute;
                un();
            });
        }
        return original.apply($location, [path]);
    };
}]);*/
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
                var maxLength = scope.$eval(attrs.ddTextCollapseMaxLength);
                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing
                    var firstPart = String(text).substring(0, maxLength);
                    var secondPart = String(text).substring(maxLength, text.length);
                    // create some new html elements to hold the separate info
                    var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                    var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
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
    $scope.ask = {};
    $scope.user_id = user_id;
    $scope.title = title;
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
    $scope.post_like = function(post_id) {
        $('#post-like-' + post_id).attr('style', 'pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data.message == 1) {
                $('#post-like-' + post_id).removeAttr('style');
                clearInterval(int_not_count);            
                get_notification_unread_count();
                int_not_count = window.setInterval(function(){
                  get_notification_unread_count();
                }, 10000);
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
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                clearInterval(int_not_count);            
                get_notification_unread_count();
                int_not_count = window.setInterval(function(){
                  get_notification_unread_count();
                }, 10000);
                if (data.message == '1') {
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
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    }
    $scope.likePostComment = function(comment_id, post_id) {
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
            clearInterval(int_not_count);            
            get_notification_unread_count();
            int_not_count = window.setInterval(function(){
              get_notification_unread_count();
            }, 10000);
            if (data.message == '1') {
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
    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    }
    $scope.EditPost = function(post_id, post_for, index) {
        $scope.is_edit = 1;
        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.is_edit = 1;
            if (post_for == "opportunity") {
                $scope.opp.description = success.data.opportunity;
                $scope.opp.job_title = success.data.opportunity_for;
                $scope.opp.location = success.data.location;
                $scope.opp.field = success.data.field;
                $scope.opp.edit_post_id = post_id;
                $("#opportunity-popup").modal('show');
            } else if (post_for == "simple") {
                $scope.sim.description = success.data.description;
                $scope.sim.edit_post_id = post_id;
                $("#post-popup").modal('show');
            } else if (post_for == "question") {
                $scope.ask.ask_que = success.data.question;
                $scope.ask.ask_description = success.data.description;
                $scope.ask.related_category = success.data.tag_name;
                $scope.ask.ask_field = success.data.field;
                $scope.ask.edit_post_id = post_id;
                $("#ask-question").modal('show');
            }
        });
    }
    $scope.EditPostQuestion = function(post_id, post_for, index) {
        if (post_for == "question") {
            $('#ask-que-' + post_id).hide();
            $("#edit-ask-que-" + post_id).show();
            $("#ask_que_" + post_id).val($scope.postData[index].question_data.question);
            $("#ask_que_desc_" + post_id).val($scope.postData[index].question_data.description);
            if ($scope.postData[index].question_data.link != "") {
                $scope.IsVisible = true;
                $("#ask_web_link_" + post_id).val($scope.postData[index].question_data.link);
            } else {
                $("#ask_web_link_" + post_id).val("");
            }
            var related_category = [];
            var rel_category = $scope.postData[index].question_data.category.split(",");
            rel_category.forEach(function(element, catArrIndex) {
                related_category[catArrIndex] = {
                    "name": element
                };
            });
            $scope.ask.related_category_edit = related_category;
            if (rel_category.length > 0) {
                $('#ask_related_category_edit' + post_id + ' .input').attr('placeholder', '');
                $('#ask_related_category_edit' + post_id + ' .input').css('width', '200px');
            }
            $(document).on('focusin', '#ask_related_category_edit' + post_id + ' .input', function() {
                if ($('#ask_related_category_edit' + post_id + ' ul li').length > 0) {
                    $(this).attr('placeholder', '');
                    $(this).css('width', '200px');
                }
            });
            $(document).on('focusout', '#ask_related_category_edit' + post_id + ' .input', function() {
                if ($('#ask_related_category_edit' + post_id + ' ul li').length > 0) {
                    $(this).attr('placeholder', '');
                    $(this).css('width', '200px');
                }
                if ($('#ask_related_category_edit' + post_id + ' ul li').length == 0) {
                    $(this).attr('placeholder', 'Related Category');
                    $(this).css('width', '200px');
                }
            });
            //$("#ask_related_category_edit"+post_id).val(related_category);
            var ask_field = $scope.postData[index].question_data.field;
            if (ask_field != null) {
                $('[id=ask_field_' + post_id + '] option').filter(function() {
                    return ($(this).text() == ask_field);
                }).prop('selected', true);
            } else {
                $scope.ask.ask_field = 0
                var ask_other = $scope.postData[index].question_data.others_field;
                setTimeout(function() {
                    $('[id=ask_field_' + post_id + '] option').filter(function() {
                        return ($(this).text() == 'Other');
                    }).prop('selected', true);
                    $("#ask_other_" + post_id).val(ask_other);
                }, 100)
            }
            // var editContent = $('#simple-post-description-' + post_id).attr("dd-text-collapse-text");
            // $('#editPostTexBox-' + post_id).html(editContent);
            // setTimeout(function(){
            //     //$('#editPostTexBox-' + post_id).focus();
            //     setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            // },100);
        }
    }
    $scope.like_user_list = function(post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            $('#likeusermodal').modal('show');
        });
    }
    $scope.IsVisible = false;
    $scope.ShowHide = function() {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }
    $scope.ask_question_check = function(event, queIndex) {
        if (document.getElementById("ask_edit_post_id_" + queIndex)) {
            var post_id = document.getElementById("ask_edit_post_id_" + queIndex).value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {} else {
            var ask_que = document.getElementById("ask_que_" + post_id).value;
            var ask_que = ask_que.trim();
            if ($scope.IsVisible == true) {
                var ask_web_link = $("#ask_web_link_" + post_id).val();
            } else {
                var ask_web_link = "";
            }
            var ask_que_desc = $('#ask_que_desc_' + post_id).val();
            /*ask_que_desc = ask_que_desc.replace(/&nbsp;/gi, " ");
            ask_que_desc = ask_que_desc.replace(/<br>$/, '');
            ask_que_desc = ask_que_desc.replace(/&gt;/gi, ">");
            ask_que_desc = ask_que_desc.replace(/&/g, "%26");*/
            ask_que_desc = ask_que_desc.trim();
            var related_category_edit = $scope.ask.related_category_edit;
            var fields = $("#ask_field_" + post_id).val();
            if (fields == 0) var ask_other = $("#ask_other_" + post_id).val();
            else var ask_other = "";
            var ask_is_anonymously = ($("#ask_is_anonymously" + post_id + ":checked").length > 0 ? 1 : 0);
            if ((fields == '') || (ask_que == '')) {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function(e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {
                var form_data = new FormData();
                form_data.append('question', ask_que);
                form_data.append('description', ask_que_desc);
                form_data.append('field', fields);
                form_data.append('other_field', ask_other);
                form_data.append('category', JSON.stringify(related_category_edit));
                form_data.append('weblink', ask_web_link);
                form_data.append('post_for', "question");
                form_data.append('is_anonymously', ask_is_anonymously);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data, {
                    transformRequest: angular.identity,
                    headers: {
                        'Content-Type': undefined,
                        'Process-Data': false
                    }
                }).then(function(success) {
                    if (success) {
                        $("#edit-ask-que-" + post_id).hide();
                        $("#ask-que-" + post_id).show();
                        $scope.postData[queIndex].question_data = success.data.question_data;
                        var queUrl = $filter('slugify')(success.data.question_data.question);
                        //$location.path("/questions/"+success.data.question_data.id+"/"+queUrl,false);
                        //$location.update_path("/questions/"+success.data.question_data.id+"/"+queUrl);
                        $window.location.href = base_url + "questions/" + success.data.question_data.id + "/" + queUrl;
                        //$route.current = base_url+"questions/"+success.data.question_data.id+"/"+queUrl;
                        //$scope.getQuestions();
                        /*if (success.data.response == 1) {
                            $('#ask-post-question-' + post_id).html(success.data.ask_question);
                            $('#ask-post-description-' + post_id).html(success.data.ask_description);
                            //   $('#ask-post-link-' + post_id).html(success.data.opp_field);
                            $('#ask-post-category-' + post_id).html(success.data.ask_category);
                            $('#ask-post-field-' + post_id).html(success.data.ask_field);
                        }*/
                    }
                });
            }
        }
    }
    $scope.sendEditComment = function(comment_id, post_id) {
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
});
$(window).on("load", function() {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});