<script type="text/javascript"></script>
<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once("ortak/dbHelper.php");
$id = $_GET['id'];

$dbh = new dbHelper();

$dbh->begin();
try {
    $qry = $dbh->exec("DELETE FROM urun WHERE id_urun = :id",array('id'=>$id));
    $dbh->commit();
    header ("refresh:0 , url = logbyad.php");
} catch (Exception $e) {
    $dbh->rollback();
    echo 'error : ' . $e->getMessage();
}
?>