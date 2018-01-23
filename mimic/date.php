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
$id = $_SESSION["id"];
try{
    $dbh = new PDO($dsn,$username,$password);
    #ログイン時に入力したIDをもとに、契約IDを検索。その後、契約IDと一致する薬箱の開閉情報を全て取り出す。
    $db = $dbh->prepare("select histories.acted_at, histories.state from contracts, histories where contracts.user_id = :userid and histories.contract_id = contracts.id");
    $db->bindValue(':userid', $id);
    $db->execute();
    $result = $db->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        echo htmlspecialchars($row['acted_at'] . " ");
        echo htmlspecialchars($row['state']) . "<br>";
    }
    //print_r($result);


    $ten = 10;
    //今日の月日を取得
    //$month = date('m');
    //$day = date('d');

    //where句で使うsql文をメモ
    //state == 'opened'
    //cast(histories.acted_at as datetime) between '2009-':date'-04 00:00:00' and '2009-':date'-04 23:59:59'

    //今日の日付の情報のみ取り出す
    /*$db = $dbh->prepare("select histories.acted_at, histories.state from contracts, histories where contracts.user_id = :userid and histories.contract_id = contracts.id and cast(histories.acted_at as datetime) between '2009-':date'-04 00:00:00' and '2009-':date'-04 23:59:59'");
    $db->bindValue(':userid', $id);
    $db->bindValue(':date', $ten);
    $db->execute();
    $result = $db->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row) {
        echo htmlspecialchars(substr($row['acted_at'],5,6) . " ");
        echo htmlspecialchars($row['state']) . "<br>";
    }
    */
    date_default_timezone_set('Asia/Tokyo'); // タイムゾーンの指定
    $last_sunday = substr(date('Ymd', strtotime('last Sunday')), 6, 8); // 前の日曜日
    $next_monday = substr(date('Ymd', strtotime('next Monday')), 6, 8); // 次の月曜日
    $now = new DateTime();
    //$startWeek = strtotime('date('w',time())' day', time());

    echo $now->format('Y-m-d');
    $day = new DateTime();
    //$day->sub()
    //echo $day->format('Y-m-d', '-1 day');
    //sub() 日付の減算
    //DateInterval::createFromDateString() 引数だけ日付の間隔を指定
    //$now->sub(DateInterval::createFromDateString('1 month'));
    //echo $now->format('Y-m-d H:i:s');

    //$i = $last_sunday;

    //while($i <= $next_monday) {
    //    $date[$i] = "a";
    //}
}catch (PDOException $e) {
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
        echo htmlspecialchars(substr($row['acted_at'],5,6) . " ");
        echo htmlspecialchars($row['state']) . "<br>";
    }?>
    </p>
    <p><?php print_r($result); ?></p>
    <a href = 'user.php'>戻る</a>
</body>
</html>
