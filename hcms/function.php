<?php
session_start();
//set_time_limit(0);
//include('..\\dbcon.php');
include('config.inc.php');

//Actions
function show_actions($action)
	{
	//Valid actions array
	$actions=array('Browse','Addnew','Edit','Delete','Access');
	
	switch ($action)
		{
		case 'Browse':
		case 'Addnew':
		case 'Edit':
		case 'Delete':
		case 'Access':
		return true;
		break;
		
		default:
		return false;
		break;
		}
	}
//check if table exist
function table_exists($tableName)
{
    // taken from http://snippets.dzone.com/posts/show/3369
    if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '" . $tableName . "'")))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}
//Show filter
function show_filter($tblname,$title,$field)
	{
	global $strEnable;
	global $strDisable;
	global $strFilter;
	global $strReset;
	global $strAll;
	global $strHavein;
	?>
	<table width="100%" cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td align="center" valign="middle">
	<table width="100%" height="30" border="0" cellpadding="2" cellspacing="2">
	  	<tr>
		<td bgcolor="#E1E1E1">&nbsp;</td>
		<td width="150" style="border: 1px solid #E1E1E1">
		<p class="buttontext">
		<INPUT onclick="TF_enableFilter(<?php echo $tblname; ?>, filter, this)" type="checkbox">
		&nbsp;&nbsp;<?php echo $strEnable.' / '.$strDisable.' '.$strFilter; ?></p></td>
		<td width="80" onclick="filter.reset()" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
		<p class="buttontext"><img align="absmiddle" src="images/reset.gif" width="22" height="22">
		&nbsp;&nbsp;<?php echo $strReset; ?></p></td>
		<td bgcolor="#E1E1E1">&nbsp;</td>
		</tr>
	</table>
	</td>
	</tr>
	
	<tr>
	<td align="center" valign="top">
	<form name="filter" onsubmit="TF_filterTable(<?php echo $tblname; ?>, filter);return false" onreset="_TF_showAll(<?php echo $tblname; ?>)" style="display: none">
	<DIV style="WIDTH: 100%; HEIGHT: 80; OVERFLOW: auto; border: solid 1px #336699; display: block;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
	$itemonrow=4;
	$width=100/$itemonrow;
	$counter=$itemonrow;
	$i=1;
	echo '<tr>';
	while (isset($field[$i]))
		{	
		if ($counter==$itemonrow)
			{
			echo '</tr><tr>';
			$counter=0;
			}
		?>
		<td onMouseOver="change(this,'#EEEEEE')" onMouseOut="undo(this)">
		<p class="formtitle"><?php echo $title[$i]; ?></p>
		<p class="formindex"><?php echo $strAll; ?>
		<input type="text" onkeyup="TF_filterTable(<?php echo $tblname; ?>, filter)" name="s<?php echo $field[$i]; ?>" TF_colKey="<?php echo $field[$i]; ?>" TF_searchType="substring1" class="shortinput">
		<br><?php echo $strHavein; ?>
		<input type="text" onkeyup="TF_filterTable(<?php echo $tblname; ?>, filter)" name="s<?php echo $field[$i]; ?>" TF_colKey="<?php echo $field[$i]; ?>" TF_searchType="substring" class="shortinput"></p>
		</td>
		<?php
		$counter++;
		$i++;
		}
	?>
	</table>
	</div>
	</form>
	</td>
	</tr>
	
	</table>
	<?php
	}

//Show Data table
function show_datatbl($query,$frmname,$action,$tblname,$title,$dimension,$field)
	{
	global $link;
	$tblwidth=0;
	for ($i=0;$i<count($dimension);$i++)
		$tblwidth+=$dimension[$i];
	?>
	<div style="width: 800; height: 300; OVERFLOW: auto; border: solid 1px #336699; margin: 0 0 0 0; padding: 0 0 0 0">
	<form name="viewuser" style="margin: 0 0 0 0;" method="post" action="?module=user_profile" width="<?php echo $tblwidth; ?>">
	<input type="hidden" name="userID" value="">
	</form>
	<script language="JavaScript">
	function userprofile(id)
		{
		document.viewuser.userID.value=id;
		document.viewuser.submit();
		}
	</script>
	<form name="<?php echo $frmname; ?>" method="post" action="">
	<input type="hidden" name="action" value="deleteuser">
	<table id="<?php echo $tblname; ?>" cellSpacing="1" cellPadding="0" border="0" width="100%" style="">
		<tr bgcolor="#efefff">
		<?php
		$i=0;
		while (isset($title[$i]))
			{
			//echo '<td width="'.$dimension[$i].'" class="tdtitle">';
			//echo '<td width="'.(strlen(strip_tags($title[$i]))+1*100).'" class="tdtitle">';
			echo '<td class="tdtitle">';
			echo $title[$i];
			echo "</td>\n";
			$i++;
			}
		?>
		</tr>
	<?php
	$counter=1;
	$doquery=mysql_query($query,$link);
	if ($doquery and mysql_num_rows($doquery)>0)
		{
		$return_rows=mysql_num_rows($doquery);
		//for ($i=0; $i<30000; $i++)
		while ($result=mysql_fetch_array($doquery))
			{
			//$result=mysql_fetch_array($doquery);
			$x=0;
			while (isset($field[$x]))
				{
				$$field[$x]=$result[$field[$x]];
				//echo $field[$x].' = '.$$field[$x].'<br>';
				$x++;
				}
			if (isset($birthday))
				$birthday=datetime_conv($birthday,'%y-%m-%d','%d-%m-%y');
			if (isset($log))
				$birthday=datetime_conv($log,'%y-%m-%d %h:%i:%s','%h:%i:%s %d/%m/%y');
			if (isset($genre))
				{
				switch ($genre)
					{
					case 'm':
					$genre='Nam';
					break;
					case 'f':
					$genre='Nữ';
					break;
					}
				}
			?>
			<tr id="dataRow<?php echo $id; ?>" onMouseOver="change(this,'#EEEEEE')" onMouseOut="undo(this)" style="cursor: hand">
			<TD TF_colKey="check" align="center" width='20'>
			<input type="checkbox" name="chkbox<?php echo $counter; ?>" value="<?php echo $id; ?>" onClick="javascript:colorRow(this);">
			</TD>
			<?php
			$j=1;
			while (isset($field[$j]))
				{
				echo '<TD width="'.$dimension[$j].'" TF_colKey="'.$field[$j].'" class="tdtext" onClick="viewrec('.$$field[1].')">';
				echo $$field[$j];
				echo "</TD>\n";
			  	$j++;	
				}
			?>
			</TR>
			<?php
			$counter++;
				}
			}
		?>
		<input type="hidden" name="total_rows" value="<?php echo $return_rows; ?>">
		</table>
		</form>
		</DIV>
	<?php
	}
	
//Load SQL
function load_sql($path)
	{
	global $link;
	//Open file with Read Only
	if (@$fo=fopen($path,'r',1))
		{
		$query='';
		//Read 1 line
		while ($cur_line=fgets($fo))
			{
			//Strip spaces
			$cur_line=trim($cur_line);
			//echo $cur_line.'<br>';
			if (strlen($cur_line)>0)
				{
				$query.=$cur_line;
				}
			else
				$query='';
			if (substr($cur_line,-1)==';')
				{
				if ($query!='' and $doquery=mysql_query($query,$link))
					{
					//echo 'Query: '.$query.'<br>';
					$query='';
					}
				else
					{
					//echo 'Can not run query :'.$query.'<br>';
					return false;
					}
				}
			}
		@fclose($fo);
		return true;
		}
	}

//List all avilable languages
function load_languages()
	{
	global $link;
	global $error;
	global $lang_dir;
	global $sql_dir;
	global $strLanguage;
	global $strErr;
	global $default_language;
	$tblname='languages';
	//Kiem tra thu muc ngon ngu
	$set_dir=$lang_dir;
	if ($dopen=opendir($set_dir))
		{
		//Ham JS chon ngon ngu
		?>
		<script>
		function set_language(language)
			{
			window.location.replace('<?php echo $_SERVER["PHP_SELF"]; ?>?setlanguage=' + language)
			}
		</script>
		<span class="label"><?php echo $strLanguage; ?></span>
		<select name="language" style="width: 264px;" onchange="set_language(this.value)">
		<option value="" >------<?=$strLanguage?>------</option>
		<?php
		while ($cur_file=@readdir($dopen))
			{
			//if ($cur_file==($language.'.php'))
			if ($cur_file!='.' and $cur_file!='..' and $cur_file!='Thumb.db' and strstr(basename($cur_file),'.php'))
				{
				$cur_lang=explode('.',$cur_file);
				//Kiem tra bang ngon ngu, neu cha co thi tao moi
				$query='select * from '.$tblname.' order by id ASC limit 0,2';
				if (!$doquery=mysql_query($query,$link))
					{
					if (!load_sql($sql_dir.'languages.sql'))
						set_error($strErr['105']);
					}
				//Kiem tra su co mat cua ngon ngu hien thoi trong bang, neu chua co thi them
				$query='select * from '.$tblname.' where code="'.$cur_lang[0].'"';
				if (!$doquery=mysql_query($query,$link) or @mysql_num_rows($doquery)!=1)
					{
					$insert='Insert into '.$tblname.'(code) values("'.$cur_lang[0].'")';
					echo $insert;
					if (!$doinsert=mysql_query($insert,$link))
						set_error($strErr['102']);
					}
				//Liet ke dan sach ngon ngu
				if ($error<1)
					{
					   if($_SESSION['language'] == $cur_lang[0])$selected = 'selected=\'selected\'';else $selected = '';
					echo '<option value="'.$cur_lang[0].'" '.$selected." ";
					/*
					if ($cur_lang[0]==$default_language)
						echo '';
					*/
					echo '>'.ucfirst($cur_lang[0])."</option>\n";
					}
				}
			}
		?>
		</select>
		<?php
		@closedir($dopen);
		return true;
		}
	else
		{
		return false;
		}
	}

//Set language
function set_language($lang)
	{
	global $lang_dir;
	global $siteURL;
	$error=0;
	//Check language file exsist
	$lang_file=$lang.'.php';
	if ($fo=@fopen($lang_dir.$lang_file,'r'))
		{
		$_SESSION['language']=$lang;
		setcookie("language",$lang,time()+60*60*24*30,$_SERVER['PHP_SELF'],$siteURL);
		return true;
		}
	else
		return false;
	}

//Kiem tra dang nhap
function check_login($redirect = true)
	{
	global $phpself;
	if (!isset($_SESSION['userID'],$_SESSION['username'],$_SESSION['usergroup']))
		{
        if(!$redirect)return false;
		?>
		<script language="JavaScript">
		//alert('Ban chua dang nhap he thong !');
		window.location='index.php';
		</script>
		<?php
		return false;
		}
	else
		{
		return true;
		}
	}

//Error Handle
function set_error($message)
	{
	global $error;
	global $err_msg;
	$err_msg[$error]=$message;
	$error+=1;
	}

//Show Error
function show_error()
	{
	global $error;
	global $err_msg;
	global $strHaveError;
	?>
	<p class="formindex">
	<strong><font color="#FF3300" size="2"><?php echo $strHaveError; ?></font></strong>
	<ul type="square">
	<?php
	for ($i=0; $i<count($err_msg); $i++)
		{
		echo '<li style="margin: 3 0 3 0; font-weight: bold;">'.$err_msg[$i]."</li>\n";
		}
	?>
	</ul></p>
	<?php
	}

//Error Handle
function set_notice($message)
	{
	global $notice;
	global $notice_msg;
	$notice_msg[$notice]=$message;
	$notice+=1;
	}

//Show Error
function show_notice()
	{
	global $notice;
	global $notice_msg;
	global $strHaveNotice;
	?>
	<span class="label"><?php echo $strHaveNotice; ?></span>
	<?php
	for ($i=0; $i<count($notice_msg); $i++)
		{
		echo '&raquo;'.$notice_msg[$i]."<br />";
		}
	}

//Ham nap layout cho trang
function load_layout($theme,$name)
	{
	global $layout_dir;
	global $layout_ext;
	global $error;
	global $msg;
	$output='';
	$input=$layout_dir.$theme.'\\'.$name.$layout_ext;
	//echo $input;
	if ($fo=@fopen($input,'r'))
		{
		while (!feof($fo))
			{
			$output.=fread($fo,filesize($input));
			}
		@fclose($fo);
		return $output;
		}
	else
		{
		set_error("  Khng th&#7875; n&#7841;p giao di&#7879;n <b>[ $name ]</b>");
		}
	}

//Ham dien noi dung vao layout
function fill_content($source,$keyword,$content)
	{
	global $error;
	global $msg;
	$output='';
	$temp=$keyword;
	$keyword="<!-- ".$keyword." -->";
	$act=str_replace($keyword,$content,$source);
	if (strlen($act)>=0)
		{
		$output.=$act;
		return $output;
		}
	else
		{
		set_error('  Khng th&#7875; hi&#7875;n th&#7883; <b>[ '.$temp.' ]</b>');
		}
	}

//Ham kiem tra su hop le cua anh upload
function validateimage($imgtype,$imgname,$imgpath)
	{
	$max_size=15000; //15Kb
	$valid_image_type=array('gif','jpg','jpeg','bmp','png');
	$report='';
	switch ($imgtype)
		{
		case 'upload':
		$iname=$_FILES[$imgname]['name'];
		$isize=$_FILES[$imgname]['size'];
		$itype=$_FILES[$imgname]['type'];
		$itemp=$_FILES[$imgname]['tmp_name'];
		//Kiem tra file co ton tai ko
		if (strlen($iname)<=3)
			{
			return 'nofile';
			}
		else
			{
			if ($itype!='image/gif' && $itype!='image/pjpeg' && $itype!='image/bmp')
				{
				return 'nosupportimg';
				}
			else
				{
				if ($isize==0)
					{
					return 'emptyfile';
					}
				else
					{
					if ($isize > $max_size)
						{
						return 'toolarge';
						}
					else
						{
						//Kiem tra thu muc Upload
						$imgdir=opendir($imgpath);
						if (!$imgdir)
							{
							return 'cantcheckfolder';
							}
						else
							{
							$error=0;
							while ($cur_file=readdir($imgdir))
								{
								if ($cur_file!='.' && $cur_file!='..')
									{
									if ($cur_file==$iname)
										{
										return 'duplicatefilename';
										$error+=1;
										}
									if ($cur_file==$iname && filesize($cur_file)==$isize)
										{
										return 'exsistfile';
										$error+=1;
										}
									}
								}
							if ($error==0)
								return 'ok';
							}
						}
					}
				}
			}
		break;
		
		case 'url':
		$imgpath=strtolower(chop(strip_tags($imgpath)));
		@$f=fopen($imgpath,'r');
		//echo $imgpath;
		if ($f)
			{
			$dashpos=strrpos($imgpath,'/');
			$pathlen=strlen($imgpath);
			$imgname=strtolower(substr($imgpath,$dashpos+1,$pathlen));
			$name_array=explode('.',$imgname);
			$extension=$name_array[1];
			$i=0;
			while (isset($valid_image_type[$i]))
				{
				if ($extension==$valid_image_type[$i])
					{
					return true;
					}
				$i++;
				}
			}
		else
			return false;
		break;
		}
	}

//Ham kiem tra mot chuoi co phai la dc web
function validateurl($url)
	{
	$url=strtolower(chop(strip_tags($url)));
	if (strstr($url,'http://'))
		return true;
	else
		return false;
	}

//Ham kiem tra su ton tai cua du lieu
function checkdata($tblname,$fname,$condition)
	{
	global $link;
	$query='select * from '.$tblname.' where '.$fname.'="'.$condition.'"';
	$doquery=mysql_query($query,$link);
	if ($doquery)
		{
		$rows=mysql_num_rows($doquery);
		return $rows;
		}
	else
		return false;
	}

//Ham kiem tra anh de cap nhat
function exsistimage($tblname,$id,$fname,$foldername)
	{
	global $link;
	//Lay file anh da co trong CSDL
	$query='select '.$fname.' from '.$tblname.' where id="'.$id.'"';
	$doquery=mysql_query($query,$link);
	if ($doquery)
		{
		$result=mysql_fetch_array($doquery);
		$image=$result[0];
		
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

//Ham lay danh sach cac truong cua bang
function get_fields($tblname)
	{
	global $db_fileex,$db_dir,$upimages_dir;
	@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
	if (!$open_file)
		{
		echo '<p>';
		echo 'Khong the lay thong tin ve ban ghi !';
		echo '</p>';
		return false;
		}
		else
		{
		//Khoi tao
		$start=0;
		$line=0;
		//Doc noi dung tung dong
		while($cur_line=fgets($open_file))
			{
			$line+=1;
			if ($line==1)
				$tbldetail=chop($cur_line);
				//echo $line;
			//Neu gap dong trong
			if (strlen($cur_line)==2)
				{
				$start=1;
				$start_line=$line+1;
				//echo $start_line;
				$index=0;
				$field_array=array();
				}
			//Bat dau lay DL
			if ($start==1 && $line>=$start_line)
				{
				$line_array=explode('-',$cur_line);
				//Tieu de cot
				$field_array[$index]=$line_array[1];
				return $field_array[$index];
				$index+=1;
				}
			//return $index;
			return true;
			}
		}
	}
//Ham lay DL tu bien form
function get_tblvars($tblname)
	{
	global $db_fileex,$db_dir,$upimages_dir;
	@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
	if (!$open_file)
		{
		echo '<p>';
		echo 'Khong the lay thong tin ve ban ghi !';
		echo '</p>';
		return false;
		}
	else
		{
		//Khoi tao
		$start=0;
		$line=0;
		//Doc noi dung tung dong
		while($cur_line=fgets($open_file))
			{
			$line+=1;
			if ($line==1)
				$tbldetail=chop($cur_line);
			//echo $line;
			//Neu gap dong trong
			if (strlen($cur_line)==2)
				{
				$start=1;
				$start_line=$line+1;
				//echo $start_line;
				$index=0;
				$field_array=array();
				}
			//Bat dau lay DL
			if ($start==1 && $line>=$start_line)
				{
				$line_array=explode('-',$cur_line);
				//Tieu de cot
				$field_array[$index]=$line_array[1];
				//echo $field_array[$index];
				$index+=1;
				}
			}
		$counter=0;
		while (isset($_POST[$field_array[$counter]]))
			{
			$$field_array[$counter]=$_POST[$field_array[$counter]];
			/*
			$var=each($_POST[$counter]);
			$var_name=$var['key'];
			$var_value=$var['value'];
			echo 'Var name: '.$field_array[$counter];
			$$field_array[$var_name]=$_POST[$var_name];
			echo ' - Var value: '.$$field_array[$var_name];
			*/
			echo $$field_array[$counter];
			return $$field_array[$counter];
			$counter+=1;
			}
		return true;
		}
	}

//Ham hien thi hop EDIT
function draw($line_array,$field_value)
{
global $tblname;
global $upimages_dir;
//Ten cot
$field_name=$line_array[1];
//Kieu du lieu
$field_type=$line_array[2];
//Do dai
$field_length=$line_array[3];
//Do dai lon nhat
$field_maxlength=$line_array[4];
//Cho phep rong
$allow_null=$line_array[5];
//Cot tham chieu lay tieu de
$joint_field=$line_array[6];
//Cot tham chieu lay gia tri
$joint_value=$line_array[7];
//Cot level
//$joint_level=$line_array[8];
$field_order=$line_array[8];
//Xet kieu du lieu
switch ($field_type)
	{
	case 'text':
	case 'password':
		echo '<input type="';
		echo $field_type;
		echo '" name="';
		echo $field_name;
		echo '" size="'.$field_length.'"';
		if  ($field_maxlength!='none')
			echo ' maxlength="'.$field_maxlength.'"';
		if (isset($field_value))
			echo ' value="'.$field_value.'"';
		echo '>'."\n";
		break;
	
	case 'textarea':
		echo '<textarea class="bseditor" name="';
		echo $field_name;
		echo '" style="width: 100%; height: 400px;">';
		if (isset($field_value))
			echo $field_value;
		echo '</textarea>';
		break;
	
	case 'richtext':
	?>
	<SCRIPT LANGUAGE=JavaScript1.2 src="editor/RichTextEditor.js" type=text/javascript></SCRIPT>
	<SCRIPT LANGUAGE=JavaScript1.2 src="editor/ConversionForRichText.js" type=text/javascript></SCRIPT>
	<SCRIPT LANGUAGE=JavaScript1.2 src="editor/VietjieForRichText.js" type=text/javascript></SCRIPT>
	<script LANGUAGE=JavaScript1.2>
	var idGenerator = new IDGenerate(0);
	var editor = new Editor(idGenerator,"bsErase(this)","VietTyping(this)");
	editor.Instantiate();
	//EditorSetHTML(",.fmds,.fm,.sdmf.,sdmf")
	</script>
	<?php
	/*
	echo '<textarea name="';
	echo $field_name;
	echo '" style="LEFT:0px;VISIBILITY:hidden;POSITION:absolute;TOP:0px">';
	echo '</textarea>';
	*/
	break;
	
	case 'plaintext':
		echo '<textarea name="';
		echo $field_name;
		echo '" style="width: 80%; height: 200;">';
		if (isset($field_value))
			echo $field_value;
		echo '</textarea>'."\n";
		break;
	
	case 'select_data':
		echo '<select name="'.$field_name.'"><option value="">Select</option>';
		$joint_array=explode('.',$joint_field);
		$joint_table=$joint_array[0];
		$field_tojoint=$joint_array[1];
		$joint_array=explode('.',$joint_value);
		$value_tojoint=$joint_array[1];
		$alias='select '.$field_tojoint.',level,id,'.$value_tojoint;
		$alias.=' from '.$joint_table;
		if ($joint_table=='articles_cat' || $joint_table=='news_cat' || $joint_table=='products_cat')
			{
			$alias.=' where lang="'.get_langID().'"';
			switch ($_SESSION['usergroup'])
				{
				case '1':
				case '2':
				$alias.=' and level like "%"';
				break;
				
				case 3:
				case 4:
				$alias.=' and level like "02.%"';
				break;
				
				default:
				$alias.=' and level like "04.%"';
				break;
				}
			}
		$alias.=' order by level ASC';
		global $link;
		$doalias=mysql_query($alias,$link);
		if ($doalias)
		{
			while ($result=mysql_fetch_array($doalias))
			{
				$indent='';
				$id=$result['id'];
				$level=strlen(str_replace('.','',$result['level']))/2;
				for ($i=1;$i<$level;$i++)
					$indent.='&nbsp;&nbsp;&nbsp;';
				echo '<option value="'.$id.'"';
				if ($field_value==$id)
					echo ' selected';
				echo '>'.$indent.'- '.$result['name'].'</option>';
			}
		}
		echo '</select>';
		break;
	
	case 'select':
		echo '<select name="'.$field_name.'"><br>';
		$joint_array=explode('.',$joint_field);
		$joint_table=$joint_array[0];
		$field_tojoint=$joint_array[1];
		$joint_array=explode('.',$joint_value);
		$value_tojoint=$joint_array[1];
		$alias='select '.$field_tojoint.','.$value_tojoint;
		$alias.=' from '.$joint_table;
		if ($joint_table=='articles_cat' || $joint_table=='news_cat' || $joint_table=='products_cat')
			{
			$alias.=' where lang="'.get_langID().'"';
			switch ($_SESSION['usergroup'])
				{
				case '1':
				case '2':
				$alias.=' and level like "%"';
				break;
				
				case 3:
				case 4:
				$alias.=' and level like "02.%"';
				break;
				
				default:
				$alias.=' and level like "04.%"';
				break;
				}
			}
		if ($joint_table=='languages')
			{
			$alias.=' where lang="'.get_langID().'"';
			}
		if($field_order!="")$alias.=' order by '.$field_order.' ASC';
        else $alias.=' order by '.$field_tojoint.' ASC';
		//echo $alias;
		//Khai bao lai ket noi
		global $link;
		$doalias=mysql_query($alias,$link);
		if ($doalias)
			{
			while ($result=mysql_fetch_array($doalias))
				{
				echo '<option value="'.$result[1].'"';
				if ($field_value==$result[1])
					echo ' selected';
				echo '>'.$result[0].'</option>';
				}
			}
		echo '</select>'."\n";
		break;
	
	case 'select_seri':
		echo '<select name="'.$field_name.'"><option value="">Select</option>';
		$joint_array=explode('.',$joint_field);
		$joint_table=$joint_array[0];
		$field_tojoint=$joint_array[1];
		$joint_array=explode('.',$joint_value);
		$value_tojoint=$joint_array[1];
		$alias='select '.$field_tojoint.',level,id,'.$value_tojoint;
		$alias.=' from '.$joint_table;
		if ($joint_table=='products_cat')
			{
			$alias.=' where lang="'.get_langID().'"';
			switch ($_SESSION['usergroup'])
				{
				case '1':
				case '2':
				$alias.=' and level like "%"';
				break;
				
				case 3:
				case 4:
				$alias.=' and level like "02.%"';
				break;
				
				default:
				$alias.=' and level like "04.%"';
				break;
				}
			}
		$alias.=' order by level ASC';
		global $link;
		$doalias=mysql_query($alias,$link);
		if ($doalias)
		{
			while ($result=mysql_fetch_array($doalias))
			{
				$indent='';
				$id=$result['id'];
				$level=strlen(str_replace('.','',$result['level']))/2;
				if($level==1)
					echo '<optgroup label="- '.$result['name'].'"></option>';
				if($level==2)
					echo '<optgroup label="&nbsp;&nbsp;&nbsp;+ '.$result['name'].'"></option>';
				$seri='select * from manufacturers where category='.$id.'';
				//if(isset($_REQUEST['seriid']))
					//$seri.=' and id='.$_REQUEST['seriid'].'';
				$doseri=mysql_query($seri,$link);
				if($doseri and mysql_num_rows($doseri)>0)
				{
				while($results=mysql_fetch_array($doseri))
					{
					echo '<option value="'.$results['id'].'"';
					if ($_REQUEST['seriid']==$results['id'])
						echo ' selected';
					echo '>'.$results['name'].'</option>';
					}
				}
			}
		}
		echo '</select>';
		break;

		
	case 'time':
		echo '<strong>';
		if ($field_value!='')
			datetime_conv($field_value,'%y-%m-%d %h:%i:%s','%h:%i:%s %d/%m/%y');
		else
			echo date('H:i:s d-m-Y');
		echo '</strong>';
		echo ' (automatic by system)';
		$field_value=date('Y-m-d H:i:s');
		echo '<input type="hidden" name="'.$field_name.'" value="'.$field_value.'">'."\n";
		break;
    
    case 'viewtext':
		//echo ' (automatic by system)';
		//$field_value=date('Y-m-d H:i:s');
		echo $field_value;
		break;
		
	case 'label':
		echo '<strong>';
		if ($field_value!='')
			echo $field_value;
		else
			echo date('d-m-Y');
		echo '</strong>';
		//echo ' (automatic by system)';
		//$field_value=date('Y-m-d H:i:s');
		echo '<input type="hidden" name="'.$field_name.'" value="'.$field_value.'">'."\n";
		break;
	
	case 'dateselect':
		echo '<span id="'.$field_name.'_holder"></span>';
		echo '<input size="10" maxlength="10" type="text" name="'.$field_name.'" value="'.$field_value.'">';
		echo '&nbsp;<img src="images/calendar.png" align="baseline" width="16" height="16" alt="select" onMouseOver="showCalendar(\'\',document.mainform.'.$field_name.',this,\'\',\''.$field_name.'_holder\',0,30,1)">';
		break;
		
	case 'image':
		echo '<input type="file" name="'.$field_name.'" size="'.$field_length.'">'."\n";
		//echo '<br>';
		if (isset($field_value) && $field_value!='')
			{
			echo '<p align="center">';
			previewpic($tblname.'/'.$field_value,'center');
			echo '</p>'."\n";
			}
		break;
	case 'imageonserver':
		echo '<input class="previewable" type="text" name="'.$field_name.'" size="'.$field_length.'" style="cursor: pointer; background-image:url(images/image.gif); background-position:right; background-repeat:no-repeat;"';
		if (isset($field_value) && $field_value!='')
			{
			echo ' value="'.$field_value.'"';
			}
		echo ' onFocus="blur()" onclick="selectFile(this);" /> <span class="del_button only_icon del_image_link" style="display:;height: 25px;vertical-align: top;"></span>';
        //onClick="show_popup(\''.$_SESSION['language'].'\',\'images\',\''.$_GET['tblname'].'\',this.form.name,this.name)" />';
		
		echo '<br/><a target=\'_blank\' class=\'imgpreview\' href=\'/'.$field_value.'\'><img src="ajax/image.php?width=50&amp;height=50&amp;cropratio=2:1&amp;image=/'.$field_value.'"  /></a>';

        //Old Version
		//echo ' onFocus="blur()" onClick="show_popup(\''.$_SESSION['language'].'\',\'images\',this.value.substring(0,this.value.lastIndexOf(\'/\')+1),this.form.name,this.name)">'."\n";
		break;
		
	case 'fileonserver':
		?>
		<script language="javascript" type="text/javascript">
		var child=null
		function show_popup(lang,ftype,path,frmname,field)
			{
			if (child!=null)
				child.focus()
			if (child=='')
				{
				var file='modules/pick_file.php'
				eval("child=window.open('"+file+"?language="+lang+"&file_type="+ftype+"&dir="+path+"&frmname="+frmname+"&field="+field+"', 'file', 'width=700,height=550,top=20,left=50')")
				}
			else
				{
				var file='modules/pick_file.php'
				eval("child=window.open('"+file+"?language="+lang+"&file_type="+ftype+"&dir="+path+"&frmname="+frmname+"&field="+field+"', 'file', 'width=700,height=550,top=20,left=50')")
				}
			}
		</script>
		<?php
		echo '<input type="text" name="'.$field_name.'" size="'.$field_length.'" style="cursor: pointer; background-image:url(images/folder16.gif); background-position:right; background-repeat:no-repeat;"';
		if (isset($field_value) && $field_value!='')
			{
			echo ' value="'.$field_value.'"';
			}
		echo ' onFocus="blur()" onClick="show_popup(\''.$_SESSION['language'].'\',\'files\',\''.$_GET['tblname'].'\',this.form.name,this.name)" />'."\n";
		//Old Version
		//echo ' onFocus="blur()" onClick="show_popup(\''.$_SESSION['language'].'\',\'files\',this.value.substring(0,this.value.lastIndexOf(\'/\')+1),this.form.name,this.name)" />'."\n";
		break;
	}
}
//Ham ma hoa
	function encrypt($strinput)
	{
	$standard=array('a','b','c','d','e','f',
	'g','h','i','j','k','l','m','n','o','p',
	'q','r','s','t','u','v','w','x','w','z',
	'1','2','3','4','5','6','7','8','9','0');
$non_standard=array('`','~','!','=','#','$',
	'%','^','&','{','(',';','-','@','_','+',
	'|','[',']','*','}',')',':','.','<','>',
	'7','6','3','9','5','2','7','1','4','0');
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
		echo $standard[$x].' - '.$non_standard[$x].'<br>';
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
	
//Ham xem truoc anh
function previewpic($pic,$align)
{
global $upimages_dir;
$maxwidth=400;
$maxheight=400;

$f='../'.$upimages_dir.$pic;
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
		@$ratio=$maxwidth/$width;
		if ($ratio>3)
			$ratio=3;
		$newheight=$height*$ratio;
		$newwidth=$maxwidth;
		}
	if ($pictype=='doc')
		{
		@$ratio=$maxheight/$height;
		if ($ratio>3)
			$ratio=3;
		$newheight=$maxheight;
		$newwidth=$width*$ratio;
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
echo '<img src='.$f.' width='.$newwidth.' height='.$newheight.' align="'.$align.'" border="0" hspace="6" vspace="0">';
@fclose($fo);
}	

// Ham hien thi anh voi kich thuoc 50%
function view50($pic,$align)
{
	$f='upimages/'.$pic;
	//echo $f.'<br>';
	@$fo=fopen($f,'r');
	@$size=getimagesize($f);
	$width=$size[0];
	//echo 'Width: '.$width;
	$height=$size[1];
	//echo 'Height: '.$height;
	if ($width>$height)
		$pictype='ngang';
	else
		$pictype='doc';
	//Xu ly
	$newwidth=$width/2;
	$newheight=$height/2;
	//return $newwidth;
	//return $newheight;
	//return $pictype;
	//echo '<br>The image after resize: Newwidth='.$newwidth.' Newheight='.$newheight;
	echo '<img src='.$f.' width='.$newwidth.' height='.$newheight.' align="'.$align.'" border="0" hspace="6" vspace="0">';
	@fclose($fo);
}
//Ham dieu chinh kich thuoc anh
function displaypic($pic,$kt,$align)
	{
	if ($kt=='tiny')
		{
		$maxwidth=48;
		$maxheight=48;
		//$align='center';
		}
	if ($kt=='small')
		{
		$maxwidth=80;
		$maxheight=80;
		//$align='center';
		}
	if ($kt=='medium')
		{
		$maxwidth=120;
		$maxheight=120;
		//$align='center';
		}
	if ($kt=='large')
		{
		$maxwidth=200;
		$maxheight=200;
		//$align='center';
		}
	if ($kt=='xlarge')
		{
		$maxwidth=300;
		$maxheight=300;
		//$align='center';
		}
	global $upimages_dir;
	$f=$upimages_dir.$pic;
	//echo $f.'<br>';
	@$fo=fopen($f,'r');
	@$size=getimagesize($f);
	$width=$size[0];
	//echo 'Width: '.$width;
	$height=$size[1];
	//echo 'Height: '.$height;
	if ($width>$height)
		$pictype='ngang';
	else
		$pictype='doc';
	//Xu ly
	if ($pictype=='ngang')
		{
		@$ratio=$maxwidth/$width;
		if ($ratio>3)
			$ratio=3;
		$newheight=$height*$ratio;
		$newwidth=$maxwidth;
		}
	if ($pictype=='doc')
		{
		@$ratio=$maxheight/$height;
		if ($ratio>3)
			$ratio=3;
		$newheight=$maxheight;
		$newwidth=$width*$ratio;
		}
	//return $newwidth;
	//return $newheight;
	//return $pictype;
	//echo '<br>The image after resize: Newwidth='.$newwidth.' Newheight='.$newheight;
	echo '<img src="'.$f.'" width="'.$newwidth.'" height="'.$newheight.'" align="'.$align.'" border="0" hspace="6" vspace="0">';
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
		$weekday='Ch&#7911; Nh&#7853;t';
		break;
	case 'Mon':
		$weekday='Th&#7913; Hai';
		break;
	case 'Tue':
		$weekday='Th&#7913; Ba';
		break;
	case 'Wed':
		$weekday='Th&#7913; T&#432;';
		break;
	case 'Thu':
		$weekday='Th&#7913; N&#259;m';
		break;
	case 'Fri':
		$weekday='Th&#7913; Su';
		break;
	case 'Sat':
		$weekday='Th&#7913; B&#7843;y';
		break;
	}
$monthday=$getmonthday;

switch ($getmonth)
	{
	case '01':
		$month='M&#7897;t';
		break;
	case '02':
		$month='Hai';
		break;
	case '03':
		$month='Ba';
		break;
	case '04':
		$month='B&#7889;n';
		break;
	case '05':
		$month='N&#259;m';
		break;
	case '06':
		$month='Su';
		break;
	case '07':
		$month='B&#7843;y';
		break;
	case '08':
		$month='Tm';
		break;
	case '09':
		$month='Chn';
		break;
	case '10':
		$month='M&#432;&#7901;i';
		break;
	case '11':
		$month='M&#432;&#7901;i M&#7897;t';
		break;
	case '12':
		$month='M&#432;&#7901;i Hai';
		break;
	}

$year=$getyear;
echo $weekday.', ngy '.$monthday.' thng '.$month.' n&#259;m '.$year.'</b>';
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
		$weekday='C.N';
		break;
	case 'Mon':
		$weekday='T.Hai';
		break;
	case 'Tue':
		$weekday='T.Ba';
		break;
	case 'Wed':
		$weekday='T.T&#432;';
		break;
	case 'Thu':
		$weekday='T.N&#259;m';
		break;
	case 'Fri':
		$weekday='T.Su';
		break;
	case 'Sat':
		$weekday='T.B&#7843;y';
		break;
	}
$monthday=$getmonthday;
$month=$getmonth;
$year=$getyear;

echo $weekday.', '.$monthday.'/'.$month.'/'.$year;	
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
function handlestring($yourstring)
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
	$period='r&#7841;ng sng';
elseif ($gethour>5 && $gethour<=11)
	$period='sng';
elseif ($gethour>11 && $gethour<=14)
	$period='tr&#432;a';
elseif ($gethour>14 && $gethour<=18)
	$period='chi&#7873;u';
elseif ($gethour>18 && $gethour<=21)
	$period='t&#7889;i';
elseif ($gethour>21 && $gethour<=24)
	$period='&#273;m';
elseif ($gethour>=0 && $gethour<=1)
	$period='&#273;m';

echo $hour.' gi&#7901; '.$getminute.' pht '.$period;
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
	$thetime=$part[1];
	$timepart=explode(':',$thetime);
	$hour=$timepart[0];
	$minute=$timepart[1];
	$second=$timepart[2];
	echo $hour.' gi&#7901; '.$minute.' pht, ngy '.$weekday.'/'.$month.'/'.$year;
	//echo $weekday.'/'.$month.'/'.$year;
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
//Get language ID in language table
function get_langID()
	{
	global $link;
	global $lang_tbl;
	$query='select * from '.$lang_tbl.' where code="'.$_SESSION['language'].'" limit 0,1';
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
/*
//Convert datetime from a string format1 to string format2
function datetime_conv($source,$format1,$format2)
	{
	//source => format such as 2005-03-28 11:56:00 <=> %y-%m-%d %h:%i:%s
	//format => %y: year, %m: month, %d: day, %h; hour, %i: minute, %s: second
	echo 'Source : '.$source;
	echo 'F1 : '.$format1;
	echo 'F2 : '.$format2;
	$output='';
	$j=0;
	$s_arr=split("[-: /%]",$source);
	$f1_arr=split("[-: /%]",$format1);
	$f2_arr=split("[-: /%]",$format2);
	$num_arr=array();
	$j=0;
	for ($i=0; $i<count($s_arr); $i++)
		{
		if ($f1_arr[$i]!='')
			{
			$num_arr[$f1_arr[$i]]=$s_arr[$j];
			echo $f1_arr[$i].'=>'.$s_arr[$j].'<br>';
			$j++;
			}
		}
	for ($i=0; $i<count($f2_arr); $i++)
		{
		//echo $f2_arr[$i].' = '.$num_arr[$f2_arr[$i]].'<br>';
		$output=str_replace($f2_arr[$i],$num_arr[$f2_arr[$i]],$output);
		}
	return $output;
	}
*/
///*
function datetime_conv($source,$format1,$format2)
	{
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
	}
//*/

function tab_deactive($tblname,$catlevel)
{
	global $link;

	if ($langID=get_langID())
	{
	$categories ='select * from '.$tblname.'_cat';
	//$categories.=' where lang="'.$langID.'" and';
	$categories.=' where level like "'.$catlevel.'%"';
	$categories.=' order by level ASC';
	$docategories=mysql_query($categories,$link);
	if ($docategories and mysql_num_rows($docategories)>0)
		{
		$catnum=mysql_num_rows($docategories);
		$j=0;
		$x=0;
		while ($result=mysql_fetch_array($docategories))
			{
			$level=strlen($result['level']);
			if ($level>3)
				{
				$x++;
				if ($x>1)
					$catIDs[$j].=',';
				$catIDs[$j].=$result['id'];
				}
			else
				{
				$j++;
				$x=0;
				$catNames[$j]=$result['name'];
				$catIDs[$j]='';
				}
			}
		
		for ($i=1; $i<=$j; $i++)
			{
			$feature ='select * from '.$tblname.' where category in ('.$catIDs[$i].')';
			//if (isset($focus_id))
				//$feature.=' and id <> '.$focus_id.'';
			$feature.=' and active!="1"';
			//$feature.=' and lang="'.$langID.'"';
			$feature.=' order by';
			$feature.=' log DESC';
			//$feature.=' limit 0,12';
			//echo $feature;
			?>
			<!--<form action="" method="post" name="frmList" onSubmit="return checkInput();">-->
            	<tr>
                	<td align="middle" valign="top">
            	    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    		<tr valign="center"> 
                    			<td width="3%" height="14" class="Cat">No.</td>
                				<td width="3%" height="14"> 
            						<input type="checkbox" name="chkall" value="0" onClick="docheck(document.frmList.chkall.checked,0);" />
            					</td>
            					<td style="padding-left:20px;" width="25%" height="14" class="Cat">Title</td>
            					<td style="padding-left:20px;" width="100%" height="14" class="Cat">Content</td>
            					<td width="12%" style="padding-left:20px;" height="14" class="Cat">Email</td>
            				</tr>
			<?php
			$dofeature=mysql_query($feature);
			if ($dofeature and mysql_num_rows($dofeature)>0)
				{
				$i=0;
				//$strid="";
				while ($result1=mysql_fetch_array($dofeature))
					{
					$i++;
					$id=$result1['id'];
					$category=$result1['category'];
					$title=stripslashes($result1['title']);
					$content=$result1['content'];
					$image=$result1['image'];
					$log=$result1['log'];
					$price=$result1['price'];
					$status=$result1['status'];
					$author=$result1['postby'];
					$lang=$result1['lang'];
					$email=$result1['email'];
					//$strid .=$id.",";
					$bgcolor="#F7F7F7";
					$bgcolor1="#FFFFFF";
					?>
					<tr bgcolor="<?php if ($i % 2 !=0){ echo $bgcolor; }else{ echo $bgcolor1; }  ?>">
						<td align="middle" class="content"><?php echo $i; ?></td><td class="content"><input type="checkbox" id="chkid" name="chkid" value="<?php echo $id; ?>" onClick="docheckone();" /></td><td class="content" style="padding-left:20px;"><?php echo $title; ?></font></td>	            	    							<td style="padding-left:20px;" class="content"><?php echo $content; ?></td>
	            		<td style="padding-left:20px;" class="content"><?php echo $email; ?></td><td class="content"></td>
					</tr>
					<input type="hidden" name="chkid" />
					<?php
					}
				}
				?>
	            	<tr valign="top">
	            		<td colspan="5" valign="center"><br>
							<!--<input type="hidden" name="chkids" />
	            			<input type="submit" value="Ative" class="button" name="submit" />
							<input type="submit" onclick="javascript: return confirm('Ban co chac chan la` muon xoa no koh ?');" value="Delete" class="button" name="delete" />-->
	            		</td>
	            	</tr>		
            	</table>
        		</td>
            </tr>
    		<!--</form>--><?php
			}
		}
	} 
}
/**
 * 
 * 
 * format number
 * dec point (.)
 * thousands sep (,)
 * 
 * 
 * 
**/
function format_number($number, $edit=0 , $ext = ""){
	if($edit == 0){
		$return	= number_format($number, 2, ".", ",");
		if(intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", ",");
		elseif(intval(substr($return, -1, 1)) == 0) $return = number_format($number, 1, ".", ",");
		return $return . $ext;
	}
	else{
		$return	= number_format($number, 2, ".", "");
		if(intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", "");
		return $return . $ext;
	}
}
/**
 * do sql from array
 * action support :
 * -> insert 
 * -> update
 * -> delete
 * 
 * 
 */ 
 function do_sql($_table , $_array, $_action)
{
    //$_pre   = substr($_table,0,3);
    
    
    $_field_array;
    $_get_field = mysql_query("SHOW COLUMNS FROM ".$_table);
    //print_r(mysql_fetch_assoc($_field_array));
    if($_get_field && mysql_num_rows($_get_field))
    {
        while($_row = mysql_fetch_assoc($_get_field))
        {
            $_field_array[] = $_row['Field'];
        }
    } else return false;
    $_standar_array = array() ;
    foreach($_field_array as $_item)
    {
        if(isset($_array[$_item]))
            $_standar_array[$_item] = addslashes($_array[$_item]);
    }
    if(count($_standar_array) == 0){
        //log_error("do_sql wrong array input");return false;
    }
    //print_r($_standar_array);
    switch($_action)
    {
        case "delete":
            if(isset($_standar_array["id"]))
                {
                    $_del       = "delete from " . $_table . " where id=" . $_standar_array["id"];
                   
                    $_do_del    = mysql_query($_del);
                    if(!$_do_del || !mysql_affected_rows() )
                    {
                         //log_error("do_sql " . $_del . " false ");
                        return false;
                    } 
                    else {
                        //log_error("do_sql " . $_del . " true ");
                        return true;
                    }
                }
            else 
            {
                $_set_array;
                    foreach($_standar_array as $_index => $_value)
                    {
                        $_set_array[] = $_index . "=" . "'". $_value ."'";
                    }
                $_del = "delete from " . $_table . " where ".implode(" and ",$_set_array);
                    $_do_del    = mysql_query($_del);
                    if(!$_do_del || !mysql_affected_rows() )
                    {
                     //    log_error("do_sql " . $_del . " false ");
                        return false;
                    } 
                    else {
                     //   log_error("do_sql " . $_del . " true ");
                        return true;
                    }
            }
            return true;
            break;
        case "update":
            if(isset($_standar_array["id"]))
                {
                    $_update    =   "update " . $_table . " set ";
                    $_set_array;
                    foreach($_standar_array as $_index => $_value)
                    {
                        $_set_array[] = $_index . "=" . "'". $_value ."'";
                    }
                    $_set       =   implode(",",$_set_array);
                    $_update    .=  $_set . " where id=" . $_standar_array["id"];
                    $_do_update =   mysql_query($_update);
                    if(!$_do_update || !mysql_affected_rows() )
                    {
                         //log_error("do_sql " . $_update . " false ");
                        return false;
                    } 
                    else 
                    {
                        // log_error("do_sql " . $_update . " true ");
                        return true;
                    } 
                }
            break;
        case "insert":
            $_index_array;
            $_value_array;
            foreach($_standar_array as $_index => $_value)
            {
                $_index_array[] = $_index;
                $_value_array[] = $_value;
            }
            $_index_array   = implode(",",$_index_array);
            $_value_array   = "'" . implode("','",$_value_array) . "'";
            $_insert        =   "insert into " . $_table;
            $_insert        .= " (" . $_index_array . ") ";
            $_insert        .= " values(" . $_value_array . ")";
            $_do_insert =   mysql_query($_insert);
            if(!$_do_insert && !mysql_affected_rows() )
            {
                       //  log_error("do_sql " . $_insert . " false ");
                        return false;
            } 
            else 
            {
                         //log_error("do_sql " . $_insert . " true ");
                        return true;
            } 
            break;
        case "count":
            {
                //$_count = "select " . $_pre . "_id from " . $_table;
                $_count = "select id from " . $_table;
                foreach($_standar_array as $_index => $_value)
                    {
                        $_set_array[] = $_index . "=" . "'". $_value ."'";
                    }
                    $_set       =   implode(",",$_set_array);
                $_count .= " where ".$_set;
                $_do_count = mysql_query($_count);
                if($_do_count)
                return mysql_num_rows($_do_count);
                else return false;
            }
            break;
    }
    //log_error("do_sql error action ");
    return false;
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
                 $_amount = "")
{
    $_result = array();
    $_sql = "select * from " . $_table . " where 1 ";
    if($_where != "")$_sql .= " and " . $_where . " ";
    if($_orderby != "")$_sql .= " order by " . $_orderby . " ";
    if(intval($_from) >=0 && intval($_amount) > 0)$_sql .= " limit " . intval($_from) . "," . intval($_amount);
    //echo $_sql;
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
/**
 * 
 * Get value from id
 * 
 * @return value
 **/ 
 
function get_by_id($_table, $_id, $_value_col="")
{
    $_pre = substr($_table,0,3);
    $_sql = "select * from " . $_table . " where id='" . $_id . "'";
    
    $_do_sql = mysql_query($_sql);
    //echo $_sql;
    //log_error($_sql);
    if($_do_sql && mysql_num_rows($_do_sql) && $_row = mysql_fetch_assoc($_do_sql))
    {
        if($_value_col != "")
        {
            if(isset($_row[$_pre . "_" . $_value_col]))$_value = $_row[$_pre . "_" . $_value_col];
            else if(isset($_row[$_value_col]))  $_value = $_row[$_value_col];
            return stripslashes($_value);
        }
        else 
        {
            foreach($_row as $_key=>$_value)
            
            {
                $result[$_key] = stripslashes($_value);
            }
            return $result; 
        }
        
        
    }
    return false;
}
function get_by_level($_table, $_level, $_value_col="")
{
    $tmp = get_all($_table," level = ".$_level,0,1);
    if($_value_col == "")return $tmp[0];
    else return $tmp[0][$_value_col];
}
function get_all_products_from_cat_id($_table,$cat_id,$_where="",$_orderby="",$_from="",$_amount="",$_fromlevel="0")
{
    $_ctable = preg_replace("/_cat$/","",$_table);
    $_table = $_ctable."_cat";
    $return = array();
    $pinfo = get_by_id($_table,$cat_id);
    $_plevel = $pinfo['level'];
    //print_r($pinfo);echo "aaaaaaaaaaaaaaaa";
    //build where clause (always have where clause )
    $where = array( "1" );
    if(is_array($_where))
    {
        foreach($_where as $_wherekey => $_whereitem)
        {
            if(is_array($_whereitem))
            {
                $tmpwhere = " ".$_ctable.".".$_whereitem[0]." ";
                if($_whereitem[2] == '>=' || $_whereitem[2] == '>' || $_whereitem[2] == '<=' || $_whereitem[2] == '<' || $_whereitem[2] == 'like' || $_whereitem[2] == '!=' || $_whereitem[2] == '=' )
                {
                    if(is_numeric($_whereitem[1]))
                        $tmpwhere .= $_whereitem[2]." ".$_whereitem[1]." ";
                        else $tmpwhere .= $_whereitem[2]." '".$_whereitem[1]."' ";
                    $where[] = $tmpwhere;
                }
                else {
                    if(is_numeric($_whereitem[1]))
                        $tmpwhere .= " = ".$_whereitem[1]." ";
                        else $tmpwhere .= " = '".$_whereitem[1]."' ";
                    $where[] = $tmpwhere;
                }
            }
            else if($_wherekey && $_whereitem)$where[] =  " ".$_ctable.".".$_wherekey." = '".$_whereitem."' ";
        }
        
    }
    $where = implode(" and ",$where);
    //build orderby clause (not sure that always have order by clause)
    $order = "";
    if(is_array($_orderby))
    {
        foreach($_orderby as $_orderbykey => $_orderbyitem )
        $order[] = " ".$_ctable.".".$_orderbykey." ".$_orderbyitem." "; 
    }
    if($order != "")$order = implode(" , ",$order);
    //build select clause
    $_select = "";
    $_get_field = mysql_query("SHOW COLUMNS FROM ".$_ctable);
    if($_get_field && mysql_num_rows($_get_field))
    {
        while($_row = mysql_fetch_assoc($_get_field))
        {
            $_select[] = " ".$_ctable.".".$_row['Field']." as ".$_row['Field']." ";
        }
    }
    $_select = implode(",",$_select);
    //build sql query
    if($_select == "")$sql = "select * ";
    else $sql = "select $_select ";
    $sql .= "from $_ctable , $_table where ";
    $sql .= "$_ctable.category = $_table.id and ";
    $sql .= "$_table.level like '$_plevel%' and ";
    $sql .= " $_table.lang = ".get_langID()." and $_ctable.lang = ".get_langID()." and ".$where." ";
    if($order != "")$sql .= " order by ".$order." and ";
    if($_amount != "")$sql .= " limit ".intval($_from).", ".intval($_amount);
    //echo $sql;
    
    $do_sql = mysql_query($sql);
    if($do_sql && mysql_num_rows($do_sql) > 0)
    {
        while($row_sql = mysql_fetch_assoc($do_sql))
        {
            $return[] = $row_sql;
        }
    }
    
    return $return;
    
/*
     $return = get_all($_ctable," id=".$cat_id." and lang=".get_langID()." and active=1 ");
     while(1)
     {
         $tmp = get_all($_table," level like '".$pinfo['level'].".__' and lang=".get_langID()." ");
     }
 */
}
?>