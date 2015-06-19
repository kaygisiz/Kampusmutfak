<?php
session_start();
error_reporting(0);
define("anasayfa","anasayfaya sahip");
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script type="text/javascript" src="css-script/jquery.jrumble.1.3.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script type="text/javascript" src="css-script/jquery.leanModal.min.js"></script>
    <script type="text/javascript" src="css-script/zoomerang.js"></script>
    <link rel="stylesheet" type="text/css" href="css-script/dizayn.css" >
    <link rel="stylesheet" type="text/css" href="css-script/csshake.css" >
    <script type="text/javascript" src="css-script/script.js"></script>
</head>
<body>
<!--                                                *POPUPS*                                                -->

    <div id="kayit_pop" class="divPop"><?php include("uye_kayit.php"); ?></div>
    <div id="giris_pop" class="divPop"><?php include("uye_giris.php"); ?></div>
    <div id="hesap_pop" class="divPop"><?php include("hesap_degistir.php"); ?></div>

<!--                                                *LOGO*                                                  -->

<a href="index.php" id="alog"><img id="log" src="img/logo2.png" /></a>

<!--                                                *SOL MENU*                                              -->

    <div class="menu1" onmouseover="this.start();"><a onmouseover="this.start();" href="?res=1">Restoran1</a></div>
    <div class="menu1" style="top: 250px" onmouseover="this.start();"><a onmouseover="this.start();" href="?res=2">Restoran2</a></div>
    <div class="menu1" style="top: 300px" onmouseover="this.start();"><a onmouseover="this.start();" href="?res=3">Restoran3</a></div>
    <div id='sepetim'><div id='sepet1' onmouseover="this.start();">Sepet</div><div id='sepet2'><?php include("sepet_icerik.php"); ?></div> </div>

<div id="main">
    <?php
//                                                      *ÜYE*

        if($_GET['res'] == 1){
            $_SESSION['res_id'] = 1;
            include("urunler.php");
        }
        else if($_GET['res'] == 2){
            $_SESSION['res_id'] = 2;
            include("urunler.php");
        }
        else if($_GET['res'] == 3){
            $_SESSION['res_id'] = 3;
            include("urunler.php");
        }
        else if($_GET['siparis'] == 1){
            include("siparis_onay.php");
        }
        if(!isset($_GET['res']) && !isset($_GET['siparis'])){
            $_SESSION['res_id'] = 0;
            include("urunler.php");
        }
    if(isset($_SESSION['kullanici'])){
        echo "<div id='altserit' >
                <a class='shake shake-little' href='uye_cikis.php'>Çıkış</a>
                <a id='hesap' class='shake shake-little' rel='leanModal' href='#hesap_pop'>Hesabım</a>
            </div>";
    }

//                                                  *ÜYE DEĞİL*

    else {
        echo "<div id='altserit' >
                    <a id='kaydol' class='shake shake-little' rel='leanModal' href='#kayit_pop'>Üye Ol</a>
                    <a id='giris' class='shake shake-little' rel='leanModal' href='#giris_pop'>Giriş</a>
            </div>";
    } ?>
    </div>
</body>
</html>