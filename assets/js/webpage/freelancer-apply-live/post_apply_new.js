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
                var condition = scope.$eval(attrs.ddTextCollapseCond);
                

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing

                    if(/^\<a.*\>.*\<\/a\>/i.test(text))
                    {
                        var start = text.indexOf("<a href");
                        var end = text.indexOf('target="_blank">');
                        element.append(text);
                    }
                    else
                    {
                        var firstPart = String(text).substring(0, maxLength);                    
                        var secondPart = String(text).substring(maxLength, text.length);                    

                        // create some new html elements to hold the separate info
                        var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                        var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
                        var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                        var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                        if(condition == true)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : "View more"}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }
                        if(condition == false)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }

                        // remove the current contents of the element
                        // and add the new ones we created
                        element.empty();
                        element.append(firstSpan);
                        element.append(secondSpan);
                        element.append(moreIndicatorSpan);
                        element.append(lineBreak);
                        element.append(toggleButton);

                    }                    
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);
app.filter('slugify', function () {
    return function (input) {
        if (!input)
            return;

        // make lower case and trim
        var slug = input.toLowerCase().trim();

        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');

        if(slug[slug.length - 1] == "-")
        {            
            slug = slug.slice(0,-1);
        }
        return slug;
    };
});
app.filter('capitalize', function () {
    return function (str) {
        if (str === undefined || !str || str == null) {
            return false;
        }
        return str.split(" ").map(function (input) {
            return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : ''
        }).join(" ");

    }
});
app.controller('FARecommendedProjectController', function ($scope, $http,$window,$compile ) {
    $scope.title = title;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.job_search = {};

    $scope.cat_fil = "";    
    $scope.skills_fil = "";
    $scope.worktype = "";
    $scope.per_fil = "";
    $scope.exp_fil = "";

    $scope.jobs = {};
    
    $scope.fa ={};

    var fil_limit = 10;
    
    var isProcessing = false;

    function FAFields(limit) {
        $http.get(base_url + "freelancer_apply_live/freelancerFields?limit="+limit).then(function (success) {
            $scope.FAFields = success.data;
        }, function (error) {});
    }
    FAFields(fil_limit);

    function FASkills(limit) {
        $http.get(base_url + "freelancer_apply_live/freelancerSkills?limit="+limit).then(function (success) {
            $scope.FASkills = success.data.fa_category;
        }, function (error) {});
    }
    FASkills(fil_limit);
    
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.5) {
            isLoadingData = true;
            var page = $scope.fa.page_number;
            var total_record = $scope.fa.total_record;
            var perpage_record = $scope.fa.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.fa.page_number + 1;
                    search_job(pagenum);
                }
            }
        }
    });

    function search_job(pagenum) {

        if (isProcessing) {           
            return;
        }
        isProcessing = true;
        $('#loader').show();
        if(pagenum == undefined || pagenum == "1"){
            $('#main_loader').show();
        }
        $.post(base_url + "freelancer/ajax_freelancer_apply_post?page=" + pagenum, {"category_id" : $scope.cat_fil, "skill_id": $scope.skills_fil, "worktype": $scope.worktype, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                if(pagenum == undefined || pagenum == "1"){
                    $('#main_loader').hide();
                }
                // $('#main_page_load').show();
                $('body').removeClass("body-loader");
                $('#loader').hide();
                data = JSON.parse(success);
                if(data.fa_projects.length > 0)
                {
                    //$scope.mainKeyword = skill;
                    if(pagenum > 1)
                    {
                        for (var i in data.fa_projects) {
                            $scope.$apply(function () {
                                $scope.freepostapply.push(data.fa_projects[i]);
                            });
                        }
                    }
                    else
                    {
                        $scope.freepostapply = data.fa_projects;
                    }                    
                    $scope.fa.page_number = pagenum;
                    $scope.fa.total_record = data.total_record;
                    $scope.fa.perpage_record = 5;            
                    isProcessing = false;
                }
                else
                {
                    if(pagenum == 1)
                    {                    
                        $scope.freepostapply = data.fa_projects;
                    }
                    $scope.showLoadmore = false;                
                }
            }
        );

    }

    search_job(1);

    //apply post start
    $scope.applypopup = function(postid, userid)
    {
        if(login_user_id == "" || fa_profile_set == 0)
        {                
            /*if(login_user_id == ""){
                $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Lorem ipsum is a dummy text ists use for dummy data</h2>Please <p class='poppup-btns'><a class='btn1' href='"+base_url+"login'>Login</a> or <a class='btn1' href='"+base_url+"freelancer/create-account'>Register</a></p></div>");        
            }
            else if(job_deactive == 1)
                $('.biderror .mes').html("<div class='pop_content'>Please Reactive.</div>");*/
             $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Never miss out any opportunities, news, and updates.</h2>Join Now! <p class='poppup-btns'><a class='btn1' href='"+base_url+"login'>Login</a> or <a class='btn1' href='"+base_url+"freelancer/create-account'>Register</a></p></div>");  
            $('#bidmodal').modal('show');
        }
        else if(login_user_id != "" || fa_profile_set == 1)
        {                
            var $el = $('.biderror .mes').html("<div class='pop_content'>Do you want to apply for this work?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " ng-click='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $compile($el)($scope);
            $('#bidmodal').modal('show');
        }
        
    };

    $scope.apply_post = function(abc, xyz) {
        var alldata = 'all';
        var user = xyz;
        $.ajax({
            type: 'POST',
            url:  base_url + "freelancer/apply_insert",
            data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
            success: function (data) {
                clearInterval(int_not_count);            
                get_notification_unread_count();
                int_not_count = window.setInterval(function(){
                  get_notification_unread_count();
                }, 10000);
                $('.savedpost' + abc).hide();                
                var $eln = $('.applypost' + abc).html("Applied");
                $compile($eln)($scope);
                $('.applypost' + abc).attr('disabled', 'disabled');
                $('.applypost' + abc).attr('onclick', 'myFunction()');
                $('.applypost' + abc).addClass('applied');
            }
        });
    };
    //apply post end

    //save post start 
    $scope.savepopup  = function(id) {        
        if(login_user_id == "" || fa_profile_set == 0)
        {
            /*if(login_user_id == ""){
               $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Lorem ipsum is a dummy text ists use for dummy data</h2>Please <p class='poppup-btns'><a class='btn1' href='"+base_url+"login'>Login</a> or <a class='btn1' href='"+base_url+"freelancer/create-account'>Register</a></p></div>");
            }
            else if(fa_profile_set == 0)
                $('.biderror .mes').html("<div class='pop_content'>Please Login.</div>");*/
            $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Never miss out any opportunities, news, and updates.</h2>Join Now! <p class='poppup-btns'><a class='btn1' href='"+base_url+"login'>Login</a> or <a class='btn1' href='"+base_url+"freelancer/create-account'>Register</a></p></div>");
            $('#bidmodal').modal('show');
        }
        else if(login_user_id != ""  && fa_profile_set == 1)
        {
            save_post(id);
            $('.biderror .mes').html("<div class='pop_content'>Project successfully saved.");
            $('#bidmodal').modal('show');
        }
    };

    function save_post(id)
    {
        $.ajax({
            type: 'POST',
            url:  base_url + "freelancer/save_user",
            data: 'post_id=' + id,
            success: function (data) {
                $('.' + 'savedpost' + id).html(data).addClass('saved');
            }
        });

    };

    $scope.signuppopup = function()
    {
        $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>To Complete This Step, You Have to Register in the Job Profile.</h2><p class='poppup-btns'><a class='btn1' href='"+base_url+"freelancer/signup'>Register</a></p></div>");
        $('#bidmodal').modal('show');
    };

    $scope.applyJobFilter = function() {
       
        $scope.cat_fil = "";
        $('.category-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.cat_fil += ($scope.cat_fil == "") ? currentid : "," + currentid;
            }
        });
        //console.log($scope.cat_fil);

        
        $scope.skills_fil = "";
        $('.skills-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.skills_fil += ($scope.skills_fil == "") ? currentid : "," + currentid;
            }
        });
        //console.log($scope.skills_fil);

        $scope.worktype = "";
        $('.worktype-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.worktype += ($scope.worktype == "") ? currentid : "," + currentid;
            }
        });
        //console.log($scope.worktype);

        $scope.per_fil = "";
        $('.period-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.per_fil += ($scope.per_fil == "") ? currentid : "," + currentid;
            }
        });
        //console.log($scope.per_fil);
        
        $scope.exp_fil = "";
        $('.exp-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.exp_fil += ($scope.exp_fil == "") ? currentid : "," + currentid;
            }
        });
        //console.log($scope.exp_fil);
        pagenum = 1;

        $("#loader").show();
        $scope.freepostapply = {};
        $.post(base_url + "freelancer/ajax_freelancer_apply_post?page=" + pagenum, {"category_id" : $scope.cat_fil, "skill_id": $scope.skills_fil, "worktype": $scope.worktype, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $("#loader").hide();                
                data = JSON.parse(success);
                $scope.$apply(function () {

                    $scope.freepostapply = data.fa_projects;
                    $scope.fa.page_number = pagenum;
                    $scope.fa.total_record = data.total_record;
                    $scope.fa.perpage_record = 5;
                    isProcessing = false;
                });
            }
        );
    };   
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});