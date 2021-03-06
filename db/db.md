# データベース

## データベース定義

データベース名は`mimic`とする。  
内部設計書にて取り決めた仕様とは一部異なる。NOT NULL制限の有無を変更したほか、configurationsテーブルにカラムを追加した。追加したカラムを以下に示す。

| Field                 | Type             | Null | Key | Default             | Extra |
|:----------------------|:-----------------|:-----|:----|:--------------------|:------|
| morning_enabled       | enum('on','off') | NO   |     | off                 |       |
| noon_enabled          | enum('on','off') | NO   |     | off                 |       |
| evening_enabled       | enum('on','off') | NO   |     | off                 |       |
| night_enabled         | enum('on','off') | NO   |     | off                 |       |

それぞれ、各時間帯にアラームを鳴らすかどうかのフラグである。当初、`***_time`が有値かNULLかでアラーム設定の有無を判別する予定だった記憶があるが、その仕様だと、一度アラーム設定をOFFにすると設定時間を保持できなくなり、システム的にもUI的にも都合が悪いので追加した。

### usersテーブル

| Field         | Type        | Null | Key | Default             | Extra |
|:--------------|:------------|:-----|-----|:--------------------|:------|
| id            | char(8)     | NO   | PRI | NULL                |       |
| name          | varchar(64) | YES  |     | NULL                |       |
| password      | varchar(16) | NO   |     | pass                |       |
| mail          | varchar(64) | NO   |     | example@mail.com    |       |
| phone_number  | varchar(16) | YES  |     | NULL                |       |
| address       | varchar(64) | YES  |     | NULL                |       |
| registered_at | timestamp   | NO   |     | 0000-00-00 00:00:00 |       |
| deleted_at    | timestamp   | NO   |     | 0000-00-00 00:00:00 |       |
| created_at    | timestamp   | NO   |     | CURRENT_TIMESTAMP   |       |
| updated_at    | timestamp   | NO   |     | 0000-00-00 00:00:00 |       |

### contractsテーブル

| Field      | Type             | Null | Key | Default             | Extra |
|:-----------|:-----------------|:-----|:----|:--------------------|:------|
| id         | char(8)          | NO   | PRI | NULL                |       |
| user_id    | char(8)          | NO   | MUL | NULL                |       |
| partner    | varchar(64)      | YES  |     | NULL                |       |
| ip_address | int(11) unsigned | YES  |     | 0                   |       |
| started_at | timestamp        | NO   |     | 0000-00-00 00:00:00 |       |
| closed_at  | timestamp        | NO   |     | 0000-00-00 00:00:00 |       |
| created_at | timestamp        | NO   |     | CURRENT_TIMESTAMP   |       |
| updated_at | timestamp        | NO   |     | 0000-00-00 00:00:00 |       |

### configurationsテーブル

| Field                 | Type             | Null | Key | Default             | Extra |
|:----------------------|:-----------------|:-----|:----|:--------------------|:------|
| id                    | char(8)          | NO   | PRI | NULL                |       |
| contract_id           | char(8)          | YES  | MUL | NULL                |       |
| morning_enabled       | enum('on','off') | NO   |     | off                 |       |
| morning_time          | time             | NO   |     | 08:00:00            |       |
| noon_enabled          | enum('on','off') | NO   |     | off                 |       |
| noon_time             | time             | NO   |     | 13:00:00            |       |
| evening_enabled       | enum('on','off') | NO   |     | off                 |       |
| evening_time          | time             | NO   |     | 19:00:00            |       |
| night_enabled         | enum('on','off') | NO   |     | off                 |       |
| night_time            | time             | NO   |     | 21:00:00            |       |
| mail                  | varchar(64)      | YES  |     | NULL                |       |
| mail_after_blank_time | enum('on','off') | NO   |     | off                 |       |
| blank_time_for_mail   | time             | NO   |     | 72:00:00            |       |
| mail_once_a_day       | enum('on','off') | NO   |     | off                 |       |
| line                  | varchar(64)      | YES  |     | NULL                |       |
| line_after_blank_time | enum('on','off') | NO   |     | off                 |       |
| blank_time_for_line   | time             | NO   |     | 72:00:00            |       |
| line_once_a_day       | enum('on','off') | NO   |     | off                 |       |
| created_at            | timestamp        | NO   |     | CURRENT_TIMESTAMP   |       |
| updated_at            | timestamp        | NO   |     | 0000-00-00 00:00:00 |       |

### historiesテーブル

| Field       | Type                                                | Null | Key | Default           | Extra |
|:------------|:----------------------------------------------------|:-----|:----|:------------------|:------|
| contract_id | char(8)                                             | NO   | MUL | NULL              |       |
| acted_at    | timestamp                                           | NO   |     | CURRENT_TIMESTAMP |       |
| state       | enum('opened','no_response','go_out','return_home') | NO   |     | opened            |       |

### administratorsテーブル

| Field      | Type        | Null | Key | Default             | Extra |
|:-----------|:------------|:-----|:----|:--------------------|:------|
| id         | char(8)     | NO   | PRI | NULL                |       |
| name       | varchar(64) | YES  |     | NULL                |       |
| password   | varchar(64) | NO   |     | pass                |       |
| created_at | timestamp   | NO   |     | CURRENT_TIMESTAMP   |       |
| updated_at | timestamp   | NO   |     | 0000-00-00 00:00:00 |       |


## ローカル環境のmysqlにmimicデータベースをビルドする
本システム用のデータベースを作成。データベース名は`mimic`とする。なお、予めmysqlは起動しておく。  
mysql起動
```
$ sudo /etc/init.d/mysqld start
```

#### 1. mimicデータベース作成を作成する。
```
$ mysql -u root
mysql> create database mimic;
mysql> quit;
```
#### 2. カレントディレクトリを'SoftWareEngineering/db'にする。
```
$ cd /SoftWareEngineering/db
```

#### 3. テーブル作成用のsqlファイルを実行する。
```
$ mysql -u root mimic < mimic_db_create.sql
```

#### 4. 初期データ挿入用のsqlファイルを実行する。
```
$ mysql -u root mimic < mimic_db_initialize.sql`
```

## mysqlのエンコード設定をutf-8にする
mysqlのデフォルトのエンコード設定がすべてutf-8ではないため、設定する。なお、予めmysqlは起動しておく。 

#### 1. 現在のmysqlのエンコード設定を確認する。
```
$ mysql -u root
mysql> status;
:
Server characterset:    latin1
Db     characterset:    latin1
Client characterset:    utf8
Conn.  characterset:    utf8
:
mysql> quit;
```
上記4項目の`characterset`が`utf8`なら設定変更の必要なし。例の`latin1`ように異なる文字コードが設定されているなら、以降の設定を行う。

#### 2. mysqlの設定ファイル(Linuxなら`/etc/my.cnf`)に以下のように追記する。
```
[mysqld]
:
character-set-server=utf8

[client]
default-character-set=utf8
```
各セクションの末尾に設定行を追加する。すでに設定行が存在し、`utf8`でない文字コードが設定されていれば、書き換える。セクションが存在しなければ、追記する。  

(注)たとえば、mysqldセクションが`Server characterset`と`DB characterset`を決定するセクションである。
`Server characterset`だけが`utf8`でなかったならば、`[mysqld]`セクションに追記をするだけで終えてもよい。  
また、`Client characterset`、`Conn. characterset`は`[client]`セクションのエンコード設定を決定する。  

#### 3. mysqlを再起動する。  
```
$ sudo /etc/init.d/mysqld restart
```

## timestamp型カラムへの'0000-00-00 00:00:00'のinsertを有効にする

MySQLのバージョンによっては、`SoftWareEngineering/db/mimic_db_initialize.sql`を実行する際、timestamp型カラムへの'0000-00-00 00:00:00'のinsertが原因で構文エラーが発生する。これを解消すべく、設定を変更する。なお、予めmysqlは起動しておく。  

#### 1. 現在の設定を確認する。
```
$ mysql -u root
mysql> SELECT @@GLOBAL.sql_mode;
+--------------------------------------------+
| @@GLOBAL.sql_mode                          |
+--------------------------------------------+
| STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION |
+--------------------------------------------+
1 row in set (0.00 sec)
```
`NO_ENGINE_SUBSTITUTION`とある部分に、`NO_ZERO_DATE`や`NO_ZERO_IN_DATE`が含まれていなければ設定変更の必要なし。含まれていれば、以降の設定を行う。

#### 2. `sql_mode`から`NO_ZERO_DATE`、`NO_ZERO_IN_DATE`を削除する。

###### 方法1. `SET`文で`sql_mode`の値を変更する。
```
mysql> SET GLOBAL sql_mode = 'STRICT_TRANS_TABLES, NO_ENGINE_SUBSTITUTION';
```
現在の設定から`NO_ZERO_DATE`、`NO_ZERO_IN_DATE`を除いたものを入力する。

###### 方法2. `/etc/my.cnf`を編集する。
`[mysqld]`セクションに以下の設定行を追記する。
```
[mysqld]
:
sql_mode=STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION
```
現在の設定から`NO_ZERO_DATE`、`NO_ZERO_IN_DATE`を除いたものを入力する。

#### 3. mysqlを再起動する。

```
$ sudo /etc/init.d/mysqld restart
```

## IPアドレスを格納するカラムのデータの扱い

contractテーブルのカラム`ip_address`には、32bitの符号なし整数型でIPアドレスが格納される。  
`'127.0.0.1'`のような、文字列型の　IPアドレスをこのカラムに格納するには、`INET＿ATON()`関数を用いる。この関数は、引数の文字列型のIPアドレスを10進数の整数にして返す。
```
mysql> SELECT inet_aton('127.0.0.1');
+------------------------+
| inet_aton('127.0.0.1') |
+------------------------+
|             2130706433 |
+------------------------+
```
逆に、整数のIPアドレスを区切り点を含む文字列で表示したい場合は、`INET_NTOA()`関数を用いる。
```
mysql> SELECT inet_ntoa(2130706433);
+-----------------------+
| inet_aton(2130706433) |
+-----------------------+
|             127.0.0.1 |
+-----------------------+
```