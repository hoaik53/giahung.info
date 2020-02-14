<?php if (substr_count($_SERVER['PHP_SELF'],'/bp.php')>0) die ("You can't access this file directly..."); ?>
<div class="main" >
	<?php
	$tblname='products';
	if (isset($_REQUEST['pcatID']))
	{
	$requestid = intval($_REQUEST['pcatID']);
	$query ='select * from '.$tblname.'_cat where id='.$requestid.' and lang='.get_langID().'';
	$doquery=mysql_query($query,$link);
	if ($doquery and mysql_num_rows($doquery)>0)
		{
		$result=mysql_fetch_array($doquery);
		$path=$result['level'];
		$name=$result['name'];
		$level=strlen(str_replace('.','',$path))/2;
		}
	}
	$obj=$level;
	switch ($obj)
		{
		case '1':
		case '2':
		$itemonrow=1;
		$rows=20;
		$curpage=1;
		// Get title
		$catid = cat_id($tblname, $path);
		$Level = new Level();
		$Level = $Level->cat_Level($tblname, $requestid, 'danh-muc-san-pham');
		?>
		<ul class='products'>
		<?php
		$query2 ='select * from '.$tblname.' where';
		if(isset($_REQUEST['pcatID']) && $_REQUEST['pcatID']!='')
			$query2.=' id in ('.$catid.') and';
		$query2.=' lang="'.get_langID().'"';
		$query2.=' and '.$tblname.'.active=1';
		//$query2.=' and '.$tblname.'.level=3';
		$query2.=' order by log DESC';
		$query2= str_replace(',)',')',$query2);
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
				
				if ($doquery2 and mysql_num_rows($doquery2)>0)
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
					//detail new
                    $count = mysql_num_rows($doquery2);
					$du = $count % 3;
						if( $du == 0) $du =3;
					while ($result2=mysql_fetch_array($doquery2) and $i<=($itemonrow*$rows))
						{
						$i++;
						//echo $a;
						$id=$result2['id'];
						$category=$result2['category'];
						$title=stripslashes($result2['title']);
						$image=$result2['image'];
						$icon=$result2['icon'];
						$price=$result2['price'];
						$price1=$result2['price1'];
							if( $price1 == 0 )
							$price == $price ;
						$brief = $result2['brief'];
						$content = $result2['content'];
						$url='/chi-tiet-san-pham/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
						$style= "padding-left: 5px;";	
						?>
						<li style="<?php if( $i%3 == 1 ) echo $style; ?>; <?php if( $i%3 == 0 ) echo 'padding-right: 5px;'; ?>; " >
							<div class="p" style="">
							<div class="list_review" style=" position: relative;" >
								<div class="fl width_3">
									<div class="block">
										<div class="picture_small">
										<div id="bodytext" class="details-content clearfix">
											<a class="tooltip" href="<?php echo $url; ?>" style=" color: #fff;"><img src="/<?php echo $image; ?>" width="140" height="175" style="border: none;" alt="<?php echo $title; ?>" /></a>
										</div>
										</div>
									</div>
									<pre class="hidden">
										<div class="name"><?php echo $title; ?></div>
										<div class="content"><?php echo get(strip_tags($content),50); ?></div>
										<br />
										<div class="picture" src="/<?php echo $image; ?>" > <img src="/<?php echo $image; ?>" style="width: 300px; border-radius: 3px 3px 3p 3px; height: 300px;" alt="<?php echo $title; ?>"/> </div>
										<div></div>
									</pre>
								</div>
							</div>	
							<script type="text/javascript">$(function(){ tooltipReview(); });</script>
							</div>
							<div class="title" style="padding: 10px 5px 5px 5px; float: left; width: 160px; text-align: center; "><a href="<?=$url?>"><?php echo get($title,10); ?></a></div>
								
								<div id="cart">
									<a href='<?php echo $url; ?>'><?php echo $display['view_more']; ?></a>
									<a onclick="ajaxfunction(<?php echo $id; ?>)" style="cursor:pointer;"><?php echo $display['order']; ?></a>
								</div>
						</li>
						<?php
							if ($i==$rows*$itemonrow)
								break;
							}
						?>
						
					<div id="pt" >
						<?php paging($requestid, $totalpage, $found, $curpage, $i, 'danh-muc-san-pham') ?>
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
							$url2='/chi-tiet-san-pham/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
							?>
							<script>
							window.location.replace("<?php echo $url2; ?>")
							</script>
							<?php
							}
						}
					break;		
				default:
				break;
		}
			?>
		</ul>
		<div class="bottom"></div>
</div>	