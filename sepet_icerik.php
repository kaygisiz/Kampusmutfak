<?php
session_start();
require_once("ortak/dbHelper.php");
$dbh = new dbHelper();
if(isset($_SESSION['kullanici'])){
$toplam = 0;
echo "ÜRÜN  <span style='float: right;'>ADET   FİYAT</span></br><hr/>";
$qry = $dbh->query("Select * From sepet inner join urun on sepet.id_urun = urun.id_urun Where id_uye = :id", array('id' => $_SESSION['kullanici_id']));
foreach($qry as $row){
    echo $row['isim_urun']."<input type='image' style='float: right;' src='img/crosswhite2.png' onclick='sepetsil(".$row['id_urun'].");' /> <span style='float: right;'>".$row['adet_urun']."&nbsp;".$row['fiyat_urun']." TL </span></br>";
    $toplam = $toplam + $row['tutar'];
}
if(empty($qry))
    echo "Hiçbir ürün seçmediniz.";
echo "<hr/>Toplam Tutar: $toplam TL <input type='button' class='batin' value='Siparişi Onayla' onclick='location.href=\" ?siparis=1 \"' style='background-color: #24b300; margin: 0 auto;'/> ";
}
else{
    echo "Sepetten yararlanabilmek için üye olun.";
}
?>