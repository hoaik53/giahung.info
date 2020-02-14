<?php
include ('function.php');
$phpself=$_SERVER['PHP_SELF'];
$phpself='';
//-----------                 MAIN ACTION                       -----------
	if (isset($_REQUEST['module']))
		{
		$module=$_REQUEST['module'];
		switch ($module)
			{
			 case 'cart_detail';
             $phpinclude='cart_detail.php';
			 $pagetitle = $display['detailcart'];
             break; 
			 
			 case 'cart_del';
             $phpinclude='cart_del.php';
             break;
			
			case 'bp':
			$phpinclude='bp.php';
			$pagetitle = $display['products'];
			if (isset($_GET['pcatID']))
			{
				$artID = (int)($_GET['pcatID']);
				$sql = "SELECT * FROM products_cat WHERE id=".$_GET['pcatID']." and lang=".get_langID()."";
				$result = mysql_query($sql, $link);
				$row = mysql_fetch_assoc($result);
				if($row['title'] != "") $pagetitle = stripslashes($row['title']);
				else $pagetitle = stripslashes($row['name']);
				if($row['description'] != "") $pagedescription = stripslashes($row['description']);
				else $pagedescription = $pagetitle;
				if($row['keyword'] != "") $pagekeyword = stripslashes($row['keyword']);
				else $pagekeyword = $pagetitle;
				
			}
			$jsinclude=array('scripts.js','last_visit.js','dhtmllib.js','scroller.js');
			if ($fo=fopen($jscript_dir.'show.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			case 'dp':
			$phpinclude='dp.php';
			if (isset($_GET['artID']))
			{
				$artID = (int)($_GET['artID']);
				$sql = "SELECT * FROM products WHERE id=".$_GET['artID']." and lang=".get_langID()."";
				$result = mysql_query($sql, $link);
				$row = mysql_fetch_assoc($result);
				$pagetitle = stripslashes($row['title']);
			}	
			$jsinclude=array('xc2_default.js','scripts.js','xc2_inpage.js',
				'last_visit.js','dhtmllib.js','scroller.js');
			if ($fo=fopen($jscript_dir.'show.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			case 'ba':
			$phpinclude='ba.php';
			$pagetitle = $display['news'];
			if (isset($_GET['acatID']))
			{
				$ncatID = (int)($_GET['acatID']);
				$sql = "SELECT * FROM articles_cat WHERE id=".$_GET['acatID']." and lang=".get_langID()."";
				$result = mysql_query($sql, $link);
				$row = mysql_fetch_assoc($result);
				if($row['title'] != "") $pagetitle = stripslashes($row['title']);
				else $pagetitle = stripslashes($row['name']);
				if($row['description'] != "") $pagedescription = stripslashes($row['description']);
				else $pagedescription = $pagetitle;
				if($row['keyword'] != "") $pagekeyword = stripslashes($row['keyword']);
				else $pagekeyword = $pagetitle;
			}
			$jsinclude=array('scripts.js','last_visit.js','dhtmllib.js','scroller.js');
			if ($fo=fopen($jscript_dir.'show.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			case 'da':
			$phpinclude='da.php';
			if (isset($_GET['artID']))
			{
				$artID = (int)($_GET['artID']);
				$sql = "SELECT * FROM articles WHERE id=".$_GET['artID']." and lang=".get_langID()."";
				$result = mysql_query($sql, $link);
				$row = mysql_fetch_assoc($result);
				$pagetitle = stripslashes($row['title']);
			}		
			$jsinclude=array('xc2_default.js','scripts.js','xc2_inpage.js',
				'last_visit.js','dhtmllib.js','scroller.js');
			if ($fo=fopen($jscript_dir.'show.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			case 'searchresults':
			$phpinclude='searchresults.php';
			$pagetitle = $display['search'];
			$jsinclude=array('xc2_default.js','xc2_inpage.js','scripts.js',
				'last_visit.js','dhtmllib.js','scroller.js','slideshow.js');
			if ($fo=fopen($jscript_dir.'checkregister.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
				
			case 'contact':
			$phpinclude='contact.php';
			$pagetitle = $display['contactdetail'];
			$jsinclude=array('xc2_default.js','xc2_inpage.js','scripts.js',
				'last_visit.js','dhtmllib.js','scroller.js','slideshow.js');
			if ($fo=fopen($jscript_dir.'checkregister.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			case 'order':
			$phpinclude='order.php';
			$pagetitle = $display['cart'];
			$jsinclude=array('xc2_default.js','xc2_inpage.js','scripts.js',
				'last_visit.js','dhtmllib.js','scroller.js','slideshow.js');
			if ($fo=fopen($jscript_dir.'checkregister.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			case 'process':
			$phpinclude='process.php';
			$pagetitle = $display['contact'];
			$jsinclude=array('xc2_default.js','xc2_inpage.js','scripts.js',
				'last_visit.js','dhtmllib.js','scroller.js','slideshow.js');
			if ($fo=fopen($jscript_dir.'checkregister.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			
			default:
			//count
			docounter();
			$phpinclude='main.php';
			//echo $phpinclude;
			$jsinclude=array('last_visit.js','scripts.js','dhtmllib.js','scroller.js','dw_scroller.js','mootools.release.83.js','timed.slideshow.js');
			if ($fo=fopen($jscript_dir.'color.js','r'))
			{
			$script="<script>\n";
			while ($cur_line=fgets($fo))
				{
				$script.=$cur_line;
				}
			}
			$script.="</script>\n";
			$head_info=$script;
			break;
			}
		}
	else
		{
		docounter();
		$phpinclude='main.php';
		//echo $phpinclude;
		$jsinclude=array('last_visit.js','dhtmllib.js','scripts.js','scroller.js','dw_scroller.js','xc2_default.js','xc2_inpage.js');
		}
	$thisstat='block';
	if (isset($_REQUEST['action']))
		{
		$action=$_REQUEST['action'];
		switch ($action)
			{
			case 'print':
			$thisstat='none';
			break;
			}
		}
//-----------             END OF MAIN ACTION                       ----------
//-----------                PAGE OUT PUT                       -------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<h1><title>
	<?php
	if(isset($_GET['module']))
		echo $pagetitle;
	else
		echo $siteName;
	
	?>
</title></h1>
<?php
	if(isset($_GET['module']) && isset($pagekeyword))
		{
		echo '<meta name="keywords" content="'.$pagekeyword.'"/>';
		}
	else if(isset($_GET['module']) && !isset($pagekeyword))
		echo '<meta name="keywords" content="'.$pagetitle.'"/>';
	else
		{
		echo '<meta name="keywords" content="'.$sitekeywords.'"/>';
		}
	?>
	<?php
	if(isset($_GET['module']))
		echo '<meta name="description" content="'.$pagedescription.'"/>';
	else
		echo '<meta name="description" content="Ban nap ho ga, ban tam san grating, nắp h�?ga, tấm sàn grating, tam san grating, bán nắp h�?ga, bán tấm sàn grating chất lượng cao, giá r�?nhất th�?trường"/>';
	?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
<meta content="INDEX,FOLLOW" name="robots" />
<link rel="Shortcut Icon" href="/<?php echo $webicon; ?>" type="image/x-icon" /> 
<link href="/css/style.css" type="text/css" rel="stylesheet" />
<link href="/css/menu.css" type="text/css" rel="stylesheet" />
<link href="/css/lightbox.css" type="text/css" rel="stylesheet" />
<link href="/css/css_002.css" type="text/css" rel="stylesheet" />
<link rel="author" href="https://plus.google.com/+GiahungInfobannaphoga/posts"/>
<script type="text/javascript" src="/javascripts/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/javascripts/jquery_002.js"></script>
<script src="/javascripts/jquery.lightbox.js" type="text/javascript"></script>
<script src="/javascripts/contentslider.js" type="text/javascript"></script>
<script src="/javascripts/image-slideshow.js" type="text/javascript"></script>

<script src="/javascripts/main.js" type="text/javascript"></script>
<script src="/javascripts/new.js" type="text/javascript"></script>
<script src="/javascripts/menu.js" type="text/javascript"></script>
<script src="/javascripts/site.js" type="text/javascript"></script>
<script src="/javascripts/ajax_cart.js" type="text/javascript"></script>
<script src="/javascripts/jquery.boxy.js" type="text/javascript"></script>


<script type="text/javascript" src="/javascripts/functions_main.js"></script>
<script type="text/javascript" src="/javascripts/functions_v2.js"></script>
<script type="text/javascript" src="/javascripts/jquery.tooltip.js"></script>
<script src="/javascripts/common_imgboxhover-v3.3.js" type="text/javascript"></script>
</head>
<script type="text/javascript"> 
	$(function(){
		$('#r_tin_content').vTicker({ 
			speed: 1000,
			pause: 7000,
			animation: 'fade',
			mousePause: false,
			showItems: 4
		});
	});
	
	$(function(){
		$('#r_tin_content1').vTicker({ 
			speed: 1000,
			pause: 4000,
			animation: 'fade',
			mousePause: false,
			showItems: 2
		});
	});  
	
	</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43262424-2', 'giahung.info');
  ga('send', 'pageview');

</script>
	
<body>
	<div id="body">
		<div id="wearp">
			<div id="top">
<!--/* OpenX iFrame Tag v2.8.10 (Rich Media - OpenX) */-->

<!--/*
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://giahung.info/openx-2.8.10/www/delivery/...'
  * to
  *   'https://giahung.info/openx-2.8.10/www/delivery/...'
  *
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://giahung.info/openx-2.8.10/www/delivery/...'
  * to
  *   'https://giahung.info/openx-2.8.10/www/delivery/...'
  *
  * If iFrames are not supported by the viewer's browser, then this
  * tag only shows image banners. There is no width or height in these
  * banners, so if you want these tags to allocate space for the ad
  * before it shows, you will need to add this information to the <img>
  * tag.
  */-->
				<?php include ('top.php'); ?>
			</div>	
			<div id="main">
				<div id="left">
					<?php include ('left.php') ?>
				</div>
				<?php
				if (isset($phpinclude))
				{ ?>
				<div id="content">
				<?php
				require ($module_dir.$phpinclude); 
				}
				?>
				</div>
				<div id="right">
						<?php include ('right.php') ?>
				</div>
			</div>
			<div id="footer">
			<?php include ('bottom.php') ;?>
			</div>
		</div>	
	</div>	
	
	

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/876448237/?guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>