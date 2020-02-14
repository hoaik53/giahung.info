<?php if (substr_count($_SERVER['PHP_SELF'],'/da.php')>0) die ("You can't access this file directly...");?>
<div class="main" >
<?php
if (isset($_REQUEST['acatID']))
	{
		$tblname='articles';
		$acatID=value_filter($_REQUEST['acatID']);
		$Level = new Level();
		$Level = $Level->cat_Level($tblname, $acatID, 'bai-viet');
	}	
	?>
	<div style='float: left;' >
	<?php
		if (isset($_REQUEST['module']))
		{
		$show_another=false;
		if (isset($_REQUEST['artID'],$_REQUEST['acatID']))
			{
			$tblname='articles';
			$artNum=9;
			// Get title
			$query1 ='select '.$tblname.'.*,'.$tblname.'_cat.level as category_level'; //,'.$tblname.'_cat.id as category_id';
			$query1.=' from '.$tblname.' inner join '.$tblname.'_cat';
			$query1.=' on '.$tblname.'.category='.$tblname.'_cat.id';
			$query1.=' where category = '.$_REQUEST['acatID'].' and lang="'.get_langID().'"';
			//echo $query1;
			$doquery1=mysql_query($query1,$link);
			if ($doquery1 and mysql_num_rows($doquery1)>0)
				{
				$result1=mysql_fetch_array($doquery1);
				$title=chain($tblname,$result1['category_level'],'level',get_langID());
				}
			// Get items 
			$query ='select * from '.$tblname.' where';
			$query.=' id="'.$_REQUEST['artID'].'" and';
			$query.=' lang="'.get_langID().'"';
			$query.=' order by';
			$query.=' id ASC,';
			$query.=' log DESC';
			//---------------- Show item -----------------
			function show_item($result)
				{
				global $tblname;
				global $display;
				global $datetime_format;
				global $siteUrl;
				global $background_colorbg;
				$id=$result['id'];
				$category=$result['category'];
				$title=stripslashes($result['title']);
				$image=$result['image'];
				$content=stripslashes($result['content']);
				$content=str_replace("=\"www.","=\"http://www.",$content);
				$datetime = $result['log'];
				?>
				<div style="float: left; text-align: justify; font-size:12px; width: 540px; padding: 10px 20px;">
				<p style="color: #303030; font-weight:bold; padding: 10px; text-align: center;"><?php echo $title; ?></p>
				<p style="padding: 10px; text-align: center;"><img src="/<?php echo $image; ?>" width="400" height="300" /></p>
				<p style="text-align: center;">
				<div style="float: left; padding-left: 10px; padding-bottom: 20px; border-bottom: 1px solid #c1c1c1;"><?php echo $content; ?></div>
				</p>
				</div>
		</div>
				<?php
				}
				//Another news
				$show_another=true;
				$another_query ='select * from '.$tblname.' where';
				$another_query.=' id>'.$_REQUEST['artID'].' and';
				$another_query.=' category="'.$_REQUEST['acatID'].'"';
				$another_query.=' order by id ASC';
				$another_query.=' limit 0,'.($artNum+1).'';
				
				$previous_query ='select * from '.$tblname.' where';
				$previous_query.=' id<'.$_REQUEST['artID'].' and';
				$previous_query.=' category="'.$_REQUEST['acatID'].'"';
				$previous_query.=' order by id ASC';
				$previous_query.=' limit 0,'.($artNum+1).'';
			}
			//show_content();
			//echo $query;
			$doquery=mysql_query($query,$link);
			if ($doquery and mysql_num_rows($doquery)>0)
				{
				$result=mysql_fetch_array($doquery);
				$update='update '.$tblname.' set view="'.($result['view']+1).'" where id="'.$_REQUEST['artID'].'"';
				//echo $update;
				$doupdate=mysql_query($update,$link);
				?>
				<?php @show_item($result); ?>
				<?php
				}
				//End show detail
				?>							
				<div style="float: left; text-align: left; font-weight:bold; padding-left: 20px;">
                    <?php echo $display['same_news'];?>
                </div>                                                      
                <?php								
				//Another article
			if ($show_another==true)
				{
				$cont=false;
				?>
				<div style="float: left; text-align: left; padding-left: 30px; margin-top:10px; clear:both;">
				<?php
				//echo $another_query;
				if ($doanother_query=mysql_query($another_query,$link) and mysql_num_rows($doanother_query)>0)
					{
					$counter=0;
					while ($result=mysql_fetch_array($doanother_query))
						{
						$counter++;
						//echo $counter;
						if ($counter==($artNum+1))
							{
							$nextid=$result['id'];
							$cont=true;
							break;
							}
						else
							{
							$id=$result['id'];
							$category=$result['category'];
							$title=stripslashes($result['title']);
							$url='/chi-tiet-bai-viet/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
							echo "&middot; <a href=".$url.">".$title."</a><br/>\n";
							}
						}
					}
				if ($doprevious_query=mysql_query($previous_query,$link) and mysql_num_rows($doprevious_query)>0)
					{
					$counter=0;
					while ($result=mysql_fetch_array($doprevious_query))
						{
						$counter++;
						//echo $counter;
						if ($counter==($artNum+1))
							{
							$nextid=$result['id'];
							$cont=true;
							break;
							}
						else
							{
							$id=$result['id'];
							$category=$result['category'];
							$title=stripslashes($result['title']);
							$url='/chi-tiet-bai-viet/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
							echo "&middot; <a href=".$url.">".$title."</a><br/>\n";
							}
						}
					
					}
					?>
					</div>
					<?php
				}
			else
				{
				?>
				<script>
				alert("<?php echo $display['noarticle']; ?>")
				window.history.go(-1)
				</script>
				<?php
				}
			}
			?>
		</div>	
	<div class="bottom"></div>		