<script type="text/javascript" src="css-script/zoomerang.js"></script>
<script type="text/javascript" src="css-script/script.js"></script>

<?php
ob_start();
session_start();
if(defined("yonetici")){
    require_once("ortak/dbHelper.php");
    $dbh = new dbHelper();
    $qry = $dbh->query("Select * From restoran");
    echo "<div id='main' style='display: inline'>
            <form action='?insert=admin' method='post'>
                <div class='divTable'>
                    <div class='divCell'>İsim:</div>
                    <div class='divCell'><input type='text' name='isim'/></div>
                <div class='divRow'>
                    <div class='divCell'>Şifre:</div>
                    <div class='divCell'><input type='password' name='sifre'/></div>
                </div>
                    <div class='divCell'>Restoran:</div>
                    <div class='divCell'><select name='selo'>
                    ";
                      foreach($qry as $row){
                          echo "<option value='".$row['id_restoran']."'>".$row['isim_restoran']."</option>";
                      }

               echo     "</select></div>
                </div>
                <div class='divRow'>
                    <div class='divCell'>&nbsp;</div>
                    <div class='divCell'><a href='uye_cikis.php'><input type='button' class='batin' value='Çıkış' /></a>
                                         <input type='submit' class='batin' value='Ekle'></div>
                </div>
            </form>";
    echo "<form action='?insert=restoran' method='post'>
                <div class='divTable'>
                    <div class='divCell'>İsim:</div>
                    <div class='divCell'><input type='text' name='isim'/></div>
                <div class='divRow'>
                    <div class='divCell'>&nbsp;</div>
                    <div class='divCell'><input type='submit' class='batin' value='Ekle'></div>
                </div>
            </form>";
    echo "      <div class='divTable' style='font-size: 15'>
                    <div class='divCell'>İsim</div>
                    <div class='divCell'>ID</div>
                </div>";
    $qry = $dbh->query("Select * From admin Where seviye_admin = :seviye", array('seviye' => 0));
    foreach($qry as $row){
        echo "<div class='divTable'>
                        <div class='divCell'>".$row['isim_admin']."</div>
                        <div class='divCell'>".$row['id_restoran']."</div>
                </div>";
    }
    echo "      <div class='divTable' style='font-size: 15'>
                    <div class='divCell'>İsim</div>
                    <div class='divCell'>ID</div>
                </div>";
    $qry = $dbh->query("Select * From restoran");
    foreach($qry as $row){
        echo "<div class='divTable'>
                        <div class='divCell'>".$row['isim_restoran']."</div>
                        <div class='divCell'>".$row['id_restoran']."</div>
                </div>";
    }
    if($_GET['insert'] == 'admin'){
        $aisim = $_POST['isim'];
        $asifre = $_POST['sifre'];
        $asifre = md5($asifre);
        $select = $_POST['selo'];
        $dbh->begin();
        try {
            $qry = $dbh->exec("INSERT INTO admin (isim_admin, sifre_admin, id_restoran) VALUES (:isim, :sifre, :id)", array('isim' => $aisim,'sifre' => $asifre,'id' => $select));
            $dbh->commit();
            header ("refresh:0");
        } catch (Exception $e) {
            $dbh->rollback();
            //echo 'error : ' . $e->getMessage();
        }
    }
    if($_GET['insert'] == 'restoran'){
        $risim = $_POST['isim'];
        $dbh->begin();
        try {
            $qry = $dbh->exec("INSERT INTO restoran (isim_restoran) VALUES (:isim)", array('isim' => $risim,));
            $dbh->commit();
            header ("refresh:0");
        } catch (Exception $e) {
            $dbh->rollback();
            //echo 'error : ' . $e->getMessage();
        }
    }
    echo     "</div>";
}
?>