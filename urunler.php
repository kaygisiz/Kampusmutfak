<html>
<head>
    <script type="text/javascript" src="css-script/zoomerang.js"></script>
</head>
<body>
<?php
session_start();
if($_GET['res'] != 0){
$sonuc = 0;
$qry = $dbh->query("Select * From urun Where id_restoran = :id", array('id' => $_SESSION['res_id']));
echo "<div class='divDis'>";
foreach($qry as $row){
    switch($sonuc %4){
        case 0:
            echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
            break;
        case 1:
            echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
            break;
        case 2:
            echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
            break;
        case 3:
            echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
            break;
    }$sonuc++;
}
}
else{
    $sonuc = 0;
    $qry = $dbh->query("Select urun.*, count(*) From siparis inner join urun on siparis.id_urun = urun.id_urun Group By siparis.id_urun Having max(siparis.id_urun) Order By count(*) desc limit 4");
    foreach($qry as $row){
        switch($sonuc %4){
            case 0:
                echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
                break;
            case 1:
                echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
                break;
            case 2:
                echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
                break;
            case 3:
                echo "<div class='divResim'> <img class='urun_resim' src ='img/".$row['resim_urun']."' />
            <div class='divBilgi'>".$row['isim_urun']."</br>".$row['fiyat_urun']." TL<input type='image' class='sepet' src='img/cart-icon.png' onclick='sepetekle(".$row['id_urun'].")' /><input name='".$row['id_urun']."' class='adet' type='text' value='1' style='width: 20px;' /></div></div>";
                break;
        }$sonuc++;
    }
}
echo "</div>";
?>
</body>
</html>