<?php
session_start();
session_destroy();

require_once("config.php");
if(isset($_POST['login'])){
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $sql = "SELECT * FROM register WHERE username=:username OR email=:email";
    
	$stmt = $db->prepare($sql);
	
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );
	
	ini_set('memory_limit', '-1');
	
    $stmt->execute($params);
	
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
	
    // jika user terdaftar
    if($user)
	{
		// verifikasi password
        if(password_verify($password, $user["password"]))
		{
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman timeline
            header("Location: home.php");
        }
    }
	else
	{
		echo "<script>alert('Opps, data yang Anda masukkan salah!'); window.history.back()</script>";
	}
}
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
    <video autoplay muted loop id="myVideo" width="100%">
        <source src="../videos/CMSVideo.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="header">
            <div class="logo">
            	<a href="../index.html"><img src="../icon/BKPLogo3.png" width="150" id="bkpsdmdLogo" alt="Logo BKPSDMD"></a>	
            </div>

            <!--<div class="navbar">
            	<a href="login.php"><img src="images/button/masuk.png" height="25"/>Masuk</a>
                <a href="daftar.php"><img src="images/button/daftar.png" height="25"/>Daftar</a>
            </div>-->
    </div>
<div class="flex-container">
    <div class="flex-item-left">
        <h2>THAT HORIZON MIGHT BE CLOSER THAN YOU THINK!<br><p>Just manage your task from anywhere in the world. Get things done, stay on top of your work, wherever you are.</p></h2>
    </div>
    
    <div class="flex-item-right">
        <form action="" method="POST" name="login">
            <c>Login into CMS</c>
            <p><label>NIP</label>
            <br><input type="text" placeholder="Nomor Induk Pegawai" name="username"></p>
            <p><label>Kata Sandi</label>
            <br><input type="password" placeholder="Kata Sandi" name="password" id="input"></p>
            <input type="checkbox" onclick="myFunction()">Lihat Kata Sandi            
            <br><br><input type="submit" class="btn btn-success btn-block" name="login" value="Masuk"/>
        </form>                
    </div>
</div>
    <div class="footer">
        <p>Copyright &copy; 2025. Tim PUSDATIN - BKPSDMD Kabupaten Merangin.</p>
    </div>

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
<script>
function myFunction()
{
    var x = document.getElementById("input");
    if (x.type === "password")
	{
        x.type = "text";
    }
	else 
	{
        x.type = "password";
    }
}
</script>
</html>