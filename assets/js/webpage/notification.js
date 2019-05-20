socket.on('user notification succ', (data) => {    
    if(user_id != '' && data.user_id == user_id)
    {
        if(data.not_count > 0)
        {
            $(".noti_count").show();
            $(".noti_count").html(data.not_count);
        }
        else
        {
            $(".noti_count").hide();
            $(".noti_count").html('');
        }

        if(data.contact_count > 0)
        {
            $(".con_req_cnt").show();
            $(".con_req_cnt").html(data.contact_count);
        }
        else
        {
            $(".con_req_cnt").hide();
            $(".con_req_cnt").html('');
        }

        if(data.msg_count > 0)
        {
            $(".msg-count").show();
            $(".msg-count").html(data.msg_count);
        }
        else
        {
            $(".msg-count").hide();
            $(".msg-count").html('');
        }
    }
});