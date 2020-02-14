/**
 * @author hunglv
 * @copyright 2011
 */
session_start();
?><?php
$cart=$_SESSION['cart'];
$id=$_GET['id'];
if($id == 0)
{
 unset($_SESSION['cart']);
}
else
{
unset($_SESSION['cart'][$id]);
}
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'chi-tiet-gio-hang.html';
$url = "http://".$host."/".$extra;
/*exit();*/
?>
<script language="javascript" type="text/javascript">
window.location='<?php echo $url; ?>';
</script>
