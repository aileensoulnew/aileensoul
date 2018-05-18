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

        return slug;
    };
});
app.controller('jobSearchController', function ($scope, $http,$window) {
    $scope.title = title;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.job_search = {};

    $scope.cmp_fil = "";
    $scope.cat_fil = "";
    $scope.loc_fil = "";
    $scope.skills_fil = "";
    $scope.jd_fil = "";
    $scope.per_fil = "";
    $scope.exp_fil = "";
    $scope.jobs = {};
    $scope.keyword = q;
    $scope.city = l;

    var job_keyword = q;
    var job_location = l;
    var work_time = work_timing;
    $.each(work_timing.split("-"), function( index, value ) {
        if(value == 1)
        {
            $scope.fulltime = true;
        }
        else if(value == 2)
        {
            $scope.parttime = true;
        }
        else if(value == 3)
        {
            $scope.internship = true;
        }
    });

    // console.log(job_keyword);
    // console.log(job_location);
    // console.log(work_time);

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
                    search_job(pagenum);
                }
            }
        }
    });

    function search_job(pagenum) {

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
        $.post(base_url + "job_live/job_search_new_ajax?page=" + pagenum , 
            {"job_keyword":job_keyword, "job_location":job_location, "work_time":work_time, "company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $('#loader').hide();
                data = JSON.parse(success);
                if(data.searchJobs.length > 0)
                {                    
                    if(pagenum > 1)
                    {
                        for (var i in data.searchJobs) {                            
                            //$scope.searchJob.push(data.latestJobs[i]);
                            $scope.$apply(function () {
                                $scope.job_search.push(data.searchJobs[i]);
                            });
                        }
                    }
                    else
                    {
                        $scope.job_search = data.searchJobs;
                    }
                    //$scope.searchJob = success.data.latestJobs;
                    $scope.jobs.page_number = pagenum;
                    $scope.jobs.total_record = data.total_record;
                    $scope.jobs.perpage_record = 5;            
                    isProcessing = false;
                }
                else
                {
                    $scope.job_search = data.searchJobs;
                    $scope.showLoadmore = false;                
                }
            }
        );

    }
    search_job(1);

    function jobCategory(limit = 0) {
        $http.get(base_url + "job_live/jobCategory?limit="+limit).then(function (success) {
            $scope.jobCategory = success.data;
        }, function (error) {});
    }
    jobCategory(8);

    function jobCity(limit) {
        $http.get(base_url + "job_live/jobCity?limit="+limit).then(function (success) {
            $scope.jobCity = success.data;
        }, function (error) {});
    }
    jobCity(8);
    function jobCompany(limit) {
        $http.get(base_url + "job_live/jobCompany?limit="+limit).then(function (success) {
            $scope.jobCompany = success.data;
        }, function (error) {});
    }
    jobCompany(8);
    function jobSkill(limit) {
        $http.get(base_url + "job_live/jobSkill?limit="+limit).then(function (success) {
            $scope.jobSkill = success.data;
        }, function (error) {});
    }
    jobSkill(8);

    function jobTitle(limit) {
        $http.get(base_url + "job_live/get_jobtitle?limit="+limit).then(function (success) {
            $scope.jobDesignation = success.data;
        }, function (error) {});
    }
    jobTitle(8);

    $scope.applyJobFilter = function () {
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
        $scope.showLoadmore = true;
        pagenum = 1;

        $.post(base_url + "job_live/job_search_new_ajax?page=" + pagenum, {"job_keyword":job_keyword, "job_location":job_location, "work_time":work_time, "company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){                 
                $scope.job_search = {};
                data = JSON.parse(success);
                $scope.$apply(function () {
                    $scope.job_search = data.searchJobs;
                    $scope.jobs.page_number = pagenum;
                    $scope.jobs.total_record = data.total_record;
                    $scope.jobs.perpage_record = 5;            
                    isProcessing = false;
                });
            }
        );
        
    }
   
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

    // NEW HTML SCRIPT

    AOS.init({
        easing: 'ease-in-out-sine'
    });

    setInterval(addItem, 100);

    var itemsCounter = 1;
    var container = document.getElementById('aos-demo');

    function addItem () {
        if (itemsCounter > 42) return;
        var item = document.createElement('div');
        item.classList.add('aos-item');
        item.setAttribute('data-aos', 'fade-up');
        item.innerHTML = '<div class="aos-item__inner"><h3>' + itemsCounter + '</h3></div>';
        // container.appendChild(item);
        itemsCounter++;
    }