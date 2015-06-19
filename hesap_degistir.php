<?php
if(defined("anasayfa")){
    $dbh = new dbHelper();
    $qry = $dbh->query("Select * From uye where id_uye = :id",array('id' => $_SESSION['kullanici_id']));
    foreach($qry as $row){
        $osifre = $row['sifre_uye'];
        echo '<form action="?guncelle" method="post">
<p class="popBaslik">HESABIM</p>
            <div class="divTable">
                <div class="divCell">Kullanıcı ismi :</div>
                <div  class="divCell"><input type="text" disabled="readonly" title="Türkçe karakter kullanmayın" name="isim" value="'; echo $row['isim_uye']; echo '"></div>
            <div class="divRow">
                <div class="divCell">Şifre :</div>
                <div class="divCell"><input type="password" placeholder="Güncel şifrenizi girin..." name="sifre"></div>
            </div>
            <div class="divRow">
                <div class="divCell">Yeni Şifre :</div>
                <div class="divCell"><input type="password" title="Şifre en az 8 karakterli olmalı" placeholder="En az 8 karakter girin..." name="ysifre"></div>
            </div>
            <div class="divRow">
                <div class="divCell">Yeni Şifre (Tekrar) :</div>
                <div class="divCell"><input type="password" name="ysifre_tekrar" placeholder="Şifreyi tekrarlayın..."></div>
            </div>
            <div class="divRow">
                <div class="divCell">Eposta :</div>
                <div class="divCell"><input type="text" disabled="readonly" name="eposta" value="'; echo $row['eposta_uye']; echo ' "></div>
           </div>
            <div class="divRow">
                <div class="divCell">Telefon :</div>
                <div class="divCell"><input type="text" maxlength="10" name="gsm" value="'; echo $row['telefon_uye']; echo '"></div>
           </div>
           <div class="divRow">
                <div class="divCell">Adres :</div>
                <div class="divCell"><textarea  name="adres" style="max-height: 100; height: 100; width: 150; max-width: 180">'; echo $row['adres_uye']; echo '</textarea></div>
           </div>
           <input class="batin" type="submit" value="Güncelle" />

      </div>
      </form>';
    }
    if(isset($_GET['guncelle'])){
            $sifre = $_POST['sifre'];
            $sifre = md5($sifre);
            $ysifre = $_POST['ysifre'];
            $ysifre = md5($ysifre);
            $ysifre_tekrar = $_POST['ysifre_tekrar'];
            $ysifre_tekrar = md5($ysifre_tekrar);
            $gsm = $_POST['gsm'];
            $adres = $_POST['adres'];

            $dbh = new dbHelper();
        $dbh->begin();
        try {
            if($sifre == null || $ysifre == null || $ysifre_tekrar == null){
                $_qry = $dbh->exec("Update uye Set telefon_uye = :telefon, adres_uye = :adres Where id_uye = :uye", array('uye' => $_SESSION['kullanici_id'], 'telefon' => $gsm, 'adres' => $adres));
            }
            else{
                if($sifre == $osifre){
                    if($ysifre == $ysifre_tekrar){
                        $_qry = $dbh->exec("Update uye Set sifre_uye = :sifre, telefon_uye = :telefon, adres_uye = :adres Where id_uye = :uye", array('uye' => $_SESSION['kullanici_id'], 'sifre' => $ysifre, 'telefon' => $gsm, 'adres' => $adres));
                    }
                }
            }
            $dbh->commit();
            header ("refresh:0, url=index.php");
        } catch (Exception $e) {
            $dbh->rollback();
            echo 'error : ' . $e->getMessage();
        }

    }
}
?>