<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Logout.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>マイページ</title>
</head>
<body>
    <h1>ユーザマイページ</h1>
    <a href="history.php">履歴</a>
    <br>
    <a href="getConf.php">設定</a>
    <br>
    <a href="getContract.php">契約情報</a>
    <br>
    <br>
    <a href="logout.php">ログアウト</a>
</body>
</html>
