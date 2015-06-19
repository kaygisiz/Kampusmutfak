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
error_reporting(0);
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
if(isset($_SESSION['admin'])){
    echo "<div id='main'>";
        $qry = $dbh->query("Select * From siparis inner join uye on siparis.id_uye = uye.id_uye Where durum_siparis = :durum Group By isim_uye",array('durum' => 0));
    foreach($qry as $row){
        echo $row['isim_uye']."\t".$row['tarih_siparis']." <input type='image' src='img/redarrow.png' onclick='location.href=\"?id=".$row['id_uye']."\"' /></br>";
    }
    echo "<div id='main2'>";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $toplam=0;
        $qry_ = $dbh->query("Select * From siparis inner join urun on urun.id_urun = siparis.id_urun Where id_uye = :uye and durum_siparis = :durum",array('uye' => $id, 'durum' => 0));
        foreach($qry_ as $row){
            echo $row['isim_urun']."\t".$row['adet_urun']." ".$row['tutar']."</br>";
            $toplam = $toplam + $row['tutar'];
        }
        echo "<input type='button' class='batin' onclick='location.href=\"?id=".$id."&durum=1\"' value='Siparişi Al'/>".$toplam;
        if($_GET['durum'] == 1){
            $dbh->begin();
            try {
                $_qry = $dbh->exec("Update siparis Set durum_siparis = :durum Where id_uye = :uye", array('durum' => 1, 'uye' => $id));
                $dbh->commit();
                header ("refresh:0, url=siparis_takip.php");
            } catch (Exception $e) {
                $dbh->rollback();
                echo 'error : ' . $e->getMessage();
            }
        }
    }
    echo "</div>";
    echo "</div>";
}
?>
</body>
</html>