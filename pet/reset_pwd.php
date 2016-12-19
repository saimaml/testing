<?php $email = str_rot13($_GET['email']);?>
<html>
	<head><title>Reset password	</title></head>
	<body>
		<div class="center" style="background-color: rgb(239, 239, 239); height: 299px; margin-left: 250px; width: 775px;">
		<img style="margin-left: 100px;padding-top: 20px;" src="http://discovermypet.in/pet/uploads/dmp_logo.__orange.png">
		<div style="background-color: #fff;height: 150px;margin-bottom: -64px; margin-left: 100px;width: 577px;text-align: center;">
			<form method="post" action="api.php">
				<input type="hidden" name="action" value="reset_pwd"><br>
				<input type="hidden" name="email" value="<?php echo $email ?>">  <br>
				Enter New Password : &nbsp;&nbsp;<input type="textbox" name="password"><br><br>
				<!--Confirm Password:&nbsp;&nbsp;&nbsp;<input type="textbox" name="confirm_pwd"><br><br>-->
				<input type="submit" name="button" value="Submit">
			</form>
		</div>
		</div>
	</body>
</html>