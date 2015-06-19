<?php
session_start();
error_reporting(0);
require_once("ortak/dbHelper.php");
$dbh = new dbHelper();
if($_GET['onay'] != 1){
echo "ÜRÜN  <span style='float: right;'>FİYAT</span></br><hr/>";
$qry_ = $dbh->query("Select * From sepet inner join urun on sepet.id_urun = urun.id_urun Where id_uye = :id", array('id' => $_SESSION['kullanici_id']));
foreach($qry_ as $row){
    echo $row['isim_urun']." <span style='float: right;'>".$row['fiyat_urun']." TL </span></br>";
    $toplam = $toplam + $row['fiyat_urun'];
}
echo "<hr/>Toplam Tutar: $toplam TL <input type='button' class='batin' value='Siparişi Onayla' onclick='location.href=\" ?siparis=1&onay=1 \"' style='background-color: #24b300; margin: 0 auto;'/> ";
}
else{
    echo "<script>$('#sepet2').load('sepet_icerik.php');</script>";
    echo "Siparişiniz Gönderildi.";
    $qry_ = $dbh->query("Select * From sepet inner join urun on sepet.id_urun = urun.id_urun Where id_uye = :id", array('id' => $_SESSION['kullanici_id']));
    $dbh->begin();
    foreach($qry_ as $row){
        try {
            $qry = $dbh->exec("INSERT INTO siparis (id_urun, adet_urun, id_uye, tutar) VALUES (:id_urun, :adet, :id_uye, :tutar)", array('id_urun' => $row['id_urun'],'adet' => $row['adet_urun'],'id_uye' => $_SESSION['kullanici_id'], 'tutar' => $row['tutar']));
            $dbh->commit();
        } catch (Exception $e) {
            break;
        }
    }
    $dbh->begin();
    try {
        $qry = $dbh->exec("DELETE FROM sepet WHERE id_uye = :id", array('id' => $_SESSION['kullanici_id']));
        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollback();
        echo $e->getMessage();
    }
}
?>