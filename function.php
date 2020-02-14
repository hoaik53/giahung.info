<?php
session_start();
include('config.inc.php');

//Kiem tra ngon ngu truy cap
//Set language
if (!isset($_SESSION['curlang']))
	{
	//Kiem tra Cookie
	if (isset($_COOKIE['language']))
		{
		set_language($_COOKIE['language']);//$_SESSION['lang']=;
		}
	else
		{
		set_language($default_language);
		}
	}
else
	{
	if (isset($_GET['lang']) and strlen($_GET['lang'])>8)
		{
		//echo 'REQUEST : '.$_REQUEST['lang'];
		if (!set_language($_GET['lang']))
			{
			set_language($default_language);
			//echo '<br>Can not set language';
			}
		}
	}
/**
 * 
 * Get all record of table with some param to config result
 * @param $_table Table name to get
 * @param $_where where clause if need ( field1='value1' and field1='value1' )
 * @param $_orderby order by clause if need ( field1 asc,field2 desc )
 * @param $_from get from this index
 * @param $_amount amount of record to get 
 * @return array of records
 * 
 **/	
function get_all($_table, $_where = "" , 
                $_orderby = "" , $_from = "" ,
                 $_amount = "",$log=false)
{
    $_result = array();
    $_sql = "select * from " . $_table . " where 1 ";
    if($_where != "")$_sql .= " and " . $_where . " ";
    if($_orderby != "")$_sql .= " order by " . $_orderby . " ";
    if(intval($_from) >=0 && intval($_amount) > 0)$_sql .= " limit " . intval($_from) . "," . intval($_amount);
    if($log)echo $_sql;
    $_do_sql = mysql_query($_sql);
    $_count = 0;
    if($_do_sql && mysql_num_rows($_do_sql))
    {
        while($_row = mysql_fetch_assoc($_do_sql))
        {
            foreach($_row as $_key=>$_value)
            {
                $_result[$_count][$_key] = stripslashes($_value);
            }
            $_count++;
            
        }
        
    }
    return $_result;
}
//Get language ID in language table

function get_langID()
	{
	global $link;
	global $lang_tbl;
	$query='select * from '.$lang_tbl.' where code="'.$_SESSION['curlang'].'" limit 0,1';
	if ($doquery=mysql_query($query))
		{
		$result=mysql_fetch_array($doquery);
		if (isset($result['id']) and is_numeric($result['id']))
			{
			return $result['id'];
			}
		else
			return false;
		}
	else
		return false;
	}
//Load language file
//echo '<br>Session: '.$_SESSION['lang'];
@include($lang_dir.$_SESSION['curlang'].'.php');
//exit;
//Set language
class Level 
{
	function cat_Level($tblname, $requestid, $url_htaccess)
	{
		global $display;
		if ($temp=mysql_fetch_array(mysql_query('select * from '.$tblname.'_cat where id="'.$requestid.'" and lang="'.get_langID().'" limit 0,1')))
				{
				$catLevel=$temp['level'];
				$levels=explode('.',$catLevel);
				$level='';
				$chain='';
				$id=$temp['id'];
				for ($i=0; $i<count($levels); $i++)
					{
					if ($i>0)
						$level.='.';
					$level.=$levels[$i];
					$temp=mysql_fetch_array(mysql_query('select * from '.$tblname.'_cat where level="'.$level.'" and lang="'.get_langID().'" order by level ASC limit 0,1'));
					$name=$temp['name'];
					$id=$temp['id'];
					$url='/'.$url_htaccess.'/'.$id.'/'.removeSpecialChars(removesign($name)).'.html';
					$name = '<a style = "color:#fff;" href="'.$url.'">'.$name.'</a>';
					$chain.='<font style = "color:#fff;">&raquo;</font>';
					$chain.=' '.$name.' ';
					}
				}
				?>
				<div class = "head"><h2>
					<?php
						$home = '<a style = "color:#fff;" href="/">'.$display['home'].'</a>';
						echo ''.$home.' '.$chain;
					?>	
				</h2></div>
		<?php
		return 	$chain;
	}
}
function cat_id($tblname, $path)
{
	$query ='select '.$tblname.'.*,'.$tblname.'_cat.level as category_level';
	$query.=' from '.$tblname.' inner join '.$tblname.'_cat';
	$query.=' on '.$tblname.'.category='.$tblname.'_cat.id';
	$query.=' where '.$tblname.'_cat.level like "'.$path.'%"';
	$doquery=mysql_query($query);
	if ($doquery and mysql_num_rows($doquery) > 0)
		{
		$catid='';
		$j=0;
		while($result = mysql_fetch_array($doquery))
			{
			$j++;
			$id=$result['id'];
			$catid.=$id.',';
			}
			
		}
	return 	$catid;	
}

function set_language($lang)
	{
	global $lang_dir;
	global $siteURL;
	$error=0;
	//Check language file exsist
	$lang_file=$lang.'.php';
	//echo $lang_dir.$lang_file;
	if ($fo=@fopen($lang_dir.$lang_file,'r'))
		{
		$_SESSION['curlang']=$lang;
		//echo $_SESSION['language'];
		setcookie("language",$lang,time()+60*60*24*30,$_SERVER['PHP_SELF'],$siteURL);
		return true;
		}
	else
		return false;
	}

/*
if (!isset($_SESSION['lang']))
	{
	$_SESSION['lang']='vie';
	//echo $_SESSION['lang'];
	$_SESSION['langname']='Vietnamese';
	//echo $_SESSION['langname'];
	}

if (isset($_GET['lang']))
	{
	//echo 'GET var is OK';
	$chosenlang=$_GET['lang'];
	$test='select * from languages where code="'.$chosenlang.'" limit 0,1';
	$dotest=mysql_query($test,$link);
	if (!$dotest)
		{
		echo '<script>';
		echo 'alert("Error in connecting to database. Continue view pages in current language");';
		echo 'window.location="index.php";';
		echo '</script>';
		}
	else
		{
		//echo 'QUERY is OK';
		if (mysql_num_rows($dotest)==1)
			{
			//echo 'Value is OK';
			//echo 'hehe';
			$result=mysql_fetch_array($dotest);
			//echo $result['name'];
			//echo $result['code'];
			$_SESSION['lang']=$result['code'];
			//echo $_SESSION['lang'];
			$_SESSION['langname']=$result['name'];
			//echo $_SESSION['langname'];
			//echo '<script>window.location="index.php";</script>';
			}
		else
			{
			echo '<script>';
			echo 'alert("';
			echo '                  Lua chon sai hoac ngon ngu nay ko duoc ho tro. Moi chon lai\n\n';
			echo 'Wrong language or not supported by our site. Pages continuosly viewed in current language, Please select another");';
			echo 'window.location="index.php";';
			echo '</script>';
			}
		}
	}
$lang=$_SESSION['lang'];
//echo $_SESSION['lang'];
if ($_SESSION['lang']=='vie')
	{
	require ('lang_vn.php');
	}
else
	{
	require ('lang_en.php');
	}
	
*/

//Khai bao he thong
$error=array(
			'query'=>'<p>Co loi trong ket noi toi CSDL</p>'
			);

//Ham ma hoa
	function encrypt($strinput)
	{
	$standard=array('a','b','c','d','e','f',
	'g','h','i','j','k','l','m','n','o','p',
	'q','r','s','t','u','v','w','x','w','z',
	'1','2','3','4','5','6','7','8','9','0');
	$non_standard=array('`','~','!','=','#',
	'$','%','^','&','{','(',';','-','@','_',
	'+','|','[',']','*','}',')',':','.','<',
	'>','7','6','3','9','5','2','7','1','4','0');
	$strinput=strtolower(chop($strinput));
	$stroutput='';
	$loop=strlen($strinput);
	//echo $loop;
	for ($j=0;$j<$loop;$j++)
		{
		$cur_char=substr($strinput,$j,1);
		//echo $cur_char;
		$i=0;
		while (isset($standard[$i]))
			{
			if ($standard[$i]==$cur_char)
				{
				$stroutput.=$non_standard[$i];
				break;
				}
			$i++;
			}
		}
	return $stroutput;
	}

//Ham giai ma
	function decrypt($strinput)
	{
	$standard=array('a','b','c','d','e','f',
	'g','h','i','j','k','l','m','n','o','p',
	'q','r','s','t','u','v','w','x','w','z',
	'1','2','3','4','5','6','7','8','9','0');
	$non_standard=array('`','~','!','=','#',
	'$','%','^','&','{','(',';','-','@','_',
	'+','|','[',']','*','}',')',':','.','<',
	'>','7','6','3','9','5','2','7','1','4','0');
	$x=0;
	while (isset($standard[$x]))
		{
		//echo $standard[$x].' - '.$non_standard[$x].'<br>';
		$x++;
		}
	$strinput=strtolower(chop($strinput));
	$stroutput='';
	$loop=strlen($strinput);
	//echo $loop;
	for ($j=0;$j<$loop;$j++)
		{
		$cur_char=substr($strinput,$j,1);
		//echo $cur_char;
		$i=0;
		while (isset($non_standard[$i]))
			{
			if ($non_standard[$i]==$cur_char)
				{
				$stroutput.=$standard[$i];
				break;
				}
			$i++;
			}
		}
	return $stroutput;
	}

//Ham dem so nguoi Online
function getOnlineUsers()
	{
	global $link;
	//$allow_count=true;
	//Kiem tra ton tai cua bang UserOnline
	$check_tbl='select * from usersonline';
	$docheck=mysql_query($check_tbl,$link);
	if (!$docheck)
		{
		// Tao bang UserOnline neu chua co
		$creat_tbl="CREATE TABLE usersonline (
				  timestamp int(15) NOT NULL default '0',
				  ip varchar(40) NOT NULL,
				  FILE varchar(100) NOT NULL,
				  PRIMARY KEY  (timestamp),
				  KEY ip (ip),
				  KEY FILE (FILE)
				) TYPE=MyISAM";
		$docreat=mysql_query($creat_tbl,$link);
		if (!$docreat)
			{
			//echo 'Hehe';
			return false;
			}
		}
	else
		{
		$to_secs = 120;
		$t_stamp = time();
		$timeout = $t_stamp - $to_secs;
		$qry_insert="INSERT INTO usersonline VALUES ('$t_stamp','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['PHP_SELF']."')";
		$doinsert=mysql_query($qry_insert,$link);
		//mysql_query("INSERT INTO UsersOnline VALUES ('$t_stamp','$REMOTE_ADDR','$PHP_SELF')",$link); 
		$qry_delete="DELETE FROM usersonline WHERE timestamp<$timeout";
		$dodelete=mysql_query($qry_delete,$link);
		//mysql_query("DELETE FROM UsersOnline WHERE timestamp<$timeout",$link);
		$qry_count="SELECT DISTINCT ip FROM usersonline WHERE file='".$_SERVER['PHP_SELF']."'";
		$result=mysql_query($qry_count,$link);
		//mysql_query("SELECT DISTINCT ip FROM UsersOnline WHERE file='$PHP_SELF'",$link);
		$user = mysql_num_rows($result);
		return $user;
		}
	}

//Ham hien thi so luot truy cap
Function showcounter()
	{
	global $link;
	//Kiem tra ton tai cua bang SITE
	$check_tbl='select * from site';
	$docheck=mysql_query($check_tbl,$link);
	if (!$docheck)
		{
		// Tao bang UserOnline neu chua co
		$creat_tbl="CREATE TABLE /*!32300 IF NOT EXISTS*/ site (
  					sitename varchar(255) NOT NULL DEFAULT '' ,
  					siteurl varchar(255) NOT NULL DEFAULT '' ,
  					counter int(11) NOT NULL DEFAULT '' ,
  					PRIMARY KEY (sitename)
					);";
		$docreat=mysql_query($creat_tbl,$link);
		if (!$docreat)
			{
			//echo 'Hehe';
			return false;
			}
		else
			{
			$insert='Insert into site ';
			$insert.='(sitename,siteurl,counter)';
			$insert.=' values("No name","No URL","500")';
			if (!mysql_query($insert,$link))
				{
				echo 'Hehe';
				}
			}
		}
	else
		{
		$result=mysql_fetch_array($docheck);
		$counter=$result['counter'];
		return $counter;		
		}
	}

//Dam dem so luot truy cap
Function docounter()
	{
	global $link;
	//Kiem tra ton tai cua bang SITE
	$check_tbl='select * from site';
	$docheck=mysql_query($check_tbl,$link);
	if (!$docheck)
		{
		return false;
		}
	else
		{
		$result=mysql_fetch_array($docheck);
		$cur_value=$result['counter'];
		$new_value=$cur_value+1;
		$update='update site set counter="'.$new_value.'"';
		$doupdate=mysql_query($update,$link);
		}
	}

//Ham loai bo nhung ky tu nguy hiem a khoi gia tri bien
function value_filter($varname)
	{
	$irregular=array('_','.','/','\\','\'','"','?');
	$a=0;
	while (isset($irregular[$a]))
		{
		$varname=str_replace($irregular[$a],'',$varname);
		$a++;
		}
	return $varname;
	}
//Ham dieu chinh kich thuoc anh
Function displaypic($pic,$kt,$align,$height1)
	{
	if ($kt=='tiny')
		{
		$maxwidth=40;
		$maxheight=40;
		//$align='center';
		}
	if ($kt=='small')
		{
		$maxwidth=80;
		$maxheight=80;
		//$align='center';
		}
	if ($kt=='xsmall')
		{
		$maxwidth=120;
		$maxheight=120;
		//$align='center';
		}
	if ($kt=='medium')
		{
		$maxwidth=134;
		$maxheight=114;
		//$align='center';
		}
	if ($kt=='large')
		{
		$maxwidth=150;
		$maxheight=100;
		//$align='center';
		}
	if ($kt=='xlarge')
		{
		$maxwidth=155;
		$maxheight=150;
		//$align='center';
		}
	if ($kt=='xxlarge')
		{
		$maxwidth=180;
		$maxheight=180;
		//$align='center';
		}
	if ($kt=='banner1')
		{
		$maxwidth=210;
		$maxheight=150;
		//$align='center';
		}
	if ($kt=='banner')
		{
		$maxwidth=200;
		$maxheight=140;
		//$align='center';
		}	
	if ($kt=='slideprojects')
		{
		$maxwidth=580;
		$maxheight=90;
		//$align='center';
		}
	if($pic=='')
		$f='images/noimage01.gif';
	else
		$f=$pic;
	//echo $f.'<br>';
	@$fo=fopen($f,'r');
	@$size=getimagesize($f);
	$width=$size[0];
	//echo 'Width: '.$width;
	$height=$size[1];
	
	//echo 'Height: '.$height;
	
	if ($width !='')
	
		{
		if ($width>$height)
			$pictype='ngang';
		else
			$pictype='doc';
		//Xu ly
		if ($pictype=='ngang')
			{
			@$ratio=round($maxwidth/$width,1);
			//echo $ratio;
			if ($ratio >= 2)
				{
				$ratio=2;
				$newwidth=$width*$ratio;
				$newheight = $height;
				}
			else
				{
				
				$newwidth=$maxwidth;
				$newheight=$height*$ratio;
				if( $newheight > $maxheight )
				{
					$newheight =$maxheight;
					//echo $newheight;
				}
				}
			}
		if ($pictype=='doc')
			{
			@$ratio=round($maxheight/$height,1);
			if ($ratio>2)
				{
				$ratio=2;
				$newheight=$height*$ratio;
				//$newwidth = $width;
				}
			else
				{
				$newheight=$maxheight;
				$newwidth=$width*$ratio;
				}
			}
		}
	else
		{
		$newwidth=$width;
		$newheight=$height;
		}
	if($height1 > $newheight)	
		$style =($height1 - $newheight)/2;
	//return $newwidth;
	//return $newheight;
	//return $pictype;
	//echo '<br>The image after resize: Newwidth='.$newwidth.' Newheight='.$newheight;
	echo '<img src="/'.$f.'" style="margin-top: '.$style.'px;" width="'.$newwidth.'" height="'.$newheight.'" align="'.$align.'" border="0" hspace="4" vspace="0">';
	@fclose($fo);
	}	


//Ham dieu chinh kich thuoc anh
Function displaypic_article($pic,$kt,$align)
	{
	if ($kt=='tiny')
		{
		$maxwidth=40;
		$maxheight=40;
		//$align='center';
		}
	if ($kt=='small')
		{
		$maxwidth=80;
		$maxheight=80;
		//$align='center';
		}
	if ($kt=='xsmall')
		{
		$maxwidth=100;
		$maxheight=100;
		//$align='center';
		}
	if ($kt=='medium')
		{
		$maxwidth=134;
		$maxheight=114;
		//$align='center';
		}
	if ($kt=='large')
		{
		$maxwidth=160;
		$maxheight=160;
		//$align='center';
		}
	if ($kt=='xlarge')
		{
		$maxwidth=200;
		$maxheight=200;
		//$align='center';
		}
	if ($kt=='xxlarge')
		{
		$maxwidth=250;
		$maxheight=250;
		//$align='center';
		}
	if ($kt=='adv_large')
		{
		$maxwidth=600;
		$maxheight=200;
		//$align='center';
		}
	if ($kt=='slideprojects')
		{
		$maxwidth=520;
		$maxheight=200;
		//$align='center';
		}
	if($pic=='')
		$f='images/noimage01.gif';
	else
		$f=$pic;
	//echo $f.'<br>';
	@$fo=fopen($f,'r');
	@$size=getimagesize($f);
	$width=$size[0];
	//echo 'Width: '.$width;
	$height=$size[1];
	//echo 'Height: '.$height;
	if ($width>$maxwidth or $height>$maxheight)
		{
		if ($width>$height)
			$pictype='ngang';
		else
			$pictype='doc';
		//Xu ly
		if ($pictype=='ngang')
			{
			@$ratio=round($maxwidth/$width,1);
			if ($ratio>2)
				{
				$ratio=2;
				$newwidth=$width*$ratio;
				}
			else
				{
				$newheight=$height*$ratio;
				$newwidth=$maxwidth;
				}
			}
		if ($pictype=='doc')
			{
			@$ratio=round($maxheight/$height,1);
			if ($ratio>2)
				{
				$ratio=2;
				$newheight=$height*$ratio;
				}
			else
				{
				$newheight=$maxheight;
				$newwidth=$width*$ratio;
				}
			}
		}
	else
		{
		$newwidth=$width;
		$newheight=$height;
		}
	//return $newwidth;
	//return $newheight;
	//return $pictype;
	//echo '<br>The image after resize: Newwidth='.$newwidth.' Newheight='.$newheight;
	echo '<img src="'.$f.'" class="photos-large" width="'.$newwidth.'" height="'.$newheight.'" align="'.$align.'" border="0" hspace="4" vspace="0" title="cssbody=[dvbdy2] cssheader=[dvhdr2] header=[] body=[&lt;table&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; valign=&quot;top&quot;&gt;&lt;img id=&quot;vBCodeIMG&quot; src=&quot;'.$f.'&quot; align=&quot;center&quot; /&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tbody&gt;&lt;/table&gt;]" />';
	@fclose($fo);
	
	}
	
Function displaypic_slide($pic,$kt,$align)
	{
	if ($kt=='tiny')
		{
		$maxwidth=40;
		$maxheight=40;
		//$align='center';
		}
	if ($kt=='small')
		{
		$maxwidth=80;
		$maxheight=80;
		//$align='center';
		}
	if ($kt=='xsmall')
		{
		$maxwidth=100;
		$maxheight=100;
		//$align='center';
		}
	if ($kt=='medium')
		{
		$maxwidth=110;
		$maxheight=110;
		//$align='center';
		}
	if ($kt=='large')
		{
		$maxwidth=150;
		$maxheight=150;
		//$align='center';
		}
	if ($kt=='xlarge')
		{
		$maxwidth=200;
		$maxheight=200;
		//$align='center';
		}
	if ($kt=='xxlarge')
		{
		$maxwidth=250;
		$maxheight=250;
		//$align='center';
		}
	if ($kt=='slideprojects')
		{
		$maxwidth=450;
		$maxheight=220;
		//$align='center';
		}
		
	if($pic=='')
		$f='images/noimage01.gif';
	else
		$f=$pic;
	//echo $f.'<br>';
	@$fo=fopen($f,'r');
	@$size=getimagesize($f);
	$width=$size[0];
	//echo 'Width: '.$width;
	$height=$size[1];
	//echo 'Height: '.$height;
	if ($width>$maxwidth or $height>$maxheight)
		{
		if ($width>$height)
			$pictype='ngang';
		else
			$pictype='doc';
		//Xu ly
		if ($pictype=='ngang')
			{
			@$ratio=round($maxwidth/$width,1);
			if ($ratio>2)
				{
				$ratio=2;
				$newwidth=$width*$ratio;
				}
			else
				{
				$newheight=$height*$ratio;
				$newwidth=$maxwidth;
				}
			}
		if ($pictype=='doc')
			{
			@$ratio=round($maxheight/$height,1);
			if ($ratio>2)
				{
				$ratio=2;
				$newheight=$height*$ratio;
				}
			else
				{
				$newheight=$maxheight;
				$newwidth=$width*$ratio;
				}
			}
		}
	else
		{
		$newwidth=$width;
		$newheight=$height;
		}
	//return $newwidth;
	//return $newheight;
	//return $pictype;
		echo '<img src="'.$f.'" width="'.$newwidth.'" height="'.$newheight.'" align="'.$align.'" border="0" hspace="0" vspace="0">';
	@fclose($fo);
	}

//Ham hien thi thoi gian
function displaylongdate()
{
//Lay gia tri thu ngay thang nam hien thoi
$getweekday=date('D');
$getmonthday=date('d');
$getmonth=date('m');
$getyear=date('Y');
//Xu ly hien thi tieng Viet
switch ($getweekday)
	{
	case 'Sun':
		$weekday='Chủ Nhật';
		break;
	case 'Mon':
		$weekday='Thứ Hai';
		break;
	case 'Tue':
		$weekday='Thứ Ba';
		break;
	case 'Wed':
		$weekday='Thứ Tư';
		break;
	case 'Thu':
		$weekday='Thứ Năm';
		break;
	case 'Fri':
		$weekday='Thứ Sáu';
		break;
	case 'Sat':
		$weekday='Thứ Bảy';
		break;
	}
$monthday=$getmonthday;

switch ($getmonth)
	{
	case '01':
		$month='Một';
		break;
	case '02':
		$month='Hai';
		break;
	case '03':
		$month='Ba';
		break;
	case '04':
		$month='Bốn';
		break;
	case '05':
		$month='Năm';
		break;
	case '06':
		$month='Sáu';
		break;
	case '07':
		$month='Bảy';
		break;
	case '08':
		$month='Tám';
		break;
	case '09':
		$month='Chín';
		break;
	case '10':
		$month='Mười';
		break;
	case '11':
		$month='Mười Một';
		break;
	case '12':
		$month='Mười Hai';
		break;
	}

$year=$getyear;
echo $weekday.', ngày '.$monthday.' tháng '.$month.' năm '.$year.'</b>';
}

//Ham hien thi nhay thang dang ngan
function displayshortdate()
{
$getweekday=date('D');
$getmonthday=date('d');
$getmonth=date('m');
$getyear=date('Y');
//Xu ly hien thi tieng Viet
switch ($getweekday)
	{
	case 'Sun':
		$weekday='Chủ Nhật';
		break;
	case 'Mon':
		$weekday='Thứ Hai';
		break;
	case 'Tue':
		$weekday='Thứ Ba';
		break;
	case 'Wed':
		$weekday='Thứ Tư';
		break;
	case 'Thu':
		$weekday='Thứ Năm';
		break;
	case 'Fri':
		$weekday='Thứ Sáu';
		break;
	case 'Sat':
		$weekday='Thứ Bảy';
		break;
	}
$monthday=$getmonthday;
$month=$getmonth;
$year=$getyear;

echo $weekday.', ngày '.$monthday.'/'.$month.'/'.$year;	
}

//Ham lay thoi gian hien tai
Function gettime()
{
$gethour=date('H');
$getminute=date('i');
$getsecond=date('s');
$getday=date('d');
$getmonth=date('m');
$getyear=date('Y');

$currenttime=$getyear.'-'.$getmonth.'-'.$getday;
//.' '.$gethour.':'.$getminute.':'.$getsecond;

return $currenttime;
}

//Ham kiem tra loai nguoi dung
Function chkusertype($username)
{
include ('dbcon.php');
$qry=("select usertype from userinfo where username='".$username."'");
$doqry=mysql_query($qry,$link);
$type=mysql_fetch_array($doqry);
return $type[0];
}

//Ham xu ly chuoi
	Function handlestring($yourstring)
{
	$yourstring=ltrim($yourstring);
	$yourstring=chop($yourstring);
	$yourstring=ucfirst($yourstring);
	$yourstring=AddSlashes($yourstring);
return $yourstring;
}

//Ham hien thi gio
	Function displaytime()
{
$gethour=date('H');
if ($gethour==0)
	$hour=12;
else
	{	
	if ($gethour>0 and $gethour<=12)
	$hour=$gethour;
	else
	$hour=$gethour-12;
	}

$getminute=date('i');

if ($gethour>1 && $gethour<=5)
	$period='rạng sáng';
elseif ($gethour>5 && $gethour<=11)
	$period='sáng';
elseif ($gethour>11 && $gethour<=14)
	$period='trưa';
elseif ($gethour>14 && $gethour<=18)
	$period='chiều';
elseif ($gethour>18 && $gethour<=21)
	$period='tối';
elseif ($gethour>21 && $gethour<=24)
	$period='đêm';
elseif ($gethour>=0 && $gethour<=1)
	$period='đêm';

echo $hour.' giờ '.$getminute.' phút '.$period;
}



//Ham thay chuyen doi dinh dang thoi gian tu MySQL sang PHP
	Function chgdatetimeformat($datetime)
{		
	$part=explode(' ',$datetime);
	$theday=$part[0];
	$daypart=explode('-',$theday);
	$year=$daypart[0];
	$month=$daypart[1];
	$weekday=$daypart[2];
	/*
	$thetime=$part[1];
	$timepart=explode(':',$thetime);
	$hour=$timepart[0];
	$minute=$timepart[1];
	$second=$timepart[2];
	*/
	//echo $hour.' gi&#7901; '.$minute.' pht, ngy '.$weekday.'/'.$month.'/'.$year;
	echo $weekday.'/'.$month.'/'.$year;
}

Function chgbirth($datetime)
{		
	$part=explode(' ',$datetime);
	$theday=$part[0];
	$daypart=explode('-',$theday);
	$year=$daypart[0];
	$month=$daypart[1];
	$weekday=$daypart[2];
	
	echo $weekday.'/'.$month.'/'.$year;
}

//Ham kiem tra Phone Number
function checkphone($phone)
{
	if ($phone=="")
		return true;
	if (strlen($phone)<7)
	{
		return false;
		exit;
	}
	if ($phone!="")
	{
	//Mang cac ki tu hop le
	$chararray=("1234567890");
	//Do dai xau
	$lphone=strlen($phone)-1;
	//Vong lap duyet xau
	for ($i=0;$i<=$lphone;$i++)
	{
	//Lay tung ki tu trong phone
	$letter=substr($phone,$i,1);
	//tim ki tu vua lay duoc tu phone number trong Mang cac ki tu hop le
	$result=strstr($chararray,$letter);
	//Neu ko thay thi tra ve gt false va thoat khoi chuong trinh
	if ($result=="")
		{
		return false;
		exit;
		}
	}
	
	//Neu hop le thi tra lai gt true cho ham
	return true;
	}
}

// Ham dem so tu trong mot doan van
	Function countletter($content)
{
$content=trim($content);
$spacenum=0;
$length=strlen($content);
for ($i=0;$i<=$length;$i++)
	{
	$currentchar=substr($content,$i,1);
	if ($currentchar==' ')
		{
		$nextchar=substr($content,$i+1,1);
		if ($nextchar!=' ')
			$spacenum+=1;
		}
	}
$spacenum+=1;
return $spacenum;
}

// Ham trich ra mot so ki tu cua mot doan van
	Function get($content,$num)
{
	$content=ucfirst(trim($content));
	$length=strlen($content);
	$newcontent='';
	$spacenum=0;
	for ($i=0;$i<=$length;$i++)
		{
		$currentchar=substr($content,$i,1);
			if ($currentchar==' ')
				{
				$nextchar=substr($content,$i+1,1);
				if ($nextchar!=' ')
					$spacenum+=1;
				}
			$newcontent.=$currentchar;
			if ($spacenum==$num)
				break;				
		}
	return $newcontent;
}
//------------------------------------ New functions ------------------------------------------
function show_all_languages()
	{
	global $link;
	$tblname='languages';
	$query='select * from '.$tblname;
	if ($doquery=mysql_query($query,$link))
		{
		?>
		<table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="middle">
		<?php
		$counter=0;
		while ($result=mysql_fetch_array($doquery))
			{
			$counter++;
			$code=explode('-',$result['code']);
			if ($counter>1)
				echo "<td width=\"10\">&nbsp;</td>\n";
			?>
			<td height="40" align="center" valign="middle" style="cursor: hand;" onClick="javascript: window.location.replace('?lang=<?php echo $result['code']; ?>');">
			<img src="images/<?php echo $result['code']; ?>.gif" width="36" height="25">
			<p class="buttontext"><?php echo ucfirst($code[0]); ?></p>
			</td>
			<?php
			}
			?>
        </tr>
        </table>
		<?php
		}
	}

function show_left_menu($catID,$lang)
	{
	global $link;
	$tblname='articles';
	$phpself=$_SERVER['PHP_SELF'];
	$phpself='';
	?>
	<!-- -------------------------------- Menu ---------------------------------------- -->
	<style>
	.1_off {background-color : #435373; padding: 0 0 0 0;
		font-size : 11px; font-weight: bold; valign: middle;
		font-family : Arial,Tahoma,Verdana; cursor: hand; color: #FFCC22;
		border-top : solid 1px #506090; border-bottom : solid 1px #223355;}
	.1_text_off {padding: 0 0 0 6; cursor: hand; color: #FFCC22;
		font-size : 11px; font-weight: bold;
		font-family : Arial,Tahoma,Verdana;}
	.1_over {background-color : #3377AA; padding: 0 0 0 6;
		font-size : 11px; font-weight: bold; color: #FFFFFF; 
		font-family : Arial,Tahoma,Verdana;	border: solid 0px #FF6600;
		vertical-align: middle; cursor: hand;}
	.1_text_over {padding: 0 0 0 0;	font-size : 11px; 
		font-weight: bold; color: #FFFFFF; cursor: hand;
		font-family : Arial,Tahoma,Verdana;}
	.1_select {background-color : #435373; padding: 0 0 0 0;
		font-size : 11px; font-weight: bold; color: #FFFFFF; 
		font-family : Arial,Tahoma,Verdana;	border: solid 0px #FF6600;
		vertical-align: middle; cursor: hand;}
	.1_text_select {padding: 0 0 0 6;	font-size : 11px; 
		font-weight: bold; color: #FFCC22; cursor: hand;
		font-family : Arial,Tahoma,Verdana; text-align: left;}
		
	.2_off {background-color : #EEEEEE; padding: 2 0 2 0;
		border-top : solid 1px #FFFFFF; border-left : solid 1px #CCCCCC;
		border-right : solid 1px #FFFFFF; border-bottom : solid 1px #CCCCCC;}
	.2_text_off {font-size : 11px; font-weight: bold; color: #336699;
		font-family : Arial,Tahoma,Verdana; cursor: hand;}
	.2_over {cursor: hand; background-color : #EEEEEE;
		padding: 0  3 0 2; font-size : 11px; font-weight: bold; color: #FF6600; 
		font-family : Arial,Tahoma,Verdana;	border-top : solid 1px #CCCCCC;
		border-bottom : solid 1px #FFFFFF; valign: middle;}
	.2_text_over {font-size : 11px; font-weight: bold; color: #FF6600; 
		font-family : Arial,Tahoma,Verdana; cursor: hand;}
		
	.3_off {background-color : #EEEEEE; padding: 2 0 2 0;
		border-top : solid 1px #FFFFFF; border-left : solid 1px #CCCCCC;
		border-right : solid 1px #FFFFFF; border-bottom : solid 1px #CCCCCC;}
	.3_text_off {font-size : 11px; font-weight: bold; color: #336699;
		font-family : Arial,Tahoma,Verdana; cursor: hand;}
	.3_over {background-color : #F7F7F7; padding: 2 0 2 0;
		border-top : solid 1px #CCCCCC;	border-bottom : solid 1px #FFFFFF;}
	.3_text_over {font-size : 11px; font-weight: bold; color: #FF6600;
		font-family : Arial,Tahoma,Verdana; cursor: hand;}
	</style>
	<a name="topmenu"></a>
	<table width="100%" cellpadding="0" cellspacing="0">
	<?php
	$showtable=1;
	if ($catID!='')
		{
		//echo $catID;
		//Query du lieu o bang articles_cat
		$getcat='select * from '.$tblname.'_cat where id="'.$catID.'"';
		$docat=mysql_query($getcat,$link);
		if ($docat and mysql_num_rows($docat)==1)
			{
			$catresult=mysql_fetch_array($docat);
			$showtable=$catresult['name'];
			$catgroup=substr($catresult['level'],0,2);
			// $catgroup de lay cap 1
			$level=strlen($catresult['level'])/2;
			// $level de phan tich menu ra thanh nhieu cap
			}
		else
			{
			echo '<script>';
			echo 'alert("No exsist category. Please choose the right one !");';
			echo 'window.location="'.$phpself.'";';
			echo '</script>';
			}
		}
	
	//Main menu
	$getitem ='select * from '.$tblname.'_cat';
	$getitem.=' where lang="'.$lang.'"';
	$getitem.=' order by level ASC';
	//echo $getitem;
	$doget=mysql_query($getitem);
	if ($doget and mysql_num_rows($doget)>0)
		{
		$bullets=array('','&nbsp;&bull;&nbsp;',' - ',' - ');
		$rows=mysql_num_rows($doget);
		$i=0;
		$subcount=0;
		$opentag=false;
		while ($result=mysql_fetch_array($doget))
			{
			$i++;
			$text=$result['name'];
			if (strlen($text)>1)
				{
				$thisID=$result['id'];
				$path=$result['level'];
				$url=$result['url'];
				if ($url=='')
					$url=$phpself.'?module=browse&catID='.$result['id'];
				// ham str_replace "thay '.' bang ''"
				// ham strlen diem do dai chuoi ky tu thanh so
				// chia cho 2 de lay ra level cac cap
				$level=strlen(str_replace('.','',$path))/2;
				$indent='';
				$status='';
				if ($level==1)
					{
					//$indent.='&nbsp;';
					//$class='parent';
					$subcount+=1;
					
					//Dong muc tin chinh neu co
					if ($subcount>1)
						{
						echo '<tr><td height="0"></td></tr>';
						echo '</table></td></tr>';
						}
					$newsub= '<tr style="display: ';
					//Danh dau muc tin duoc chon
					if (isset($catID))
						{
						//echo 'Path: '.$path;
						//echo 'Cat group: '.$catgroup;
						if (isset($catgroup) && $path==$catgroup)
							{
							$newsub.='block';
							$status='none';
							}
						else
							{
							$newsub.='none';
							//$status='none';
							}
						}
					else
						{
						if ($subcount==1)
							{
							$newsub.='block';
							//$status='none';
							}
						else
							{
							$newsub.='none';
							//$status='none';
							}
						}
					$newsub.= ';" id="sub'.$subcount.'">';
					$newsub.="<td><table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
					//Tao mot dong copy
					$newsub.='<tr><td height="0"></td></tr>';
					$newsub.='<tr><td height="22" valign="middle" class="1_select">';
					//$newsub.='<font color="#FF0000" size="2">&nbsp;&nbsp;'.$indent.'</font>';
					$newsub.="<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr>\n";
					$newsub.="<td width=\"".($level*5)."\"></td>\n";
					$text_class=$level.'_text';
					$newsub.="<td valign=\"middle\" class=\"".$text_class."_select\">\n";
					$text=str_replace(' / ','<br>'.$indent,$text);
					$newsub.=$text;
					$newsub.="</td></tr></table>\n";
					$newsub.="</td></tr>\n";
					$opentag=true;
					}
				else
					{
					}
				if ($level<=3)
					{
					$class_num=$level;
					}
				else
					{
					$class_num=4;
					}
				$format=' class="'.$class_num.'_off"';
				$text_format=' class="'.$class_num.'_text_off"';
				if (isset($catID) and $catID==$thisID)
					{
					$format=' class="'.$class_num.'_over"';
					$text_format=' class="'.$class_num.'_text_over"';
					$curcat=$text;
					}
				else
					{
					$format.=' onMouseOver="this.className=\''.$class_num.'_over\';" onMouseOut="this.className=\''.$class_num.'_off\';"';
					$text_format.=' onMouseOver="this.className=\''.$class_num.'_text_over\';" onMouseOut="this.className=\''.$class_num.'_text_off\';"';
					switch ($level)
						{
						case 1:
						if (isset($url))
							$format.=' onClick="window.location=\''.$url.'\'"';
						break;
						
						case 2:
						$format.=' onClick="window.location=\''.$url.'\'"';
						break;
						
						default:
						$format.=' onClick="window.location=\''.$url.'\'"';
						break;
						}
					}
				$indent.=$bullets[$level-1];
				if ($level==1)
					echo '<tr><td height="0"></td></tr>';
				?>
				<tr<?php if ($level==1) echo ' id="main'.$subcount.'"'; ?> style="display: <?php echo $status; ?>">
				<td<?php if ($level==1) echo ' height="22"'; ?> valign="middle"<?php echo $format; ?>>
				<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
				<!-- <font color="#FF0000" size="2"><?php echo $indent; ?></font> -->
				<td width="<?php echo $level*5; ?>" align="right" valign="top">
				<font color="#FE4848">
				<?php
				if (isset($bullets[$level-1]))
					echo $bullets[$level-1];
				?>
				</font>
				</td>
				<?php $text_class=$level.'_text'; ?>
				<td valign="middle"<?php echo $text_format; ?>>
				<?php
				//$text=str_replace(' / ','<br>'.$indent,$text);
				$text=str_replace(' / ','<br>',$text);
				echo $text;
				?></td>
				</tr>
				</table></td></tr>
				<?php
				if (isset($newsub) and $newsub!='')
					{
					echo $newsub;
					$newsub='';
					}
				}
			else
				{
				?>
				<tr>
				<td height="20" valign="middle">&nbsp;
				</td>
				</tr>
				<?php
				}
			}
		if ($opentag==true)
			echo '</table>';
		?>
		<?php
		}
		?>
	<tr><td height="5"></td></tr>
	</table>
	<!------------------------------------- End menu -------------------------------------->
	<?php
	}
//Scrolling text
function scroll_text($scroll_title,$flash_title,$site_url,$tblname)
	{
	global $link;
	//global $jscript_dir;
	$jscript_dir='javascripts/';
	echo '<script language="javascript" src="'.$jscript_dir.'dw_scroller.js"></script>'."\n";
	?>
	<script type="text/javascript">
	function initScroller() {
	  // arguments: id of layer that scrolls, width and height of scroller (of wn), 
	  // number of items (including repeated 1st item), axis ("v" or "h")
	  // set up pause/resume onmouseover/out? (true or false)
	  var scr1 = new dw_scroller('cnt', 150, 160, 5, "v", true);
	  scr1.setTiming(100, 3000);
	}
	</script>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="form_table">
		<!--
		<tr><td height="22" background="images/title.gif">
		<p class="title"><?php echo $scroll_title; ?></p></td></tr>
		-->
		<tr><td height="150" align="center">
		<div id="bg">
			<div id="wn">
				<div id="cnt">
					<div class="item" align="center">
					<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
					<tr><td align="center" height="125" valign="middle" style="border: 1px solid #009933" bgcolor="#FFFFFF">
					<p class="arttitle">----- <?php echo $flash_title; ?> -----
					<br><br><?php echo $site_url; ?></p></td></tr>
					</table>
					</div>
					<?php
					$news=5;
					$getnews ='select * from '.$tblname;
					//$getnews.=' where id <> '.$focus_id;
					$getnews.=' order by log DESC limit 0,'.$news.'';
					$dogetnews=mysql_query($getnews,$link);
					if ($dogetnews and mysql_num_rows($dogetnews)>0)
						{
						while ($result=mysql_fetch_array($dogetnews))
							{
							$title=get($result['title'],10);
							$content=$result['content'];
							$id=$result['id'];
							$category=$result['category'];
							echo "<div class=\"item\">\n";
							echo "<p class=\"title4\" onClick=\"window.location='detail.php?artID=".$id."&catID=".$category."'\"><strong>&raquo; ".$title."</strong></p>";
							echo "<p class=\"scroll\">\n";
							$temp=get(nl2br(strip_tags($content)),30);
							$temp=stripslashes(($temp));
							$temp=str_replace('<br />',' ',$temp);
							$temp=str_replace('"','',$temp);
							$temp=str_replace('  ',' ',$temp);
							$temp=str_replace('\r',' ',$temp);
							echo $temp."...</p>\n<p class=\"textindex\" onClick=\"window.location='detail.php?artID=".$id."&catID=".$category."'\">Xem chi ti&#7871;t &raquo;</p>";
							echo "\n</div>";
							//$i++;
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		</td></tr>
	</table>
	<?php
	}

//Chain text
function chain($tblname,$source,$alias,$lang)
	{
	global $link;
	global $obj;
	$levels=explode('.',$source);
	$level='';
	$output='';
	for ($i=0; $i<count($levels); $i++)
		{
		if ($i>0) $level.='.';
		$level.=$levels[$i];
		$query ='select * from '.$tblname.'_cat';
		$query.=' where '.$alias.'="'.$level.'"';
		$query.=' and lang="'.$lang.'"';
		$query.=' order by '.$alias.' ASC limit 0,1';
		//echo $query;
		$temp=mysql_fetch_array(mysql_query($query,$link));
		$name=$temp['name'];
		$id=$temp['id'];
		$thislevel=strlen(str_replace('.','',$temp['level']))/2;
		if( $i< ( count($levels) - 1))
		$output.=' &raquo; ';
		if ($thislevel>2)
			$output.='<a href="?module=browse&object='.$obj.'&catID='.$id.'" style="color: #FFFFFF">';
		$output.=$name;
		if ($thislevel>2)
			$output.='</a>';
		}
	return $output;
	}
//Convert datetime from a string format1 to string format2
function datetime_conv($source,$format1,$format2)
	{
	//source => format such as 2005-03-28 11:56:00 <=> %y-%m-%d %h:%i:%s
	//format => %y: year, %m: month, %d: day, %h; hour, %i: minute, %s: second
	//echo 'Source : '.$source;
	$j=0;
	for ($i=0; $i<=strlen($format1); $i++)
		{
		$cur_char=substr($format1,$i,1);
		if ($cur_char=='%')
			{
			$f1_arr[$j]=substr($format1,$i,2);
			$j++;
			$i++;
			}
		}
	$num_arr=array();
	$char_arr=array('-',' ',':','/');
	$j=0;
	$input=trim($source);
	for ($i=0; $i<=strlen($input); $i++)
		{
		$cur_char=substr($input,$i,1);
		if (!in_array($cur_char,$char_arr))
			{
			if (!isset($num_arr[$f1_arr[$j]]))
				$num_arr[$f1_arr[$j]]='';
			$num_arr[$f1_arr[$j]].=$cur_char;
			}
		else
			$j++;
		}
	$j=0;
	for ($i=0; $i<=strlen($format2); $i++)
		{
		$cur_char=substr($format2,$i,1);
		if ($cur_char=='%')
			{
			$f2_arr[$j]=substr($format2,$i,2);
			$j++;
			$i++;
			}
		}
	$output=$format2;
	for ($i=0; $i<count($f2_arr); $i++)
		{
		//echo $f2_arr[$i].' = '.$num_arr[$f2_arr[$i]].'<br>';
		@$output=str_replace($f2_arr[$i],$num_arr[$f2_arr[$i]],$output);
		}
	return $output;
	//$output=trim($format);
	//echo $format;
	//echo $source;
	/*
	if (substr_count($source,' ')==1)
		{
		$datetime_arr=explode(' ',$source);
		//echo $datetime_arr[0];
		if (substr_count($datetime_arr[0],'-')==2)
			$date_arr=explode('-',$datetime_arr[0]);
		else
			return false;
		//echo $datetime_arr[1];
		if (substr_count($datetime_arr[1],':')==2)
			$time_arr=explode(':',$datetime_arr[1]);
		else
			return false;
		$output=str_replace('%y',$date_arr[0],$output);
		$output=str_replace('%m',$date_arr[1],$output);
		$output=str_replace('%d',$date_arr[2],$output);
		$output=str_replace('%h',$time_arr[0],$output);
		$output=str_replace('%i',$time_arr[1],$output);
		$output=str_replace('%s',$time_arr[2],$output);
		return $output;
		}
	else
		return false;
	*/
	}
function send_mail($from,$to,$subject,$message)
	{
	//Mail hreader
	$headers= "MIME-Version: 1.0\r\n";
	//$headers.= "Content-type: text/html; ";
	//$headers.= "charset=iso-8859-1\r\n";
	$headers .='Content-Type: text/html; ';
	$headers .='charset=UTF-8\n';
	$headers .= "Content-Transfer-encoding: 8bit\r\n";
	//$headers .='X-Mailer: PHP/'. phpversion();
	//$headers .='X-Priority: 1\n';
	$headers.= "From: $from";
	$subject = "$subject";
	$body = "$message";
	$to="$to";
	//Send mail
	@$send_check=mail($to,$subject,$body,$headers);
	if ($send_check)
		{
		return true;
		}
	else
		{
		return false;
		}
	}
	

//Ham hien thi so luot truy cap nhieu nhat
Function showmaxonline($curonline)
	{
	global $link;
	//Kiem tra ton tai cua bang SITE
	$check_tbl='select * from site';
	$docheck=mysql_query($check_tbl,$link);
	if (!$docheck)
		{
		// Tao bang UserOnline neu chua co
		$creat_tbl="CREATE TABLE /*!32300 IF NOT EXISTS*/ site (
					  sitename varchar(255) NOT NULL DEFAULT '' ,
					  siteurl varchar(255) NOT NULL DEFAULT '' ,
					  counter int(11) NOT NULL DEFAULT '0' ,
					  maxonline varchar(10) ,
					  maxonlinetime date ,
					  PRIMARY KEY (sitename)
					);";
		$docreat=mysql_query($creat_tbl,$link);
		if (!$docreat)
			{
			return false;
			}
		else
			{
			$insert='Insert into site ';
			$insert.='(sitename,siteurl,counter)';
			$insert.=' values("No name","No URL","500")';
			if (!mysql_query($insert,$link))
				{
				//echo 'Hehe';	
				}
			}
		}
	else
		{
		$result=mysql_fetch_array($docheck);
		$cur_max=$result['maxonline'];
		$time_max=$result['maxonlinetime'];
		if ($cur_max<$curonline)
			{
			$maxonline=$curonline;
			$maxonlinetime=date('Y-m-d');
			$query ='update site set maxonline="'.$maxonline.'"';
			$query.=',maxonlinetime="'.$maxonlinetime.'"';
			$doquery=mysql_query($query,$link);
			}
		$temp=explode('-',$time_max);
		$output=$cur_max.' người ('.$temp[2].'-'.$temp[1].'-'.$temp[0].')';
		return $output;
		}
	}

	/* INTERNAL FUNCTIONS */

	// jsOnClickStr : Called by the function 'generateMenu', this function create the correct
	// javascript for showing or hiding a specific parent's children
	function jsOnClickStr($index){
		$str="";
		$str .= "function xMenu".$index."(){\n";
		foreach($this->children[$index] as $child){
			$str .= "	if(document.getElementById('xChild".$child->id."').style.display=='none'){document.getElementById('xChild".$child->id."').style.display='block';}else{document.getElementById('xChild".$child->id."').style.display='none';}\n";
		}
		//Adding the script to swap the XC box image when clicked
		if(isset($this->boxC) && isset($this->boxO)){
			$str .= "	if(document.getElementById('xcBox".$index."').src == '".$this->boxC."'){document.getElementById('xcBox".$index."').src = '".$this->boxO."';}else{document.getElementById('xcBox".$index."').src = '".$this->boxC."';}\n";
		}
		$str .= "}\n";
		$this->javaScript .= $str;
	
	}//jsOnClickStr

/* INTERNAL CLASSES */

function bsVndDot($strNum)
{
    $len = strlen($strNum);
    $counter = 3;
    $result = "";
    while ($len - $counter >= 0)
    {
        $con = substr($strNum, $len - $counter , 3);
        $result = '.'.$con.$result;
        $counter+= 3;
    }
    $con = substr($strNum, 0 , 3 - ($counter - $len) );
    $result = $con.$result;
    if(substr($result,0,1)=='.'){
        $result=substr($result,1,$len+1);    
    }
    return $result;
}
/*Xoa nhung ky tu dac biet*/
function removesign($str)
{
	$coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
	,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
	"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
	,"ờ","ớ","ợ","ở","ỡ",
	"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
	"ỳ","ý","ỵ","ỷ","ỹ",
	"đ",
	"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
	,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
	"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
	"Ì","Í","Ị","Ỉ","Ĩ",
	"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
	,"Ờ","Ớ","Ợ","Ở","Ỡ",
	"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
	"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
	"Đ","ê","ù","à"," ");
	$khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
	,"a","a","a","a","a","a",
	"e","e","e","e","e","e","e","e","e","e","e",
	"i","i","i","i","i",
	"o","o","o","o","o","o","o","o","o","o","o","o"
	,"o","o","o","o","o",
	"u","u","u","u","u","u","u","u","u","u","u",
	"y","y","y","y","y",
	"d",
	"A","A","A","A","A","A","A","A","A","A","A","A"
	,"A","A","A","A","A",
	"E","E","E","E","E","E","E","E","E","E","E",
	"I","I","I","I","I",
	"O","O","O","O","O","O","O","O","O","O","O","O"
	,"O","O","O","O","O",
	"U","U","U","U","U","U","U","U","U","U","U",
	"Y","Y","Y","Y","Y",
	"D","e","u","a","-");
	return str_replace($coDau,$khongDau,$str);
}
function removeSpecialChars($input)
{
return preg_replace('/[^a-zA-Z0-9\-_]/','',strtolower($input));
}

function paging($requestid, $totalpage, $found, $curpage, $i, $url_htaccess)
{
	global $display;
	if (isset($totalpage))
	{
		echo '<p style="font-weight: bold; text-align: right;">';
		if (isset($requestid))
			$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/1/'.$requestid.'.html';
		else
			$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/1.html';
		if ($curpage>1)   
			{
				echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;">'.$display['the_first'].'</a>';
				if($curpage!=1)//echo back button
				{
					if (isset($requestid))
						$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage-1).'/'.$requestid.'.html';
					else
						$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage-1).'.html';
					echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;"><</a>  ';
				}
				else 
				{
					if (isset($requestid))
						$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage-1).'/'.$requestid.'.html';
					else
						$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage-1).'.html';
					echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;"><</a>  ';
				 }
			 }
		if($curpage>3) echo " ...";
		
		 for($i=$curpage-2;$i<=$curpage+2 && $i<=$totalpage;$i++)
		 {
			if($i>0)
			{
				if (isset($requestid))
					$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.$i.'/'.$requestid.'.html';
				else
					$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.$i.'.html'; 
				if ($i<10)
					$i='0'.$i;
				if ($i!=$curpage)
				{
					echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;">'.$i.'</a>';
				}
				else
				{
				?>
					<a href="<?=$page_url?>" style="padding:2px; font-weight: bold;<?php if( $curpage == $i ) echo "color: red";?>"><?=$i?></a>
				<?php
				}
			}
		 }
		if($curpage<$totalpage-2)echo "...";
		if($curpage<$totalpage)
		{   
			if($curpage<$totalpage) //echo next button
			{
				if (isset($requestid))
				$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage+1).'/'.$requestid.'.html';
			   else
				$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage+1).'.html';
				echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;">></a>';
			}
			else 
			{
				if (isset($requestid))
					$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage+1).'/'.$requestid.'.html';
				else
					$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.($curpage+1).'.html';
				echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;">></a>';
			 }
		}
		if (isset($requestid))
			$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.$totalpage.'/'.$requestid.'.html';
		else
			$page_url='/'.$url_htaccess.'/'.$found.'/'.$totalpage.'/'.$totalpage.'.html';
		if($curpage<$totalpage) echo '<a href="'.$page_url.'" style="padding:2px; font-weight: bold;">'.$display['the_last'].'</a>';
		echo '</p>';
	}
}
/**
 * 
 * Get value cart
 * 
 * @return tongsl
 **/ 
 function total($_tongsl = 0 , $_total = 0)
 {
	$tongsl=0;
	$total = 0;
	if(isset($_SESSION['cart']))
	{
		 foreach($_SESSION['cart'] as $k => $value)
			{
			   if(isset($k)){
					$ok=1;
				}
			}
		if($ok==1)
		{
			 foreach($_SESSION['cart'] as $k => $value){
				$tongsl +=$value; 
			}   
			foreach($_SESSION['cart'] as $key => $value){
				$item[] = $key;
			} 
			//tinh tong tien phai tra 
				$mang = implode(",",$item);
				$sql = "select * from products where id in($mang)";
				$sql = str_replace(',)',')',$sql);
				$donequery  = mysql_query($sql);
				while($row = mysql_fetch_array($donequery))
				{
					$total +=$_SESSION['cart'][$row['id']]*$row['price']; 
				}
		}
		else
		{
			echo "";
		}
	}
	else
	{
		echo "";
	}
	$url1='/chi-tiet-gio-hang.html';
	if(  $tongsl < 10 and 0 < $tongsl )
	$tongsl = '0'.$tongsl;
	if( $_tongsl == 1 )
		return $tongsl;
	else
		return $total;
 }
 function sql_query($tbName, $where, $orderby, $limitmin, $limitmax)
{
    $_sql = " select * from ".$tbName." where lang= ".get_langID()." " ;
    if ( $where != '') 
        $_sql .= " and ".$where." " ; 
    if ( $orderby != '' )
        $_sql .= " order by ".$orderby." " ;    
    if ( $limitmin >= 0 and $limitmax != ''  )
        $_sql .= " limit ".$limitmin." , ".$limitmax." ;";
	//echo $_sql;
    $_do_sql = mysql_query($_sql);
    $_count = 0;
    if( $_do_sql && mysql_num_rows($_do_sql) > 0 )
    {
        while($_row = mysql_fetch_assoc($_do_sql))
        {
            foreach($_row as $_key=>$_value)
            {
                $_result[$_count][$_key] = stripslashes($_value);
            }
            $_count++;
            
        }
        
    }
    return $_result;
}    

//////////////////////////////////////////////////