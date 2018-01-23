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
            $stmt2 = $dbh->prepare("select count(*) from administrators where id = ? and password = ?");
            $stmt2->bindValue(1, $id, PDO::PARAM_STR);
            $stmt2->bindValue(2, $pass, PDO::PARAM_STR);
            $stmt2->execute();
            $count2 = (int)$stmt2->fetchColumn();


            if ( $count > 0) {
                #$errorMessage = 'ログイン成功';
                $_SESSION['id'] = $_POST['id'];
                header('Location: ./userMypage.php');
                exit;
            } elseif ($count2 > 0){
                $_SESSION['id'] = $_POST['id'];
                header('Location: ./adminMyPage.html');
                exit;
            }else {
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
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン画面</h1>
    <form method = "post" action = "login.php">
        <p><?php echo $errorMessage ?></p>
        契約者ID<input type = "text" name = "id"  placeholder = "ID入れて" autocomplete="off">
        <br>
        パスワード<input type = "password" name = "pass" > <br>
        <input type = "submit" id = "login" name = "login" value = "ログイン" >
    </form>
</body>
</html>
