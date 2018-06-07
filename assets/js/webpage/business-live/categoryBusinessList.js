app.controller('businessListController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.businessLocation = {};
    function businessCategory(){
        $http.get(base_url + "business_live/businessCategory?limit=5").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();

    // Top 5 Location for filter
    function businessLocation(){
        $http.get(base_url + "business_live/businessLocation?limit=5").then(function (success) {
            $scope.businessLocation = success.data;
        }, function (error) {});
    }
    businessLocation();

    // get list of company based on category or locations
    function categoryBusinessList(){
        $http.get(base_url + "business_live/businessListByCategory/" + category_id).then(function (success) {
            $scope.businessList = success.data;
            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    function locationBusinessList(){
        $http.get(base_url + "business_live/businessListByLocation/" + location_id).then(function (success) {
            $scope.businessList = success.data;
            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    if(location_id != "" && category_id != ""){
        getfilterbusinessdata();
    }else if(location_id == '' || !location_id){
        categoryBusinessList();
    }else{
        locationBusinessList();
    }
    function getfilterbusinessdata(){
        var location = location_id;
        var category = category_id;
        var datavalue = new FormData();
        datavalue.append('category_id', category);
        datavalue.append('location_id', location);
        $("#loader").removeClass("hidden");
        filterajax = $http.post(base_url + "business_live/businessListByFilter/", datavalue,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            }).then(function (success) {
                $("#loader").addClass("hidden");
                $scope.businessList = success.data;
                $('#main_loader').hide();
                $('#main_page_load').show();
        }, function (error) {}
        , function (complete) { filterajax = false; });
    }
    $scope.getfilterbusinessdata = function (){
        var location = location_id;
        // Get Checked Location of filter and make data value for ajax call
        $('.locationcheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urllocation_id = location_id.split(",");
                if (urllocation_id.indexOf(currentid) === -1) {
                    location += (location == "") ? currentid : "," + currentid;
                }
            }
        });

        // Get Checked Category of filter and make data value for ajax call
        var category = category_id;
        $('.categorycheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urlcategory_id = category_id.split(",");
                if (urlcategory_id.indexOf(currentid) === -1) {
                    category += (category == "") ? currentid : "," + currentid;
                }
            }
        });

        var datavalue = new FormData();
        datavalue.append('category_id', category);
        datavalue.append('location_id', location);
        $("#loader").removeClass("hidden");
        filterajax = $http.post(base_url + "business_live/businessListByFilter/", datavalue,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            }).then(function (success) {
                $("#loader").addClass("hidden");
                $scope.businessList = success.data;
        }, function (error) {}
        , function (complete) { filterajax = false; });
    }
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

// change location
$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    angular.element(self).scope().getfilterbusinessdata();
});