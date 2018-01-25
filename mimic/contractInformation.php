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
    <link rel="stylesheet" type"text/css" href="contractInformation.css">
</head>
<body>
    <h1 id="top1" onClick="location.href='userMyPage.php'"/><left>　ミミック　　</left></h1>
    <center><h1>契約情報</h1></center>
    <form method = "post" action = "getContract.php">
    <ul>
    <?php
    echo "<li><label>契約者ID : </label>" . $result['user_id'] . "</li>";
    echo "<li><label>契約者名 : </label>" . $result['name'] . "</li>";
    echo "<li><label>薬箱利用者名 : </label>" . $result['partner'] . "</li>";
    echo "<li><label>現在のパスワード : </label>" . $result['password'] . "</li>";
    ?>
    <li><label>パスワード変更 : </label> <input type = "password" name = "pass2" value = "<?php echo $result['password']; ?>" ></li>
    <li><label>パスワード再入力 : </label> <input type = "password" name = "pass3" value = "<?php echo $result['password']; ?>" ></li>
    <li><label>メールアドレス : </label> <input type = "text" name = "mail" value = "<?php echo $result['mail']; ?>" ></li>
    <li><label>電話番号 : </label> <input type = "text" name = "phone" value = "<?php echo $result['phone_number']; ?>" ></li>
    <?php
    echo "<li><label>IPアドレス : </label>" . $result['ip_address'] . "</li>";
    date_default_timezone_set('Asia/Tokyo');
    echo "<li><label>前回更新日時 : </label>" . $result['updated_at'] . "</li>";
     ?>

     <li><input type = "submit" id = "send" name = "send" value = "契約情報を変更する" ></li>
     </ul>
    </form>
</body>
</html>
