<?php if (substr_count($_SERVER['PHP_SELF'],'ba.php')>0) die ("You can't access this file directly..."); ?>
<div class="main" >
	<?php
	if (isset($_REQUEST['acatID']))
	{
	$tblname='articles';
	$requestid = intval($_REQUEST['acatID']);
	$query ='select * from '.$tblname.'_cat where id='.$requestid.' and lang='.get_langID().'';
	$doquery=mysql_query($query,$link);
	if ($doquery and mysql_num_rows($doquery)>0)
		{
		$result=mysql_fetch_array($doquery);
		$path=$result['level'];
		$name=$result['name'];
		$level=strlen(str_replace('.','',$path))/2;
		}
	$obj=$level;
//	echo $obj;
	switch ($obj)
		{
		case '1':
		case '2':
		case '3':
		$itemonrow=1;
		$rows=8;
		$curpage=1;
		$catid = cat_id($tblname, $path);

		$Level = new Level();
		$Level = $Level->cat_Level($tblname, $requestid, 'bai-viet');
		?>
		<ul class='products' >
		<?php
		$query2 ='select * from '.$tblname.' where';
		$query2.=' id in ('.$catid.') and';
		$query2.=' lang="'.get_langID().'"';
		$query2.=' and '.$tblname.'.active=1';
		$query2.=' order by log DESC';
		$query2= str_replace(',)',')',$query2);
		//echo $query2;
		//echo $query2;
				//show_content();
				if (isset($_REQUEST['curpage'],$_REQUEST['totalpage'],$_REQUEST['found']))
					{
					$found=$_REQUEST['found'];
					$totalpage=$_REQUEST['totalpage'];
					$curpage=$_REQUEST['curpage'];
					$from=($curpage-1) * $itemonrow * $rows;
					$to=$from + $itemonrow*$rows;
					$limit=' limit '.$from.','.$to;
					}
				if (isset($limit,$query2))
					$query2.=$limit;
				//echo $query;
				//exit;
				$doquery2=mysql_query($query2,$link);

				if ($doquery2 and mysql_num_rows($doquery2)>1)
					{
					if (!isset($found))
						$found=mysql_num_rows($doquery2);
					if (!isset($totalpage))
						{
						if ($found<($itemonrow*$rows))
							$totalpage=1;
						else
							{
							if ($found%($itemonrow*$rows)==0)
								$totalpage=$found/($itemonrow*$rows);
							else
								$totalpage=(int)($found/($itemonrow*$rows))+1;
							}
						}
					if (isset($found) and $found!=0)
						{
						}
					$i=0;
					?>	
					<?php
					//detail new
					while ($result2=mysql_fetch_array($doquery2) and $i<=($itemonrow*$rows))
						{
						$id=$result2['id'];
						$brief = $result2['brief'];
						$category=$result2['category'];
						$title=stripslashes($result2['title']);
						$image=$result2['image'];
						$content = $result2['content'];
						$url='/chi-tiet-bai-viet/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
						//Show item
						?>
						<div style="float: left; width: 540px; border-bottom: 1px dotted #666; margin: 5px 10px; padding-bottom: 5px; position: relative;">
							<div class="image1" style="float: left; width: 150px; height: 90px; padding: 10px 0px 10px 5px;"><a href="<?php echo $url; ?>"><img src="/<?php echo $image; ?>" style="width: 130px; height: 90px; border: 1px #c3c3c3 solid; padding: 2px; "/></a></div>
								<div style="text-align: left; padding-left:10px; padding-top: 8px; font-weight:bold;" class="ba"><a href="<?php echo $url;?>" ><?php echo $title; ?></a></div>
								<div class="text" style="padding-left:10px; margin-top: 5px; text-align: justify; ">
									<?php if($brief == ''){ ?>
										<div  id="text11" ><p style="font-size:12px;"><?php echo get(strip_tags($content),50); ?></p></div>	
									<?php }
									else { ?>
										<div id="text11"><p style="font-size:12px;"><?php echo get(strip_tags($brief),50); ?></b></div>	
									<?php }?>
									</div>
									
						</div>
							<?php
							$i++;
							if ($i==$rows*$itemonrow)
								break;
							}
						?>
					<div id="pt" >
					<?php paging($requestid, $totalpage, $found, $curpage, $i, 'bai-viet') ?>
					</div>
					<?php
						}
					else
					{
					if ( $doquery2 and mysql_num_rows($doquery2)==1)
						{
						$result2=mysql_fetch_array($doquery2);
						$id=$result2['id'];
						$title=$result2['title'];
						$category=$result2['category'];
						$url2='/chi-tiet-bai-viet/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
						?>
						<script>
						window.location.replace("<?php echo $url2; ?>")
						</script>
						<?php
						}
	
					}
				?>
			</ul>
			<?php
		break;
		
			}
			}
		?>	
	<div class="bottom"></div>
</div>
	
