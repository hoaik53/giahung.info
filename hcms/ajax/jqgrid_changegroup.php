<?php
/**
 * 
 * 
 * @author HocVT
 * @datecreate 3/2012
 * @coppyright BlueSky Jsc
 * 
 * 
 */ 
define('bcms','bcms3.2');
include("../function.php");check_login();
$action = $_REQUEST['action'];//action : getgroups | changegroup
$ids = $_POST['ids'];
$togroup = $_POST['togroup'];
$tblname = $_REQUEST['tblname'];
if($action == 'getgroups' && $tblname)
{
    //$return = "";
    $catarray = get_all($tblname."_cat"," lang='".get_langID()."' "," level asc ");
   // print_r($catarray);
    if(count($catarray) == 0){
        echo $strErro['107'];
        exit(1);
    }
    else
    {
        echo "<select id='catSelect' >";
        foreach($catarray as $catitem)
        {
            $indentLen = strlen($catitem['level'])+1;
            $indentLen = intval($indentLen/3);
            $indent = "";
            for($_tmp = 1;$_tmp < $indentLen;$_tmp++)
            {
                $indent .= "--";
            }
            $value = $catitem['id'];
            $name = $indent.stripslashes($catitem['name']);
            echo "<option value='".$value."' > ".$name."</option>";
        }
        
        
        
        echo "</select>";
    }
    ?>
    
    
    
    
    <?php
}else if($action == 'changegroup' && $togroup > 0 && count($ids) > 0)
{

        $sql = "update ".$tblname." set category='".$togroup."' where id in(".implode(',',$ids).")";
        $do_sql = mysql_query($sql);
        if($do_sql && mysql_affected_rows() > 0)
        {
            echo mysql_affected_rows();
        }
        else echo '0';
        
}











?>