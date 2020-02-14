<?php

/** This file is part of KCFinder project
  *
  *      @desc Base JavaScript object properties
  *   @package KCFinder
  *   @version 2.51
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */
$addition = array();
if(count($_GET))
{
    foreach($_GET as $_key => $_item)
    {
        $addition[] = "$_key=$_item";
    }
}
$addition = implode("&",$addition);
echo "var addition = '$addition';";
?>

var browser = {
    opener: {},
    support: {},
    files: [],
    clipboard: [],
    labels: [],
    shows: [],
    orders: [],
    cms: ""
};
