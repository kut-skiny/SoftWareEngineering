# SoftWareEngineering
安否確認システム  

# クローン方法など  
以下のサイトを参考にしてください。不安なら澤田まで。  
<https://seleck.cc/630>

# 注意点
作業は各ブランチで行い、masterブランチでは作業をしないでください。  
ブランチの作成方法を下に書いておきます。  
branchの作成  
`git branch [branch名]`  
branchの切り替え  
`git checkout [branch名]`  
branchのプッシュ  
`git push -u origin [branch名]`  
各ブランチの作業をmasterブランチに反映させたい場合はPull Requestをおこなってください.  

# masterブランチの変更を自分のブランチに反映させる
```
git checkout [自分のブランチ名]
git checkout master
git pull
git checkout [自分のブランチ名]
git merge maste
```

# ローカル環境のmysqlにデータベースの設定を反映させる
本システム用のデータベースを作成。データベース名は'mimic'とする。なお、予めmysqlは起動しておく。  
```
$ mysql -u root
mysql-> create database mimic;
mysql-> quit;
```
カレントディレクトリを'SoftWareEngineering/db'にし、sqlファイルを実行する。  
`$ mysql -u root mimic < mimic_db_create.sql`

# mysqlに初期データを流し込む
初期データを挿入する。ただし、元あるレコードはすべて削除される。なお、予めmysqlは起動しておく。  
カレントディレクトリを'SoftWareEngineering/db'にし、sqlファイルを実行する。 
`$ mysql -u root mimic < mimic_db_initialize.sql`

# mysqlのエンコード設定をutf-8にする
はじめに現在のmysqlのエンコード設定を確認する。なお、予めmysqlは起動しておく。 
```
$ mysql -u root
mysql-> status;
:
Server characterset:    latin1
Db     characterset:    latin1
Client characterset:    utf8
Conn.  characterset:    utf8
:
mysql-> quit;
```
上記4項目のcharactersetが'utf8'なら設定変更の必要なし。例の'latin1'ように異なる文字コードが設定されているなら、以下の設定を行う。

---------

mysqlの設定ファイル(Linuxなら/etc/my.cnf)に以下のように追記する。
```
[mysqld]
:
haracter-set-server=utf8

[client]
default-character-set=utf8
```
各セクションの末尾に設定行を追加する。すでに設定行が存在し、utf-8でない文字コードが設定されていれば、書き換える。セクションが存在しなければ、追記する。  
たとえば、mysqldセクションがServer characterset、Db charactersetを決定するセクションで、Server charactersetだけがutf-8でなかったならば、mysqldセクションに追記をするだけで終えてもよい。  
また、Client characterset、Conn. charactersetはclientセクションのエンコード設定を決定する。  

mysqlを再起動する。  
`$ sudo service mysqld restart`