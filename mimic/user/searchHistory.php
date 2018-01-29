<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Logout.php");
    exit;
}

require_once '../DBN.php';

$id = $_SESSION["id"];
$month = $_POST['month'];
$day = $_POST['day'];

    if( (!empty($_POST['month'])) && (strcmp($_POST['day'], "　") != 0 )) {
        if ($_POST['month'] <= date('m') && $_POST['day'] <= date('d')){

        if ($month < 9) {
            $month = "0".$month;
        }
        if ($day < 9) {
            $day = "0".$day;
        }

        $minDate = '2018-'.$month.'-'.$day.' 00:00:00';
        $maxDate = '2018-'.$month.'-'.$day.' 23:59:59';
        //$result = array_fill(0, 10, '-----------------');
        //$state = array_fill(0, 10, '-------------------');
        $dbh = new PDO($dsn,$username,$password);
        $db = $dbh->prepare("select histories.acted_at, histories.state from contracts, histories where contracts.user_id =? and histories.contract_id = contracts.id and acted_at between ? and ?  ");
        $db->bindValue(1, $id);
        $db->bindValue(2, $minDate);
        $db->bindValue(3, $maxDate);
        $db->execute();
        $result = $db->fetchAll(PDO::FETCH_COLUMN,0);
        $db = $dbh->prepare("select histories.acted_at, histories.state from contracts, histories where contracts.user_id =? and histories.contract_id = contracts.id and acted_at between ? and ?  ");
        $db->bindValue(1, $id);
        $db->bindValue(2, $minDate);
        $db->bindValue(3, $maxDate);
        $db->execute();
        $state = $db->fetchAll(PDO::FETCH_COLUMN,1);

        $resultSize = sizeof($result);
        $stateSize = sizeof($state);
        for ($i = $resultSize; $i < 4; $i++) {
            $result[$i] = '-----------------';
            $state[$i] = '-----------------';
        }

        if( strcmp($state[0],'opened')==0) {
            $stateMorning = '◯';
        } else if (strcmp($state[0],'no_responce')==0){
            $stateMorning = '×';
        } else if (strcmp($state[0],'go_out')==0){
            $stateMorning = '外出中';
        } else {
            $stateMorning = '-';
        }

        if( strcmp($state[1],'opened')==0) {
            $stateNoon = '◯';
        } else if (strcmp($state[1],'no_responce')==0){
            $stateNoon = '×';
        } else if (strcmp($state[1],'go_out')==0){
            $stateMorning = '外出中';
        } else {
            $stateNoon = '-';
        }

        if( strcmp($state[2],'opened')==0) {
            $stateEvening = '◯';
        } else if (strcmp($state[2],'no_responce')==0){
            $stateEvening = '×';
        } else if (strcmp($state[2],'go_out')==0){
            $stateEvening = '外出中';
        } else {
            $stateEvening = '-';
        }

        if( strcmp($state[3],'opened')==0) {
            $stateNight = '◯';
        } else if (strcmp($state[3],'no_responce')==0){
            $stateNight = '×';
        } else if (strcmp($state[3],'go_out')==0){
            $stateNight = '外出中';
        } else {
            $stateNight = '-';
        }

        $dbh = null;
        echo
        "<table class='tab'>

               <thead>
                    <tr>
                        <th>" . $day ."日のお薬服用の状況</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>朝 :" . substr($result[0], 11, 2) . "時" . substr($result[0], 14, 2). "分". "</td>
                        <td>" . $stateMorning. "</td>
                    </tr>
                    <tr>
                        <td>昼 :" .substr($result[1], 11, 2). "時" . substr($result[1], 14, 2). "分"."</td>
                        <td>" . $stateNoon. "</td>
                    </tr>
                    <tr>
                        <td>夕方 :".substr($result[2], 11, 2). "時" .substr($result[2], 14, 2). "分"."</td>
                        <td>" . $stateEvening. "</td>
                    </tr>
                    <tr>
                        <td>夜 :".substr($result[3], 11, 2). "時" . substr($result[3], 14, 2). "分"."</td>
                        <td>" . $stateNight. "</td>
                    </tr>
                </tbody>
            </table>"
        ;
        exit;
    }
}
for ($i = 0; $i < 4; $i++) {
    $result[$i] = '-----------------';
    $stateMorning = '-';
    $stateNoon = '-';
    $stateEvening = '-';
    $stateNight = '-';
}
    echo
    "<table class='tab'>

           <thead>
                <tr>
                    <th>" . $day ."日のお薬服用の状況</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>朝 :" . substr($result[0], 11, 2) . "時" . substr($result[0], 14, 2). "分". "</td>
                    <td>" . $stateMorning. "</td>
                </tr>
                <tr>
                    <td>昼 :" .substr($result[1], 11, 2). "時" . substr($result[1], 14, 2). "分"."</td>
                    <td>" . $stateNoon. "</td>
                </tr>
                <tr>
                    <td>夕方 :".substr($result[2], 11, 2). "時" .substr($result[2], 14, 2). "分"."</td>
                    <td>" . $stateEvening. "</td>
                </tr>
                <tr>
                    <td>夜 :".substr($result[3], 11, 2). "時" . substr($result[3], 14, 2). "分"."</td>
                    <td>" . $stateNight. "</td>
                </tr>
            </tbody>
        </table>"
    ;



?>
