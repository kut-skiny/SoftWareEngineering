<?php

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Logout.php");
    exit;
}
if (isset($_POST["send"])) {
    $flag = 1;
}else{
    $flag = 0;
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
    if($flag == 1 && (strcmp($_POST["pass2"],$_POST["pass3"]) == 0)){ #&& (strcmp($_POST["pass2"],$_POST["pass3"])==0)){
        date_default_timezone_set('Asia/Tokyo');
        $sdate = date('Y-m-d H:i:s');
        $userps = $_POST['pass2'];
        $usermail = $_POST['mail'];
        $userphone = $_POST['phone'];
        $stmt = $dbh->prepare("update users set password = ?, mail = ?, phone_number = ?, updated_at = ? where id = ?;");
        $stmt->bindValue(1, $userps);
        $stmt->bindValue(2, $usermail);
        $stmt->bindValue(3, $userphone);
        $stmt->bindValue(4, $sdate);
        $stmt->bindValue(5, $id);
        $stmt->execute();
        $flag = 0;
    }
    $stmt = $dbh->prepare("select contracts.user_id, users.name, contracts.partner, contracts.ip_address, users.mail, users.password, users.phone_number, users.updated_at from contracts, users where contracts.user_id = ? and users.id = contracts.user_id ");
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
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>マイページ</title>
</head>
<body>
    <h1>契約情報</h1>
    <form method = "post" action = "getContract.php">
    <?php
    echo "契約者ID：" . $result['user_id'] . "<br>";
    echo "契約者名：" . $result['name'] . "<br>";
    echo "薬箱利用者名：" . $result['partner'] . "<br>";
    echo "現在のパスワード：" . $result['password'] . "<br>";
    ?>
    <a>パスワード変更 : <input type = "text" name = "pass2" value = "<?php echo $result['password']; ?>" ></a>
    <br>
    <a>パスワード再入力 : <input type = "text" name = "pass3" value = "<?php echo $result['password']; ?>" ></a>
    <br>
    <a>メールアドレス : <input type = "text" name = "mail" value = "<?php echo $result['mail']; ?>" ></a>
    <br>
    <a>電話番号 : <input type = "text" name = "phone" value = "<?php echo $result['phone_number']; ?>" ></a>
    <?php
    echo "<br>";
    echo "IPアドレス：" . $result['ip_address'] . "<br>";
    date_default_timezone_set('Asia/Tokyo');
    echo "前回更新日時：" . $result['updated_at'];
     ?>
     <br>
     <input type = "submit" id = "send" name = "send" value = "契約情報を変更する" >
    </form>
    <br>
    <a href = 'userMypage.php'>戻る</a>
</body>
</html>
