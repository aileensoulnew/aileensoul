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
app.filter('removeLastCharacter', function() {
    return function(text) {
        return text.substr(0, text.lastIndexOf(".") + 1);
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('capitalize', function() {
    return function(input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.controller('EditorController', ['$scope', function($scope) {
    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
    };
}]);
app.controller('postDetailsController', function($scope, $http, $window, $filter, $location, $route) {
    $scope.ask = {};
    $scope.title = "Post | Aileensoul";
    $scope.user_id = user_id;
    $scope.opp = {};
    loadPostData();

    function loadPostData() {
        $('#loader').show();
        $http.get(base_url + "user_post/post_data/?post_id=" + post_id).then(function(success) {
            $('#loader').hide();
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            $scope.postData = success.data;
            setTimeout(function() {
                $('video,audio').mediaelementplayer( /* Options */ );
            }, 300);
        }, function(error) {});
    }
    getFieldList();

    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function(success) {
            $scope.fieldList = success.data;
        }, function(error) {});
    }
    $scope.job_title = [];
    $scope.loadJobTitle = function($query) {
        return $http.get(base_url + 'user_post/get_jobtitle', {
            cache: true
        }).then(function(response) {
            var job_title = response.data;
            return job_title.filter(function(title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.location = [];
    $scope.loadLocation = function($query) {
        return $http.get(base_url + 'user_post/get_location', {
            cache: true
        }).then(function(response) {
            var location_data = response.data;
            return location_data.filter(function(location) {
                return location.city_name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.category = [];
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
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();
        }
    });
    $scope.post_like = function(post_id,parent_index) {
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
            $scope.postData[parent_index].user_like_list = success.data.user_like_list;
            setTimeout(function() {
                $('#post-like-' + post_id).removeAttr('style');
            }, 100);
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
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
            $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-" + post_id).attr("disabled", "disabled");
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
                clearTimeout(int_not_count);            
                get_notification_unread_count();
                int_not_count = setTimeout(function(){
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
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
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
            clearTimeout(int_not_count);            
            get_notification_unread_count();
            int_not_count = setTimeout(function(){
              get_notification_unread_count();
            }, 10000);
            if (data.message == '1') {
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
            setTimeout(function() {
                $('#cmt-like-fnc-' + comment_id).removeAttr("style");
            }, 100);
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
    $scope.EditPostNew = function(post_id, post_for, index) {
        $("span[id^=simple-post-description-]").show();
        $("div[id^=edit-simple-post-]").hide();
        $("div[id^=post-opp-detail-]").show();
        $("div[id^=edit-opp-post-]").hide();
        $("div[id^=ask-que-]").show();
        $("div[id^=edit-ask-que-]").hide();
        //$("div[id^=main-post-]  .post-images").show();
        //$("#main-post-"+post_id+ " .post-images").hide();
        if (post_for == "simple") {
            $("#edit-simple-post-" + post_id).show();
            var editContent = $scope.postData[index].simple_data.description //$('#simple-post-description-' + post_id).attr("ng-bind-html");

            // $scope.sim.sim_title_edit = $scope.postData[index].simple_data.sim_title
            $("#sim_title").val($scope.postData[index].simple_data.sim_title);
            
            var hashtags = "";
            if($scope.postData[index].simple_data.hashtag != '')
            {
                hashtags = $scope.postData[index].simple_data.hashtag;
                hashtags = '#'+hashtags.replace(/,/ig,' #');
            }
            // $scope.sim.sim_hashtag_edit = hashtags;//$scope.postData[index].simple_data.hashtag
            $("#sim_hashtag"+$scope.postData[index].post_data.id).val(hashtags);

            $('#editPostTexBox-' + post_id).html(editContent.replace(/(<([^>]+)>)/ig, ""));
            setTimeout(function() {
                //$('#editPostTexBox-' + post_id).focus();
                setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            }, 100);
            $('#simple-post-description-' + post_id).hide();
        } else if (post_for == "opportunity") {
            var edit_location = [];
            var edit_jobtitle = [];
            var opportunity = $scope.postData[index].opportunity_data.opportunity; //$("#opp-post-opportunity-" + post_id).attr("dd-text-collapse-text");
            var job_title = $('#opp-post-opportunity-for-' + post_id).html().split(",");
            var city_names = $('#opp-post-location-' + post_id).html().split(",");
            var field = ($scope.postData[index].opportunity_data.field == null || $scope.postData[index].opportunity_data.field == "" ? "Other" : $scope.postData[index].opportunity_data.field); //$('#opp-post-field-' + post_id).html();
            if (opportunity != "" && opportunity != undefined) {
                //$("#description_edit_" + post_id).val(opportunity.replace(/(<([^>]+)>)/ig,""));
                $("#description_edit_" + post_id).html(opportunity.replace(/(<([^>]+)>)/ig, ""));
            }
            city_names.forEach(function(element, cityArrIndex) {
                edit_location[cityArrIndex] = {
                    "city_name": element
                };
            });
            $scope.opp.location_edit = edit_location;
            job_title.forEach(function(element, jobArrIndex) {
                edit_jobtitle[jobArrIndex] = {
                    "name": element
                };
            });
            $scope.opp.job_title_edit = edit_jobtitle;
            $scope.opp.opptitleedit = $scope.postData[index].opportunity_data.opptitle;
            $("#opptitleedit" + post_id).val($scope.postData[index].opportunity_data.opptitle);

            $scope.opp.company_name_edit = $scope.postData[index].opportunity_data.company_name;

            if (city_names.length > 0) {
                $('#location .input').attr('placeholder', '');
                $('#location .input').css('width', '200px');
            }
            if (job_title.length > 0) {
                $('#job_title .input').attr('placeholder', '');
                $('#job_title .input').css('width', '200px');
            }
            $('[id=field_edit' + post_id + '] option').filter(function() {
                return ($(this).text() == field); //To select Blue
            }).prop('selected', true);
            $("#description_edit_" + post_id).focus();
            setTimeout(function() {
                $("#company_name_edit").val($scope.postData[index].opportunity_data.company_name);    
                //$('#description_edit_' + post_id).focus();                
                setCursotToEnd(document.getElementById('description_edit_' + post_id));
            }, 100);
            $("#edit-opp-post-" + post_id).show();
            $('#post-opp-detail-' + post_id).hide();
        } else if (post_for == "question") {
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
                $scope.ask.ask_field_edit = 0
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
            if (success.data.countlike > 0) {
                $('#likeusermodal').modal('show');
            }
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
                //$scope.postData.splice(index, 1);
                window.location = base_url;
            }
        });
    }

    function setCursotToEnd(el) {
        el.focus();
        if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
            var range = document.createRange();
            range.selectNodeContents(el);
            range.collapse(false);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (typeof document.body.createTextRange != "undefined") {
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(el);
            textRange.collapse(false);
            textRange.select();
        }
    }
    $scope.post_something_check = function(event, postIndex = -1) {
        //alert(postIndex);return false;
        if (document.getElementById("edit_post_id" + postIndex)) {
            var post_id = document.getElementById("edit_post_id" + postIndex).value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {} else {
            var description_check = $('#editPostTexBox-' + post_id).text();

            var description = $('#editPostTexBox-' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");
            //var description = $("#editPostTexBox-"+post_id).val();//$scope.sim.description_edit;//document.getElementById("description").value;            
            description = description.trim();

            var sim_title = $('#sim_title').val();
            var sim_hashtag = $('#sim_hashtag'+post_id).val();//$scope.sim.sim_hashtag_edit;

            if ((sim_title == '' || sim_title == undefined) && (sim_hashtag == '' || sim_hashtag == undefined) && description_check.trim() == '')
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            }
            var form_data = new FormData();
            form_data.append('description', description);
            form_data.append('post_for', $scope.postData[postIndex].post_data.post_for);
            form_data.append('sptitle', sim_title);
            form_data.append('hashtag', sim_hashtag);
            form_data.append('post_id', post_id);
            $('body').removeClass('modal-open');
            $("#post-popup").modal('hide');
            $http.post(base_url + 'user_post/edit_post_opportunity', form_data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined,
                    'Process-Data': false
                }
            }).then(function(success) {
                if (success) {
                    $("#post_something_edit")[0].reset();
                    if (success.data.response == 1) {
                        $scope.postData[postIndex].simple_data.description = success.data.sim_description;
                        //$('#simple-post-description-' + post_id).html(success.data.sim_description);
                        //$('#simple-post-description-' + post_id).attr("dd-text-collapse-text",success.data.sim_description);
                        $('#edit-simple-post-' + post_id).hide();
                        $('#simple-post-description-' + post_id).show();
                        $("#main-post-" + post_id + " .post-images").show();
                    }
                }
            });
            //}
        }
    }
    $scope.post_opportunity_check = function(event, postIndex = -1) {
        if (document.getElementById("opp_edit_post_id" + postIndex)) {
            var post_id = document.getElementById("opp_edit_post_id" + postIndex).value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {} else {
            //var description = $("#description_edit_"+post_id).val();//$scope.opp.description;//document.getElementById("description").value;
            var description = $('#description_edit_' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");
            description = description.trim();
            var opptitle = $scope.opp.opptitleedit;
            var job_title = $scope.opp.job_title_edit;
            var location = $scope.opp.location_edit;
            var company_name_edit = $scope.opp.company_name_edit;
            var fields = $("#field_edit" + post_id).val();
            if ((opptitle == undefined || opptitle == '') || (job_title == undefined || job_title == '') || (location == undefined || location == '') || (fields == undefined || fields == '')) {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
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
                form_data.append('description', description);
                form_data.append('opptitle', opptitle);
                form_data.append('field', fields);
                form_data.append('job_title', JSON.stringify(job_title));
                form_data.append('location', JSON.stringify(location));
                form_data.append('post_for', $scope.postData[postIndex].post_data.post_for);
                form_data.append('company_name', company_name_edit);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data, {
                    transformRequest: angular.identity,
                    headers: {
                        'Content-Type': undefined,
                        'Process-Data': false
                    }
                }).then(function(success) {
                    if (success.data.response == 1) {
                        $scope.postData[postIndex].opportunity_data.opptitle = success.data.opptitle;
                        $scope.postData[postIndex].opportunity_data.field = success.data.opp_field;
                        $scope.postData[postIndex].opportunity_data.location = success.data.opp_location;
                        $scope.postData[postIndex].opportunity_data.opportunity_for = success.data.opp_opportunity_for;
                        $scope.postData[postIndex].opportunity_data.opportunity = success.data.opportunity;
                        $scope.postData[postIndex].opportunity_data.company_name = success.data.company_name;
                        $("#post_opportunity_edit")[0].reset();
                        $("#edit-opp-post-" + post_id).hide();
                        $('#post-opp-detail-' + post_id).show();
                        $("#main-post-" + post_id + " .post-images").show();
                    }
                });
            }
        }
    }
    $scope.IsVisible = false;
    $scope.ShowHide = function() {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
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