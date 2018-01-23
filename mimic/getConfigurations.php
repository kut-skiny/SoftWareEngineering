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
//$id = $_SESSION["id"];
$id = 10000001;
try{
    $dbh = new PDO($dsn,$username,$password);
    #ログイン時に入力したIDをもとに、契約IDを検索。その後、契約IDと一致する薬箱の情報を取り出す。
    $stmt = $dbh->prepare("select contracts.user_id, users.name, contracts.ip_address, users.mail, users.password, users.phone_number from contracts, users where contracts.user_id = ? and users.id = contracts.user_id ");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $result['user_id'] . "<br>";
    echo $result['name'] . "<br>";
    echo $result['password'] . "<br>";
    echo $result['mail'] . "<br>";
    echo substr($result['phone_number'],0,3) . "-" . substr($result['phone_number'],3,4), "-" . substr($result['phone_number'],4,4) . "<br>";
    echo $result['ip_address'] . "<br>";


    $dbh = null;
   } catch (PDOException $e) {
       exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
   }

?>
