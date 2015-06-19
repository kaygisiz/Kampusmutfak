<?php
session_start();
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
echo "<form action='?giris=1' method='post'>
<p class='popBaslik'>KULLANICI GİRİŞİ</p>
    <div class='divTable'>
            <div class='divCell'> Kullanıcı Adı:</div>
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
       </form>";
if($_GET['giris'] == 1){
    $isim = $_POST['isim'];
    $sifre = $_POST['sifre'];
    $sifre = md5($sifre);

    $qry = $dbh->query("SELECT sifre_uye, isim_uye, id_uye FROM uye WHERE isim_uye = :kullanici_adi",array('kullanici_adi' => $isim));
    foreach($qry as $row){
        if($sifre == $row['sifre_uye']){
            $_SESSION['kullanici'] = $row['isim_uye'];
            $_SESSION['kullanici_id'] = $row['id_uye'];
            echo "<script>alert('Hoşgeldin '+$isim)</script>";
            header ("refresh:0 , url = index.php");
        }
        else{
            echo "<script>alert('Kullanıcı adınız veya şifreniz hatalı, lütfen tekrar deneyin.')</script>";
            header ("refresh:0 , url = index.php");
        }
    }
}
?>