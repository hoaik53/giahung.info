<?php //exit(1);
define('bcms','bcms3.2');
//include the information needed for the connection to MySQL data base server. 
// we store here username, database and password 
include("../function.php");check_login();
include("../modules/quickedit_config.php");
// to the url parameter are added 4 parameters as described in colModel
// we should get these parameters to construct the needed query
// Since we specify in the options of the grid that we will use a GET method 
// we should use the appropriate command to obtain the parameters. 
// In our case this is $_GET. If we specify that we want to use post 
// we should use $_POST. Maybe the better way is to use $_REQUEST, which
// contain both the GET and POST variables. For more information refer to php documentation.
// Get the requested page. By default grid sets this to 1. 
$page = $_GET['page']; 
 
// get how many rows we want to have into the grid - rowNum parameter in the grid 
$limit = $_GET['rows']; 
 
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel 
$sidx = $_GET['sidx']; 
 
// sorting order - at first time sortorder 
$sord = $_GET['sord']; 
 
// if we not pass at first time index use the first column for the index or what you want
if(!$sidx) $sidx =1; 
 
// connect to the MySQL database server 
$db = $link;//mysql_connect($db_hostname, $db_username, $db_pass) or die("Connection Error: " . mysql_error()); 
 
// select the database 
//mysql_select_db($) or die("Error connecting to db."); 
//if search
if(isset($_GET['_search']))
{
    if($_GET['filters'] != "")
    {
        $filter = @json_decode(stripslashes($_GET['filters']));
        $rule_array = $filter->rules;
        //var_dump($_GET['filters']);
        foreach($rule_array as $itemrule)
        {
            //['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] 
            //$array('eq' => '=','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] )
            $where[] = $itemrule->field." like '%".$itemrule->data."%'";
        }
    }
    if(isset($_GET['catID']))$where[] = ' category = \''.addslashes($_GET['catID']).'\' ';
    $where[] = " lang='".get_langID()."' ";
    if(!isset($filter->groupOp))$toantu = " and "; else $toantu = $filter->groupOp;
    if(is_array($where) and count($where)>0)$where = ' where '.implode(" ".$toantu." ",$where)." ";
    else $where = "";
    //echo $where; exit(0);
}
// calculate the number of rows for the query. We need this for paging the result 
//echo "SELECT COUNT(*) AS count FROM ".$tblname." ".$where;
$result = mysql_query("SELECT COUNT(*) AS count FROM ".$tblname." ".$where); 
$row = mysql_fetch_array($result,MYSQL_ASSOC); 
$count = $row['count']; 
 
// calculate the total pages for the query 
if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
} else { 
              $total_pages = 0; 
} 
 
// if for some reasons the requested page is greater than the total 
// set the requested page to total page 
if ($page > $total_pages) $page=$total_pages;
 
// calculate the starting position of the rows 
$start = $limit*$page - $limit;
 
// if for some reasons start position is negative set it to 0 
// typical case is that the user type 0 for the requested page 
if($start <0) $start = 0; 
// the actual query for the grid data 
$SQL = "SELECT * FROM ".$tblname." ".$where." ORDER BY $sidx $sord LIMIT $start , $limit"; 
//echo $SQL;
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
$responce->page = $page; 
$responce->total = $total_pages; 
$responce->records = $count;
// be sure to put text data in CDATA
$_count = 0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    
    $responce->rows[$_count]['id'] = $row['id'];
    foreach($viewarray as $_item)
    {
        
         if($_item == "category")
                 {
                     $_get_cat = get_by_id($tblname."_cat",$row[$_item]);
                     if(strlen($_get_cat['level'])==5)$inden = "--------";
                     else if(strlen($_get_cat['level'])==8)$inden = "----------------";
                     else $inden = "";
                     $row[$_item] = $inden.$_get_cat['name'];
                 }
         if($_item == "lang")
                 {
                     $_get_cat = get_by_id("languages",$row[$_item]);
                     $row[$_item] = $_get_cat['name'];
                 }
         if($_item == "active")
                {
                    $_get_cat = get_by_id("active",$row[$_item]);
                    $row[$_item] = $_get_cat['status'];
                }
         if($_item == "content")
                {
                    $row[$_item] = get($row[$_item],60);
                }
		if($_item == "level")
                {
                    $_get_cat = get_all("level"," level = '".$row[$_item]."' ");
                    $_get_cat = $_get_cat[0];
                    $row[$_item] = $_get_cat['name'];
                }
         if($_item == "avdproducts")
                {
                    $_get_cat = get_by_id("avdproducts",$row[$_item]);
                    $row[$_item] = $_get_cat['type'];
                }
         if($_item == "advertising")
                {
                    $_get_cat = get_by_id("advertising",$row[$_item]);
                    $row[$_item] = $_get_cat['type_ad'];
                }
				
				
        $responce->rows[$_count]['cell'][] = stripslashes($row[$_item]);
    }
    $_count++;
}
echo json_encode($responce);
?>