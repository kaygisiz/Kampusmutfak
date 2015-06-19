<?php
session_start();

$girilen_kod	= trim(strip_tags($_POST['security']));
$guvenlik_kodu	= trim(strip_tags($_SESSION['koruma']));

if($girilen_kod != $guvenlik_kodu)
	{
		echo 'Güvenlik Kodu Yanlış';
	}
	else
	{
		echo 'Güvenlik Kodu Doğru';
	}
?>