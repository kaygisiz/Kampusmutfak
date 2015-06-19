<?php
ob_start();
session_start();
require_once("ortak/dbHelper.php");
$dbh = new dbHelper();
if(defined("s_index")){
if($_GET['edit'] == 'ok'){
    $id = $_GET['id'];

    $qry = $dbh->query("SELECT * FROM urun WHERE id_urun = :id",array('id'=>$id));

    $isim2 = $qry[0]['isim_urun'];
    $fiyat2 = $qry[0]['fiyat_urun'];
    $resim2 = $qry[0]['resim_urun'];
}
echo "      <form action='?edit=ok&id=$id&kayit=degisti' method='post'>
                <div class='divTable'>
                    <div class='divCell'>İsim:</div>
                    <div class='divCell'><input type='text' name='isim' value='$isim2'/></div>
                <div class='divRow'>
                    <div class='divCell'>Fiyat:</div>
                    <div class='divCell'><input type='text' name='fiyat' value='$fiyat2'/></div>
                </div>
                <div class='divRow'>
                    <div class='divCell'>Resim:</div>
                    <div class='divCell'><input type='file' name='resim' style='width: 190px'/></div>
                </div>
                <div class='divRow'>
                    <div class='divCell'>&nbsp;</div>
                    <div class='divCell'><input type='submit' class='batin' value='Kaydet'></div>
                </div>
                </div>
            </form>";
if($_GET['kayit'] == 'degisti'){
    $isim = $_POST['isim'];
    $fiyat = $_POST['fiyat'];
    $resim = $_POST['resim'];
    if($resim == null){
        $resim = $resim2;
    }
    $dbh->begin();
    try {
        $qry = $dbh->exec("Update urun Set isim_urun = :isim, fiyat_urun = :fiyat, resim_urun = :resim Where id_urun = :id", array('isim' => $isim,'fiyat' => $fiyat,'resim' => $resim, 'id' => $id));
        $dbh->commit();
        header ("Location: logbyad.php");
    } catch (Exception $e) {
        $dbh->rollback();
        echo 'error : ' . $e->getMessage();
    }
}
}
?>