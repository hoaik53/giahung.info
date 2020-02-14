<?php session_start(); if (substr_count($_SERVER['PHP_SELF'],'/searchresults.php')>0) die ("You can't access this file directly..."); ?>
<?php
if(isset($_REQUEST['product']) )
{
	$requestname = $_REQUEST['product'];
	$_SESSION['requestname'] = $requestname;
}
else {
	$requestname = $_SESSION['requestname'];
}
//echo $_SESSION['requestname'];

?>							
<div class="main">
	<div class="head"><h2><?php echo $display['home']; ?><?php echo ' &raquo; '.$display['searchresult']; ?></h2></div>
	<ul>
		<?php
		$itemonrow=1;
		$rows=21;
		$curpage=1;
			$tblname='products';
			$query ='select * from '.$tblname.' where';
			$query.='  lang="'.get_langID().'"';
			$query.=' and '.$tblname.'.active=1 and (title like "%'.$requestname.'%" or content like "%'.$requestname.'%")';
			$query.=' or category="'.$_REQUEST['category'].'"';
			$query.=' order by log DESC';
			//echo $query;
			if (isset($_REQUEST['curpage'],$_REQUEST['totalpage'],$_REQUEST['found']))
				{
				$found=$_REQUEST['found'];
				$totalpage=$_REQUEST['totalpage'];
				$curpage=$_REQUEST['curpage'];
				$from=($curpage-1) * $itemonrow * $rows;
				$to=$from + $itemonrow*$rows;
				$limit=' limit '.$from.','.$to;
				}
			if (isset($limit,$query))
				$query.=$limit;
			$doquery=mysql_query($query,$link);

			if ($doquery and mysql_num_rows($doquery)>=1)
				{
				if (!isset($found))
					$found=mysql_num_rows($doquery);
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
			   $count = mysql_num_rows($doquery);
			   $du = $count % 3;
						if( $du == 0) $du =3;
				while ($result=mysql_fetch_array($doquery) and $i<=($itemonrow*$rows))
					{
						$id=$result['id'];
						$category=$result['category'];
						$title=stripslashes($result['title']);
						$image=$result['image'];
						$icon=$result['icon'];
						$price=$result['price'];
						$brief = $result['brief'];
						$content = $result['content'];
						$url='/chi-tiet-san-pham/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
						$style= "padding-left: 0px;";	
						//Show item
						$i++;
						?>
					<li style="<?php if( $i%3 == 1 ) echo $style; ?>; " >
						<div class="p" style="<?php if( $i%3 == 0 || $count==$i ) echo "border-right: none;"; if($i > ($count - $du )) echo "border-bottom: none;" ;   ?> ">
						<div class="list_review" style=" position: relative;" >
						<?php if( $icon != '' ) { ?>
						<div style=" position: absolute; top: -8px; right: -5px; z-index: 99;"><img src="/upimages/products/new.png" width="58" height="58" style="border: none;" /></div>
						<?php } ?>
							<div class="fl width_3">
								<div class="block">
									<div class="picture_small">
									<div id="bodytext" class="details-content clearfix">
										<div class="city"  style="height: 160px; ">
										<a class="tooltip" href="<?php echo $url; ?>" style=" color: #fff;"><img src="/<?php echo $image; ?>" width="160" height="150" style="border: none; margin-top: 8px;" /></a>
										</div>
									</div>
									</div>
								</div>
								<pre class="hidden">
									<div class="name"><?php echo $title; ?></div>
									<div class="name" style='color: #232323;'><?php echo $display['price'].' <b style="color: red">'.bsVndDot($price).' VNĐ</b>'; ?></div>
									<div class="content"><?php echo get(strip_tags($content),50); ?></div>
									<br />
									<div class="picture" src="/<?php echo $image; ?>" > <img src="/<?php echo $image; ?>" style="width: 300px; border-radius: 3px 3px 3p 3px; height: 300px; "/> </div>
									<div></div>
								</pre>
							</div>
						</div>	
						<script type="text/javascript">$(function(){ tooltipReview(); });</script>
							
							<div class="title" style="padding: 5px 5px 5px 5px;"><a href="<?=$url?>"><?=$title?></a></div>
							
							<div id="btn">
								<div id="muahang"><a onclick="ajaxfunction(<?php echo $id; ?>)" style="cursor:pointer;"><img src="/images/datmua5.jpg" width="75" height="23" border="0" /></a></div>
								<div class="price"><?=bsVndDot($price)?> VNĐ</div>
							</div>
						</div>
					</li>
						<?php
						
						if ($i==$rows*$itemonrow)
							break;
					}
					?>
				<div id="pt">
				<div id="pt1">
					<?php
					if (isset($totalpage))
						{
							echo '<p style="font-weight: bold; text-align: right; ">';
							$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/1.html';
							
							if ($curpage>1)   
								{echo '<a href="'.$page_url.'" >'.$display['the_first'].'</a>';
							
								if($curpage!=1)//echo back button
								 {
									$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/'.($curpage-1).'.html';
									echo '<a href="'.$page_url.'"><</a>  ';
								 }
								else {
									$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/'.($curpage-1).'.html';
									echo '<a href="'.$page_url.'" ><</a>  ';
								 }}
							if($curpage>3) echo " ...";
							
							 for($i=$curpage-2;$i<=$curpage+2 && $i<=$totalpage;$i++)
							 {
								if($i>0)
								{
									$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/'.$i.'.html';
								if ($i<10)
									$i='0'.$i;
								if ($i!=$curpage)
									{
									echo '<a href="'.$page_url.'" >'.$i.'</a>';
									}
								else
								{
									?>
									<a href="<?=$page_url?>" style="<?php if( $curpage == $i ) echo "color: red;"; ?>" ><?=$i?></a>
									<?php
								}	
								}
							 }
							 if($curpage<$totalpage-2)echo "...";
							 if($curpage<$totalpage)
								 {   
									if($curpage<$totalpage) //echo next button
									 {
										$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/'.($curpage+1).'.html';
										echo '<a href="'.$page_url.'" >></a>';
									 }
									else {
										$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/'.($curpage+1).'.html';
										echo '<a href="'.$page_url.'" >></a>';
									 }
								 }
							 //echo last  
								$page_url='/ket-qua-tim-kiem/'.$found.'/'.$totalpage.'/'.$totalpage.'.html';
							   if($curpage<$totalpage) echo '<a href="'.$page_url.'" >'.$display['the_last'].'</a>';
							 echo '</p>';
						}	
					?>
				</div>
				</div>
				<?php
				}
				else echo "Không tìm thấy sản phẩm nào ";
				?>	
	</ul>
		<div class="bottom"></div>
</div>