<?php
/**
 * 
 * @author Hocvt
 * @date 6/3/2012
 * @description 
 * @require jquery
 * 
 * 
 * 
 * 
 * 
 * 
 */ 

//get this config
$getpopup = "select * from popup_conf where id = 1";
$getpopup = mysql_query($getpopup);
$popup_config = mysql_fetch_assoc($getpopup);
/*if(!isset($_SESSION['activepopup']))
{
	$popup_config['active'] = $popup_config['active'];
	$_SESSION['activepopup'] = false;
}
else {
	$popup_config['active'] = 0;
}
$popup_config['active'] = 1;*/
function show_popup()
{
    
    global $popup_config,$display;
    if($popup_config['active'] == 0)return;
    $url = "";
    if($popup_config['largeImage'] != "")
    {
        $url = "/".$popup_config['largeImage'];
    }
    else if($popup_config['linkUrl']!= "")
    {
        $url = $popup_config['linkUrl'];
    }
    if($popup_config['newtab'] == 1)
    {
        $is_blank = "target='_blank'";
    }
    else $is_blank = "";
    ?>
    
<style>
    #popup_adv
    {
		position: fixed;
		width: 100%;
		height : 100%;
		text-align: center;
		z-index: 99999 !important;
		
		top : 0;
		left : 0;
    }
	#popup_adv .overlay
	{
		background-color: #000000;
		height: 100%;
		opacity: 0.9;
		position: absolute;
		width: 100%;
		filter: alpha(opacity = 90);
		zoom : 1;
		top : 0;
		left : 0;
	}
	#popup_adv a
	{
		display: inline-block;
		position: relative;
	}
    #popup_close
    {
        display: block;
        height: 30px;
        line-height: 16px;
        position: absolute;
        right: -16px;
        top: -16px;
        width: 30px;
		background : url('/images/close.png') no-repeat scroll center center transparent ;
        text-align: center;
        color: #ef0000;
        font-weight: bold;
        cursor: pointer;
    }
</style>    
<script type="text/javascript">
	function getImgHeight(imgSrc)
	{
	var newImg = new Image();
	newImg.src = imgSrc;
	return newImg.height;
	}

    $(document).ready(function(){
        mypopup = "<div id='popup_adv' style='display:none' ><div class='overlay'></div>";
		mypopup += "<a href='<?=$url?>' <?=$is_blank?>><span title='Đóng' id='popup_close'></span><img src='<?=$siteUrl."/".$popup_config['image']?>' /></a>";
		mypopup += "</div>";
        function showPopup()
        {
			$mypopup = $(mypopup);
            $("body").append(mypopup);
			var aheight = $("#popup_adv a").height();
			var newImg1 = new Image();
			newImg1.src = $("#popup_adv a img").attr("src");
			newImg1.onload = function()
			{
			aheight = newImg1.height;
			var wheight = $(window).height();
			var atop = (wheight - aheight )/2;
			//alert(aheight);
			$("#popup_adv a").css({"top":atop});
			$("#popup_adv").fadeIn(1000);
			}
			//alert($("#popup_adv a").height());
			<?php if($popup_config['timeshow'] > 0){ ?> setTimeout('$("#popup_adv").fadeOut(1000)',<?=$popup_config['timeshow']?>*1000);<?php } ?>
			$("#popup_close").click(function(){
				$("#popup_adv").fadeOut(1000);
				return false;
			});
			$("#popup_adv a").click(function(){
				$("#popup_adv").fadeOut(1000);
			});
        }
		
        <?php if($popup_config['showafter'] > 0)
            { ?> 
            setTimeout(showPopup,<?=$popup_config['showafter']?>*1000); 
            <?php 
            } else echo "showPopup();";
            ?>
    });
</script>
    <?php    
}

?>