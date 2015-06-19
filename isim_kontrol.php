<?php
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
$a = '<img class="kontrol_resim" src="img/cross.png" />';
$b = '<img class="kontrol_resim" src="img/success.png" />';
$c = '<img src="img/Bos.gif" />';
$isim = $_POST['deger'];
if($isim == ""){
    echo json_encode(array('returned_val' => $c));
}
else{
    if(turkcekarakter_kontrolu($isim) == false)
    {
$qry = $dbh->query("SELECT isim_uye FROM uye WHERE isim_uye = :kullanici_adi",array('kullanici_adi' => $isim));
if(count($qry)>0){
    echo json_encode(array('returned_val' => $a));
}
else{
    echo json_encode(array('returned_val' => $b));
}
}
    else{
        echo json_encode(array('returned_val' => $a));
    }
}
function turkcekarakter_kontrolu($deger){
    $turkcekarakterler = array('ç','ı','ğ','ö','ü','ş','Ç','İ','Ğ','Ö','Ü','Ş');

    $hatalikarakter=false;
    foreach($turkcekarakterler as $turkcekarakter){
        if(strpos($deger,$turkcekarakter)!==false){
            $hatalikarakter = true;
            break;
        }
    }
    return $hatalikarakter;
}
?>