var allDialogs = [];
var seq = 0; 
function create(options) {
    options = $.extend({title: "Thông báo"}, options || {});
    var dialog = new Boxy("<div><p>Bạn vừa thêm một sản phẩm vào giỏ hàng </p><a class='gohome' href='javascript:void(0);' onclick='Boxy.get(this).hide();'>Tiếp tục mua hàng</a><a class='carticon' href='/chi-tiet-gio-hang.html'>Chi tiết giỏ hàng</a><a class='tt' href='/dat-hang.html'>Thanh toán</a></div>", options);
    allDialogs.push(dialog);
    return false;
}
function ajaxfunction(id)
{
    if(window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if(xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("gh_content").innerHTML=xmlhttp.responseText;
        create({modal : true});
        }
      }
    xmlhttp.open("GET","gio-hang.php?p="+id,true);
    xmlhttp.send();
}