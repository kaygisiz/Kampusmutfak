$(function() {
    Array.prototype.forEach.call(document.querySelectorAll('p'), function (p, i) {
        p.style.marginLeft = i * 6 + '%'
    })
    Zoomerang
        .config({
            maxHeight: 400,
            maxWidth: 400,
            bgColor: '#000',
            bgOpacity: .85,
            onOpen: openCallback,
            onClose: closeCallback
        })
        .listen('.zoom')

    function openCallback (el) {
        console.log('zoomed in on: ')
        console.log(el)
    }

    function closeCallback (el) {
        console.log('zoomed out on: ')
        console.log(el)
    }
    $('a[rel*=leanModal]').leanModal({ top : 200, overlay : 0.4, closeButton: ".modal_close" });
    $('#log').jrumble();
    var demoStart = function(){
        $('#log').trigger('startRumble');
        setTimeout(demoStop, 500);
    };

    var demoStop = function(){
        $('#log').trigger('stopRumble');
        setTimeout(demoStart, 10000);
    };

    demoStart();
    $('input').attr('autocomplete','off');
    $('[class*="menu1"]').mouseenter(function() {
        $(this)
            .animate({ marginLeft: '70px' },{duration: 'slow',easing: 'easeOutBack'});
    });
    $('[class*="menu1"]').mouseleave(function () {
        $(this)
            .animate({ marginLeft: '0px' },{duration: 'slow', easing: 'easeOutBack'});
    });
    $('[id*="sepetim"]').mouseenter(function() {
            $(this)
                .animate({ marginBottom: '155px' },{duration: 'slow',easing: 'easeInOutQuint'});
    });
    $('[id*="sepetim"]').mouseleave(function() {
        $(this)
            .animate({ marginBottom: '0px' },{duration: 'slow', easing: 'easeOutBack'});
    });
});
function kontrol_isim(){
    var deger_k = $('[id*="kullanici_adi"]').val();
    var degerler ="deger="+deger_k;
    $.ajax({
        type: "POST",
        url: ("isim_kontrol.php"),
        data: degerler,
        cache: false,
        dataType: 'json',
        success: function(html) {
            var variable_returned_from_php = html.returned_val;
            $('#kullanici_kontrol').html(variable_returned_from_php);
        }

    })}
function kontrol_eposta(){
    var deger = $('[id*="eposta_adi"]').val();
    var degerler ="deger="+deger;
    $.ajax({
        type: "POST",
        url: ("eposta_kontrol.php"),
        data: degerler,
        cache: false,
        dataType: 'json',
        success: function(html) {
            var variable_returned_from_php = html.returned_val;
            $('#eposta_kontrol').html(variable_returned_from_php);
        }

    })}
function kontrol_sifre(){
    var uzunluk = $('[id*="pass"]').val();
    if (uzunluk.length >= 8)
    {
        $('#Rsifre_kontrol').attr({src:"img/success.png",class:"kontrol_resim"});
    }
    else if (uzunluk.length < 8)
    {
        $('#Rsifre_kontrol').attr({src:"img/cross.png",class:"kontrol_resim"});
    }
    if( $('#pass').val() == "" ){
        $('#Rsifre_kontrol').attr({src:"img/Bos.gif"});
    }
}
function kontrol_sifre_tekrar(){
    var uzunluk = $('[id*="pass"]').val();
    var uzunluk2 = $('[id*="pass_tekrar"]').val();
    if (uzunluk2.length >= 8)
    {
        if(uzunluk == uzunluk2){
            $('#Rsifre_kontrol_tekrar').attr({src:"img/success.png",class:"kontrol_resim"});
        }
        else{
            $('#Rsifre_kontrol_tekrar').attr({src:"img/cross.png",class:"kontrol_resim"});
        }
    }
    else if (uzunluk2.length < 8 | uzunluk2 != uzunluk)
    {
        $('#Rsifre_kontrol_tekrar').attr({src:"img/cross.png",class:"kontrol_resim"});
    }
    if( $('#pass_tekrar').val() == "" ){
        $('#Rsifre_kontrol_tekrar').attr({src:"img/Bos.gif"});
    }
}
function ChangeCode(){
    var NewSecurity= "guvenlik/security.php?rnd="+Math.random();
    $("#security").attr("src",NewSecurity);
    return false;
}
function sepetekle($urunid){
    var id = $urunid;
    var adet = $("input[name="+id+"]").val();
    var degerler ="urun_id="+id+"&adet="+adet;
    $.ajax({
        type: "POST",
        url: ("sepet.php"),
        data: degerler,
        success: function(data){
            if(data == "basarisiz"){
                alert("Sepette farklı restoranlara ait ürünler bulunduramazsınız.");
            }
            else{
                $('#sepet2').load('sepet_icerik.php');
            }
        }
    })
}
function sepetsil($urunid){
    var id = $urunid;
    var deger ="urun_id="+id;
    $.ajax({
        type: "POST",
        url: ("sepet_sil.php"),
        data: deger,
        success: function(){
            $('#sepet2').load('sepet_icerik.php');
        }
    })
}