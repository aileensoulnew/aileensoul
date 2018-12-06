// CHECK SEARCH KEYWORD AND LOCATION BLANK START
function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}

function checkvalue_search() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "")
    {
        return false;
    }
}
function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
// CHECK SEARCH KEYWORD AND LOCATION BLANK END
//CODE FOR VALIDATION OF SKILL AND OTHER SKILL START
function imgval() {
    /*$("#postinfo .select2-selection").removeClass("keyskill_border_active");
    var skill_main = document.getElementById("skills").value;
    var skill_other = document.getElementById("other_skill").value;
    if (skill_main == '' && skill_other == '') {
        $("#postinfo .select2-selection").addClass("keyskill_border_active");
    }*/
}
//CODE FOR VALIDATION OF SKILL AND OTHER SKILL END
// FORM FILL UP VALIDATION START
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");
$.validator.addMethod("regx", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
    // return regexpr.test(value);
}, "Only space, only number and only special characters are not allow");
// for date validtaion start
jQuery.validator.addMethod("isValid", function (value, element) {
    var todaydate = new Date();
    var dd = todaydate.getDate();
    var mm = todaydate.getMonth() + 1; //January is 0!
    var yyyy = todaydate.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }
    var todaydate = yyyy + '-' + mm + '-' + dd;
    var one = new Date(value).getTime();
    var second = new Date(todaydate).getTime();
  
    if(one >= second){
    return one >= second;
    }
    $('.day').addClass('error');
    $('.month').addClass('error');
    $('.year').addClass('error');
}, "Last date should be grater than and equal to today date");

//date validation end
//   validation border is not show in last date start
$.validator.addMethod("required1", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        $('.day').addClass('error');
        $('.month').addClass('error');
        $('.year').addClass('error');
        return false;
    } else
    {
        return true;
    }

    // return regexpr.test(value);
}, "Last Date of apply is required.");
//   validation border is not show in last date end 
//VALIDATION FOR ESTIMATE TIME NOT ACCEPT ONLY NUMBER START
$.validator.addMethod("regx_num_space", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
    // return regexpr.test(value);
}, "Please add proper Estimated time. Eg: '3 month' or '3 Year' ");
//VALIDATION FOR ESTIMATE TIME NOT ACCEPT ONLY NUMBER END

$(document).on('change','#add_project_file', function(e){
    $("#add_project_file_error").hide();
    if(this.files[0].size > 10485760)
    {
        $("#add_project_file_error").html("File size must be less than 10MB.");
        $("#add_project_file_error").show();
        $(this).val("");
        return true;
    }
    else
    {
        var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
        var ext = $(this).val().split('.');        
        if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
            // fh_formdata.append('add_project_file', $('#add_project_file')[0].files[0]);
        }
        else {
            $("#add_project_file_error").html("Invalid file selected.");
            $("#add_project_file_error").show();
            $(this).val("");
        }         
    }
});

$(document).ready(function () {
    $("#postinfo").validate({
        ignore: '*:not([name])',
        rules: {
            post_name: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            skills: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            fields_req: {
                required: true,
            },
            post_desc: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            last_date: {
                required1: "Last date of apply is required.",
                isValid: 'Last date should be grater than and equal to today date'
            },
            add_project_type: {
                required: true,
            },
            add_project_duration: {
                required: true,
            },
            add_project_hours: {
                required: true,
            },
            add_project_freelancer_type: {
                required: true,
            },
            add_project_freelancer: {
                required: true,
            },
            add_project_eng_level: {
                required: true,
            },
            add_project_location: {
                required: true,
            },
            rating: {
                required: true,
            },            
            currency:{
                required: {
                    depends: function(element) {
                        return $("input[name='rating']:checked").val() == 0 || $("input[name='rating']:checked").val() == 1 ? true : false;
                    }
                },
            },
            rate:{
                required: {
                    depends: function(element) {                        
                        return $("input[name='rating']:checked").val() == 0 || $("input[name='rating']:checked").val() == 1 ? true : false;
                    }
                },
            }

        },

        messages: {
            post_name: {
                required: "Project name is required.",
            },

            skills: {
                required: "Skill is required"
            },

            fields_req: {
                required: "Please select field of requirement",
            },
            post_desc: {
                required: "Project description  is required.",
            },
            last_date: {
                //required: "Last Date of apply is required.",
            },
            add_project_type: {
                required: "Please select project type",
            },
            add_project_duration: {
                required: "Please select project duration",
            },
            add_project_hours: {
                required: "Please select hours per week",
            },
            add_project_freelancer_type: {
                required: "Please select freelancer type",
            },
            add_project_freelancer: {
                required: "Please enter number of freelancer",
            },
            add_project_eng_level: {
                required: "Please select english level",
            },
            add_project_location: {
                required: "Please select location",
            },
            rating: {
                required: "Please select work type"
            },
            currency:{
                required: "Please select currency"
            },
            rate:{
                required: "Please enter rate"
            }

        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "rating") {
                error.insertAfter("#rating_div");
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $("#submit").attr("disabled","disabled");
            $("#submit").attr("style","pointer-events: none;display:none;");
            $("#post_loader").show();
            var form = $('#postinfo')[0];
            var formData = new FormData(form);
            formData.append('add_project_file', $('#add_project_file')[0].files[0]);

            $.ajax({
                url: base_url + "freelancer_hire/freelancer_add_post_insert_new",
                type: "POST",             
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',    
                success: function(res) {
                    if(res.success == 1)
                    {
                        window.location = base_url + "hire-freelancer";
                    }
                    else
                    {
                        $("#bidmodal .modal-body .mes").html("Sorry!! Your project not posted. Please try again later.");
                        $("#submit").removeAttr("disabled");
                        $("#submit").removeAttr("style");
                        $("#post_loader").hide();                    
                    }
                }
            });
            return false;
        },

    });
});

// FORM FILL UP VALIDATION END
// CODE FOR COUNTRY,STATE, CITY CODE START
$(document).ready(function () {
    $('#country').on('change', function () {
        var countryID = $(this).val();

        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_dataforcity",
                data: 'country_id=' + countryID,
                success: function (html) {
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>');
                }
            });
        } else {
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>');
        }
    });

    $('#state').on('change', function () {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_dataforcity",
                data: 'state_id=' + stateID,
                success: function (html) {
                    $('#city').html(html);
                }
            });
        } else {
            $('#city').html('<option value="">Select state first</option>');
        }
    });
});
// CODE FOR COUNTRY,STATE, CITY CODE END

////SELECT2 AUTOCOMPLETE START FOR SKILL
// $('#skills').select2({
//                placeholder: 'Find Your Skills',
//                ajax: {
//                    url:  base_url + "freelancer/keyskill",
//                    dataType: 'json',
//                    delay: 250,
//                    processResults: function (data) {
//                        return {
//                            results: data
//                        };
//                    },
//                    cache: true
//                }
//            });
////SELECT2 AUTOCOMPLETE FOR SKILL END
//SCRIPT FOR COPY-PASTE START
var _onPaste_StripFormatting_IEPaste = false;
function OnPaste_StripFormatting(elem, e) {

    if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
        e.preventDefault();
        var text = e.originalEvent.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    } else if (e.clipboardData && e.clipboardData.getData) {
        e.preventDefault();
        var text = e.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    } else if (window.clipboardData && window.clipboardData.getData) {
        // Stop stack overflow
        if (!_onPaste_StripFormatting_IEPaste) {
            _onPaste_StripFormatting_IEPaste = true;
            e.preventDefault();
            window.document.execCommand('ms-pasteTextOnly', false);
        }
        _onPaste_StripFormatting_IEPaste = false;
    }
}
//SCRIPT FOR COPY-PASTE END

//SCRIPT FOR DATEPICKER START
$(function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var today = yyyy;
    $("#example2").dateDropdowns({
        submitFieldName: 'last_date',
        submitFormat: "yyyy-mm-dd",
        minYear: today,
        maxYear: today + 1,
        daySuffixes: false,
        monthFormat: "short",
        dayLabel: 'DD',
        monthLabel: 'MM',
        yearLabel: 'YYYY',

        //startDate: today,
    });
    $(".day").attr('tabindex', 7);
    $(".month").attr('tabindex', 8);
    $(".year").attr('tabindex', 9);

});
//SCRIPT FOR DATEPICKER END 
//NEW SCRIPT FOR SKILL START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#skills2").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_skill", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var text = this.value;
                    var terms = split(this.value);

                    text = text == null || text == undefined ? "" : text;
                    var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                    if (checked == 'checked') {

                        terms.push(ui.item.value);
                        this.value = terms.split(", ");
                    }//if end

                    else {
                        if (terms.length <= 10) {
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(", ");
                            return false;
                        } else {
                            var last = terms.pop();
                            $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                            $(this).effect("highlight", {}, 1000);
                            $(this).attr("style", "border: solid 1px red;");
                            return false;
                        }
                    }//else end
                }

            });
});

//NEW SCRIPT FOR SKILL END

// SCRIPT FOR ADD OTHER FIELD  START
$(document).on('change', '.field_other', function (event) {

    var item = $(this);
    var other_field = (item.val());

    if (other_field == 15) {
        item.val('');
        $.fancybox.open('<div class="message" style="width:300px;"><h2>Add Field</h2><input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()"><div class="fw"><a id="field" class="btn">OK</a></div></div>');

        $('.message #field').on('click', function () {
            $("#other_field").removeClass("keyskill_border_active");
            $('#field_error').remove();

            var x = $.trim(document.getElementById("other_field").value);
            if (x == '') {
                $("#other_field").addClass("keyskill_border_active");
                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_field');
                return false;
            } else {
                var $textbox = $('.message').find('input[type="text"]'),
                        textVal = $textbox.val();
                $.ajax({
                    type: 'POST',
                    url: base_url + "freelancer/freelancer_hire_other_field",
                    dataType: 'json',
                    data: 'other_field=' + textVal,
                    success: function (response) {

                        if (response.select == 0)
                        {
//                            $.fancybox.open('<div class="message" ><h2>Written field already available in Field Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                            $("#other_field").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written field already available in Field Selection</span>').insertAfter('#other_field');
                        } else if (response.select == 1)
                        {
                            $("#other_field").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_field');
//                                          $('#other_field').parent().append('<span class="error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>');
//                                        $.fancybox.open('<div class="message"><h2>Empty Field  is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else
                        {
                            $.fancybox.close();
                            $('.field_other').html(response.select);
                        }
                    }
                });
            }
        });
    }

});

function remove_validation() {
    $("#other_field").removeClass("keyskill_border_active");
    $('#field_error').remove();
}

function category_other_field(cat_val)
{
    if(cat_val.trim() != '' && cat_val == 0)
    {
        $("#other_field_div").show();
    }
    else
    {
        $("#other_field_div").hide();
    }
}
//SCRIPT FOR ADD OTHER FILED END