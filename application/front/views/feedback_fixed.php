<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="fix-feedback">
	<div class="fix-small">
		<span>Feedback</span>
	</div>
	<div class="fix-big">
		<div class="feed-top">
			Feedback<a class="pull-right feed-close"><img src="<?php echo base_url('assets/n-images/f-close.png') . '' ?>"></a>
		</div>
		<form action="javascript:void(0);" name="main_feedback" id="main_feedback">
			<?php if($user_id == ""): ?>
			<div class="form-group">
				<input type="text" name="f_email" id="f_email" placeholder="Enter Your Email">
			</div>
			<?php endif; ?>
			<div class="form-group">
				<textarea type="text" id="f_desc" name="f_desc" placeholder="Add Discription" maxlength="1000"></textarea>
			</div>
			<div class="form-group fd-btn">
				<!-- <a href="#">Add Screensot</a> -->
				<input file-input="files" type="file" id="feedback_file" name="postfiles[]" data-overwrite-initial="false" multiple="" onchange="makeFileList()" style="display: none;">
				<label for="feedback_file">
					<i class="upload_icon">
						<span class="upload_span_icon"> Add Screenshot </span>
					</i>
					<span id="fileList"></span>
				</label>
				<button id="send_feedback" class="pull-right" type="submit"><img src="<?php echo base_url('assets/n-images/fd-send.png') . '' ?>"></button>
			</div>
			<div id="feed_success" class="form-group" style="display: none;position: absolute;bottom: 53px;color: #1b8ab9;">
				Thank you for the feedback.
			</div>
		</form>
	</div>
</div>
<div class="modal fade message-box post-error" id="feedback-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";
var user_id = "<?php echo $this->session->userdata('aileenuser'); ?>";
var valid_img = false;
$(function() {
	$("#f_email").focusin(function(){
        $(this).removeClass("error");
    });
    $("#f_desc").focusin(function(){
        $(this).removeClass("error");
    });

});

function makeFileList() {
	var input = document.getElementById("feedback_file");
	var ul = document.getElementById("fileList");
	$("#fileList").html("");
	if(input.files.length > 5)
	{
		// alert("Select Only 5 Images.");
		$("#feedback-modal .mes").html('<div class="pop_content error">Select Only 5 Screenshot.</div>');
		$("#feedback-modal").modal("show");
		setTimeout(function(){
			// $("#feed_success").hide();
			$("#feedback-modal .mes").html('');
			$("#feedback-modal .modal-close").click();
		},5000);
		// $("#feedback_file").val();
		input.value = "";		
	}
	else
	{
		if(input.files.length > 0)
		{
			for(i=0;i<input.files.length;i++)
			{
				if(!(input.files[i].type == "image/jpeg" || input.files[i].type == "image/png" || input.files[i].type == "image/gif"))
				{
					alert("Invalid Image");
					return false;
				}
			}
			$("#fileList").html(input.files.length+" image selected.");
		}
		else{
			$("#fileList").html("");
		}
	}

}
$(document).ready(function (e) {
	$("#main_feedback").on('submit',(function(e) {
		e.preventDefault();
		if(user_id == ""){
			var f_email = $("#f_email").val();
		}
		else{
			var f_email = user_id;
		}
		var f_desc = $("#f_desc").val();
		if(f_email == "" && f_desc == "")
		{
			$("#f_email").addClass("error");
			$("#f_desc").addClass("error");
			return false;
		}
		else if(f_email == "")
		{
			$("#f_email").addClass("error");
			return false;
		}
		else if(f_desc == "")
		{
			$("#f_desc").addClass("error");
			return false;
		}
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(!f_email.match(mailformat) && user_id == "")
		{		
			$("#f_email").addClass("error");
			return false;
		}
		$("#send_feedback").attr('disabled','disabled')
		$("#send_feedback img").attr('src',base_url+'assets/images/loader.gif')
		$.ajax({
			url: base_url+"feedback/main_feedback_insert", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				$("#send_feedback").removeAttr('disabled');
				$("#send_feedback img").attr('src',base_url+'assets/n-images/fd-send.png');
				$("#feedback-modal .mes").html('<div class="pop_content" style="color: #1b8ab9;">Thank You for the Feedback.</div>');
				$("#feedback-modal").modal("show");
				setTimeout(function(){
					// $("#feed_success").hide();
					$("#feedback-modal .mes").html('');
					// $("#feedback-modal").modal("hide");
					$("#feedback-modal .modal-close").click();
				},5000);
				$("#main_feedback")[0].reset();
				$("#fileList").html("");
			}
		});
	}));
	// Function to preview image after validation
	/*$(function() {
		$("#file").change(function() {
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{
				$('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			}
			else
			{
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});
	});
	function imageIsLoaded(e) {
		$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
	};*/
});
</script>
<!--div class="fix-feedback mobile">
	<div class="fix-small1" data-target="#feed-mob" data-toggle="modal">
		Feedback<span class="pull-right"><img src="<?php echo base_url('assets/n-images/fd.png') . '' ?>"></span>
	</div>
	<div style="display:none;" class="modal fade" id="feed-mob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="fix-big">
						<div class="feed-top">
							Feedback
						</div>
						<form>
							<div class="form-group">
								<input type="text" placeholder="Enter Your Email">
							</div>
							<div class="form-group">
								<textarea type="text" placeholder="Add Discription"></textarea>
							</div>
							<div class="form-group pt20 fd-btn">
								<a href="#">Add Screensot</a>
								<button class="pull-right btn1" type="submit">Send</button>
							</div>
						</form>
					</div>
                </div>
            </div>
        </div>

</div-->

<script>
	$(".fix-small").click(function(){
		$(".fix-big").show();
		$(".fix-small").hide();
	});
	$(".feed-close").click(function(){
		$(".fix-big").hide();
		$(".fix-small").show();
	});
</script>