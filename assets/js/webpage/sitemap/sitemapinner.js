app.controller('siteMapInnerController', function ($scope, $http) {   
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/sitemap/artist", {
            templateUrl: base_url + "sitemap/sitemap_art_list",
            controller: 'siteMapMainController'
        })
        .when("/sitemap/artist/:param1", {
            templateUrl: base_url + "sitemap/sitemap_art_list",
            controller: 'siteMapArtistController'
        })
        .when("/sitemap/companies", {
            templateUrl: base_url + "sitemap/sitemap_company_list",
            controller: 'siteMapMainController'
        })
        .when("/sitemap/companies/:param1", {
            templateUrl: base_url + "sitemap/sitemap_company_list",
            controller: 'siteMapCompaniesController'
        })
        .when("/sitemap/jobs", {
            templateUrl: base_url + "sitemap/sitemap_job_list",
            controller: 'siteMapMainController'
        })
        .when("/sitemap/jobs/:param1", {
            templateUrl: base_url + "sitemap/sitemap_job_list",
            controller: 'siteMapJobController'
        })
        .when("/sitemap/freelance-jobs", {
            templateUrl: base_url + "sitemap/sitemap_freelancer_list",
            controller: 'siteMapMainController'
        })
        .when("/sitemap/freelance-jobs/:param1", {
            templateUrl: base_url + "sitemap/sitemap_freelancer_list",
            controller: 'siteMapFreelancerController'
        })
        .when("/sitemap/people", {
            templateUrl: base_url + "sitemap/sitemap_member_list",
            controller: 'siteMapMainController'
        })
        .when("/sitemap/people/:param1", {
            templateUrl: base_url + "sitemap/sitemap_member_list",
            controller: 'siteMapMemberController'
        }); 
    $locationProvider.html5Mode(true);
});

app.controller('siteMapMainController', function ($scope, $http,$location) {
    $scope.alphabetList = {};
    $scope.isPaginationShow = false;
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            alpha.push(
                { 'name' : name, 'isactive' : ''}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();
});

app.controller('siteMapArtistController', function ($scope, $http,$location) {
    $scope.total_record = 0;
    $scope.$parent.title = "Artist Sitemap | Aileensoul";
    $scope.alphabetList = {};
    $scope.categoryList = {};
    $scope.artistList = [],
    $scope.limit = 100;
    $scope.currentPage = ($location.search()) ? $location.search()['page_id'] : 1,
    $scope.numPerPage = 5,
    $scope.maxSize = 5;
    $scope.searchword = searchword;
    $scope.isPaginationShow = true;
    $scope.isPageNoClicked = false;

    // PAGE NO AND SEARCHWORD BASED ON URL
    var searchkeyword = $location.path().split("/");
    $scope.searchkeyword = searchkeyword[searchkeyword.length-1];
    //ARTIST LISTING
    function artistList(page){
        $scope.artistList = {};
        $http.get("sitemap/get_artist_list?page_id=" + $scope.currentPage + "&searchword="+ $scope.searchkeyword).then(function (success) {
            $scope.artistList = success.data.artist_list;
            $scope.total_record = success.data.total_record['total_artist'];
            $scope.isPageNoClicked = true;
        }, function (error) {});
    }
    artistList();
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            var isactive = (($scope.searchword).toLowerCase() == name.toLowerCase()) ? 'active' : '';
            alpha.push(
                { 'name' : name, 'isactive' : isactive}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();

    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
        if($scope.isPageNoClicked){
            window.location.href = base_url + 'sitemap/artist/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage;
            // $location.url('sitemap/artist/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage);
        }
    });
});

/*app.controller('siteMapMainCompaniesController', function ($scope, $http,$location) {
    $scope.alphabetList = {};
    $scope.isPaginationShow = false;
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            alpha.push(
                { 'name' : name, 'isactive' : ''}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();
});*/

app.controller('siteMapCompaniesController', function ($scope, $http,$location) {
    $scope.total_record = 0;
    $scope.$parent.title = "Companies Sitemap | Aileensoul";
    $scope.alphabetList = {};
    $scope.categoryList = {};
    $scope.companyList = [],
    $scope.limit = 100;
    $scope.currentPage = ($location.search()) ? $location.search()['page_id'] : 1,
    $scope.numPerPage = 5,
    $scope.maxSize = 5;
    $scope.searchword = searchword;
    $scope.isPaginationShow = true;
    $scope.isPageNoClicked = false;

    // PAGE NO AND SEARCHWORD BASED ON URL
    var searchkeyword = $location.path().split("/");
    $scope.searchkeyword = searchkeyword[searchkeyword.length-1];
    //ARTIST LISTING
    function companyList(page){
        $scope.companyList = {};
        $http.get("sitemap/get_company_list?page_id=" + $scope.currentPage + "&searchword="+ $scope.searchkeyword).then(function (success) {
            $scope.companyList = success.data.company_list;
            $scope.total_record = success.data.total_record['total_rec'];
            $scope.isPageNoClicked = true;
        }, function (error) {});
    }
    companyList();
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            var isactive = (($scope.searchword).toLowerCase() == name.toLowerCase()) ? 'active' : '';
            alpha.push(
                { 'name' : name, 'isactive' : isactive}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();

    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
        if($scope.isPageNoClicked){
            window.location.href = base_url + 'sitemap/companies/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage;
            // $location.url('sitemap/artist/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage);
        }
    });
});

/*app.controller('siteMapMainJobController', function ($scope, $http,$location) {
    $scope.alphabetList = {};
    $scope.isPaginationShow = false;
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            alpha.push(
                { 'name' : name, 'isactive' : ''}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();
});*/

app.controller('siteMapJobController', function ($scope, $http,$location) {
    $scope.total_record = 0;
    $scope.$parent.title = "Job Sitemap | Aileensoul";
    $scope.alphabetList = {};
    $scope.categoryList = {};
    $scope.companyList = [],
    $scope.limit = 100;
    $scope.currentPage = ($location.search()) ? $location.search()['page_id'] : 1,
    $scope.numPerPage = 5,
    $scope.maxSize = 5;
    $scope.searchword = searchword;
    $scope.isPaginationShow = true;
    $scope.isPageNoClicked = false;

    // PAGE NO AND SEARCHWORD BASED ON URL
    var searchkeyword = $location.path().split("/");
    $scope.searchkeyword = searchkeyword[searchkeyword.length-1];
    console.log($scope.currentPage);
    //ARTIST LISTING
    function jobList(page){
        $scope.jobList = {};
        $http.get("sitemap/get_job_list?page_id=" + $scope.currentPage + "&searchword="+ $scope.searchkeyword).then(function (success) {
            $scope.jobList = success.data.job_list;
            $scope.total_record = success.data.total_record['total_rec'];
            $scope.isPageNoClicked = true;
        }, function (error) {});
    }
    jobList();
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            var isactive = (($scope.searchword).toLowerCase() == name.toLowerCase()) ? 'active' : '';
            alpha.push(
                { 'name' : name, 'isactive' : isactive}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();

    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
        if($scope.isPageNoClicked){
            window.location.href = base_url + 'sitemap/jobs/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage;
            // $location.url('sitemap/artist/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage);
        }
    });
});
/*app.controller('siteMapMainFreelancerController', function ($scope, $http,$location) {
    $scope.alphabetList = {};
    $scope.isPaginationShow = false;
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            alpha.push(
                { 'name' : name, 'isactive' : ''}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();
});*/

app.controller('siteMapFreelancerController', function ($scope, $http,$location) {
    $scope.total_record = 0;
    $scope.$parent.title = "Freelancer Sitemap | Aileensoul";
    $scope.alphabetList = {};
    $scope.categoryList = {};
    $scope.freelancerList = [],
    $scope.limit = 100;
    $scope.currentPage = ($location.search()) ? $location.search()['page_id'] : 1,
    $scope.numPerPage = 5,
    $scope.maxSize = 5;
    $scope.searchword = searchword;
    $scope.isPaginationShow = true;
    $scope.isPageNoClicked = false;

    // PAGE NO AND SEARCHWORD BASED ON URL
    var searchkeyword = $location.path().split("/");
    $scope.searchkeyword = searchkeyword[searchkeyword.length-1];
    //ARTIST LISTING
    function freelancerList(page){
        $scope.freelancerList = {};
        $http.get("sitemap/get_freelancer_list?page_id=" + $scope.currentPage + "&searchword="+ $scope.searchkeyword).then(function (success) {
            $scope.freelancerList = success.data.freelancer_list;
            $scope.total_record = success.data.total_record['total_rec'];
            $scope.isPageNoClicked = true;
        }, function (error) {});
    }
    freelancerList();
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            var isactive = (($scope.searchword).toLowerCase() == name.toLowerCase()) ? 'active' : '';
            alpha.push(
                { 'name' : name, 'isactive' : isactive}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();

    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
        if($scope.isPageNoClicked){
            window.location.href = base_url + 'sitemap/freelance-jobs/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage;
            // $location.url('sitemap/artist/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage);
        }
    });
});

app.controller('siteMapMemberController', function ($scope, $http,$location) {
    $scope.total_record = 0;
    $scope.$parent.title = "Member Sitemap | Aileensoul";
    $scope.alphabetList = {};
    $scope.memberList = [],
    $scope.limit = 100;
    $scope.currentPage = 1,
    $scope.selectedPage = 3,
    // $scope.currentPage = ($location.search()) ? $location.search()['page_id'] : 1,
    $scope.numPerPage = 5,
    $scope.maxSize = 5;
    $scope.searchword = searchword;
    $scope.isPaginationShow = true;
    $scope.isPageNoClicked = false;

    // PAGE NO AND SEARCHWORD BASED ON URL
    var searchkeyword = $location.path().split("/");
    $scope.searchkeyword = searchkeyword[searchkeyword.length-1];
    //ARTIST LISTING
    function memberList(page){
        $scope.memberList = {};
        $http.get("sitemap/get_member_list?page_id=" + $scope.currentPage + "&searchword="+ $scope.searchkeyword).then(function (success) {
            $scope.memberList = success.data.member_list;
            $scope.total_record = success.data.total_record['total_rec'];
            $scope.isPageNoClicked = true;
        }, function (error) {});
    }
    memberList();
    function alphabetList(page){
        // Loop for alphabet list
        var alpha = [];
        for (var i = 65; i <= 90; i++) {
            var name = String.fromCharCode(i);
            var isactive = (($scope.searchword).toLowerCase() == name.toLowerCase()) ? 'active' : '';
            alpha.push(
                { 'name' : name, 'isactive' : isactive}
            );
        }
        $scope.alphabetList = alpha;
    }
    alphabetList();

    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
        if($scope.isPageNoClicked){
            window.location.href = base_url + 'sitemap/people/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage;
            // $location.url('sitemap/artist/'+ $scope.searchkeyword + '?page_id=' + $scope.currentPage);
        }
    });
});

app.filter('unsafe', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
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