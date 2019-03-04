app.directive("owlCarousel", function() {
    return {
        restrict: 'E',
        link: function(scope) {
            scope.initCarousel = function(element) {
                // provide any default options you want
                var defaultOptions = {
                    loop: false,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        960: {
                            items: 1,
                        },
                        1200: {
                            items: 1
                        }
                    }
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for (var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
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
app.directive('owlCarouselItem', [function() {
    return {
        restrict: 'A',
        link: function(scope, element) {
            // wait for the last item in the ng-repeat then call init
            if (scope.$last) {
                scope.initCarousel(element.parent());
            }
        }
    };
}]);
app.filter('removeLastCharacter', function() {
    return function(text) {
        return text.substr(0, text.lastIndexOf(".") + 1);
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
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
app.controller('EditorController', ['$scope', function($scope) {
    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
    };
}]);
app.controller('searchController', function($scope, $http, $compile) {
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    $scope.pro = {};
    $scope.pst = {};
    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);
    if(!user_id){
        window.location = "/";
    }
    searchData();
    getContactSuggetion();

    function searchData() {
        //$(".post_loader").show();
        $http({
            method: 'POST',
            url: base_url + 'user_post/searchData',
            data: 'searchKeyword=' + searchKeyword,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $(".post_loader").hide();
            $scope.searchProfileData = success.data.profile;
            $scope.postData = success.data.post;
            $scope.pro.page_number = 2;
            $scope.pst.page_number = 2;
            $('#main_loader').hide();
            if (success.data.profile_total_rec > 5) {
                $("#load_more_pro_div").show();
            }
            if (success.data.post_total_rec > 3) {
                $("#load_more_pst_div").show();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            setTimeout(function() {
                $('video,audio').mediaelementplayer( /* Options */ );
            }, 300);
        });
    };
    
    $scope.load_more_profile = function() {
        var pagenum = $scope.pro.page_number;
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $('#load_more_pro').attr("disabled", "disabled");
        $('#load_more_pro').html('<img src="' + base_url + 'assets/images/loading.gif" alt="loaderimage">');
        $http({
            method: 'POST',
            url: base_url + 'user_post/searchDataProfileAjax',
            data: 'searchKeyword=' + searchKeyword + '&pagenum=' + pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $('#load_more_pro').removeAttr("disabled");
            $('#load_more_pro').html("Load more");
            if (success.data.profile.length > 0) {
                for (var i in success.data.profile) {
                    $scope.searchProfileData.push(success.data.profile[i]);
                    /*$scope.$apply(function () {
                        $scope.searchProfileData.push(success.data.profile[i]);
                    });*/
                }
                $scope.pro.page_number = parseInt($scope.pro.page_number) + 1;
                isProcessing = false;
            } else {
                $scope.showLoadmore = false;
                isProcessing = true;
                $('#load_more_pro').attr("disabled", "disabled");
                $('#load_more_pro_div').remove();
            }
        });
    };
    $scope.load_more_post = function() {
        var pagenum_pst = $scope.pst.page_number;
        if (isProcessingPst) {
            return;
        }
        isProcessingPst = true;
        $('#load_more_pst').attr("disabled", "disabled");
        $('#load_more_pst').html('<img src="' + base_url + 'assets/images/loading.gif" alt="loaderimage">');
        $http({
            method: 'POST',
            url: base_url + 'user_post/searchDataPostAjax',
            data: 'searchKeyword=' + searchKeyword + '&pagenum=' + pagenum_pst,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $('#load_more_pst').removeAttr("disabled");
            $('#load_more_pst').html("Load more");
            if (success.data.post.length > 0) {
                for (var i in success.data.post) {
                    $scope.postData.push(success.data.post[i]);
                    /*$scope.$apply(function () {
                        $scope.postData.push(success.data.post[i]);
                    });*/
                }
                $scope.pst.page_number = parseInt($scope.pst.page_number) + 1;
                isProcessingPst = false;
            } else {
                $scope.showLoadmore = false;
                isProcessingPst = true;
                $('#load_more_pst').attr("disabled", "disabled");
                $('#load_more_pst_div').remove();
            }
        });
    };

    function getContactSuggetion() {
        $http.get(base_url + "user_post/getContactSuggetion").then(function(success) {
            $scope.contactSuggetion = success.data;
        }, function(error) {});
    };

    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.addToContact = function(user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data.message == 1) {
                $('#item-' + user_id + ' button.follow-btn').html('Request Send');
                $('.addtobtn-' + user_id).html('Request Send');
                $('.addtobtn-' + user_id).attr('style', 'pointer-events:none;');
                // $('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    };

    $scope.addToContactSearch = function(user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data.message == 1) {
                $('#search-profile-contact-' + user_id).html('Request Send');
            }
        });
    };

    $scope.follow_user = function(id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user',
            data: 'to_id=' + id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#" + id).html($compile(success.data)($scope));
        });
    };

    $scope.unfollow_user = function(id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollow_user',
            data: 'to_id=' + id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#" + id).html($compile(success.data)($scope));
        });
    };

    $scope.followSearch = function(user_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addfollow',
            data: 'to_id=' + user_id + '&status=1',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data == 1) {
                $('#search-profile-follow-' + user_id).html('Following');
            }
        });
    };

    $scope.post_like = function(post_id) {
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
        });
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
    };

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
    };

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
    };

    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    };

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
    };

    $scope.likePostComment = function(comment_id, post_id) {
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
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    };

    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0, cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    };

    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    };

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
    };

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
    };

    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    };

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
    };

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
    };

    $('input:radio[name="report_spam"]').change(function(){
        if($(this).val() == '0'){
           $("#report_other").show();
        }
        else
        {
            $("#report_other").hide();   
        }
    });
    $scope.report_post_id = 0;
    $scope.open_report_spam = function(post_id){
        $scope.report_post_id = post_id;
        $("#report_spam_form")[0].reset();
        $("#report-spam").modal('show');
    };

    $scope.report_spam_validate = {        
        rules: {           
            report_spam: {
                required: true,
            },
            other_report_spam: {
                required: {
                    depends: function(element) {
                        return $("input[name='report_spam']:checked").val() == 0 ? true : false;
                    }
                },
            },
        },
        messages: {
            report_spam: {
                required: "Select Report",
            },
            other_report_spam: {
                required: "Enter Other Report",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "report_spam") {
                error.appendTo($("#err_report"));
            } else {
                error.insertAfter(element);
            }
        },
    };
    $scope.save_report_spam = function(){
        if ($scope.report_spam_form.validate()) {

            $("#save_report_spam").attr("style","pointer-events:none;display:none;");
            $("#save_report_spam_loader").show();

            var reported_post_id = $scope.report_post_id;            
            var reported_reason = $("input[name='report_spam']:checked").val();
            var reported_reason_other = $("#other_report_spam").val();
            var updatedata = $.param({'reported_post_id':reported_post_id,'reported_reason':reported_reason,'reported_reason_other':reported_reason_other});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_report_spam',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#report_spam_form")[0].reset();                
                if(success == 1)
                {
                    
                }
                $("#save_report_spam").removeAttr("style");
                $("#save_report_spam_loader").hide();
                $("#report-spam").modal('hide');
            });
        }
    };
});
$(window).on("load", function() {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});