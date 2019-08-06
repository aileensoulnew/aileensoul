socket.on('user notification succ', (data) => {    
    if(user_id != '' && data.user_id == user_id)
    {
        if(data.not_count > 0)
        {
            $(".noti_count").show();
            if(parseInt(data.not_count) > 99)
            {
                $(".noti_count").addClass('not-max');
                $(".noti_count").html('99+');
            }
            else
            {
                $(".noti_count").removeClass('not-max');
                $(".noti_count").html(data.not_count);
            }            
        }
        else
        {
            $(".noti_count").hide();
            $(".noti_count").html('');
        }

        if(data.contact_count > 0)
        {
            $(".con_req_cnt").show();
            if(data.contact_count > 99)
            {
                $(".con_req_cnt").addClass('not-max');
                $(".con_req_cnt").html('99+');
            }
            else
            {
                $(".con_req_cnt").removeClass('not-max');
                $(".con_req_cnt").html(data.contact_count);
            }
        }
        else
        {
            $(".con_req_cnt").hide();
            $(".con_req_cnt").html('');
        }

        if(data.msg_count > 0)
        {
            if(parseInt(data.msg_count) > 99)
            {
                $(".msg-count").addClass('not-max');
                $(".msg-count").html('99+');
            }
            else
            {
                $(".msg-count").removeClass('not-max');
                $(".msg-count").html(data.msg_count);
            }
        }
        else
        {
            $(".msg-count").hide();
            $(".msg-count").html('');
        }
    }
});
socket.on('user push notification succ', (response) => {
    $.ajax({
        url: base_url + "user_post/is_mutual",        
        type: "POST",
        data: 'user_id='+response.user_id,
        cache: false,
        dataType:"JSON",
        success: function (data) {
            if(data == 1){
                var user = response.fullname;
                var message = "Add new post.";
                notifyMe(user,message);
            }
        }
    });
});

function notifyMe(user,message) {
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }
    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
        var options = {
            body: message,
            dir : "ltr"
        };
        var notification = new Notification(user,options);
    }
    // Otherwise, we need to ask the user for permission
    // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // Whatever the user answers, we make sure we store the information
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }
            // If the user is okay, let's create a notification
            if (permission === "granted") {
                var options = {
                body: message,
                dir : "ltr"
            };
            var notification = new Notification(user + " Posted a comment",options);
            }
        });
    }
    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother them any more.
}