<?php 
	if (isset($_SESSION['username']))
		{
		?>
	<li>
        <a href="../index.php">
            <span><?php echo $strWebHome; ?></span>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <span>|</span>
        </a>
    </li>
    <li>
        <a href="<?php echo $phpself; ?>?module=cpanel">
            <span><?php echo $strControlPanel; ?></span>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <span>|</span>
        </a>
    </li>
    <li>
        <a href="<?php echo $phpself; ?>?module=user_profile">
            <span><?php echo $strPersonal; ?></span>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <span>|</span>
        </a>
    </li>
    <li>
        <a href="<?php echo $phpself; ?>?module=login&action=logout">
            <span><?php echo $strLogOut; ?></span>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <span>|</span>
        </a>
    </li>
    <li> <a target="_blank" href="http://bluesky.vn/support/open.php">
        <span><?=$strTickerRequest?></span>
    </a> </li><?php } ?>    
</ul>