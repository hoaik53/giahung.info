<?php
//Name
//Modules dir
$module_dir='modules//';
//Javascripts dir
$jscript_dir='javascripts//';
//Upload image directory
$upimages_dir='..//upimages//';
//Languages table
$lang_tbl='languages';
//Languages dir
$lang_dir='languages//';
//Default languages
$default_language='vietnamese-utf-8'; //Vietnamese
//Theme dir
$layout_dir='theme//';
//Theme extension
$layout_ext='.php';
//Default theme
$default_theme='original';
//Maximum upload image
$max_upload_img=5;
//Dung luong anh toi da duoc phep upload
$max_upload_img_size=500; //=50KB
//Dung luong file toi da duoc phep upload
$max_upload_file_size=500; //=50KB
//
$icon_db='images//table.gif';
$icon_addnew='images//filenew.gif';
$icon_edit='images//edit.gif';
$icon_delete='images//cancel.gif';
$icon_fimage='images//icon_fimage.png';
//SQL dir
$sql_dir='SQLs//';
//Ten mo rong cua tep tin chua thong tin ve database
$db_fileex='pdb';
//Duong dan toi thu muc chua cac file khai bao database
$db_dir='database/';
//Host name
$db_hostname='localhost';
//DB name
$db_dbname='giahung_gh';
//Username
$db_username='giahung_gh';
//Password
$db_pass='hoaik53a3';
//Connection
$link=mysql_connect($db_hostname,$db_username,$db_pass) or die ("Cannot connect to the database.");
mysql_select_db($db_dbname,$link);
$check_tbl='select * from site';
$docheck=mysql_query($check_tbl,$link);
$result=mysql_fetch_array($docheck);
$counter=$result['counter'];
$siteName=$result['sitename'];
$siteUrl=$result['siteurl'];
$webicon=$result['icon'];
$sitedescription=$result['description'];
$sitekeywords=$result['keywords'];
?>