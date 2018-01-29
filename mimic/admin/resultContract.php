<?php

require_once '../DBN.php';

#searchContract.htmlからデータを受け取る
$userID = $_POST['id'];             #契約者ID
$contractName = $_POST['name1'];    #契約者名
$userName = $_POST['name2'];        #薬箱利用者名
#$ = $_POST[''];

#データの受け取れていることを確認
#echo $userID . ":" . $contractName . ":" . $userName;


    #sql文の生成(契約者IDを基に、契約者名と薬箱利用者名を取り出す)
    //partner=おじいちゃん
    $stmt = $dbh->prepare("select users.id, users.name, contracts.partner, users.password, users.mail, users.phone_number, contracts.ip_address from users, contracts where contracts.id = ? and contracts.user_id = users.id");
    #bindValue()を使って「?」に値を代入
    $stmt->bindValue(1, $userID, PDO::PARAM_STR);
    #sql文実行
    $stmt->execute();
    #sql文の実行結果を配列に入れる
    #配列['属性名']でデータにアクセスできる
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //$data = array( "id"=>$result['id'], "userName"=>$result['name'], "partner"=>$result['partner'] );
    $data = array( $result['id'], $result['name'], $result['partner'], $result['password'], $result['mail'], $result['phone_number'], $result['ip_address']);
    //$data = array( $result['id'], $result['name'], $result['partner']);
    //echo $data['id'] . $data['userName'] . $data['partner'];
    echo json_encode($data, JSON_UNESCAPED_UNICODE);


?>
