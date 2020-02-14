<?php if (substr_count($_SERVER['PHP_SELF'],'/process.php')>0) die ("You can't access this file directly..."); ?>
<?php session_start(); ?>
<div class="main">
<?php 
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $key => $value){
        if(isset($key)){
            $ok=2;
            $item[] = $key;
        }
    }
		if($ok==2){
		$mang1 = implode(",",$item);
	$sql = "select * from products where id in($mang1) ";
	$string ="<table width='660' border='0' cellpadding='0' cellspacing='0' style='border:1px solid #ccc; padding:10px; text-align: right;'>";
	$string .="
	<tr style='font-size: 12px;' >
    <th width='45' style='font-weight:normal;border-bottom:1px solid #ccc; text-align: center;'>STT</th>
    <th width='300' style='font-weight:normal;border-bottom:1px solid #ccc;text-align: center;'>".$display['products']."</th>
    <th width='104' style='font-weight:normal;border-bottom:1px solid #ccc;text-align: center;'>Đơn giá</th>
    <th width='100' style='font-weight:normal;border-bottom:1px solid #ccc;text-align: center;'>Số lượng</th>
    <th width='118' style='font-weight:normal;border-bottom:1px solid #ccc;text-align: center;'>".$display['total']."</th>
  </tr>";
	$doquery = mysql_query($sql);
	$i = 0;
		while($row = mysql_fetch_array($doquery)){
		$price = $row['price1'];
		if ( $price == '' )
			$price = $row['price'];
		$i++;
		$string .= 
        "<tr height='30px'>
            <td align='center'>".$i."</td>
            <td align='left'><b>".$row['title']."</td>
            <td align='right'>".bsVndDot($price)." ".$display['part_meny']."</td>
            <td align='right'>".$_SESSION['cart'][$row[id]]."</td>
            <td align='right'>".bsVndDot($_SESSION['cart'][$row[id]]*$price)." ".$display['part_meny']."</td>
        </tr>";

       $total=$_SESSION['cart'][$row['id']]*$price ;
		}

		 $string .= "<tr><td width='45'></td><td width='300' >Tổng tiền : </td><td width='104'></td><td width='100'  ></td><td>".bsVndDot($total)."".$display['part_meny']." </td></tr></tr></table > ";
		
	}
}
?>
<div class = "head"><h2>
<?php echo ''.$display['home'].' >'.$chain.$display['success']; ?>
</h2></div>       
<ul>
	<?php
			if (isset($_REQUEST['object']))
				{
					$obj=$_REQUEST['object'];
					switch ($obj)
					{
						case 'order':
							$datetime=date("d-m-Y");
							$message='<b>';
							$message.='Đặt hàng sản phẩm';
							$message.='</b>';
							$message='<br>Đơn đặt đặt hàng được gửi từ website no1';
							$message.='<b>';
							$message.=$_REQUEST['fullname'];
							$message.='</b>';
							$message.=' đến <b>SHOP.BLUESKY.VN </b> với thông tin : ';
							$message.='<b>';
							$message.='<br>Địa chỉ : ';
							$message.='</b>';
							$message.=$_REQUEST['address'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Điện thoại : ';
							$message.='</b>';
							$message.=$_REQUEST['phone'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Email : ';
							$message.='</b>';
							$message.=$_REQUEST['email'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Hình thức thanh toán với : ';
							$message.='</b>';
							$message.=$_REQUEST['payment'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Nội dung : ';
							$message.='</b>';
							$message.=$_REQUEST['content'];
							$message.='.<br/><br/>';
							$message.= $string;
							$message.='.';
							$email1=$_REQUEST['email'];
							$query='insert into contact(fullname,address,phone,email,log,products,content,lang) values("'.$_REQUEST['fullname'].'","'.$_REQUEST['address'].'","'.$_REQUEST['phone'].'","'.$_REQUEST['email'].'","'.$datetime.'","'.$string.'","'.$_REQUEST['content'].'","'.get_langID().'")';
							$doquery=mysql_query($query,$link);
							require("class.phpmailer.php");
							$mail = new PHPMailer();
							$mail->IsSMTP(); // send via SMTP
							//IsSMTP(); // send via SMTP
							$mail->SMTPAuth = true; // turn on SMTP authentication
							$mail->Username = "hoanggiagroupno1@gmail.com"; // SMTP username
							$mail->Password = "hoaik53a3"; // SMTP password
							$webmaster_email = "hoanggiagroupno1@gmail.com"; //Reply to this email ID
							echo $email1;
							$email=$email1; // Recipients email ID
							$name=" hoanggiagroup"; // Recipient's name
							$mail->From = $webmaster_email;
							$mail->FromName = "Khach hang dat hang toi hoanggia no1";
							$mail->AddAddress($email,$name);
							$mail->AddCC($webmaster_email,$name);
							$mail->WordWrap = 50; // set word wrap
							$mail->IsHTML(true); // send as HTML
							$mail->Subject = "Hoa don dat hang toi hoanggia";
							$mail->Body = $message; //HTML Body
							if(!$mail->Send())
							{
								echo "Mailer Error: " . $mail->ErrorInfo;
							}
							else
							{
								echo "";
							}
						?>				
						<div style="float: left; width: 580px; color: #344991; padding: 40px 5px; font-size: 14px; font-weight : bold; text-align: center;"><span style="line-height:18px; color: #C00000"><?php echo $display['contactsuccess']; ?></span></div>
						<?php
						session_unregister("cart");
						break;

						case 'contact':
							$datetime=date("d-m-Y");
							$message='<b>';
							$message.='Liên hệ';
							$message.='</b>';
							$message='<br>Lời nhắn được gửi từ ';
							$message.='<b>';
							$message.=$_REQUEST['fullname'];
							$message.='</b>';
							$message.=' đến <b>SHOP.BLUESKY.VN</b> với thông tin : ';
							$message.='<b>';
							$message.='<br>Địa chỉ : ';
							$message.='</b>';
							$message.=$_REQUEST['address'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Điện thoại : ';
							$message.='</b>';
							$message.=$_REQUEST['phone'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Email : ';
							$message.='</b>';
							$message.=$_REQUEST['email'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Hình thức liên hệ : ';
							$message.='</b>';
							$message.=$_REQUEST['contactwith'];
							$message.='.';
							$message.='<b>';
							$message.='<br>Nội dung : ';
							$message.='</b>';
							$message.=$_REQUEST['content'];
							$message.='.';
							//echo $message;
							$email1=$_REQUEST['email'];
							$query='insert into contact(fullname,address,phone,email,log,content,lang) values("'.$_REQUEST['fullname'].'","'.$_REQUEST['address'].'","'.$_REQUEST['phone'].'","'.$_REQUEST['email'].'","'.$datetime.'","'.$_REQUEST['content'].'","'.get_langID().'")';
							$doquery=mysql_query($query,$link);
							require("class.phpmailer.php");
							$mail = new PHPMailer();
							$mail->IsSMTP(); // send via SMTP
							//IsSMTP(); // send via SMTP
							$mail->SMTPAuth = true; // turn on SMTP authentication
							$mail->Username = "hoanggiagroupno1@gmail.com"; // SMTP username
							$mail->Password = "hoaik53a3"; // SMTP password
							$webmaster_email = "hoanggiagroupno1@gmail.com";
							$email=$email1; // Recipients email ID
							$name="hoang gia"; // Recipient's name
							$mail->From = $webmaster_email;
							$mail->FromName = "Khach hang lien he toi hoang gia"; 
							$mail->AddAddress($email,$name);
							$mail->AddCC($webmaster_email,$name);
							$mail->WordWrap = 50; // set word wrap
							$mail->IsHTML(true); // send as HTML
							$mail->Subject = "Lien he toi hoang gia";
							$mail->Body = $message; //HTML Body
							if(!$mail->Send())
							{
								echo "Mailer Error: " . $mail->ErrorInfo;
							}
							else
							{
								echo "";
							}
						?>				
						<div style="float: left; width: 700px; color: #344991; padding: 40px 5px; font-size: 14px; font-weight : bold; text-align: center;"><span style=" line-height:18px; color: #C00000"><?php echo $display['contactsuccess']; ?></span></div>
				
						<?php
						break;						
					}
				}
			else
			{
			?>
			<script>
				alert("<?php echo $display['incorrec']; ?>")
				window.history.go(-1)
			</script>
			<?php
			}
	?>
	</ul>
	<div class="bottom"></div>
</div>	