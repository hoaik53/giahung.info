<?php if (substr_count($_SERVER['PHP_SELF'],'/order.php')>0) die ("You can't access this file directly..."); ?>
<style>
#cart_detail {float: center;width: 580px;margin-left: 5px; clear: both; height: 50px; text-transform: uppercase;}
#cart_detail div.c1 {float: left;width: 40px; height: 50px; padding-left: 5px; 	}
#cart_detail div.c2 { float: left;width: 100px;padding-left: 5px;height: 50px;  }
#cart_detail div.c3 { float: left;width: 90px;padding-left: 10px;height: 50px;  }
#cart_detail div.c4 { float: left;width: 95px;padding-left: 0px;height: 50px;  }
#cart_detail div.c6 { float: left;width: 70px;padding-left:5px;height: 50px;  }
#cart_detail div.c7 { float: left;width: 20px; padding-left:10px;height: 50px;  }
#cart_detail div.c8 { float: left;width: 100px; padding-left: 20px;height: 50px; }
#cart_detail1 {float:left; width: 100%; line-height: 20px;  } 
#cart_detail1 div.c1 {float: left; width: 580px; height: 20px;}
#cart_detail1 div.c2 {float: left; width: 100px; height: 20px;}
#cart_detail1 div.c2 {float: left; width: 100px; height: 20px;}
</style>
<div class="main">	
<?php
if(isset($_POST['submit']))
{
 foreach($_POST['qty'] as $key=>$value)
 {
  if( ($value == 0) and (is_numeric($value)))
  {
   unset ($_SESSION['cart'][$key]);
  }
  elseif(($value > 0) and (is_numeric($value)))
  {
   $_SESSION['cart'][$key]=$value;
  }
 }
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'chi-tiet-gio-hang.html';
$url = "http://".$host."/".$extra;
?>
<script language="javascript" type="text/javascript">
window.location='<?php echo $url; ?>';
</script>
<?php
}
	?>
	<div class = "head"><h2><?php echo $display['home']; ?> &raquo; <?php echo $display['cart']; ?></h2></div>
	<ul style="padding-bottom: 20px; border-top: none;">
         <div style="float:left;width:100%;height: 50px;padding-top:10px; padding-left:10px;">
			<a href="#"><div style="float: left;width:125px;padding-right:15px;">1) <?php echo  $display['b1'];?></div></a>
			<a href="/chi-tiet-gio-hang.html"><div style="float: left; width:125px; padding-right:15px;">2) <?php echo  $display['b2'];?></div></a>
			<div style="float: left;width:125px;padding-right:15px;font-weight:bold; color: #ff0000; font-size: 12px;">3)<?php echo  $display['b3'];?></div>
			<div style="float: left;width:125px;">4) <?php echo  $display['b4'];?></div>
		</div>	
		<div  id="cart_detail" style="border-bottom: 1px solid #666; height: 20px; margin-bottom: 10px; padding-top: 20px;">
			<div class="c1" style=" text-align: center;" >STT</div>
			<div class="c2"><?php echo $display['products']; ?></div>
			<div class="c3"><?php echo $display['image'];?></div>
			<div class="c4" >ĐƠN GIÁ</div>
			<div class="c6"><?php echo $display['count'];?></div>
			<div class="c7"></div>
			<div class="c5" ><?php echo $display['unit'];?></div>
			<div class="c8" style=""><?php echo $display['total'];?></div>
		</div>	
<?php
echo "<div style='float:left; width:100%;'>";
echo "<form action=/chi-tiet-gio-hang.html method=post>";
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
$doquery = mysql_query($sql);
echo "<div style='float:left; width:100%; border:1px solid #ccc;margin-bottom:20px;'>";
$total = 0;
$i=0;
while($row = mysql_fetch_array($doquery)){
	$i++;
		
	$price = $row['price'];
    $url='/chi-tiet-gio-hang/xoa-gio-hang/'.$row['id'].'.html';
  ?>
	<div  id="cart_detail"  style="text-transform: none;  padding-top: 5px;">
		<div class="c1" style=" text-align: center;"><?php echo $i; ?></div>
		<div class="c2" ><b><?php echo $row['title']; ?></b></div>
		<div class="c3"><img src="<?php echo $row['image'];?>" width="80" height="75"/></div>
		<div class="c4" style="color: #ff0000;"><?php echo bsVndDot($price).' '.$display['part_meny'];?></div>
		<div class="c6"><?php echo $_SESSION['cart'][$row[id]]; ?></div>
		<div class="c7"></div>
		<div class="c8" style="text-align: left; width: 100px; color: #ff0000;"><?php echo bsVndDot($_SESSION['cart'][$row[id]]*$price).' '.$display['part_meny']; ?></div>
	</div>	
  <?php
  $total+=$_SESSION['cart'][$row[id]]*$price;    
} 
  $total=bsVndDot($total);
echo "<div style='float:right;font-weight:bold; color: red; padding: 10px 60px 10px 0;font-size: 14px; clear: both; '>$display[total] $total $display[part_meny]  </div>";
echo "</div>"; 
$url='/dat-hang.html';    
}
else{
    echo $display['null'];
}
  echo "</form>";
}
else{
echo $display['cart_null'];
}
echo "</div>";
?>
				<script>
                    function checkcontact()
                        {
                        str = document.check.phone.value;
                        if (document.check.fullname.value=='')
                            {
                            alert('<?php echo $display['namecheck']; ?>');
                            document.check.fullname.focus();
                            return false;
                            }
                        if (document.check.address.value=='')
                            {
                            alert('<?php echo $display['addcheck']; ?>');
                            document.check.address.focus();
                            return false;
                            }
                        if (str=='')
                            {
                            alert('<?php echo $display['phonecheck']; ?>');
                            document.check.phone.focus();
                            return false;
                            }
                        if (isNaN(str))
                            {
                            alert('<?php echo $display['fnumbercheck']; ?>');
                            document.check.phone.focus();
                            return false;
                            }
                        if (document.check.payment.value=='')
                            {
                            alert('<?php echo $display['contactwithcheck']; ?>');
                            document.check.payment.focus();
                            return false;
                            }	
                        if (document.check.content.value=='')
                            {
                            alert('<?php echo $display['contentcheck']; ?>');
                            document.check.content.focus();
                            return false;
                            }
                        mail = /^[a-z][a-z0-9_\.]*\@[a-z-]*\.[a-z]*[a-z0-9_\.]*/g;
                       // if(mail.test(document.check.email.value)==false)
                        //    {
                        //    alert('<?php echo $display['emailcheckerror']; ?>');
                        //    document.check.email.focus();
                        //    flag=false;
                        //    return false;
                        //    }
                        }
                </script>
				<form name="check" method="post" action="/dat-hang/thong-tin-don-hang.html" onSubmit="return checkcontact();" style="700px;">
					<div id="content_project">
                        <div style="float: left; width: 568px; padding-top: 0px;">
							<div style="padding:15px 0 10px 40px;line-height: 160%; "><?php echo $display['orderinfo']; ?> : </div>
                        <div style="float: left; width: 500px; padding-top: 10px;">
                        
                        <div style="clear: both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['fullname']?> : </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="fullname" type="text"></div>
                        
                        <div style=" clear: both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['address']?>  </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="address" type="text"></div>
        
                        <div style=" clear: both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['phone']?>  </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="phone" type="text"></div>
        
                        <div style=" clear: both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['email']?> : </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="email" type="text"></div>
        
                        <div style=" clear: both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['payment']?> : </div>
                        <div style="text-align: left; padding-top: 8px;">
                            <select name="payment" style="padding: 3px;">
                                <option value=""> --- <?php echo $display['progress_payment']; ?> --- </option>
                                <option value="<?php echo $display['bank_payment']; ?>"> - <?php echo $display['bank_payment']; ?> - </option>
                                <option value="<?php echo $display['house_payment']; ?>"> - <?php echo $display['house_payment']; ?> - </option>
                                <option value="<?php echo $display['shop_payment']; ?>"> - <?php echo $display['shop_payment']; ?> - </option>
                            </select>
                        </div>
                        
                        <div style=" clear: both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['information']; ?> : </div>
                        <div style="text-align: left; padding-top: 8px;"><TEXTAREA name="content" rows="6" cols="38"></TEXTAREA></div>
                        <div style="float: left; padding-left: 10px; padding-top: 20px; width: 500px; margin-left:100px;">
                        <input name="Submit" type="submit" value=" <?php echo $display['send']; ?> " class="input" />
                        &nbsp;<input name="Submit" type="reset" value=" <?php echo $display['reset']; ?> " class="input" />
                        </div>
                    
                        </div>
                        </div>
					</div>
                </form>
	</ul>
	<div class="bottom"></div>			
</div>				