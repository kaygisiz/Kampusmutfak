<?php
require_once('ortak/dbHelper.php');
$dbh = new dbHelper();
$a = '<img class="kontrol_resim" src="img/cross.png" />';
$b = '<img class="kontrol_resim" src="img/success.png" />';
$c = '<img src="img/Bos.gif" />';
$eposta = $_POST['deger'];
if($eposta == ""){
    echo json_encode(array('returned_val' => $c));
}
else{
    if(filter_var($eposta, FILTER_VALIDATE_EMAIL)!== false && turkcekarakter_kontrolu($eposta) === false)
    {
        $qry = $dbh->query("SELECT eposta_uye FROM uye WHERE eposta_uye = :eposta",array('eposta' => $eposta));
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