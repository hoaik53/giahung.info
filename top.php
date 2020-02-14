<!-- menu-->
<div id="logo">		
	<?php
	$result = get_all("weblinks"," lang = '".get_langID()."' and advertising = 1 ","log desc",0,1);
	$image=$result[0]['image'];
	?>
	<img src="/<?php echo $image; ?>" alt="<?php echo $title; ?>"/>
	<h2 style="display: none;"><a href="http://giahung.info/">Bán nắp hố ga, tấm sàn grating, song chắc rác<a></h2>
</div>
	
        <div id="navigation">
			<ul id="nav">
          <li><a href="/"><?php echo $display['home'] ?></a></li>
<?php
				$query = sql_query('articles_cat', ' level like "__" and lang = "'.get_langID().'" ', ' level ASC ', 0, 4 );
				if ( $query !='' )
				{
					$i =0;
					foreach( $query as $next )
					{
						$i++;
						$name = stripslashes($next['name']);
						$id = $next['id'];
						$level = $next['level'];
						$url='/bai-viet/'.$id.'/'.removeSpecialChars(removesign($name)).'.html';
					?>
           <li><a href="<?php echo $url; ?>"><?php echo $name; ?></a>
           <?php
							$query1 = sql_query('articles_cat', '  level like "'.$level.'.%"  and lang = "'.get_langID().'" ', ' level ASC ', 0, 16 );
							
					if ( $query1 !='' )
							{
							
							?>
							<ul>
							<?php
											$kt=0;
											$count = count($query1);
											foreach( $query1 as $next1 )
											{ 
												$kt++;
												//echo "hoai";
												$name = stripslashes($next1['name']);
												$id1 = $next1['id'];
												$url1='/bai-viet/'.$id1.'/'.removeSpecialChars(removesign($name)).'.html';
												//echo $url1; 
											?>
							   <li  class="<?php if($kt==$count) echo "nav_bottom";?>"><a href="<?php echo $url1; ?>"><?php echo $name; ?></a> </li>
							 <?php
								}
							?> 
							</ul>
                <?php } ?>
			</li>	
			<?php

		}
	}
	?>
        <li><a href="/lien-he.html"><?php echo $display['contact'];?></a></li>
        </ul>
        </div>
<?php 
	if( !$_REQUEST['module'])
	{
	?>

<div style="float: left; margin-top: 3px; border: 1px solid #EBEBEB; background-color: #fff; width: 990px; height: 300px; padding: 4px;">
		<link rel="stylesheet" href="css/vslider.css" />
		<script type="text/javascript" src="javascripts/jquery.js" ></script>
		<script type="text/javascript" src="javascripts/jquery.vslider.js" ></script>
		<script type="text/javascript">
		$(function(){
			$("#test").vSlider();
			});
		</script>
		<div style ="float: left;">
				<?php 
				$tblname='weblinks';
				$slide='select * from '.$tblname.' where ';
				$slide.=' lang='.get_langID().' and active=1 and advertising = 4';
				$slide.=' ORDER BY log DESC';
				$doslide=mysql_query($slide);
				if ($doslide and mysql_num_rows($doslide)>0)
				{
				$i = 0;
					echo '<ul id="test">';
					while ($result=mysql_fetch_array($doslide))
					{
					$i++;
					$id=$result['id'];
					$category=$result['category'];
					$title=stripslashes($result['title']);
					$image=$result['image'];
					$url=$result['org_web'];
					?>
					
						<li>
							<a href="<?php echo $url; ?>"><img style=" float: left;display: block; width: 990px; height: 300px;" src="/<?php echo $image; ?>" alt="<?php echo $title; ?>" width='980' border="0" /></a>
						</li>
					
					<?php	
					}
					echo "</ul>";
				}
				?>				
		</div>
			
	</div>
	<?php }?>