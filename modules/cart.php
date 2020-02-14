<?php
include('../function.php');
session_start();
?>
<?php
 $total=0;
$id = $_GET['p'];
if(isset($_SESSION['cart'][$id])){
    $sl = $_SESSION['cart'][$id]+1;
}
else{
    $sl =1;
}
$_SESSION['cart'][$id]=$sl;
// tinh tong so hang da chon
$tongsl=0;
foreach($_SESSION['cart'] as $k => $value){
    $tongsl +=$value; 
}
//tinh tong tien phai tra
foreach($_SESSION['cart'] as $key => $value){
    $item[] = $key;
} 
$mang = implode(",",$item);
//echo $mang;
$sql = "select * from products where id in ($mang)";
//echo $sql;
$sql = str_replace(',)',')',$sql);
$donequery  = mysql_query($sql);
	
while($row = mysql_fetch_array($donequery)){
    $total +=$_SESSION['cart'][$row['id']]*$row['price']; 
}
$url1='/chi-tiet-gio-hang.html';
if(  $tongsl < 10)
$tongsl = '0'.$tongsl;
if($_SESSION['curlang']=="vietnamese-utf-8"){
include('../languages/vietnamese-utf-8.php');
?>
			<span class="count" style="padding-left: 23px;"><?php echo $display['found']." : <font color='#ff0000' >".$tongsl.'&nbsp;'.$display['products'].'</font>';?></span>
			<span class="cart" style="padding-left: 53px;"><a href="<?php echo $url1; ?>"><?PHP echo $display['detailcart'];  ?></a></span>
			<span class="buy" style="padding-left: 55px;"><a href="<?php echo '/dat-hang.html'; ?>"><?PHP echo $display['buy'];  ?></a></span>
	<?php 
} ?>