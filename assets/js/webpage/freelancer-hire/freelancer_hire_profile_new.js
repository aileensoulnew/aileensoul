app.controller('freelanceHireProfileController', function ($scope, $http) {
    
    var fh_formdata = new FormData();
    $(document).on('change','#review_file', function(e){
        $("#review_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#review_file_error").html("File size must be less than 10MB.");
            $("#review_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                fh_formdata.append('review_file', $('#review_file')[0].files[0]);
            }
            else {
                $("#review_file_error").html("Invalid file selected.");
                $("#review_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.freelancer_hire_profile_review_validate = {
        rules: {
            review_star: {
                required: true,
            },
            review_desc: {
                required: true,
            },
        },
        messages: {
            review_star: {
                required: "Please select start",
            },
            review_desc: {
                required: "Please enter rating review description",
            },
        },
    };

    $scope.save_review = function(){
        if ($scope.freelancer_hire_profile_review.validate())
        {
            $("#review_loader").show();
            $("#save_review").attr("style","pointer-events:none;display:none;");

            fh_formdata.append('from_user_id', from_user_id);
            fh_formdata.append('to_user_id', to_user_id);
            fh_formdata.append('review_star', $('#review_star').val());
            fh_formdata.append('review_star', $('#review_star').val());
            fh_formdata.append('review_desc', $('#review_desc').val());

            $http.post(base_url + 'freelancer_hire_live/save_review', fh_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })            
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    $("#review_loader").hide();
                    $("#save_review").removeAttr("style");
                    $("#reviews").modal("hide");
                }
                else if(success == 0)
                {                    
                    $("#reviews").modal("hide");
                }
            });
        }
    };

    $scope.get_review = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer_hire_live/get_review',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.review_data = result.data.review_data;
                $("#review-loader").hide();
                $("#review-body").show();
                setTimeout(function(){
                    $("#rating-1").rating({min:0.5, max:5, step:0.5, size:'sm'});
                    $(".user-rating").rating({min:0.5, max:5, step:0.5, size:'lg'});
                },1000);
            }
        });
    };
    $scope.get_review();

});