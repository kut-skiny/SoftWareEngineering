<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Logout.php");
    exit;
}


$dsn  = 'mysql:dbname=mimic;host=localhost';
$host = 'localhost';
$username = 'root';
$password = 'uz@1!Hm!';
$dbname = 'mimic';

#idあってるか確認する（修正）
$id = $_SESSION["id"];

try{
    $dbh = new PDO($dsn,$username,$password);
    #ログイン時に入力したIDをもとに、契約IDを検索。その後、契約IDと一致する契約情報を取り出す。
    $stmt = $dbh->prepare("select contracts.user_id, users.name, contracts.partner, contracts.ip_address, users.mail, users.password, users.phone_number from contracts, users where contracts.user_id = ? and users.id = contracts.user_id ");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //タイムゾーンを設定
    //date_default_timezone_set('Asia/Tokyo');
    //$now = date('Y-m-d H:i:s');
    //契約情報を更新
    //$stmt = $dbh->prepare("update users set mail = ?, phone_number = ?, updated_at = ? where id = ?");
    //$stmt->bindValue(1, $mail);
    //$stmt->bindValue(2, $phone);
    //$stmt->bindValue(3, $now);
    //$stmt->bindValue(4, $id);
    //$stmt->execute();
    //$result = $stmt->fetch(PDO::FETCH_ASSOC);

    $dbh = null;
   } catch (PDOException $e) {
       exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
   }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>マイページ</title>
</head>
<body>
    <h1>契約情報</h1>
    <?php
    echo "契約者ID：" . $result['user_id'] . "<br>";
    echo "契約者名：" . $result['name'] . "<br>";
    echo "薬箱利用者名：" . $result['partner'] . "<br>";
    echo "現在のパスワード：" . $result['password'] . "<br>";
    echo "メールアドレス：" . $result['mail'] . "<br>";
    echo "電話番号：" . substr($result['phone_number'],0,3) . "-" . substr($result['phone_number'],3,4), "-" . substr($result['phone_number'],4,4) . "<br>";
    echo "IPアドレス：" . $result['ip_address'] . "<br>";
    date_default_timezone_set('Asia/Tokyo');
    echo date('Y-m-d H:i:s');
     ?>
    <br>
    <a href = 'user.php'>戻る</a>
</body>
</html>
