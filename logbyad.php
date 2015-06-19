<html>
<head>
<link rel="stylesheet" type="text/css" href="css-script/dizayn.css" >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body bgcolor = #f8f8ff>
<a href="index.php" id="alog"><img id="log" src="img/logo2.png" /></a>
<?php
session_start();
ob_start();
define("yonetici","admin is here");
error_reporting(0);
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
if(!isset($_SESSION['admin'])){
echo "<div  class='divPop' style='display: inline-table; position: absolute; top: 40%; left: 35%;'>
<form action='?log_ad=1' method='post'>
    <p class='popBaslik'>LOGIN BY ADMIN</p>
        <div class='divTable'>
            <div class='divCell'> Admin:</div>
            <div class='divCell'><input type='text' name='isim'/></div>
        <div class='divRow'>
            <div class='divCell'> Şifre: </div>
            <div class='divCell'> <input type='password' name='sifre'/></div>
        </div>
        <div class='divRow'>
            <div class='divCell'>&nbsp;</div>
            <div class='divCell'><input type='submit' class='batin' value='Giriş'></div>
        </div>
    </div>
       </form>
       </div>";
if($_GET['log_ad'] == 1){
    $isim = $_POST['isim'];
    $sifre = $_POST['sifre'];
    $sifre = md5($sifre);

    $qry = $dbh->query("Select isim_admin, sifre_admin, id_restoran, seviye_admin From admin Where isim_admin = :kullanici",array('kullanici' => $isim));
    foreach($qry as $row){
        if($sifre == $row['sifre_admin'] || isset($_SESSION['sifre'])){
            $_SESSION['seviye'] = $row['seviye_admin'];
            $_SESSION['admin'] = $row['isim_admin'];
            $_SESSION['restoran'] = $row['id_restoran'];
            $_SESSION['sifre'] = $sifre;
            echo "<script>alert('Hoşgeldiniz ".$isim."');</script>";
            echo "<script>document.getElementById('adgiris').style.display = 'none';</script>";
            if($_SESSION['seviye'] == 0)
                include("s_index.php");
            else
                include("seviye1_admin.php");
        }
        else{
            echo "<script>alert('Adınız veya şifreniz hatalı, lütfen tekrar deneyin.');</script>";
            header ("Location: logbyad.php");
        }
    }
    }
}
else{
    if($_SESSION['seviye'] == 0)
        include("s_index.php");
    else
        include("seviye1_admin.php");
}
?>
</body>
</html>