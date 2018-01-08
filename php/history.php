<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Logout.php");
    exit;
}


$dsn  = 'mysql:dbname=soft;host=localhost';
$host = 'localhost';
$username = 'root';
$password = 'uz@1!Hm!';
$dbname = 'soft';

#idあってるか確認する（修正）
$id = $_SESSION["id"];

try{
    $dbh = new PDO($dsn,$username,$password);
    #$dbID = "select id from users";
    #$dbPass = ""select password from users where;
    $db = $dbh->prepare("select acted_at, state from histories where contract_id = ? ");
    $db->bindValue(1, $id, PDO::PARAM_STR);
    $db->execute();
    #$result = $db->fetch(PDO::FETCH_ASSOC);
    $result = $db->fetchAll(PDO::FETCH_ASSOC);
    #$dbActed_at = $row['acted_at'];
    #$dbState = $row['state'];
    #$dbID->bindValue(2, $pass, PDO::PARAM_STR);
    #$dbh = new PDO($dsn,$username,$pass);
    #$all = "select * from test";
    #$stmt = $dbh->query($all);
    #$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    #print_r($result);
    #$dbh = null;
   } catch (PDOException $e) {
       exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
   }

?>

<!DOCTTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>履歴画面</title>
</head>
<body>
    <h1>履歴</h1>
    <p><?php foreach ($result as $row) {
        echo htmlspecialchars($row['acted_at'] . " ");
        echo htmlspecialchars($row['state']) . "<br>";
    }?>
    </p>
    <p><?php print_r($result); ?></p>
    <a href = 'user.php'>戻る</a>
</body>
</html>
