<?php if (substr_count($_SERVER['PHP_SELF'],'/dp.php')>0) die ("You can't access this file directly..."); ?>
<div class="main">
<?php
$tblname='products';
if (isset($_REQUEST['pcatID']))
	{
	$pcatID=value_filter($_REQUEST['pcatID']);
	$catid = cat_id($tblname, $path);
	$Level = new Level();
	$Level = $Level->cat_Level($tblname, $requestid, 'khoa-hoc');
	?>
	<ul style="padding-bottom: 20px; border-top: none;">
	<?php
	}
	if (isset($_REQUEST['module']))
		{
		$show_another=false;
		if (isset($_REQUEST['artID'],$_REQUEST['pcatID']))
			{
			$artNum=12;
			// Get title
			$query1 ='select '.$tblname.'.*,'.$tblname.'_cat.level as category_level'; //,'.$tblname.'_cat.id as category_id';
			$query1.=' from '.$tblname.' inner join '.$tblname.'_cat';
			$query1.=' on '.$tblname.'.category='.$tblname.'_cat.id';
			$query1.=' where category = '.$_REQUEST['pcatID'].' and lang="'.get_langID().'"';
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
				global $url1;
				$id=$result['id'];
				$category=$result['category'];
				$title=stripslashes($result['title']);
				$image=$result['image'];
				$content=stripslashes($result['content']);
				$content=str_replace("=\"www.","=\"http://www.",$content);
				$datetime = $result['log'];
				$view  = $result['view'];
				$price=$result['price'];
							
				if ( $percent == "") $percent =0;
					$url1='/chi-tiet-gio-hang.html';
					
				?>
				<div style="float: left; font-weight:bold; margin: 15px; text-align: justify; font-size:12px; width: 700px; padding: 10px 20px;">
				<p style="float: left; padding: 10px 0; width: 500px; text-align: center; " ><a href="<?php echo $url; ?>" style="color: #000; font-weight: bold; text-transform: uppercase; "><?php echo $title; ?></a></p>
				<span style="float: left; width: 500px; text-align: center; "><img src="/<?php echo $image;?>" style="width: 250px; border: 1px #c3c3c3 solid; padding: 2px; margin-right: 20px;"/></span>
				
				<!--p style="padding-bottom: 10px;"><div id="muahang"><a onclick="ajaxfunction(<?php echo $id; ?>)" style="cursor:pointer;"><img src="/images/datmua5.jpg" width="75" height="23" border="0" /></a></div></p-->

				</div>
				<div style="float: left; border-bottom: 1px solid #ccc; width: 540px; font-size: 12px; padding-bottom: 20px; padding-left: 20px;"><p><b>Thông số kỹ thuật :</b></p> 
				<?php echo $content; ?>
				</div>
				
				<?php
				}
				//Another articles
				$show_another=true;
				$another_query ='select * from '.$tblname.' where';
				$another_query.=' id <> '.$_REQUEST['artID'].' and';
				$another_query.=' category="'.$_REQUEST['pcatID'].'"';
				$another_query.=' order by id ASC';
				$another_query.=' limit 0,'.($artNum+1).'';

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
                <div style="float: left; text-align: left; font-weight:bold; padding-left: 20px; font-size: 12px; padding-top: 10px; "><?php echo $display['other_products']; ?></div>                                                      
                <?php								
				//Another article
			if ($show_another==true)
				{
				$cont=false;
				//echo $another_query;
					?>
					<ul class='products' style="float: left; text-align: left; padding-left: 0px; margin-top:10px; clear:both; ">
					<?php
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
							$price=$result['price'];
							$price1=$result['price1'];
							if( $price1 == 0 )
							$price1 == $price ;
							$image=$result['image'];
							$category=$result['category'];
							$title=stripslashes($result['title']);
							$url='/chi-tiet-san-pham/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
							$style= "padding-left: 5px;";
							?>
							<li style="<?php if( $counter%3 == 1 ) echo $style; ?>; <?php if( $counter%3 == 0 ) echo 'padding-right: 5px;'; ?>; " >
								<div class="p" style="">
								<div class="list_review" style=" position: relative;" >
									<div class="fl width_3">
										<div class="block">
											<div class="picture_small">
											<div id="bodytext" class="details-content clearfix">
												<a class="tooltip" href="<?php echo $url; ?>" style=" color: #fff;"><img src="/<?php echo $image; ?>" width="140" height="175" style="border: none;" /></a>
											</div>
											</div>
										</div>
										<pre class="hidden">
											<div class="name"><?php echo $title; ?></div>
											<div class="content"><?php echo get(strip_tags($content),50); ?></div>
											<br />
											<div class="picture" src="/<?php echo $image; ?>" > <img src="/<?php echo $image; ?>" style="width: 300px; border-radius: 3px 3px 3p 3px; height: 300px; "/> </div>
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
							}
						}
					}
					?>
					</ul>
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
		</ul>
		<div class="bottom"></div>
</div>						