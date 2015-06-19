<?php
    if(defined("anasayfa")){
        if(isset($_GET['kontrol'])){
            $girilen_kod	= trim(strip_tags($_POST['security']));
            $guvenlik_kodu	= trim(strip_tags($_SESSION['koruma']));
            if($girilen_kod == $guvenlik_kodu){
            $isim = $_POST['isim'];
            $sifre = $_POST['sifre'];
            $sifre = md5($sifre);
            $eposta = $_POST['eposta'];
            $gsm = $_POST['gsm'];
            $adres = $_POST['adres'];
                $dbh = new dbHelper();
                $dbh->begin();

                try {
                    $qry = $dbh->exec("INSERT INTO uye(isim_uye, sifre_uye, eposta_uye, telefon_uye, adres_uye)
                    VALUES (:kullanici, :sifre, :eposta, :telefon, :adres)", array('kullanici' => $isim,'sifre' => $sifre, 'eposta' => $eposta, 'telefon' => $gsm, 'adres' => $adres ));
                    $dbh->commit();

                    echo '<script type="text/javascript">alert("KampüsMutfak\'a Hoşgeldin!");</script>';
                    $_SESSION['kullanici'] = $isim;
                    header ("refresh:2 , url = index.php");
                } catch (Exception $e) {
                    $dbh->rollback();
                    echo 'Hata' . $e->getMessage();
                    $err = 1;
                }
            }
            else{
                echo '<script type="text/javascript">alert("Güvenlik Kodu Yanlış!");history.back();</script>';
            }

        }
        else{
            echo '<form action="?kontrol" method="post">
<p class="popBaslik">ÜYE FORMU</p>
            <div class="divTable">
                <div class="divCell">Kullanıcı ismi :</div>
                <div  class="divCell"><input type="text" title="Türkçe karakter kullanmayın" name="isim" id="kullanici_adi" onkeyup="kontrol_isim();"></div>
                <div id="kullanici_kontrol" class="divCell_kontrol"></div>
            <div class="divRow">
                <div class="divCell">Şifre :</div>
                <div class="divCell"><input type="password" title="Şifre en az 8 karakterli olmalı" placeholder="En az 8 karakter girin..." name="sifre" id="pass" onkeyup="kontrol_sifre();"></div>
                <div id="sifre_kontrol" class="divCell_kontrol" src=""><img id="Rsifre_kontrol" /></div>
            </div>
            <div class="divRow">
                <div class="divCell">Şifre (Tekrar) :</div>
                <div class="divCell"><input type="password" name="sifre_tekrar" placeholder="Şifreyi tekrarlayın..." id="pass_tekrar" onkeyup="kontrol_sifre_tekrar();"></div>
                <div id="sifre_kontrol_tekrar" class="divCell_kontrol" src=""><img id="Rsifre_kontrol_tekrar" /></div>
            </div>
            <div class="divRow">
                <div class="divCell">Eposta :</div>
                <div class="divCell"><input type="text" placeholder="ornek@deneme.com" " id="eposta_adi" name="eposta" onkeyup="kontrol_eposta();"></div>
                <div id="eposta_kontrol" class="divCell_kontrol" ></div>
           </div>
            <div class="divRow">
                <div class="divCell">Telefon :</div>
                <div class="divCell"><input type="text" placeholder="05XX-XXX-XXXX" maxlength="10" name="gsm"></div>
           </div>
           <div class="divRow">
                <div class="divCell">Adres :</div>
                <div class="divCell"><textarea  name="adres" style="max-height: 100; height: 100; width: 180; max-width: 180"></textarea></div>
           </div>
           <div class="divRow">
                <div class="divCell">&nbsp;</div>
           </div>
           <div class="divRow">
                <div class="divSec">Güvenlik Kodu :</div>
                <div class="divSec"><img id="security" src="guvenlik/security.php" alt="guvenlik" style="border: 1px solid #999999;"></div>
                <div class="divSec"><a href="#" onclick="ChangeCode();"><img style="margin: 10px 10px 8px 0" src="guvenlik/refresh.png" /></a></div>
           </div>
           <div class="divRow">
                <div class="divSec">&nbsp;</div>
                <div class="divSec"><input class="guvenlik" type="text" name="security"/></div>
                <div class="divSec" style="width: 154px ; margin: 10px 10px 8px 0">(Resimdeki kodu giriniz.)</div>
           </div><input class="batin" type="submit" value="Kaydol" />

      </div>
      </form>';
        }
    }
?>