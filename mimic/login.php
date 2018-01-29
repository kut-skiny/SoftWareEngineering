<?php

session_start();
require_once './DBN.php';


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
                header('Location: user/userMypage.php');
                exit;
            } elseif ($count2 > 0){
                $_SESSION['id'] = $_POST['id'];
                header('Location: admin/adminMyPage.html');
                exit;
            }else {
                $errorMessage = 'ユーザは存在しない';
            }
            $dbh = null;
        }
}


?>

<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"　name="viewport" content="width=device-width">
<head>
    <title>株式会社 skiny</title>
    <link rel="stylesheet" type"text/css" href="loginPage.css">
</head>
<body>
    <center>
        <h1>安否確認システム　ミミック</h1>
        <p><?php echo $errorMessage ?></p>
        <form method = "post" action = "login.php">
            <div class="button">
                <ul>
                    <p><li><label for="name">契約者ID</label><input type = "text" name = "id"  placeholder = "ID入れて" autocomplete="off"></li></p>
                    <p><li><label for="name">パスワード</label><input type = "password" name = "pass" ></li></p>
                </ul>
                <br>
                <input id="button1" type="submit" name="login" value="ログイン">
        </form>
    </center>
</body>
</html>
