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
$dbname = 'soft';

$id = $_SESSION["id"];

#getConf.phpから受け取った薬箱の設定情報を変数に格納
$dbMorningEnabled = $_POST['morningEnabled'];
$morningHour = $_POST['morningHour'];
$morningMinute = $_POST['morningMinute'];

$dbNoonEnabled = $_POST['noonEnabled'];
$noonHour = $_POST['noonHour'];
$noonMinute = $_POST['noonMinute'];

$dbEveningEnabled = $_POST['eveningEnabled'];
$eveningHour = $_POST['eveningHour'];
$eveningMinute = $_POST['eveningMinute'];

$dbNightEnabled = $_POST['nightEnabled'];
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

#SQL文用に書式を整える
$dbMorning = $morningHour . ":" . $morningMinute . ":" . "0" ;
$dbNoon = $noonHour . ":" . $noonMinute . ":" ."0";
$dbEvening = $eveningHour . ":" . $eveningMinute. ":" . "0";
$dbNight = $nightHour .  ":" . $nightMinute . ":" ."0";
$dbMailBlankTime = $mailBlankTime . ":" . "0" . ":" . "0";
$dbLineBlankTime = $lineBlankTime . ":" . "0" . ":" . "0";

try{
    $dbh = new PDO($dsn,$username,$password);
    #ユーザIDと一致する契約IDを取得する
    $stmt = $dbh->prepare("select id from contracts where user_id = ? ");
    $stmt->bindValue(1, $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $contract_id = $result['id'];
    #薬箱の設定情報を更新する
    //タイムゾーンを設定
    date_default_timezone_set('Asia/Tokyo');
    $now = date('Y-m-d H:i:s');
    $stmt = $dbh->prepare("update configurations set morning_enabled = ?, morning_time = ?, noon_enabled = ?, noon_time = ?, evening_enabled = ?, evening_time = ?, night_enabled = ?, night_time = ?,
    mail = ?, mail_after_blank_time_enabled = ?, blank_time_for_mail = ?, mail_once_a_day_enabled = ?, line = ?, line_after_blank_time_enabled= ?, blank_time_for_line = ?, line_once_a_day_enabled = ?, updated_at = ? where contract_id = ?");
    $stmt->bindValue(1, $dbMorningEnabled);
    $stmt->bindValue(2, $dbMorning);
    $stmt->bindValue(3, $dbNoonEnabled);
    $stmt->bindValue(4, $dbNoon);
    $stmt->bindValue(5, $dbEveningEnabled);
    $stmt->bindValue(6, $dbEvening);
    $stmt->bindValue(7, $dbNightEnabled);
    $stmt->bindValue(8, $dbNight);
    $stmt->bindValue(9, $dbMail);
    $stmt->bindValue(10, $dbMailBlank);
    $stmt->bindValue(11, $dbMailBlankTime);
    $stmt->bindValue(12, $dbMailOnce);
    $stmt->bindValue(13, $dbLine);
    $stmt->bindValue(14, $dbLineBlank);
    $stmt->bindValue(15, $dbLineBlankTime);
    $stmt->bindValue(16, $dbLineOnce);
    $stmt->bindValue(17, $now);
    $stmt->bindValue(18, $contract_id);
    $stmt->execute();

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
<?php echo $contract_id; ?>
</body>
</html>
