app.controller('recruiterController', function ($scope, $http) {
    $scope.title = title;    
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