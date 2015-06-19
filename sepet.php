<?php
session_start();
error_reporting(0);
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
$id = $_POST['urun_id'];
$adet = $_POST['adet'];
$qry_ = $dbh->query("Select fiyat_urun, id_restoran From urun Where id_urun = :id", array('id' => $id));
$tutar = $adet * $qry_[0]['fiyat_urun'];
$rest_sonurun = $qry_[0]['id_restoran'];

$_qry = $dbh->query("Select urun.id_restoran From sepet inner join urun on sepet.id_urun = urun.id_urun Where id_uye = :id", array('id' => $_SESSION['kullanici_id']));
$rest = $_qry[0]['id_restoran'];

if($rest == $rest_sonurun || empty($_qry)){
$dbh->begin();
try {
    $qry = $dbh->exec("INSERT INTO sepet (id_urun, adet_urun, id_uye, tutar) VALUES (:id_urun, :adet, :id_uye, :tutar)", array('id_urun' => $id,'adet' => $adet,'id_uye' => $_SESSION['kullanici_id'], 'tutar' => $tutar));
    $dbh->commit();
} catch (Exception $e) {
    $dbh->rollback();
    //echo 'error : ' . $e->getMessage();
}
}
else{
    echo "basarisiz";
}
?>