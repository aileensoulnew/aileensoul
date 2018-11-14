//validation start
$(document).ready(function() {
    // $.validator.addMethod("lowercase", function(value, element, regexpr) {          
    //          return regexpr.test(value);
    //      }, "email Should be in Small Character");
    $.validator.addMethod("regx2", function(value, element, regexpr) {
        if (!value) {
            return true;
        } else {
            return regexpr.test(value);
        }
    }, "Special character and space not allow in the beginning");
    $.validator.addMethod("regx_digit", function(value, element, regexpr) {
        if (!value) {
            return true;
        } else {
            return regexpr.test(value);
        }
    }, "Digit is not allow");
    $.validator.addMethod("regx1", function(value, element, regexpr) {
        if (!value) {
            return true;
        } else {
            return regexpr.test(value);
        }
    }, "Only space, only number and only special characters are not allow");
    $("#jobseeker_regform").validate({
        ignore: '*:not([name])',
        rules: {
            first_name: {
                required: true,
                regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                regx_digit: /^([^0-9]*)$/,
            },
            last_name: {
                required: true,
                regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                regx_digit: /^([^0-9]*)$/,
            },
            cities: {
                required: true,
            },
            email: {
                required: true,
                email: true,
                // lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                remote: {
                    url: base_url + "job/check_email",
                    //async is used for double click on submit avoid
                    async: false,
                    type: "post",
                },
            },
            phone: {
                required: true,
            },
            fresher: {
                required: true,
            },
            job_title: {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
            },
            industry: {
                required: true,
            },
            cities: {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
            },
            skills: {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
            },
        },
        messages: {
            first_name: {
                required: "First name is required.",
            },
            last_name: {
                required: "Last name is required.",
            },
            email: {
                required: "Email address is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists"
            },
            phone: {
                required: "Enter contact number.",
            },/*
            fresher: {
                required: "Fresher is required.",
            },*/
            industry: {
                required: "Industry is required.",
            },
            cities: {
                required: "City is required.",
            },
            job_title: {
                required: "Job title is required.",
            },
            skills: {
                required: "Skill is required.",
            }
        },
        errorPlacement: function(error, element) {            
            if (element.attr("name") == "fresher" )
                error.insertBefore(".fresher-error");            
            else
                error.insertBefore(element);
        },
    });

    $("#phone").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
//BUTTON SUBMIT DISABLE AFTER SOME TIME START
$("#submit").on('click', function() {
    if (!$('#jobseeker_regform').valid()) {
        return false;
    } else {
        $("#submit").addClass("register_disable");
        return true;
    }
});
//BUTTON SUBMIT DISABLE AFTER SOME TIME END