<?php
// lay banner
function banner($tbl){
	$sql = "select * from ".$tbl." where advertising=1 and lang=".get_langID()." and active=1 order by log desc limit 0,1";
	$doquery = mysql_query($sql);
	return mysql_fetch_array($doquery);
	}
// lay menu	
function get_menu($tbl){
	$sql = "select * from  ".$tbl."_cat where lang =".get_langID()." order by level asc ";
	$doquery =mysql_query($sql);
	return $doquery;
}
// lay tin huong dan
function get_tinhd($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and category=163 order by level ASC, log DESC limit 0,5 ";
	$doquery =mysql_query($sql);
	return $doquery;
}
// get weblink
function get_th($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and advertising=3 order by log desc";
	$doquery =mysql_query($sql);
	return $doquery;
}
// lay ben left
function get_menu_left($tbl){
	$sql = "select * from  ".$tbl."_cat where lang =".get_langID()." order by level ASC";
	$doquery =mysql_query($sql);
	return $doquery;
}
function get_onlinesupport($tbl){
	$sql = "select * from ".$tbl." where lang=".get_langID()." order by log desc";
	$doquery = mysql_query($sql);
	return $doquery;
}
function get_qc($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and avdproducts=1 and active=1 order by level asc,log desc limit 0,3 ";
	$doquery  = mysql_query($sql);
	return $doquery;
}
// get lien he quang cao
function get_lhqc($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and advertising=2 order by log desc limit 0,1 ";
	$doquery =mysql_query($sql);
	return $doquery;
}
// get logo
function get_logo($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and advertising=4 and active=1";
	$doquery =mysql_query($sql);
	return mysql_fetch_array($doquery);
}
// mmain
// get sp moi nhat
function get_spnb($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and level=1 order by log desc limit 0,3";
	$doquery =mysql_query($sql);
	return $doquery;
}
// san pham dang ban
function get_spdb($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and level=2";
	$doquery =mysql_query($sql);
	return $doquery;
}
// get ajax
function get_ajax($tbl){
	$sql = "select * from  ".$tbl." where active=1 order by level asc, log desc limit 0,1 ";
	$doquery =mysql_query($sql);
	return $doquery;
}

// get right
// get tin moi
function get_tintuc($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and level=1 order by log desc, log desc limit 0,7 ";
	$doquery =mysql_query($sql);
	return $doquery;
}
// get san pham moi
function get_spmoi($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 order by log desc limit 0,3 ";
	$doquery =mysql_query($sql);
	return $doquery;
}

// get doi tac - khach hang
function get_dtkh($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and advertising=5 order by log desc limit 0,6 ";
	$doquery =mysql_query($sql);
	return $doquery;
}
// get doi tac
function get_dt($tbl){
	$sql = "select * from  ".$tbl." where lang =".get_langID()." and active=1 and advertising=2 order by log desc limit 0,1 ";
	$doquery =mysql_query($sql);
	return mysql_fetch_array($doquery);
}
// get san pham tung danh muc
function get_product($tbl,$id){
    $sql = "select * from ".$tbl." ";
    $sql .=" where category=".$id." ";
    $sql.=" and lang=".get_langID()." and active =1 ";
    $sql .=" order by level asc, log desc limit 0,12 ";
    $doquery =  mysql_query($sql);
    return $doquery;
}
// lay ten danh muc
function get_name_cart($tbl,$id){
    $sql = "select * from ".$tbl."_cat ";
    $sql .=" where id=".$id." ";
    $sql.=" and lang=".get_langID()." ";
    return mysql_fetch_array(mysql_query($sql));
}
// get san chi tiet san pham
function get_detail_product($tbl,$cartID,$productID){
    $sql = "select * from ".$tbl." ";
    $sql .=" where category=".$cartID." and id=".$productID." ";
    $sql.=" and lang=".get_langID()." ";
    $doquery = mysql_query($sql);
    return mysql_fetch_array($doquery);
}
// get category news
function name_category_news($tbl,$id){
    $sql = "select * from ".$tbl."_cat ";
    $sql .=" where id=".$id." ";
    $sql.=" and lang=".get_langID()." ";
    $doquery = mysql_query($sql);
    return mysql_fetch_array($doquery);
}
function get_cart_news($tbl,$id){
    $sql = "select * from ".$tbl." ";
    $sql .=" where category=".$id." ";
    $sql.=" and lang=".get_langID()." and active =1 ";
    $sql .=" order by level asc, log desc ";
    $doquery =  mysql_query($sql);
        return $doquery;   
}
// get chi tiet tin tuc
function get_detail_news($tbl,$ncartID,$nproductID){
    $sql = "select * from ".$tbl." ";
    $sql .=" where category=".$ncartID." and id=".$nproductID." ";
    $sql.=" and lang=".get_langID()." ";
    $doquery = mysql_query($sql);
    return $doquery;
}

?>