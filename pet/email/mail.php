<?php 
function register_mail($name,$email,$password) // For Register mail			
{
	 $to = $email;
	
	$subject = "Discover My Pet User";
	$message = "<html>
				<head><title>Registration details of Discovermypet</title></head>
				<body>	
					<table style='margin:0;padding:0;width:100%!important;line-height:100%!important' width='100%' cellspacing='0' cellpadding='0' border='0' height='100%'>
					<tbody><tr>	
					<td valign='top' bgcolor='ECECEC' background='bg_grey.gif' align='center'>	
					<table width='700' cellpadding='0' border='0'>
					<tbody><tr>
					<td valign='top' align='left'>
					<table width='100%' cellspacing='0' cellpadding='0' border='0'>
					<td width='155' valign='bottom' align='left' height='56'><img src='http://discovermypet.in/pet/email/dmp_logoTNM.png' alt='Discovermypet' style='outline:none;display:block' class='CToWUd' width='169' border='0' height='70'></td>
					</tr></tbody>
				</table>
				<table style='border-radius:7px;border-top:1px solid #e1e1e1;border-right:1px solid #cecece;border-left:1px solid #cecece;border-bottom:1px solid #b4b4b4' width='80%' cellspacing='0' cellpadding='0' border='0' bgcolor='ffffff'>
					<tbody><tr>
						<td valign='top' align='center'>								
							<table width='100%' cellspacing='0' cellpadding='22' border='0'>
								<tbody><tr>
									<td valign='top' align='center'><h2 style='font-family:Lucida Sans Unicode;color:#000000!important;line-height:40px;font-size:34px;margin-top:0;margin-left:0;margin-right:0;margin-bottom:2px;font-weight:400;letter-spacing:-1px'>Welcome to Discovermypet</h2>
									<h2 style='font-family:Lucida Sans Unicode; line-height:22px;color:#666666!important;font-size:18px;margin-top:0;font-weight:lighter;line-height: 0;margin-top: 20px;'>Visit us www.discovermypet.in</h2></td>
								</tr></tbody>
								</table>
								<table style='border-radius:7px;border-top:1px solid #e1e1e1;border-right:1px solid #cecece;border-left:1px solid #cecece;border-bottom:1px solid #b4b4b4' width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='ffffff'>
									<tbody><tr>
										<td valign='top' align='center'><img src='line.gif' style='outline:none;display:block' class='CToWUd' width='700' border='0' height='7'> 
											<table width='100%' cellspacing='0' cellpadding='0' border='0' height='12'>
												<tbody><tr>
													<td valign='top' align='left' height='12'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='15'></td>
												</tr></tbody>
											</table>
											<table width='100%' cellspacing='0' cellpadding='0' border='0'>
												<tbody><tr>
												<td valign='top' align='center'>
													<table width='656' cellspacing='0' cellpadding='0' border='0'>
													<tbody><tr>
														<td valign='top' align='left'><h3 style='font-family:Lucida Sans Unicode; color:#000000!important;font-size:21px;line-height:.8em;margin-top:0;margin-left:0;margin-right:0;margin-bottom:0;font-weight:200'>Thank you for Registration</h3></td>
													</tr>
													<tr>
														<td valign='top' align='left' height='12'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='15'></td>
													</tr><tr>
														<td valign='top' align='left' height='12'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='15'></td>
													</tr>
													<tr>
														<td valign='top' align='left'><h3 style='font-family:Lucida Sans Unicode;color:#000000!important;font-size:17px;line-height:.8em;margin-top:0;margin-left:0;margin-right:0;margin-bottom:0;font-weight:200'>Your Registration Details </h3></td>
													</tr></tbody>
													</table>
													<table width='100%' cellspacing='0' cellpadding='0' border='0' height='15'>
													<tbody><tr>
														<td valign='top' align='left' height='15'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='15'></td>
													</tr></tbody>
													</table>
													<table style='border-right:1px solid #d4d4d4;border-left:1px solid #d4d4d4;border-bottom:1px solid #aaaaaa;border-radius:5px' width='656' cellspacing='0' cellpadding='12' border='0'>		
													</table>
													<table width='100%' cellspacing='0' cellpadding='0' border='0' height='15'>
														<tbody><tr>
															<td style='height:15px' valign='top' align='left' height='15'><img src='space.gif' style='display:block;outline:none' alt='' class='CToWUd' width='1' border='0' height='15'></td>
														</tr></tbody>
													</table>
													<table width='622' cellspacing='0' cellpadding='0' border='0' align='center'>
							<tbody><tr>
							<td style='font-family:Lucida Sans Unicode;color:#111111;font-size:12px;font-weight:bold;line-height:18px' valign='top' align='left'>Name</td>
							<td width='1' valign='top' align='left'></td>
							<td style='font-family:Lucida Sans Unicode;color:#111111;font-size:12px' width='189' valign='top' align='left'>
							<div style='line-height:18px'>$name</div></td>
							</tr>
							<tr>
							<td colspan='7' height='12'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='12'></td>
							</tr>
							<tr>
							<td style='font-family:Lucida Sans Unicode;color:#111111;font-size:12px;font-weight:bold;line-height:18px' width='90' valign='top' align='left'>Email</td>
							<td width='1' valign='top' align='left'></td>
							<td style='font-family:Lucida Sans Unicode; color:#111111;font-size:12px;line-height:18px' width='189' valign='top' align='left'><a href='mailto:<?php echo $email; ?>' target='_blank'>$email</a></td>
							</tr>
							<tr>
							<td colspan='7' height='12'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='12'></td>
							</tr>
							<tr>
							<td style='font-family:Lucida Sans Unicode; color:#111111;font-size:12px;font-weight:bold;line-height:18px' width='90' valign='top' align='left'>Password</td>
							<td width='1' valign='top' align='left'></td>
							<td style='font-family:Lucida Sans Unicode; color:#111111;font-size:12px;line-height:18px' width='400' valign='top' align='left'>$password</td>
							</tr>
							<tr>
							<td colspan='7' height='12'><img src='space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='12'></td>
							</tr>
							
							</tbody>
						</table>				
					</td>
				</tr></tbody>
			</table>												
		</td>
	</tr>
	<tr>
		<td style='padding:29px 13px 0;margin:0;font-family:Lucida Sans Unicode; color:#3d3d3d;font-size:15px;line-height:1.6em'>Thanks again for joining!
		<br><br>Sincerely,<br>Discover My Pet team
		<img src='pet/space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='15'><img src='pet/space.gif' alt='' style='display:block;outline:none' class='CToWUd' width='1' border='0' height='15'></td>
	</tr></tbody>
</table>
</td>
</tr></tbody>
</table>
</td>
</tr></tbody>
</table>
</td>
</tr></tbody>
</table>
</body>
</html>	";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@discovermypet.com>' . "\r\n";

mail($to,$subject,$message,$headers);
}

?> 