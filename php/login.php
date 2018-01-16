<?php
$dsn  = 'mysql:dbname=mimic;host=localhost';
$host = 'localhost';
$username = 'root';
$password = 'uz@1!Hm!';
$dbname = 'soft';

session_start();

$errorMessage = "";

if (isset($_POST["login"])) {
    if (empty($_POST["id"])) {
        $errorMessage = 'IDが未入力';
    } else if (empty($_POST["pass"])) {
        $errorMessage = 'パスワードが未入力';
    }
    if (!empty($_POST["id"]) && !empty($_POST["pass"])) {
        $id = $_POST["id"];
        $pass = $_POST["pass"];
        try{
            $dbh = new PDO($dsn,$username,$password);
            $stmt = $dbh->prepare("select count(*) from users where id = ? and password = ?");
            $stmt->bindValue(1, $id, PDO::PARAM_STR);
            $stmt->bindValue(2, $pass, PDO::PARAM_STR);
            $stmt->execute();
            $count = (int)$stmt->fetchColumn();
            if ( $count > 0) {
                $foo = True;
                #$errorMessage = 'ログイン成功';
                $_SESSION['id'] = $_POST['id'];
                header('Location: ./user.php');
                exit;
            } else {
                $foo = False;
                $errorMessage = 'ユーザは存在しない';
            }
            $dbh = null;
        } catch (PDOException $e) {
            $errorMessage = 'エラー発生';
            exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
        }
    }
}


?>

<!DOCTTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン画面</h1>
    <form method = "post" action = "login.php">
        <p><?php echo $errorMessage ?></p>
        契約者ID<input type = "text" name = "id"  placeholder = "ID入れて">
        <br>
        パスワード<input type = "text" name = "pass" > <br>
        <input type = "submit" id = "login" name = "login" value = "ログイン" >
    </form>
</body>
</html>
