<?php
/**
 * category	573
 * code	CU/CS-KC9 MKH adsfdsfd
 * id	1477
 * oper	edit
 * price	5950000
 * promotion	Khuyến mãi công lắp đặt
 title	PANASONIC 9.000 BTU / 2 cục 1 chiều / Bán sang trọng
 * 
 */ 
define('bcms','bcms3.2');
require_once("../function.php");check_login();
require_once("../modules/quickedit_config.php");
$oper = $_POST['oper'];
$tblname = $_POST['tblname'];
$id = $_POST['id'];
switch($oper)
{
    case 'edit':
    $id = $_POST['id'];
    if(!get_by_id($tblname,$id)){echo "0";exit(1);}
    $updatestring = 'update '.$tblname." ";
    $setarray = array();
    foreach($_POST as $key => $item)
    {
        if($key != $idfield && $key != 'oper' && $key != 'tblname' && $key != 'id')
        $setarray[] = " ".$key." = '".addslashes($item)."'";
    }
    $setarray = implode(" , ",$setarray);
    $updatestring .= " set ".$setarray." where ".$idfield." = '".$id."'";
   // echo $updatestring;
    mysql_query($updatestring);
    if(mysql_affected_rows()>0){echo "1";exit(1);}
    break;
    case 'del':
    $ids = explode(",",$id);
    foreach($ids as $id)
    {
        do_sql($tblname,array("id"=>$id),'delete');
    }
    echo "1";
    break;
}
echo "0";
?>