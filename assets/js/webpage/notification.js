socket.on('user notification succ', (data) => {    
    if(user_id != '' && data.user_id == user_id)
    {
        if(data.not_count > 0)
        {
            $(".noti_count").show();
            if(parseInt(data.not_count) > 99)
            {
                $(".noti_count").html('99+');
            }
            else
            {
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