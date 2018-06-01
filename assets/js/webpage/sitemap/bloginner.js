app.controller('siteMapBlogListController', function ($scope, $http) {
    $scope.total_record = 0;
    $scope.blogPost = [],
    $scope.limit = 100;
    $scope.currentPage = 1,
    $scope.numPerPage = 5,
    $scope.maxSize = 5;
    $scope.categorySelectedId = '';
    $scope.cate_name = category_name;
    if((category_id) && category_id != ""){
        $scope.categorySelectedId = category_id;
    }
    var isCatProcessing = false;
    $scope.cat_post = function(cateid,page) { 
        category_post_list(cateid,page);
    }

    function category_post_list(cateid,page){
        if (isCatProcessing) {
            return;
        }
        page = (!page) ? 1 : page;
        cateid = (!cateid) ? $scope.categorySelectedId : cateid;
        isCatProcessing = true;
        $('#loader').show();
        var datavalue = new FormData();
        datavalue.append('cateid', cateid);
        datavalue.append('total_record', $("#total_record").val());
        isCatProcessing = $http.post(base_url + "blog/cat_ajax?cateid=" + cateid + "&page=" + page+ "&limit=" + $scope.limit, datavalue,
        {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        }).then(function (success) {
            $scope.blogPost = success.data.blog_data;
            $scope.total_record = success.data.total_record;
            isCatProcessing = false; 
            $scope.categorySelectedId = cateid;
        }, function (error) {}, 
        function (complete) { 
            $("#loader").addClass("hidden");
            isCatProcessing = false; 
        });
    }
    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
        category_post_list('',$scope.currentPage);
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