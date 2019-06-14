<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<title>Welcome Mail</title>
<style>
	td{font-family:Arial;}
	.container {display: block!important; max-width: 600px!important; margin: 0 auto!important; clear: both!important;}
	.content {padding: 15px; max-width: 600px; margin: 0 auto; display: block;}
	.header{text-align: center;}
	.header img{width: 35px; height: 35px; vertical-align: middle;}
	.header a{text-decoration: none; display: inline-block;}
	.header span{color: #1b8ab9; font-size: 23px; vertical-align: middle; padding-left: 10px;}
	.column-wrap {padding: 0px; max-width: 600px; margin: 0 auto;}
	table {width: 100%;}
	.column{float: left; width: 100%;}
	.user-img{width: 50px; height: 50px;}
	.user-img img{width: 100%;}
	.btn{background: #1b8ab9; font-size: 14px; color: #fff !important; padding: 5px 15px; text-decoration: none; border-radius: 3px; display: inline-block;}
	.user-content p{margin: 0; color: #5c5c5c; font-size: 14px;}
	.user-content span{font-size:12px; color: #7b7b7b; }
	.p10{padding: 10px;}
	.fw{width: 100%; float: left;}
	.user-img-td{width: 40px; padding-left: 10px; padding-right: 10px;}
	.mail-btn{padding-right: 10px; text-align: right;}
	.column-bottom{border-top: 1px solid #d2d2d2; width: 100%; float: left; text-align: center; font-size: 12px;}
	.column-bottom table{padding: 15px 10px; }
	.column-bottom table td{color:#7b7b7b;}
	.column-bottom a{font-size: 13px; text-decoration: none; color:#5c5c5c;}
	@media only screen and (max-width: 600px) {
		div[class="column"] { width: 100% !important; float:left !important; display: none !important;}
		div[class="column-right"] { width: 100% !important; float:left !important; padding-top: 15px;}		
		div[class="user-img"] { width: 40px!important; height: 40px !important; background: #ff0000 !important}		
	}

</style>
</head>
<body>
	<div class="container">
		<table style="background:#fff; border:1px solid #d2d2d2; border-radius:20px; margin: 0 auto;" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<div class="content header">
						<table cellpadding="0" cellspacing="0">
							<a href="">
								<img src="https://www.aileensoul.com/assets/img/mail/m-logo.png"> <span>Aileensoul</span>
							</a>
						</table>
					</div>
					<div class="column-wrap">
						<div class="column">
							<?php echo $main_part; ?>
						</div>
						<div class="p10 fw"></div>
						<div class="column-bottom">
							<table cellpadding="0" cellspacing="0">
								<?php if($unsubscribe_link != ''): ?>
								<tr>
									<td style="padding-bottom: 10px;">
										<a href="<?php echo $unsubscribe_link; ?>">Unsubscribe</a>
									</td>
								</tr>
								<?php endif; ?>
								<tr>
									<td>
										Aileensoul Technologies Private Limited
									</td>
								</tr>
								<tr>
									<td>
										Titanium City Centre, 100 Feet Road, Satellite, Ahmedabad, India.
									</td>
								</tr>
								
							</table>
						</div>					
					</div>
				</td>
			</tr>
		</table>
	</div>
	
</body>
</html>