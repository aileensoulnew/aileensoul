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
app.controller('jobSearchController', function ($scope, $http,$window) {
    $scope.showLoadmore = true;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.searchJob = {};
    $scope.jobs = {};
    $scope.jds = "";
    $scope.mainKeyword = "";

    $scope.cmp_fil = "";
    $scope.cat_fil = "";
    $scope.loc_fil = "";
    $scope.skills_fil = "";
    $scope.jd_fil = "";
    $scope.per_fil = "";
    $scope.exp_fil = "";
    //$scope.jobcompany = "";
    var fil_limit = 10;
    job_search(1);

    function jobCategory(limit = "") {
        $http.get(base_url + "job_live/jobCategory?limit="+limit).then(function (success) {
            $scope.jobCategory = success.data;
        }, function (error) {});
    }
    jobCategory(fil_limit);

    function jobCity(limit = "") {
        $http.get(base_url + "job_live/jobCity?limit="+limit).then(function (success) {
            $scope.jobCity = success.data;
        }, function (error) {});
    }
    jobCity(fil_limit);
    function jobCompany(limit = "") {
        $http.get(base_url + "job_live/jobCompany?limit="+limit).then(function (success) {
            $scope.jobCompany = success.data;
        }, function (error) {});
    }
    jobCompany(fil_limit);
    function jobSkill(limit = "") {
        $http.get(base_url + "job_live/jobSkill?limit="+limit).then(function (success) {
            $scope.jobSkill = success.data;
        }, function (error) {});
    }
    jobSkill(fil_limit);

    function jobTitle(limit = "") {
        $http.get(base_url + "job_live/get_jobtitle?limit="+limit).then(function (success) {
            $scope.jobDesignation = success.data;
        }, function (error) {});
    }
    jobTitle(fil_limit);

    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            isLoadingData = true;
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
                    job_search(pagenum);
                }
            }
        }
    });

    function job_search(pagenum) {
        if (isProcessing) {
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
            return;
        }
        isProcessing = true;
        $('#loader').show();
        $.post(base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill)+"&search_location=" + encodeURIComponent(search_location), {"company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $('#loader').hide();
                data = JSON.parse(success);
                if(data.jobData.length > 0)
                {
                    $scope.mainKeyword = skill;
                    if(pagenum > 1)
                    {
                        for (var i in data.jobData) {
                            console.log(data.jobData[i]);
                            //$scope.searchJob.push(data.jobData[i]);
                            $scope.$apply(function () {
                                $scope.searchJob.push(data.jobData[i]);
                            });
                        }
                    }
                    else
                    {
                        $scope.searchJob = data.jobData;
                    }
                    //$scope.searchJob = success.data.jobData;
                    $scope.jobs.page_number = pagenum;
                    $scope.jobs.total_record = data.total_record;
                    $scope.jobs.perpage_record = 5;            
                    isProcessing = false;
                }
                else
                {
                    $scope.showLoadmore = false;                
                }

            }
        );
        /*$http({
            method: 'POST',
            url: base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill),
            data: { "total_record": $("#total_record").val(), },
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $('#loader').hide();
            if(success.data.jobData.length > 0)
            {
                $scope.mainKeyword = skill;
                if(pagenum > 1)
                {
                    for (var i in success.data.jobData) {
                        $scope.searchJob.push(success.data.jobData[i]);
                    }                
                }
                else
                {
                    $scope.searchJob = success.data.jobData;
                }
                //$scope.searchJob = success.data.jobData;
                $scope.jobs.page_number = pagenum;
                $scope.jobs.total_record = success.data.total_record;
                $scope.jobs.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                $scope.showLoadmore = false;                
            }

        });*/        
    }
    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

    $scope.applyJobFilter = function() {
        $scope.cmp_fil = "";
        $('.company-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.cmp_fil += ($scope.cmp_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(cmp_fil);

        $scope.cat_fil = "";
        $('.category-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.cat_fil += ($scope.cat_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(cat_fil);

        $scope.loc_fil = "";
        $('.location-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.loc_fil += ($scope.loc_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(loc_fil);

        $scope.skills_fil = "";
        $('.skills-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.skills_fil += ($scope.skills_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(skills_fil);

        $scope.jd_fil = "";
        $('.jds-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.jd_fil += ($scope.jd_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(jd_fil);

        $scope.per_fil = "";
        $('.period-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.per_fil += ($scope.per_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(per_fil);
        
        $scope.exp_fil = "";
        $('.exp-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.exp_fil += ($scope.exp_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(exp_fil);
        pagenum = 1;

        //$("#loader").show();

        $.post(base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill)+"&search_location=" + encodeURIComponent(search_location), {"company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $scope.searchJob = {};
                data = JSON.parse(success);
                $scope.$apply(function () {
                    $scope.searchJob = data.jobData;
                });
            }
        );
        
        // $http({
        //     method: 'POST',
        //     url: base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill),
            /*data: "company_id=" + cmp_fil + "category_id" + cat_fil + "location_id" + loc_fil + "skill_id" + skills_fil + "job_desc" + jd_fil + "period_filter" + per_fil + "exp_fil" + exp_fil,*/
        //     data: {"company_id": cmp_fil, "category_id" : cat_fil, "location_id": loc_fil, "skill_id": skills_fil, "job_desc": jd_fil, "period_filter": per_fil, "exp_fil": exp_fil},
        //     headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        //     dataType : "json"
        // })
        // .then(function (success) {
        //     $('#loader').hide();
            /*if(success.data.jobData.length > 0)
            {
                $scope.mainKeyword = skill;
                if(pagenum > 1)
                {
                    for (var i in success.data.jobData) {
                        $scope.searchJob.push(success.data.jobData[i]);
                    }                
                }
                else
                {
                    $scope.searchJob = success.data.jobData;
                }
                //$scope.searchJob = success.data.jobData;
                $scope.jobs.page_number = pagenum;
                $scope.jobs.total_record = success.data.total_record;
                $scope.jobs.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                $scope.showLoadmore = false;                
            }*/

        //}); 
    };
});  