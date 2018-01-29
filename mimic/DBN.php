<?php
$dsn  = 'mysql:dbname=mimic;host=localhost';
$host = 'localhost';
$username = 'root';
$password = 'uz@1!Hm!';
$dbname = 'soft';

try{
    $dbh = new PDO($dsn,$username,$password);
} catch (PDOException $e){
    $errorMessage = 'エラー発生';
    exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
