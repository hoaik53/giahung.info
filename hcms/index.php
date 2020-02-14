<?php

//must be access other file by index
define('bcms','bcms3.2');
//set_time_limit(0);
include ('function.php');
$phpself=$_SERVER['PHP_SELF'];
//echo $phpself;
$error=0;
$err_msg=array();
$notice=0;
$notice_msg=array();
//Set language
if (!isset($_SESSION['language']))
	{
	//Kiem tra Cookie
	if (isset($_COOKIE['language']))
		{
		$_SESSION['language']=$_COOKIE['language'];
		}
	else
		{
		set_language($default_language);
		}
	}
else
	{
	if (isset($_REQUEST['setlanguage']))
		{
		//echo $_REQUEST['language'];
		if (!set_language($_REQUEST['setlanguage']))
			{
			set_language($default_language);
			}
		}
	}
//Load language file
require($lang_dir.$_SESSION['language'].'.php');

//Theme
if (!isset($_SESSION['theme']))
	{
	$_SESSION['theme']=$default_theme;
	}
//Load theme
if (isset($_SESSION['theme']))
	{
	$page_layout=load_layout($_SESSION['theme'],'layout');
	}

//---------------------------------- MAIN ACTION -----------------------------------------
//       jquery and jquery ui         
$cssinclude[] = 'redmond/jquery-ui-1.8.16.custom.css';
$jsinclude[] = 'jquery-1.6.2.min.js';
$jsinclude[] = 'jquery-ui-1.8.16.custom.min.js';
$jsinclude[] = 'jquery.dimention.js';
$jsinclude[] = 'jquery.lightbox-0.5.min.js';
$cssinclude[] = 'jquery.lightbox-0.5.css';

if (isset($_REQUEST['module']))
	{
	$module=$_REQUEST['module'];
	switch ($module)
		{
		//------------- Log in -------------
		case 'login':
		$phpinclude='login.php';
        if($_REQUEST['action']=='logout')
        {
            unset($_SESSION['userID'],$_SESSION['username'],$_SESSION['usergroup']);
        }
		$caption=$strLoginTitle;
		$jsinclude[] = 'check_login.js';
		break;
		
		//--------- Control Panel -----------
		case 'cpanel':
		check_login();
		$phpinclude='cpanel.php';
		$caption=$strControlPanelTitle;
		break;
		
		//---------- Categories ------------
		case 'categories':
		check_login();
		$phpinclude='categories.php';
        $jsinclude[] = 'category.js';
		$caption=$strCategoriesTitle;
		$jsinclude[] = 'mouseovermenu.js';
		break;
        //---------- Categories1 ------------
		case 'categories1':
		check_login();
		$phpinclude='categories1.php';
        $jsinclude[] = 'category.js';
		$caption=$strCategoriesTitle;
		$jsinclude[] = 'mouseovermenu.js';
		break;
        case 'category_edit':
		check_login();
		$phpinclude='category_edit.php';
        //$jsinclude[] = 'category.js';
        if(!isset($_GET['catID']))$caption = " Thêm nhóm ";
        else $caption = " Sửa chi tiết nhóm ";
		//$caption=$strCategoriesTitle;
		$jsinclude[] = 'mouseovermenu.js';
		break;
        case 'catman':
		check_login();
		$phpinclude='catman.php';
		$caption=$strCategoriesTitle;
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- View table ------------
		case 'viewtbl':
		check_login();
		$phpinclude='viewtbl.php';
		$caption=$strViewtableTitle;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
        $jsinclude[] = 'jquery.lightbox-0.5.min.js';
        $jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- Addnew record ------------ 
        case 'popup_config':
		check_login();
		$phpinclude='popup_config.php';
		$caption=$strConfigModule." Popup ";
		break;
        
		//---------- Addnew record ------------
		case 'addnew':
		check_login();
		$phpinclude='addnew.php';
		$caption=$strAddnewTitle;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
        
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- Insert record ------------
		case 'insert':
		check_login();
		$phpinclude='doaddnew.php';
		$caption=$strAddnewTitle;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- View record ------------
		case 'viewrec':
		check_login();
		$phpinclude='viewrec.php';
		$caption=$strViewrecTitle;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- Update record ------------
		case 'update':
		check_login();
		$phpinclude='doedit.php';
		$caption=$strUpdaterecTitle;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- Delete record ------------
		case 'delete':
		check_login();
		$phpinclude='dodelete.php';
		$caption=$strUpdaterecTitle;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//-------- Creat new User ----------
		case 'creat_user':
		check_login();
		$phpinclude='creat_user.php';
		$caption=$strCreatUserTitle;
        
		$jsinclude[] = 'validator/languages/jquery.validationEngine-en.js';
        $jsinclude[] = 'validator/jquery.validationEngine.js';
        
        $cssinclude[] = 'validationEngine.jquery.css';
        $cssinclude[] = 'template.css';
		break;
		
		//-------- User Group ----------
		case 'user_group':
		check_login();
		$phpinclude='user_group.php';
		$caption=$strUserGroupTitle;
        $jsinclude[] = 'tablefilter.js';
        $jsinclude[] = 'gen_validatorv2.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//--------- User Profile -----------
		case 'user_profile':
		check_login();
		$phpinclude='user_profile.php';
		$caption=$strViewUserTitle;
		$jsinclude[] = 'textcount.js';
        $jsinclude[] = 'gen_validatorv2.js';
        $jsinclude[] = 'toggle.js';
        $jsinclude[] = 'setdisplay.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//---------- Mailing List ------------
		case 'mailing':
		check_login();
		$phpinclude='mailing_list.php';
		$caption=$strViewMailList;
		$jsinclude[] = 'checkbox.js';
        $jsinclude[] = 'tablefilter.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		//-------- Quick edit table --------
        case 'quickedit':
        check_login();
        $tblname = $_REQUEST['tblname'];
        $caption = $strQickEdit." : ".$tblname;
        $cssinclude[] = 'ui.jqgrid.css';
        $cssinclude[] = 'jquery.lightbox-0.5.css';
        $jsinclude[] = 'i18n/grid.locale-en.js';
        $jsinclude[] = 'jquery.jqGrid.min.js';
        $jsinclude[] = 'quickedit.js';
        $phpinclude = 'quickedit.php';
        break;		
		//-------- File explorer ----------
		case 'explorer':
		check_login();
		$phpinclude='explorer.php';
		$caption=$strExplorerTitle;
        $cssinclude[] = 'gsFileManager.css';
        $cssinclude[] = 'jquery.Jcrop.css';
		$jsinclude[] = 'textcount.js';
        $jsinclude[] = 'toggle.js';
        $jsinclude[] = 'gen_validatorv2.js';
		$jsinclude[] = 'mouseovermenu.js';
        $jsinclude[] = 'gsFileManager.js';
        $jsinclude[] = 'jquery.form.js';
        $jsinclude[] = 'jquery.Jcrop.js';
		break;
		
		//-------- Backup database ----------
		case 'explorerdb':
		check_login();
		$phpinclude='explorerdb.php';
		$caption=$strExplorerTitle;
		$jsinclude[] = 'textcount.js';
        $jsinclude[] = 'toggle.js';
        $jsinclude[] = 'gen_validatorv2.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//--------- About vSpider ----------
		case 'about':
		$caption=$strBCMSTitle;
		$phpinclude='about.php';
		break;
		
		//-------- Language Sys ----------
		case 'langsys':
		check_login();
		$phpinclude='langsys.php';
		$caption=$strLangsys;
		$jsinclude[] = 'textcount.js';
        $jsinclude[] = 'toggle.js';
        $jsinclude[] = 'gen_validatorv2.js';
		$jsinclude[] = 'mouseovermenu.js';
		break;
		
		//-------- Edit Language Layout  ---------
		case 'editlanglayout':
		check_login();
		$phpinclude='editlanglayout.php';
		$caption=$streditlanglayout;
		$jsinclude[] = 'textcount.js';
        $jsinclude[] = 'toggle.js';
        $jsinclude[] = 'gen_validatorv2.js';
		$jsinclude[] = 'mouseovermenu.js';
        $jsinclude[] = 'codemirror/codemirror.js';
        $jsinclude[] = 'codemirror/xml.js';
        $jsinclude[] = 'codemirror/javascript.js';
        $jsinclude[] = 'codemirror/css.js';
        $jsinclude[] = 'codemirror/clike.js';
        $jsinclude[] = 'codemirror/php.js';
        
        $cssinclude[] = 'codemirror.css';
		break;
		
		//-------- Edit Language vSpider  ---------
		case 'editlang':
		check_login();
		$phpinclude='editlang.php';
		$caption=$streditlang;
		$jsinclude[] = 'textcount.js';
        $jsinclude[] = 'toggle.js';
        $jsinclude[] = 'gen_validatorv2.js';
		$jsinclude[] = 'mouseovermenu.js';
        $jsinclude[] = 'codemirror/codemirror.js';
        $jsinclude[] = 'codemirror/xml.js';
        $jsinclude[] = 'codemirror/javascript.js';
        $jsinclude[] = 'codemirror/css.js';
        $jsinclude[] = 'codemirror/clike.js';
        $jsinclude[] = 'codemirror/php.js';
        
        $cssinclude[] = 'codemirror.css';
		break;
		
		//--------- Status Articles ----------
		case 'st_articles':
		$caption=$strvSpiderstatusAr;
		$phpinclude='ac_articel.php';
		break;
		
		default:
		check_login();
		$phpinclude='cpanel.php';
        $jsinclude[] = 'check_login.js';
		$caption=$strControlPanelTitle;
		break;
		}
	}
else
	{
        if(!check_login(false))
        {
            $phpinclude='login.php';
        	$caption=$strLoginTitle;
            $jsinclude[] = 'check_login.js';
        }
    	else
        {
            check_login();
    		$phpinclude='cpanel.php';
    		$caption=$strControlPanelTitle;
        }
	
	}
//-------------------------------- END OF MAIN ACTION ------------------------------------


//----------------------------------- PAGE OUT PUT ---------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>:: <?php echo $siteName; ?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>"/>
<style type="text/css">
fieldset {
	padding: 5px;
    -moz-border-radius: 5px;
	border: 1px solid #CCCCCC;
	background-color:#fff;
}

fieldset legend {
	padding-bottom: 3px;
	font-weight:bold;
	font-size:12px;
	color:#000000;
	line-height: 16px;
	text-align: justify;
	font-variant: small-caps;
}
.tabele {
	background-color: #F6F6F6;
	border-top: 1px solid  #DADADA;
	border-right: 1px solid  #DADADA;
	border-bottom: 2px solid  #DADADA;
	border-left: 2px solid  #DADADA;
	padding-left: 2px;
}
.Cat {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #990000;
	font-weight: bold;
}
.Cat a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #990000;
	font-weight: bold;
}
.container {
	PADDING-RIGHT: 0px; DISPLAY: block; PADDING-LEFT: 0px; FONT-SIZE: smaller; BACKGROUND: none transparent scroll repeat 0% 0%; PADDING-BOTTOM: 0px; MARGIN: 0px auto; WIDTH: 60px; PADDING-TOP: 0px; TEXT-ALIGN: center;
}
</style>
<?php
$jsinclude[] = 'site.js';
if (isset($jsinclude))
	{
	for ($i=0; $i<count($jsinclude); $i++)
		{
		echo "<script language=\"JavaScript\" type=\"text/javascript\" ";
		echo "src=\"".$jscript_dir.$jsinclude[$i]."\"></script>\n";
		}
	}
$cssinclude[] = 'site.css';
if (isset($cssinclude))
	{
	for ($i=0; $i<count($cssinclude); $i++)
		{
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$css_dir.$cssinclude[$i]."\" />";
		}
	}
if (isset($head_info))
	echo $head_info;
if($modulescript)echo $modulescript;
?>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">

#kcfinder_div {
    display: none;
    padding: 1px;
}

</style>
 
<script type="text/javascript">

function selectFile(field , type ) {
    //show dialog
	var width = $(window).width() - 50;
	var height = $(window).height() - 50;
    if(!type)type = '<?=$_GET['tblname']?>';
    else type += '&dir=<?=$_GET['tblname']?>/';
    $("#kcfinder_div").html('<iframe name="kcfinder_iframe" src="bsexplorer/browse.php?type='+type+'" ' +
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />')
                        .dialog({
        position : 'center',
		dialogClass : 'myDialog',
        width : width,
        height : height,
        modal : true
    });
	$('.myDialog.ui-dialog').css({position : "fixed", top : "25px" , left : "25px" });
    //var div = document.getElementById('kcfinder_div');
   // if (div.style.display == "block") {
   //     div.style.display = 'none';
    //    div.innerHTML = '';
   //     return;
   // }
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            field.value = url.replace(/^\//,"");
            //div.style.display = 'none';
            //div.innerHTML = '';
            $("#kcfinder_div").dialog('close');
            $(field).focus().blur();
        }
    };
    //div.innerHTML = '';
   // div.style.display = 'block';
}

</script>
<script language="javascript" type="text/javascript" src="editor/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	   tinyMCE.init({
		relative_urls : false,
        remove_script_host : true,  
        editor_selector : 'bseditor',
        document_base_url : "/",
        mode : "specific_textareas",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
        theme : "advanced",
        skin : "o2k7",
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
        language : 'vi',
		// Example content CSS (should be your site CSS)
		content_css : "../style.css",

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},
        file_browser_callback: 'openKCFinder'
	});
    function openKCFinder(field_name, url, type, win) {
        tinyMCE.activeEditor.windowManager.open({
            file: 'editor/bsexplorer/browse.php?opener=tinymce&type=' + type + "&dir=" + type + "/<?=$tblname?>",
            title: 'BSExplorer base KCFinder',
            width: 700,
            height: 500,
            resizable: "yes",
            inline: true,
            close_previous: "no",
            popup_css: false
        }, {
            window: win,
            input: field_name
        });
        return false;
    }
	function fileBrowserCallBack(field_name, url, type, win) {
		var connector = "/bsexplorer/browse.php?";//../filemanager/browser.html?Connector=connectors/php/connector.php";
		var enableAutoTypeSelection = true;

		var cType;
		tinyfck_field = field_name;
		tinyfck = win;

		switch (type) {
			case "image":
				cType = "upimages";
				break;
			case "flash":
				cType = "Flash";
				break;
			case "file":
				cType = "upfiles";
				break;
		}

		if (enableAutoTypeSelection && cType) {
			connector += "&Type=" + cType;
		}

		window.open(connector, "tinyfck", "modal,width=600,height=600");
	}
</script>
</head>

<body topmargin="0" leftmargin="0" bgcolor="#999999">

<div id="wrap_all">
    <div class="header fullwidth">
        <div id="logo">
            <img src="images/banner.gif" width="1000" height="80" />
        </div>
        <div id="topmenu">
            <?php include ('top.php'); ?>
        </div>
    </div>
    <?php if(check_login(false)){ ?>
    <div id="sysinfo" class="fullwidth ">
        <strong>&raquo; <?php echo $strLanguage.' </strong>[ '.$languages_name.' ]'; ?></strong>
        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&raquo;<?=$strHello?> : <?=$_SESSION['username']?> </strong>
    </div>
    <?php } ?>
    <div id="mainbody" class="fullwidth">
        <div id="leftbody">
            
            <?php if(check_login(false)) {
                echo "<span id=\"show_hide_lmenu\"></span>";
                include('left.php');
            }  ?>
        </div>
        <div id="rightbody">
            <div id='wrap_rightbody'>
            <?php if(check_login(false)) { ?>
            <div id="breadcrumb">
                <?php if($_GET['module'] != 'cpanel') { ?>
                &raquo; <a href="<?php echo $phpself; ?>?module=cpanel"> <?php echo $strControlPanel; ?> </a> &raquo; <?php if (isset($caption)) echo $caption; ?> </strong>
                <?php } else echo ' &raquo; '.$strControlPanel; ?>
            </div>
            <?php } ?>
            <div id="contener">
                
                    <?php
        			if (isset($phpinclude))
        				{
        				eval('require ("'.$module_dir.$phpinclude.'");');
        				}
        			?>
            </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="footer">
        <?php include('bottom.php'); ?>
    </div>
</div>
<div id="kcfinder_div"></div>
</body>
</html>