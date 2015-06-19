<?php
session_start();
require_once("ortak/dbHelper.php");
$dbh = new dbHelper();
$id = $_POST['urun_id'];

$dbh->begin();
try {
    $qry = $dbh->exec("DELETE FROM sepet WHERE id_urun = :id", array('id' => $id));
    $dbh->commit();
} catch (Exception $e) {
    $dbh->rollback();
    echo $e->getMessage();
    $err = 1;
}
?>