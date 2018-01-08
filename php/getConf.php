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
    #contract_idで条件検索する
    $db = $dbh->prepare("select * from configurations where id = ? ");
    $db->bindValue(1, $id, PDO::PARAM_STR);
    $db->execute();
    $result = $db->fetch(PDO::FETCH_ASSOC);
    #配列の中身表示
    #print_r($result);
    $dbMorningHour = (int)substr($result['morning_time'], 0, 2);
    $dbMorningMinute = (int)substr($result['morning_time'], 3, 3);
    $dbNoonHour = substr($result['noon_time'], 0, 2);
    $dbNoonMinute = substr($result['noon_time'], 3, 3);
    $dbEveningHour = substr($result['evening_time'], 0, 2);
    $dbEveningMinute = substr($result['evening_time'], 3, 3);
    $dbNightHour = substr($result['night_time'], 0, 2);
    $dbNightMinute = substr($result['night_time'], 3, 3);
    $dbMail = $result['mail'];
    $dbMailBlank = $result['mail_after_blank_time'];
    $dbMailBlankTime = $result['blank_time_for_mail'];
    $dbMailOnce = $result['mail_once_a_day'];
    $dbLine = $result['line'];
    $dbLineBlank = $result['line_after_blank_time'];
    $dbLineBlankTime = $result['blank_time_for_line'];
    $dbLineOnce = $result['line_once_a_day'];
    #dbCreate = $result['created_at'];
    #dbCreate = $result['updated_at'];
    $dbh = null;
} catch (PDOException $e) {
    exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>使用設定画面</title>
</head>
<body>
    <h1>使用設定</h1>
    <form method = "post" action = "setConf.php">
        朝:<select name = "morningHour">
            <option <?php if($dbMorningHour == 0) {echo 'selected';}?>>0</option>
            <option <?php if($dbMorningHour == 1) {echo 'selected';}?>>1</option>
            <option <?php if($dbMorningHour == 2) {echo 'selected';}?>>2</option>
            <option <?php if($dbMorningHour == 3) {echo 'selected';}?>>3</option>
            <option <?php if($dbMorningHour == 4) {echo 'selected';}?>>4</option>
            <option <?php if($dbMorningHour == 5) {echo 'selected';}?>>5</option>
            <option <?php if($dbMorningHour == 6) {echo 'selected';}?>>6</option>
            <option <?php if($dbMorningHour == 7) {echo 'selected';}?>>7</option>
            <option <?php if($dbMorningHour == 8) {echo 'selected';}?>>8</option>
        </select>
        時
        <select name = "morningMinute">
            <option value = "0" <?php if($dbMorningMinute == 0) {echo 'selected';}?>>0</option>
            <option value = "10" <?php if($dbMorningMinute == 10) {echo 'selected';}?>>10</option>
            <option value = "20" <?php if($dbMorningMinute == 20) {echo 'selected';}?>>20</option>
            <option value = "30" <?php if($dbMorningMinute == 30) {echo 'selected';}?>>30</option>
            <option value = "40" <?php if($dbMorningMinute == 40) {echo 'selected';}?>>40</option>
            <option value = "50" <?php if($dbMorningMinute == 50) {echo 'selected';}?>>50</option>
        </select>
        分
        <br>
        昼:<select name = "noonHour">
            <option <?php if($dbNoonHour == 9) {echo 'selected';}?>>9</option>
            <option <?php if($dbNoonHour == 10) {echo 'selected';}?>>10</option>
            <option <?php if($dbNoonHour == 11) {echo 'selected';}?>>11</option>
            <option <?php if($dbNoonHour == 12) {echo 'selected';}?>>12</option>
            <option <?php if($dbNoonHour == 13) {echo 'selected';}?>>13</option>
            <option <?php if($dbNoonHour == 14) {echo 'selected';}?>>14</option>
        </select>
        時
        <select name = "noonMinute">
            <option <?php if($dbNoonMinute == 0) {echo 'selected';}?>>0</option>
            <option <?php if($dbNoonMinute == 10) {echo 'selected';}?>>10</option>
            <option <?php if($dbNoonMinute == 20) {echo 'selected';}?>>20</option>
            <option <?php if($dbNoonMinute == 30) {echo 'selected';}?>>30</option>
            <option <?php if($dbNoonMinute == 40) {echo 'selected';}?>>40</option>
            <option <?php if($dbNoonMinute == 50) {echo 'selected';}?>>50</option>
        </select>
        分
        <br>
        夕:<select name = "eveningHour">
            <option <?php if($dbEveningHour == 15) {echo 'selected';}?>>15</option>
            <option <?php if($dbEveningHour == 16) {echo 'selected';}?>>16</option>
            <option <?php if($dbEveningHour == 17) {echo 'selected';}?>>17</option>
        </select>
        時
        <select name = "eveningMinute">
            <option <?php if($dbEveningMinute == 0) {echo 'selected';}?>>0</option>
            <option <?php if($dbEveningMinute == 10) {echo 'selected';}?>>10</option>
            <option <?php if($dbEveningMinute == 20) {echo 'selected';}?>>20</option>
            <option <?php if($dbEveningMinute == 30) {echo 'selected';}?>>30</option>
            <option <?php if($dbEveningMinute == 40) {echo 'selected';}?>>40</option>
            <option <?php if($dbEveningMinute == 50) {echo 'selected';}?>>50</option>
        </select>
        分
        <br>
        夜:<select name = "nightHour">
            <option <?php if($dbNightHour == 18) {echo 'selected';}?>>18</option>
            <option <?php if($dbNightHour == 19) {echo 'selected';}?>>19</option>
            <option <?php if($dbNightHour == 20) {echo 'selected';}?>>20</option>
            <option <?php if($dbNightHour == 21) {echo 'selected';}?>>21</option>
            <option <?php if($dbNightHour == 22) {echo 'selected';}?>>22</option>
            <option <?php if($dbNightHour == 23) {echo 'selected';}?>>23</option>
        </select>
        時
        <select name = "nightMinute">
            <option <?php if($dbNightMinute == 0) {echo 'selected';}?>>0</option>
            <option <?php if($dbNightMinute == 10) {echo 'selected';}?>>10</option>
            <option <?php if($dbNightMinute == 20) {echo 'selected';}?>>20</option>
            <option <?php if($dbNightMinute == 30) {echo 'selected';}?>>30</option>
            <option <?php if($dbNightMinute == 40) {echo 'selected';}?>>40</option>
            <option <?php if($dbNightMinute == 50) {echo 'selected';}?>>50</option>
        </select>
        分
        <br>
        <h3>メール通知</h3>
        on:off<input type = "text" name = "mailAlarm" value = "<?php echo $dbMailBlank . "テーブルのどれ"; ?>" >
        <br>

        <input type = "hidden" name = "mailOnce" value = "off"  <?php if($dbMailOnce === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "mailOnce" value = "on" <?php if($dbMailOnce === "on"){echo "checked";}; ?>>
        1日の開閉履歴(21時通知)
        <br>
        <input type = "hidden" name = "mailBlank" value = "off"  <?php if($dbMailBlank === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "mailBlank" value = "on" <?php if($dbMailBlank === "on"){echo "checked";}; ?>>
        前回の開閉から
        <select name = "mailBlankTime">
            <option <?php if($dbMailBlankTime == 10) {echo 'selected';}?>>10</option>
            <option <?php if($dbMailBlankTime == 11) {echo 'selected';}?>>11</option>
            <option <?php if($dbMailBlankTime == 12) {echo 'selected';}?>>12</option>
            <option <?php if($dbMailBlankTime == 13) {echo 'selected';}?>>13</option>
        </select>
        時間<br>
        メールアドレスアドレスの変更<br>
        <input type = "text" name = "mail" value = "<?php echo $result['mail']; ?>" >
        <br>

        <h3>LINE通知</h3>
        on:off<input type = "text" name = "lineAlarm" value = "<?php echo $dbLineBlank . "テーブルのどれ"; ?>" >
        <br>

        <input type = "hidden" name = "lineOnce" value = "off"  <?php if($dbLineOnce === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "lineOnce" value = "on" <?php if($dbLineOnce === "on"){echo "checked";}; ?>>
        1日の開閉履歴(21時通知)
        <br>
        <input type = "hidden" name = "lineBlank" value = "off"  <?php if($dbLineBlank === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "lineBlank" value = "on" <?php if($dbLineBlank === "on"){echo "checked";}; ?>>
        前回の開閉から
        <select name = "lineBlankTime">
            <option <?php if($dbLineBlankTime == 10) {echo 'selected';}?>>10</option>
            <option <?php if($dbLineBlankTime == 11) {echo 'selected';}?>>11</option>
            <option <?php if($dbLineBlankTime == 12) {echo 'selected';}?>>12</option>
            <option <?php if($dbLineBlankTime == 13) {echo 'selected';}?>>13</option>
        </select>
        時間<br>
        LINE IDの変更<br>
        <input type = "text" name = "line" value = "<?php echo $result['line']; ?>" >
        <br>
        <input type = "submit" name = "send" value = "設定を変更する" >
    </form>
    <a href="user.php">戻る</a>
</body>
</html>
