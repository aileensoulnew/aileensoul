app.controller('freelancerApplyController', function ($scope, $http) {
    $scope.title = title;

    function FAFields(limit = 0) {
        $http.get(base_url + "freelancer_apply_live/freelancerFields?limit="+limit).then(function (success) {
            $scope.FAFields = success.data;
        }, function (error) {});
    }
    FAFields(8);

    function FASkills(limit = 0) {
        $http.get(base_url + "freelancer_apply_live/freelancerSkills?limit="+limit).then(function (success) {
            $scope.FASkills = success.data.fa_skills;
        }, function (error) {});
    }
    FASkills(8);
});
AOS.init({
    easing: 'ease-in-out-sine'
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});