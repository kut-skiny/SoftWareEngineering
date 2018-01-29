<?php

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../logout.php");
    exit;
}

require_once '../DBN.php';


#idあってるか確認する（修正）
$id = $_SESSION["id"];



    #薬箱の設定情報を取得する
    $db = $dbh->prepare("select configurations.morning_enabled, configurations.morning_time, configurations.noon_enabled, configurations.noon_time, configurations.evening_enabled, configurations.evening_time, configurations.night_enabled, configurations.night_time, configurations.mail,
    configurations.mail_after_blank_time_enabled, configurations.blank_time_for_mail, configurations.mail_once_a_day_enabled, configurations.line, configurations.line_after_blank_time_enabled, configurations.blank_time_for_line, configurations.line_once_a_day_enabled, configurations.created_at, configurations.updated_at
    from configurations, contracts where contracts.user_id = ? and configurations.contract_id = contracts.id");
    $db->bindValue(1, $id, PDO::PARAM_STR);
    $db->execute();
    $result = $db->fetch(PDO::FETCH_ASSOC);

    $dbMorningEnabled = $result['morning_enabled'];
    #アラーム時刻は 00:00:00 という形でDBに保存されている
    #substr()で時、分にあたる部分を抜き出す
    $dbMorningHour = substr($result['morning_time'], 0, 2);
    $dbMorningMinute = substr($result['morning_time'], 3, 4);

    $dbNoonEnabled = $result['noon_enabled'];
    $dbNoonHour = substr($result['noon_time'], 0, 2);
    $dbNoonMinute = substr($result['noon_time'], 3, 3);

    $dbEveningEnabled = $result['evening_enabled'];
    $dbEveningHour = substr($result['evening_time'], 0, 2);
    $dbEveningMinute = substr($result['evening_time'], 3, 3);

    $dbNightEnabled = $result['night_enabled'];
    $dbNightHour = substr($result['night_time'], 0, 2);
    $dbNightMinute = substr($result['night_time'], 3, 3);

    $dbMail = $result['mail'];
    $dbMailBlank = $result['mail_after_blank_time_enabled'];
    $dbMailBlankTime = $result['blank_time_for_mail'];
    $dbMailOnce = $result['mail_once_a_day_enabled'];

    $dbLine = $result['line'];
    $dbLineBlank = $result['line_after_blank_time_enabled'];
    $dbLineBlankTime = $result['blank_time_for_line'];
    $dbLineOnce = $result['line_once_a_day_enabled'];
    #dbCreate = $result['created_at'];
    $dbupdate = $result['updated_at'];
    $dbh = null;


?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="./jquery-3.2.1.min.js"></script>
    <META charset="UTF-8" name="viewport" content="width=device-width">
    <title>使用設定画面</title>

    <script type="text/javascript">
    $(function() {
        $(top1).click(function() {
          window.location.href = './userMyPage.php';
        });
    });
    </script>

</head>
<body>

    <h1 id = "top1"><left>　　ミミック　　</left></h1>
    <h1><center>使用設定</center></h1>
    <center>
    <form method = "post" action = "setConf.php">
        <!--朝のアラームを利用するかのチェックボックス
            if文でDBの設定情報(onまたはoff)を判定し、phpで出力する。htmlはその出力をプログラムコードとして認識する。-->
        <input type = "hidden" name = "morningEnabled" value = "off"  <?php if($dbMorningEnabled === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "morningEnabled" value = "on" <?php if($dbMorningEnabled === "on"){echo "checked";}; ?>>
        <!--朝のアラーム(hour)-->
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
        <!--朝のアラーム(minute)-->
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

        <input type = "hidden" name = "noonEnabled" value = "off"  <?php if($dbNoonEnabled === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "noonEnabled" value = "on" <?php if($dbNoonEnabled === "on"){echo "checked";}; ?>>
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

        <input type = "hidden" name = "eveningEnabled" value = "off"  <?php if($dbEveningEnabled === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "eveningEnabled" value = "on" <?php if($dbEveningEnabled === "on"){echo "checked";}; ?>>
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

        <input type = "hidden" name = "nightEnabled" value = "off"  <?php if($dbNightEnabled === "off"){echo "checked";}; ?>>
        <input type = "checkbox" name = "nightEnabled" value = "on" <?php if($dbNightEnabled === "on"){echo "checked";}; ?>>
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



        <br>
        <?php echo "前回更新日時：" . $dbupdate;?>
        <br>
        <input type = "submit" name = "send" value = "変更" >
    </form>
    <!--<a href="userMypage.php">戻る</a>-->
</center>

</body>
</html>
