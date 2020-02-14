<?php
//Name
$siteName='BCMS 3.2';
//URL
$siteUrl='http://giayhaianh.vn';
//Root folder
$root_dir='../';
//Path to this folder
$path_dir=$siteUrl.'adcp/';
//System folder ( can not access or change )
$system_dir=array('adcp');
//Modules dir
$module_dir='modules/';
//Javascripts dir
$jscript_dir='javascripts/';
//Style dir
$css_dir='css/';
//Upload image directory
$upimages_dir='upimages/';
//Valid image file types
$VALID_IMAGE_FILE_TYPES=array("gif","jpg","jpeg","png","bmp","JPG","GIF");
//Max image file size
$max_upimage_size=1000000;//100KB
//Upload file directory
$upfiles_dir='upfiles/';
//Valid file types
$VALID_NORMAL_FILE_TYPES=array("swf","txt","doc","htm","html","zip","rar","pdf","css","psd","exe","xls","ppt");
//Max normal file size
$max_upfile_size=10000000;//10MB
//Upload file directory
$updatabase_dir='updatabases/';
//Valid file types
$VALID_NORMAL_DATABASE_TYPES=array("zip","gz","sql","txt");
//Max normal file size
$max_updatabase_size=10000000;//10MB
//Upload documents directory
$updocs_dir='updocs/';
//Valid documents types
$VALID_DOCUMENT_FILE_TYPES=array("txt","doc","htm","html","pdf");
//Max document file size
$max_updoc_size=5000000;//5MB
//Upload media directory
$upmedias_dir='upmedias/';
//Valid media types
$VALID_MEDIA_FILE_TYPES=array("mp3","wma","midi","mpg","mpeg","dat","avi");
//Upload avatar directory
$avatar_dir='avatar/';
//Languages table
$lang_tbl='languages';
//Languages dir
$lang_dir='languages/';
//Default languages
$default_language='vietnamese-utf-8';
//$default_language='english-iso-8859-1'; //E
//Theme dir
$layout_dir='theme/';
//Theme extension
$layout_ext='.php';
//Default theme
$default_theme='original';
//Limit of menu level
$limit_menu_level=4;
//Maximum upload image
$max_upload_img=5;
//Dung luong anh toi da duoc phep upload
$max_upload_img_size=500; //=50KB
//Dung luong file toi da duoc phep upload
$max_upload_file_size=500; //=50KB
//
$icon_db='images/table.gif';
$icon_addnew='images/filenew.gif';
$icon_edit='images/edit.gif';
$icon_delete='images/cancel.gif';
$icon_fimage='images/icon_fimage.png';
//SQL dir
$sql_dir='SQLs/';
//Ten mo rong cua tep tin chua thong tin ve database
$db_fileex = 'pdb';
$cf_fileex = 'conf';
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
?>