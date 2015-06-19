<script type="text/javascript" src="css-script/zoomerang.js"></script>
<script type="text/javascript" src="css-script/script.js"></script>

<?php
ob_start();
session_start();
if(defined("yonetici")){
define("s_index","sahip");
require_once("ortak/dbHelper.php");
$dbh = new dbHelper();
$qry = $dbh->query("Select * From urun Where id_restoran = :id",array('id' => $_SESSION['restoran']));
    echo "<div id='main' style='display: inline'>";
echo "<h3 style='text-align: center'>".$_SESSION['admin']."</h3>";
         echo   "<form action='?log_ad=1&insert=ok' enctype='multipart/form-data' method='post'>
                <div class='divTable'>
                    <div class='divCell'>İsim:</div>
                    <div class='divCell'><input type='text' name='isim'/></div>
                <div class='divRow'>
                    <div class='divCell'>Fiyat:</div>
                    <div class='divCell'><input type='text' name='fiyat'/></div>
                </div>
                <div class='divRow'>
                    <div class='divCell'>Resim:</div>
                    <div class='divCell'><input type='file' name='resim' style='width: 190px'/></div>
                </div>
                <div class='divRow'>
                    <div class='divCell'>&nbsp;</div>
                    <div class='divCell'><a href='uye_cikis.php'><input type='button' class='batin' value='Çıkış' /></a>
                                         <input type='submit' class='batin' value='Ekle'></div>
                </div>
                </div>
            </form>";
    echo "      <div class='divTable' style='font-size: 15'>
                    <div class='divCell'>İsim</div>
                    <div class='divCell'>Fiyat</div>
                    <div class='divCell'>Resim</div>
                    <div class='divCell'>&nbsp;</div>
                </div>";
          foreach($qry as $row){
              echo "<div class='divRow'>
                        <div class='divCell'>".$row['isim_urun']."</div>
                        <div class='divCell'>".$row['fiyat_urun']." TL</div>
                        <div class='divCell'><img class='zoom' src='img/".$row['resim_urun']."' style='height: 25px;width: auto;'/></div>
                        <div class='divCell'><a href='?edit=ok&id=".$row['id_urun']."'><img src='img/edit2.png'/></a>
                                             <a href='s_rmv.php?id=".$row['id_urun']."'><img src='img/cross2.png' /></a></div>
                    </div>";
          }
    if($_GET['insert'] == 'ok'){
        $isim = $_POST['isim'];
        $fiyat = $_POST['fiyat'];
        if($_FILES['resim']){
            $uploaddir = './img/'; // upload edilecek klasör
            $img = getimagesize($_FILES['resim']['tmp_name']); // resmin boyutları ve türü için kullanılıyor manuale detayı için bakabilirsin
            $ext = explode('/', $img['mime']); // resmin uzantısını alıyoruz jpg, png, gif...
            $new_name = time() . mt_rand(10000, 99999); // rastgele bir isim yaratıyoruz. yoksa aynı isimli dosya üstüne yazılabilir
            $uploadfile = $new_name . '.' . $ext[1]; // yeni dosya ismi uzantısıyla birlikte

            // resmi geçici klasöründen yüklemek istediğimiz yere taşıyoruz.
            move_uploaded_file($_FILES['resim']['tmp_name'], $uploaddir . '/' . $uploadfile);
            echo "asdfa";
        }
        $dbh->begin();
        try {
            $qry = $dbh->exec("INSERT INTO urun (isim_urun, fiyat_urun, resim_urun, id_restoran) VALUES (:isim, :fiyat, :resim, :id)", array('isim' => $isim,'fiyat' => $fiyat,'resim' => $uploadfile, 'id' => $_SESSION['restoran']));
            $dbh->commit();
            header ("refresh:0");
        } catch (Exception $e) {
            $dbh->rollback();
            //echo 'error : ' . $e->getMessage();
        }
    }
    elseif($_GET['edit'] == 'ok'){
        echo "<div id='duzenle'>";
        include("s_edt.php");
        echo "</div>";
    }
echo "<span><input type='button' class='batin' onclick='location.href=\"siparis_takip.php\"' value='Sipariş Takip' /> </span>";
echo     "</div>";
}
?>