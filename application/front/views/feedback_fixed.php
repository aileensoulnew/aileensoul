<div class="fix-feedback">
	<div class="fix-small">
		<span>Feedback</span>
	</div>
	<div class="fix-big">
		<div class="feed-top">
			Feedback<a class="pull-right feed-close"><img src="<?php echo base_url('assets/n-images/f-close.png') . '' ?>"></a>
		</div>
		<form>
			<div class="form-group">
				<input type="text" placeholder="Enter Your Email">
			</div>
			<div class="form-group">
				<textarea type="text" placeholder="Add Discription"></textarea>
			</div>
			<div class="form-group fd-btn">
				<a href="#">Add Screensot</a><button class="pull-right" type="submit"><img src="<?php echo base_url('assets/n-images/fd-send.png') . '' ?>"></button>
			</div>
		</form>
	</div>
</div>
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