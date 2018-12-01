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
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
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
            // $("#company_loader").show();
            // $("#save_company").attr("style","pointer-events:none;display:none;");
            // $("#back_company").attr("style","pointer-events:none;display:none;");

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
                    window.location = base_url + "post-freelance-project";
                }
                else if(success == 0)
                {
                    $("#freelancer_loader").hide();
                    $("#save_individual").removeAttr("style");
                    $("#back_individual").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
    };

});