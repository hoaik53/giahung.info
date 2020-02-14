<?php if (substr_count($_SERVER['PHP_SELF'],'/cart_detail.php')>0) die ("You can't access this file directly..."); ?>
<style>
#cart_detail {float: center;width: 580px; clear: both; height: 50px; text-transform: uppercase; margin-left: 4px;}
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
</style>
<div class="main">
<?php
if(isset($_POST['submit1']))
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
<ul style="padding-bottom: 20px; border-top: none; ">	
<div style="float:left;width:100%;height: 50px;padding-top:15px; padding-left:10px;">
   <a href="/"> <div style="float: left;width:125px;padding-right:15px;">1) <?php echo  $display['b1'];?></div></a>
    <div style="float: left;width:125px;padding-right:15px; color: #ff0000; font-weight: bold;">2) <?php echo  $display['b2'];?></div>
    <div style="float: left;width:125px;padding-right:15px;">3) <?php echo  $display['b3'];?></div>
    <div style="float: left;width:125px;">4) <?php echo  $display['b4'];?></div>
</div>
<div  id="cart_detail" style="border-bottom: 1px solid #666; height: 20px; margin-bottom: 10px; padding-top: 20px;">
	<div class="c1" style=" text-align: center;" >STT</div>
	<div class="c2"><?php echo $display['products']; ?></div>
	<div class="c3"><?php echo $display['image'];?></div>
	<div class="c4">ĐƠN GIÁ</div>
	<div class="c6"><?php echo $display['count'];?></div>
	<div class="c7"></div>
	<div class="c5" ><?php echo $display['unit'];?></div>
	<div class="c8" style=""><?php echo $display['total'];?></div>
</div>	
<?php
echo "<div style='float:left; width:100%;'>";
echo "<form action='/chi-tiet-gio-hang.html' method='post' name='updatecart' >";
//echo $_SESSION['cart'];
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $key => $value){
        if(isset($key)){
            $ok=1;
            $item[] = $key;
        }
    }
    if($ok==1){
    $mang1 = implode(",",$item);
   // $dbc =mysql_connect('localhost','root','');
   // mysql_select_db('mispic_db',$dbc);
$sql = "select * from products where id in($mang1)";
//and lang=".get_langID()."
$doquery = mysql_query($sql);
echo "<div style='float: left; ; margin: 2px; width: 584px; border:1px solid #ccc;margin-bottom:20px; padding-top: 20px;'>";
$total = 0;
$i=0;
while($row=mysql_fetch_array($doquery)){
	$i++;
    $url='/chi-tiet-gio-hang/xoa-gio-hang/'.$row['id'].'.html';
  ?>
	<div  id="cart_detail"  style="text-transform: none;  padding-top: 5px;">
		<div class="c1" style=" text-align: center;"><?php echo $i; ?></div>
		<div class="c2"><?php echo $row['title']; ?></div>
		<div class="c3"><img src="<?php echo $row['image'];?>" width="60" height="45"/></div>
		<div class="c4"><?php echo bsVndDot($row['price']).' '.$display['part_meny'];?></div>
		<div class="c6"><input  style="" type='text' name='qty[<?php echo $row['id']?>]' maxlength="5" size="5" value=<?php echo $_SESSION['cart'][$row[id]]; ?>></div>
		<div class="c7"><a href='<?php echo $url; ?>'><?php echo $display['del'];?></a></div>
		<div class="c8" style="text-align: left; width: 110px;"><?php echo bsVndDot($_SESSION['cart'][$row[id]]*$row['price']).' '.$display['part_meny']; ?></div>
	</div>	
  <?php
  $total+=$_SESSION['cart'][$row['id']]*$row['price']; 
}
  $total=bsVndDot($total);
echo "<div style='float:right; padding-right: 60px;font-weight:bold; font-size: 14px;color: red; padding-bottom: 20px;clear: both;  '>$display[total] :   $total $display[part_meny]</div>";
echo "</div>"; 
$url='/dat-hang.html'; 
    ?>
    <div style="float: left;width: 550px;height: 30px;clear: both; text-align: center; padding-left:40px;">
		<div style="float: left;font-weight: bold; border: 1px solid #ccc; height: 16px; padding:2px; width:140px; text-align: center; "><a href='/' style="width:130px; padding-top:6px;padding-left:3px;padding-right:3px; text-align: center;"><?php echo $display['next'];?></a></div>
		<div style="float: left;font-weight: bold; border: 1px solid #ccc; height: 16px; padding:2px;margin-left: 50px; margin-right: 50px; width:140px; text-align: center; "><a href='javascript:void(0);' onclick='document.updatecart.submit();' style="width:100px; padding-top:6px;padding-left:3px;padding-right:3px; text-align: center;"><?php echo $display['update_cart'];?></a></div>
        <input type='hidden' name='submit1' value='true' />
		<!--div style="float: left;width:140px;padding-left: 50px; margin-right:50px; text-align: center;"><input type='submit' name='submit1' value='<?php echo $display['update_cart'];?>' style="background-color: #fff;font-weight: bold;font-size: 12px; height: 22px;border: 1px solid #ccc; padding-left:3px;padding-right:3px; text-align: center;width:140px;"/></div-->
        <div style="float: left;font-weight: bold;  border: 1px solid #ccc; height: 16px; padding:2px;text-align: center;width:110px;"><a href='<?php echo $url; ?>'style=" padding-top:6px;padding-left:3px;padding-right:3px;text-align: center;width:80px;"><?php echo $display['order']?></a></div>
    </div>
    <?php     
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
	</ul>
	<div class="bottom"></div>
</div>