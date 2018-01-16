import socket
from datetime import datetime
from time import sleep
import subprocess
  # Import smtplib for the actual sending function
import smtplib

# Import the email modules we'll need
from email.mime.text import MIMEText
import MySQLdb

s = socket.socket()

port = 5000
s.bind(('192.168.24.20',port))

while True:
  print('listening')
  s.listen(1)
  c, addr = s.accept()
  print('receiving')
  data = c.recv(4096)
  print(data.decode(encoding='utf-8'))
  #phpをpythonから実行するときのやつ
  #chk = subprocess.run(('php','/Library/WebServer/Documents/test.php'))
  #DBから値を取得する処理、タプル形式で取得
  conn = MySQLdb.connect(user='root', passwd='tukasa96', host='localhost', db='mimic')
  cur = conn.cursor()   #コネクト開始
  cur.execute("select users.name,users.mail,contracts.partner from contracts join users on contracts.user_id=users.id where users.id = 10000001 ;")
  rows = cur.fetchall() #fetchallで上の文を実行とともに値をタプル形式で取得(たぶん)
  #ここから下はDBに開けた時刻とかをinsertするもの今は値を入れてあるが実際には変数で受け取る
  cid = 20000001
  date = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
  state = "opened"
  cur.execute("insert into histories(contract_id,acted_at,state) values (%s,%s,%s);", (cid, date, state))
  conn.commit() #commitで上のINSERT文を実際に実行
  for row in rows:
      i = 0
  conn.close()
  cur.close()


  # メールを送信する処理
  # me : 自分のGmail アドレス, you : 送信先のアドレス, passwd : Gmailパスワード
  me = "sawady102@gmail.com"
  passwd = "tukasa102"
  you = row[1]
  titletext = "安否確認システムミミックより 薬箱利用のお知らせ"
  body = row[0] + "様いつもお世話になっております。\n\n(" + date + ")頃\n" + row[2] + "様がお薬を飲まれました。"

  msg = MIMEText(body)
  msg['Subject'] = titletext
  msg['From'] = me
  msg['To'] = you

  # Send the message via our own SMTP server.
  ma = smtplib.SMTP('smtp.gmail.com',587)
  ma.ehlo()
  ma.starttls()
  ma.ehlo()
  ma.login(me, passwd)
  ma.send_message(msg)
  ma.close()
  #while True:
    #print('sending')
    #now = datetime.now().strftime("%Y/%m/%d %H:%M:%S")
    #try:
      #c.send(now)
    #except:
     # break
    #sleep(1)
  c.close()
s.close()

#今の所はクライアントからb''で送信してサーバで受信したのちデコードして表示ができてる
