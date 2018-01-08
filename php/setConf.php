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

$morningHour = $_POST['morningHour'];
$morningMinute = $_POST['morningMinute'];
$noonHour = $_POST['noonHour'];
$noonMinute = $_POST['noonMinute'];
$eveningHour = $_POST['eveningHour'];
$eveningMinute = $_POST['eveningMinute'];
$nightHour = $_POST['nightHour'];
$nightMinute = $_POST['nightMinute'];
$dbMail = $_POST['mail'];
$dbMailBlank = $_POST['mailBlank'];
$mailBlankTime = $_POST['mailBlankTime'];
$dbMailOnce = $_POST['mailOnce'];
$dbLine = $_POST['line'];
$dbLineBlank = $_POST['lineBlank'];
$lineBlankTime = $_POST['lineBlankTime'];
$dbLineOnce = $_POST['lineOnce'];
$dbMorning = $morningHour . ":" . $morningMinute . ":" . "0" ;
$dbNoon = $noonHour . ":" . $noonMinute . ":" ."0";
$dbEvening = $eveningHour . ":" . $eveningMinute. ":" . "0";
$dbNight = $nightHour .  ":" . $nightMinute . ":" ."0";
$dbMailBlankTime = $mailBlankTime . ":" . "0" . ":" . "0";
$dbLineBlankTime = $lineBlankTime . ":" . "0" . ":" . "0";

try{
    $dbh = new PDO($dsn,$username,$password);
    $stmt = $dbh->prepare("select * from configurations where id = ? ");
    $stmt->bindValue(1, $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $contract_id = $result['contract_id'];
    echo $dbMorning;
    echo "<br>";
    echo $dbNoon;
    echo "<br>";
    echo $dbEvening;
    echo "<br>";
    echo $dbNight;
    echo "<br>";
    echo $dbMail;
    echo "<br>";
    echo $dbMailBlank;
    echo "<br>";
    echo $dbMailBlankTime;
    echo "<br>";
    echo $dbMailOnce;
    echo "<br>";
    echo $dbLine;
    echo "<br>";
    echo $dbLineBlank;
    echo "<br>";
    echo $dbLineBlankTime;
    echo "<br>";
    echo $dbLineOnce;
    $stmt = $dbh->prepare("update configurations set morning_time = ?, noon_time = ?, evening_time = ?, night_time = ?, mail = ?, mail_after_blank_time = ?, blank_time_for_mail = ?, mail_once_a_day = ?, line = ?, line_after_blank_time = ?, blank_time_for_line = ?, line_once_a_day = ? where id = ?");
    $stmt->bindValue(1, $dbMorning);
    $stmt->bindValue(2, $dbNoon);
    $stmt->bindValue(3, $dbEvening);
    $stmt->bindValue(4, $dbNight);
    $stmt->bindValue(5, $dbMail);
    $stmt->bindValue(6, $dbMailBlank);
    $stmt->bindValue(7, $dbMailBlankTime);
    $stmt->bindValue(8, $dbMailOnce);
    $stmt->bindValue(9, $dbLine);
    $stmt->bindValue(10, $dbLineBlank);
    $stmt->bindValue(11, $dbLineBlankTime);
    $stmt->bindValue(12, $dbLineOnce);
    $stmt->bindValue(13, $id);
    $stmt->execute();
    #dbCreate = $result['created_at'];
    #dbUpdate = $result['updated_at'];
    $dbh = null;
   } catch (PDOException $e) {
       exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
   }
   header("Location: getConf.php");
   exit;
?>

<!DOCTTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>

</body>
</html>
