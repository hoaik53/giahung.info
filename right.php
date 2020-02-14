
	<div class="menu_left"> 
    	<div class="header_bar">
        	<h2><?php echo $display['product_hot']; ?></h2>
        </div><!--End header_bar-->
		<div class="body_block_bar">
			<div style="float: left; width: 180px;text-align:center; padding-top: 10px;padding-left: 9px;" >

				<div id="r_tin_content" style="float: left; width: 180px; " >

					<ul class="main" style=' border: none;  padding: 0; '>

					<?php
							$query = sql_query("products", " active = 1 ", " log DESC ", 0, 10 );

							if(  $query !='')

							{

								foreach( $query as $next ) 

								{
									$title = stripslashes($next['title']);
									$image = stripslashes($next['image']);
									$id	=  $next['id'];
									$name = 'san-pham';
									$category= $next['category'];
									$url='/chi-tiet-san-pham/'.$category.'/'.$id.'/'.removeSpecialChars(removesign($title)).'.html';
									?>
										<li style='width: 180px; border: none; height: 150px; padding: 0;'>
											<a href="<?php echo $url; ?>"  ><img src="/<?php echo $image; ?>"  alt="<?php echo $title ?>" style='width: 180px; height: 110px;' />
											</a>
											<a class="title" style=" display: block; padding: 5px 0px;"   href="<?php echo $url; ?>"> <?php echo $title; ?> </a>
										</li>
								  <?php  

								 } 

							}

					?>
				   </ul>
			</div>
		</div>
	</div>
</div><!--End body_block-->

	<div class="menu_left">
		<script language="javascript" src="http://www.vnexpress.net/Service/Forex_Content.js"></script>
		<div class = "header_bar"><h2 style = "background: url(../images/icon5.png) no-repeat scroll 8px 10px;" ><?php echo $display['dollar']; ?></h2></div>
			<table cellpadding="0" width="100%" cellspacing="0" class="tygia" border="0">
				<Script language="JavaScript" src="http://vnexpress.net/Service/Forex_Content.js"></Script>
				<Script language="JavaScript" >
					for(var i=0;i<12;i++){
						if(typeof(vForexs[i]) !='undefined' && typeof(vCosts[i]) !='undefined' && vForexs[i] =='USD' || vForexs[i] =='EUR' || vForexs[i] =='SGD' || vForexs[i] =='JPY')
						{
							document.writeln('<tr><td style="padding-top:5px; padding-left:10px; font-size : 12px;" align="center">', vForexs[i], '</td><td style="padding-top:5px; padding-right:10px; font-size : 12px;" align="center">', vCosts[i], '</td></tr>');
							document.writeln('<tr><td colspan="2" align="center"><span style="font-size : 12px;">.........................................</span></td></tr>');
						}
					}
				</Script>
				</table>
		<div class="bottom" ></div>
	</div>