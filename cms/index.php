<?php
session_start();
session_destroy();
?>
<!DOCTYPE HTML>
<html hreflang="id">
<head>
<meta charset="UTF-8">
<meta name="google-site-verification" content="e4QWuVl6rDrDmYm3G1gQQf6Mv2wBpXjs6IV0kMv4_cM" />
<title>CMS BKPSDMD</title>
<link rel="shortcut icon" href="images/button/logo2.png">
<link href="index.css" rel="stylesheet" type="text/css">
</head>
<body>
	<!--<img class="mySlides" src="images/index_pict/1.jpg" style="width:100%">
	<img class="mySlides" src="images/index_pict/2.jpg" style="width:100%">
	<img class="mySlides" src="images/index_pict/3.jpg" style="width:100%">
	<img class="mySlides" src="images/index_pict/4.jpg" style="width:100%">
	<img class="mySlides" src="images/index_pict/5.jpg" style="width:100%">-->
	<section class="wrapper">
        <header>
            <logo>
            	<a href="../index.html"><img src="../icon/BKPLogo3.png" width="180" id="bkpsdmdLogo" alt="Logo BKPSDMD"></a>	
            </logo>
            <div class="navbar">
            	<!--<a href="products/product.php"><img src="images/button/product.png" height="25"/>Product</a>
                <a href="tutorials/tutorial.php"><img src="images/button/tutorial.png" height="25"/>Tutorials</a>-->
                <span>
            	<a href="login.php"><img src="images/button/masuk.png" height="25"/>Masuk</a>
                <a href="daftar.php"><img src="images/button/daftar.png" height="25"/>Daftar</a>
                </span>
            </div>
        </header>
        
        <main>
        	<center><table>
            	<tr>
                	<th>THAT HORIZON MIGHT BE CLOSER THAN YOU THINK!</th>
                </tr>
                <tr>
                    <td>Just control your work from anywhere in the world.</td>
                </tr>
            </table></center>
        </main>
        
        <footer>
        	<center><table>
            	<tr>
                	<td>Copyright &copy; 2025. Tim PUSDATIN - BKPSDMD Kabupaten Merangin.</td>
                </tr>
            </table></center>
        </footer>
        
	</section>
</body>
<script>
var myIndex = 0;
carousel();
function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 5000);
}
</script>
<script>
  (function() {
    var cx = '008927343735519909654:w8bciv_yp7u';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
</html>