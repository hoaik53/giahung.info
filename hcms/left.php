<?php if(!defined('bcms'))die('Cannot access directly!'); 
$group_active = 0;
if( $_REQUEST['module'] == 'creat_user'||
    $_REQUEST['module'] == 'user_group'
)$group_active = 1;
if( $_REQUEST['module'] == 'explorer'||
    $_REQUEST['module'] == 'langsys' ||
    $_REQUEST['tblname'] == 'site'|| 
	$_REQUEST['module'] =='popup_config'
)$group_active = 2;
?>
<script type="text/javascript">
$(document).ready(function(){
    //style menu left
    var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
    $('#menuleft').accordion({
        icons: icons,
        active : <?=$group_active?>,
        clearStyle : true
    });
});
</script>
<?php
$menu_array  = array(
    $strManagement.' '.$strInformation => array(

                                    array(
                                                "title" => $strArticles,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=categories1&tblname=articles'",
                                                "icon" => "icons/news1.png"
                                                ),
                                    array(
                                                "title" => $strProduct,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=categories1&tblname=products'",
                                                "icon" => "icons/folder.png"
                                                ), 
									array(
                                                "title" => $strWeblink,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=quickedit&tblname=weblinks'",
                                                "icon" => "icons/weblinks.png"
                                                ),
									array(
                                                "title" => $strContact.' & '.$strOrders,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=quickedit&tblname=contact'",
                                                "icon" => "icons/contact.png"
                                                ),
									  array(
                                                "title" => $strSupport,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=quickedit&tblname=support_online'",
                                                "icon" => "icons/yahoo.png"
                                                )
                                    ),
    $strManagement.' '.$strUser => array(
                                    array(
                                                "title" => $strCreatNew,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=creat_user'",
                                                "icon" => "icons/user.png"
                                                ),
                                    array(
                                                "title" => $strManagement.' '.$strGroup,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=user_group'",
                                                "icon" => "icons/usergroup.png"
                                                )
                                    ),
    $strManagement.' '.$strSystem => array(
                                    array(
                                                "title" => $strFile,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=explorer&file_type=files'",
                                                "icon" => "icons/folder48.gif"
                                                ),
                                    array(
                                                "title" => $strImage,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=explorer&file_type=images'",
                                                "icon" => "icons/photo.png"
                                                ),
                                    array(
                                                "title" => $strLanguage,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=langsys'",
                                                "icon" => "icons/edit1.png"
                                                ),
                                    array(
                                                "title" => $strConfig,
                                                "href" => "javascript:void(0);",
                                                "onclick" => "window.location='?module=quickedit&tblname=site'",
                                                "icon" => "icons/setting2.png"
                                                )
									
                                    )
    

);

?>
<div class="menuleft" id="menuleft">
    <?php
    foreach($menu_array as $kmenu => $gmenu)
    {?>
        <h3><a href="javascript:void(0);"><?php echo $kmenu; ?></a></h3>
        <div>
            <ul>
                <?php foreach($gmenu as $imenu) { ?>
                <li>
                    <a href="<?=$imenu['href']?>" onClick="<?=$imenu['onclick']?>"><?=$imenu['title']?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    <?php }
    ?>
</div>