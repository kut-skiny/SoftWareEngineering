<?php

$dsn  = 'mysql:dbname=mimic;host=localhost';
$host = 'localhost';
$username = 'root';
$password = 'uz@1!Hm!';
$dbname = 'mimic';

#searchContract.htmlからデータを受け取る
$userID = $_POST['id'];             #契約者ID
$contractName = $_POST['name1'];    #契約者名
$userName = $_POST['name2'];        #薬箱利用者名
$mail = $_POST['mail'];
$phone = $_POST['phone'];
$ip = $_POST['ip'];
#$ = $_POST[''];


try{
    $dbh = new PDO($dsn,$username,$password);
    //IDで検索
    if (!empty($userID)) {
        #データベースへ接続
        #sql文の生成(契約者IDを基に、契約者名と薬箱利用者名を取り出す)
        $stmt = $dbh->prepare("select contracts.id, users.name, contracts.partner from users, contracts where users.id = ? and contracts.user_id = users.id");
        $stmt->bindValue(1, $userID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $userID = $result['id'];

        //契約者名が空欄ならDBのデータを使う．入力されているならDBのデータと比較して、違ったら検索失敗．
        if (empty($contractName)) {
            $contractName = $result['name'];
        } else if (strcmp($contractName, $result['name']) != 0) {
            echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
            exit;
        }

        //薬箱利用者が空欄ならDBのデータを使う．入力されているならDBのデータと比較して、違ったら検索失敗．
        if (empty($userName)) {
            $userName = $result['partner'];
        } else if (strcmp($userName, $result['partner']) != 0) {
            echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
            exit;
        }

        $data = array( $userID, $contractName, $userName );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
        //契約者名で検索
    } else if (!empty($contractName)) {
        $stmt = $dbh->prepare("select contracts.id, users.name, contracts.partner from users, contracts where users.name = ? and contracts.user_id = users.id");
        $stmt->bindValue(1, $contractName, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $contractName = $result['name'];

        //IDが空欄ならDBのデータを使う．入力されているならDBのデータと比較して、違ったら検索失敗．
        if (empty($userID)) {
            $userID = $result['id'];
        } else if (strcmp($userID, $result['id']) != 0) {
            echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
            exit;
        }

        //薬箱利用者が空欄ならDBのデータを使う．入力されているならDBのデータと比較して、違ったら検索失敗．
        if (empty($userName)) {
            $userName = $result['partner'];
        } else if (strcmp($userName, $result['partner']) != 0) {
            echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
            exit;
        }

        $data = array( $userID, $contractName, $userName );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
        //薬箱利用者で検索
    } else if (!empty($userName)) {
        $stmt = $dbh->prepare("select contracts.id, users.name, contracts.partner from users, contracts where contracts.partner = ? and contracts.user_id = users.id");
        $stmt->bindValue(1, $userName, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $userName = $result['partner'];

        //IDが空欄ならDBのデータを使う．入力されているならDBのデータと比較して、違ったら検索失敗．
        if (empty($userID)) {
            $userID = $result['id'];
        } else if (strcmp($userID, $result['id']) != 0) {
            echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
            exit;
        }

        //契約者名が空欄ならDBのデータを使う．入力されているならDBのデータと比較して、違ったら検索失敗．
        if (empty($contractName)) {
            $contractName = $result['name'];
        } else if (strcmp($contractName, $result['name']) != 0) {
            echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
            exit;
        }

        $data = array( $userID, $contractName, $userName );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
        //全て空欄だったら検索できないのでnull返す
    } else {
        echo json_encode($data = array( null, null, null), JSON_UNESCAPED_UNICODE);
    }

} catch (PDOException $e) {
    exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
