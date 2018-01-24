<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>履歴閲覧ページ</title>
<link rel="stylesheet" href="history.css" media="all" title="history" charset="utf-8" />
<script type="text/javascript" src="jquery-3.2.1.min.js"></script>
<script type="text/javascript">
//head内記載分
var myDate = new Date();
var myWeekTbl = new Array("日","月","火","水","木","金","土");
var myMonthTbl = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
if (((myYear%4)==0 && (myYear%100)!=0) || (myYear%400)==0){
    myMonthTbl[1] = 29;
}

var myYear = myDate.getFullYear(); //西暦
var myMonth = myDate.getMonth(); //月（0～11）
var myToday = myDate.getDate(); //何日
var myWeek = myDate.getDay(); //曜日（0～6）いらない行

myDate.setDate(1); //今月１日の情報を取得できる。ここでは曜日
var myWeek = myDate.getDay();//12月は０＝日曜日
var myTblLine = Math.ceil((myWeek+myMonthTbl[myMonth])/7);//0と31日を足すとカレンダーテーブルの総マス数これを7で割って切り上げると行数
var myTable = new Array(7*myTblLine);//マス目全ての配列を作る

for(i=0; i<7*myTblLine; i++){
    myTable[i]="-";    //適当に値を入れる
}
for(i=0; i<myMonthTbl[myMonth]; i++){
    myTable[myWeek+i] =i+1;    //適当な空欄に日にちを入れる
}


$(function(){
    $(top1).click(function() {
      window.location.href = './adminMyPage.html';
    });
$("#d9").css("marginLeft","-300px");
//右ボタン
    $("#d13").click(function(){
    if($("#d9").css("marginLeft")=="-1200px"){
    return;
    }else{
    $("#d13").hide();
    $("#d9").animate({marginLeft:parseInt($("#d9").css("marginLeft"))-300+"px"},"slow","swing",
    function(){
    $("#d13").show();
    });
    }
    });
//左ボタン
    $("#d12").click(function(){
    if($("#d9").css("marginLeft")=="0px"){
    return;
    }else{
    $("#d12").hide();
    $("#d9").animate({marginLeft:parseInt($("#d9").css("marginLeft"))+300+"px"},"slow","swing",
    function(){
    $("#d12").show();
    });
    }
    });
});
</script>
</head>


<body>
<h1><left = "top1">　　ミミック　　</left></h1>
<h1><center>履歴閲覧ページ</center></h1>

<center>
<script>
function abc(myTodayOffset){

var myDate = new Date();
var myWeekTbl = new Array("日","月","火","水","木","金","土");
var myMonthTbl = new Array(31,28,31,30,31,30,31,31,30,31,30,31);

var myMonth = myDate.getMonth();//月
var myToday = myDate.getDate();//何日（今日の日にち）
var myWeek = myDate.getDay();//曜日（0～

myDate.setDate(1); //今月１日の情報を取得できる。
myMonth = myMonth+myTodayOffset;//前月、翌月データ補正
myDate.setMonth(myMonth);
myYear = myDate.getFullYear();//年を再取得
myMonth = myDate.getMonth();//月を再取得
myWeek = myDate.getDay();//曜日を再取得
if (((myYear%4)==0 && (myYear%100)!=0) || (myYear%400)==0){
    myMonthTbl[1] = 29;
}

var myTable = new Array(7*6);//マス目全ての配列を作る

for(i=0; i<42; i++){
    myTable[i]="　";    //適当に値を入れる
}
for(i=0; i<myMonthTbl[myMonth]; i++){
    myTable[myWeek+i] =i+1;    //適当な空欄に日にちを入れる
}

document.write("<div class='d8'><table class='d1'>");

document.write("<tr class='d2'><td colspan='7'>"+myYear+"年"+(myMonth+1)+"月</td></tr>");
document.write("<tr class='d6'>");
for(i=0; i<7; i++){
if(i==0){
document.write("<td class='d3a'");
}else if(i==6){
document.write("<td class='d4a'");
}else{
document.write("<td");
}
document.write(">"+myWeekTbl[i]+"</td>");
}
document.write("</tr>");

for(i=0; i<6; i++){
    document.write("<tr>");
    for(j=0; j<7; j++){
        var myDat = myTable[j+(i*7)];//ポイント→日にちの計算方法。myTableの値を１つずつ取り出す。
if((myDat==myToday)&&(myTodayOffset==0)){ //今日
    document.write("<td class='d5'>");
}else if(j==0){ //日曜日
    document.write("<td class='d3'>");
}else if(j==6){ //土曜日
    document.write("<td class='d4'>");
}else if(myYear==2013){
    if((myMonth==11)&&(myDat==23)||(myMonth==10)&&(myDat==4)||(myMonth==10)&&(myDat==23)){ //12.23 天皇誕生日
    document.write("<td class='d3'>");
    }else{
    document.write("<td>");
    }
}else if((myMonth==0)&&(myDat==1)||//1.1.元旦
    (myMonth==0)&&(myDat==8)|| //1.8.成人の日
    (myMonth==1)&&(myDat==11)|| //2.11.建国記念の日
    (myMonth==1)&&(myDat==12)) {//2.12.建国記念の日振替
    document.write("<td class='d3'>");
    } else {
    document.write("<td>");
}
    document.write(myDat);
    document.write("</td>");
    }
    document.write("</tr>");
    }
document.write("</table></div>");

}


</script>

<div id="d11">
    <div id="d12"><img src="img/hidari.gif" alt="" /></div>
    <div id="d13"><img src="img/migi.gif" alt="" /></div>
    <div id="d10">
        <div id="d9" class="clearfix">
            <script>
            abc(-1);
            abc(0);
            abc(1);
            abc(2);
            abc(3);
            </script>
        </div>
    </div>
</div>


<div class='detail'> <!-- 履歴の詳細を表示 -->
    <table class='tab'>
        <thead>
            <tr>
                <th>○日のお薬服用の状況</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>朝 :</td>
                <td> ○ </td>
            </tr>
            <tr>
                <td>昼 :</td>
                <td> ○ </td>
            </tr>
            <tr>
                <td>夕方 :</td>
                <td> ○ </td>
            </tr>
            <tr>
                <td>夜 :</td>
                <td> ○ </td>
            </tr>
        </tbody>
    </table>
</div>


</center>

</body>
</html>
