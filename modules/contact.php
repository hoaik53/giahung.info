<?php if (substr_count($_SERVER['PHP_SELF'],'/contact.php')>0) die ("You can't access this file directly..."); ?>
<div class="main">
				<script>
                    function checkcontact()
                        {
                        str = document.check.phone.value;
                        if (document.check.fullname.value=='')
                            {
                            alert('<?php echo $display['namecheck']; ?>');
                            document.check.fullname.focus();
                            return false;
                            }
                        if (document.check.address.value=='')
                            {
                            alert('<?php echo $display['addcheck']; ?>');
                            document.check.address.focus();
                            return false;
                            }
                        if (str=='')
                            {
                            alert('<?php echo $display['phonecheck']; ?>');
                            document.check.phone.focus();
                            return false;
                            }
                        if (isNaN(str))
                            {
                            alert('<?php echo $display['fnumbercheck']; ?>');
                            document.check.phone.focus();
                            return false;
                            }
                        if (document.check.email.value=='')
                            {
                            alert('<?php echo $display['emailcheck']; ?>');
                            document.check.email.focus();
                            return false;
                            }
                        if (document.check.contactwith.value=='')
                            {
                            alert('<?php echo $display['contactwithcheck']; ?>');
                            document.check.contactwith.focus();
                            return false;
                            }	
                        if (document.check.content.value=='')
                            {
                            alert('<?php echo $display['contentcheck']; ?>');
                            document.check.content.focus();
                            return false;
                            }
                        if (document.check.security_code.value=='')
                            {
                            alert('<?php echo $display['introimage']; ?>');
                            document.check.security_code.focus();
                            return false;
                            }
                        mail = /^[a-z][a-z0-9_\.]*\@[a-z-]*\.[a-z]*[a-z0-9_\.]*/g;
                        if(mail.test(document.check.email.value)==false)
                            {
                            alert('<?php echo $display['emailcheckerror']; ?>');
                            document.check.email.focus();
                            flag=false;
                            return false;
                            }
                        }
                </script>
				
				
				<div class = "head"><h2><?php echo $display['home'].' &raquo; '.$display['contact']; ?></h2></div>
				<ul style="border: 1px solid #<?php echo $background_colorbg;?>; border-top: none; ">
				<div style="padding: 5px 0 10px 30px; line-height: 160%; "><?php echo $display['contactinfo']; ?></div>
				<form name="check" method="post" action="/thong-tin-lien-he.html" onSubmit="return checkcontact();" style="700px;">
					<div id="content_project">
                        <div style="float: left; width: 500px;  padding-left: 30px;">
                        <div style="float: left; width: 500px; padding-top: 10px;">
                        
                        <div style=" clear:both;  float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['fullname']?> : </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="fullname" type="text"></div>
                        
                        <div style="clear:both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['address']?>  </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="address" type="text"></div>
        
                        <div style="clear:both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['phone']?>  </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="phone" type="text"></div>
        
                        <div style="clear:both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['email']?> : </div>
                        <div style="text-align: left; padding-top: 8px;"><input maxLength="100" size="36" name="email" type="text"></div>
                        
                        <div style="clear:both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['content']; ?> : </div>
                        <div style="text-align: left; padding-top: 8px;"><TEXTAREA name="content" rows="6" cols="38"></TEXTAREA></div>
                        
                        <div style="clear:both; float: left; padding-right: 10px; padding-top: 10px; width: 100px; text-align: right;"><?php echo $display['secode']; ?> : </div>
                        <div style="float: left; text-align: left; padding-top: 8px; padding-right: 10px;"><input maxLength="5" size="5" name="security_code" type="text"></div>
                        <div style="text-align: left; padding-top: 8px;" id="bs-captcha">
                            <a onclick="reload(); return false;" href="#"><img src="/CaptchaSecurityImages.php?width=100&height=40&characters=5" alt="Click Refesh Image" title="Click Refesh Image" border="0"/></a>
                            <script language='JavaScript' type="text/javascript">
                            function reload () {
                                var rndval = new Date().getTime(); 
                                document.getElementById('bs-captcha').innerHTML = '<a onclick="reload(); return false;" href="#"><img src="/CaptchaSecurityImages.php?rndval=' + rndval + '" border="0" width="100" height="40" alt="Click Refesh Image" title="Click Refesh Image" /></a>';
                            };
                            </script>
                        </div>
                        
                        <div id="contact" style="float: left; padding-left: 10px; padding-top: 10px; padding-bottom: 20px; width: 500px; margin-left:200px;">
                        <input name="Submit" type="submit" value=" <?php echo $display['send']; ?> " class="input" />
                        &nbsp;<input name="Submit" type="reset" value=" <?php echo $display['reset']; ?> " class="input" />
                        </div>
                    
                        </div>
                        </div>
					</div>
                </form>
  </ul>
  <div class="bottom"></div>
</div>