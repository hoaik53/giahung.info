<div class="menu_left">
			<div class="header_bar">
				<h3><?php echo $display['catproduct'] ?></h3>
			 </div><!--End header_bar-->
			 <div class="body_block_bar">
					<?php
					$tblname='products';
					
					if ( $phpinclude == 'bp.php' )
					$requestid = intval($_REQUEST['pcatID']);
					else
					$requestid = intval($_REQUEST['artID']);
					$query ='select * from '.$tblname.'_cat where id='.$requestid.' and lang='.get_langID().'';
					$doquery=mysql_query($query,$link);
					$result = mysql_fetch_array($doquery);
					$level = $result['level'];
					$level1 = substr($level, 0, 2);
					$query = 'select * from products_cat where level = "'.$level1.'" and lang='.get_langID().'';
					$doquery = mysql_query($query,$link);
					$result = mysql_fetch_array($doquery);
					$requestid1 = $result['id'];
					$query2 ='select * from products_cat where level like "__" and lang='.get_langID().' order by level ASC';
					$doquery2 =mysql_query($query2,$link);
					if ($doquery2 and mysql_num_rows($doquery2)>0)
					{
						 ?>
						<ul  id="menu_bar" >
						<?php
						$k=0;
						$count1 = mysql_num_rows($doquery2);
						while ($result2=mysql_fetch_array($doquery2))
						{
							$k++;
							$lv=$result2['level'];
							$level=strlen($lv);
							$id=$result2['id'];
							$name=$result2['name'];
							$url='/danh-muc-san-pham/'.$id.'/'.removeSpecialChars(removesign($name)).'.html';

							?>  
							<li class="l1 <?php if( $k == $count1) echo "l1_bottom"; ?>" ><h2><a href="<?php echo $url; ?>" class ="a1 <?php if( $id == $requestid1 ) echo 'active'; ?>"  ><span class= "l1_a" ><?php echo $name; ?></span></a></h2>
								<?php
								$query ='select * from products_cat where level like "'.$lv.'.%" and lang='.get_langID().' order by level ASC';
								$doquery =mysql_query($query,$link);
								if ($doquery and mysql_num_rows($doquery)>0)
								{
									
								?>
									<ul style=" border: none; padding: 0px 0px 10px 0px;"  <?php if( $level1 == $lv ) echo "class='active' "; ?>>
									<?php
										$kt=0;
										$count = mysql_num_rows($doquery);
									while ($result=mysql_fetch_array($doquery))
									{
									$kt++;
									$lv1=$result['level'];
									$level=strlen($lv1); 
									$id=$result['id'];
									$name=$result['name'];
									$url='/danh-muc-san-pham/'.$id.'/'.removeSpecialChars(removesign($name)).'.html';
									?>
										<li class="l2 <?php  if( $kt == $count) echo "l2_bottom"; ?>" ><h3><a class="a2 <?php if( $id == $requestid) echo "active2"; ?>" href="<?php echo $url; ?>"><span class= "li_a2" ><?php echo $name; ?></span></a></h3></li>
									<?php
									} ?>
									</ul>
								<?php	
								}
								?>
							</li>
							<?php	
						} ?>
						</ul>
					<?php		
					}  ?>
			
			 </div>

    </div><!--End block_bar-->
	<div class="menu_left">
		<div class = "header_bar"><h3 ><?php echo $display['detailcart']; ?></h3></div>
		<ul>
			<div id="gh_content" style="color: <?php echo "#252525"; ?>; padding: 5px 5px 10px;">
			<span class="count" style="padding-left: 23px;"><?php echo $display['found']." : <font color='#ff0000' >".total(1).'&nbsp;'.$display['products'].'</font>';?></span>
			<a href="/chi-tiet-gio-hang.html"><span class="cart" style="padding-left: 53px;"><?PHP echo $display['detailcart'];  ?></span></a>
			<a href="<?php echo '/dat-hang.html'; ?>"><span class="buy" style="padding-left: 55px;"><?PHP echo $display['buy'];  ?></span></a>
			</div>
		</ul>
		<div class="bottom" ></div>
	</div>
	<div class="menu_left">
		<div class = "header_bar"><h2 style = "background: url(../images/icon2.png) no-repeat scroll 8px 10px;" ><?php echo $display['onlinesupport']; ?></h2></div>
		<ul>
		<?php
		$tblname='support_online';
		$intro=' select * from '.$tblname.' where lang='.get_langID().' and active=1 LIMIT 0,6';
		$dointro=mysql_query($intro);
		while($result=mysql_fetch_array($dointro))
		{
		$id=$result['id'];
		$phone=$result['support_phone'];
		$name=$result['support_name'];
		$nick=$result['nick_name'];8
		?>
		<li style="width: 204px; text-align: center; padding-bottom: 8px; padding-top: 8px; " >
		<?php echo "<a href='ymsgr:sendim?$nick' style='background-image: none;'><img border='0' src='http://opi.yahoo.com/online?u=$nick&amp;m=g&amp;t=2&amp;l=us' width='115' height='22' /></a>"; ?>
		<br/><p style="padding-top: 3px;"><b><?php echo $name; ?>: <?php echo $phone; ?></b></p>
		</li>
		<?php
		}
		?>
		</ul>
	</div>
	
		
	<div class="menu_left">
		<div class = "header_bar"><h3 style = "background: url(../images/icon1.png) no-repeat scroll 8px 10px;" ><?php echo $display['advertisement']; ?></h3></div>
		<ul>
			<?php 
			$tblname='weblinks';
			$intro='select * from '.$tblname.' where ';
			$intro.=' lang='.get_langID().' and active=1 and advertising = 2 ';
			$intro.='ORDER BY `weblinks`.`log` DESC LIMIT 0 , 10';
			$dointro=mysql_query($intro);
			if ($dointro and mysql_num_rows($dointro)>0)
				{
				while ($result1=mysql_fetch_array($dointro))
					{
					$i++;
					$image=$result1['image'];
					$url=$result1['org_web'];
					?>
					<li style="text-align: center;"><a href="<?php echo $url; ?>" target="_blank"><img src="/<?php echo $image;  ?>" width="180" style="margin-top: 5px; border: 1px #CCC solid; " /></a></li>
					<?php
					}
				}
			?>
		</ul>
	</div>
	
	<div class="menu_left">
		<div class = "header_bar"><h3><?php echo $display['searchproduct']; ?></h3></div>
		<ul>
			<form name="search" method="post" action="/ket-qua-tim-kiem.html" onSubmit="return checkcontact();" >
			<li style="padding: 3px; padding-left: 14px; width: 190px;"><input type="text" name="product" value=""  placeholder="Từ khóa tìm kiếm..." style='width: 166px;' /></li>
			<li style="padding: 3px; padding-left: 14px; width: 190px;">
				<select name="category" id="name" style="width: 170px; padding: 3px;">
				<option value=""> <?php echo $display['select_product']; ?></option>
				<?php
					$tblname='products';
					$query ='select * from '.$tblname.'_cat where lang='.get_langID().' order by level ASC';
					$doquery =mysql_query($query,$link);
					if ($doquery and mysql_num_rows($doquery)>0)
						{
						$i=0;
						while ($result=mysql_fetch_array($doquery))
							{
							$lv=$result['level'];
							$level=strlen($lv)/2;
							$id=$result['id'];
							$name=$result['name'];
							if($level == 1)
								{
								$i++;
								?>
								<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
								 <?php
									$tblname1='products';
									$query1 ='select * from '.$tblname1.'_cat where level like "0'.$i.'.%" and lang='.get_langID().' order by level ASC';
									//echo $query;
									$doquery1 =mysql_query($query1,$link);
									if ($doquery1 and mysql_num_rows($doquery1)>0)
										{ 
										$k=0;
										while ($result1=mysql_fetch_array($doquery1))
											{
											$lv=$result1['level'];
											$level=strlen($lv)/2;
											$id=$result1['id'];
											$name=$result1['name'];
											$url='/tin-tuc/'.$id.'/'.removeSpecialChars(removesign($name)).'.html';
											if($level>1)
												{
												?>
												<option name="category" id="name" value="<?php echo $id; ?>"> &nbsp &nbsp &raquo; <?php echo $name; ?> </option>
												<?php
												}
											}									
										}
								}
							}
						}	
						?>
				</select>
			</li>
		<li style="padding: 6px; padding-left: 20px;"><input style ="border:1px solid #ccc; height: 20px; font-size: 11px; font-weight: bold; padding: 2px 0; width: 80px; cursor: pointer; " name="Submit" type="submit" value=" <?php echo $display['search']; ?> " class="input" /></li>
		</form>
		</ul>
	</div>
	
	<div class="menu_left" >
		<div class = "header_bar"><h3>Thống kê truy cập</h3></div>
		<ul class='main' >
			<li style="text-align: left; background: url(/images/online.png) no-repeat 5px 3px;  padding-left: 15px; width: 160px; line-height: 20px;"><b><?php echo $display['online']; ?> :<font class="content_bt" color="#535352"> <?php echo getOnlineUsers(); ?></font></b></li>	
			<li style="text-align: left; background: url(/images/online1.png) no-repeat 5px 3px;  padding-left: 15px; width: 160px; line-height: 20px; "><b><?php echo $display['visitor']; ?> :<font class="content_bt"> <?php echo bsVndDot(showcounter()); ?></font></b></li>	
		</ul>
	</div>	