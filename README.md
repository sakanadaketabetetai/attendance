# Atte(勤怠管理システム)

## 概要

このプロジェクトは、従業員の出退勤を管理するためのシンプルで使いやすいアプリケーションです。従業員の打刻、休憩時間の管理、そして出勤データのフィルタリングを容易に行うことができます。

## 作成した目的
勤怠管理システムを作成した

## アプリケーションURL
- AtteのURL : http://57.180.64.63/
- MailCatcherのURL : http://57.180.64.63:1080

## GitHubのリポジトリ
- https://github.com/sakanadaketabetetai/attendance.git
　

## 機能一覧
- 会員登録機能 ( メール認証付 )
- ログイン機能
- 勤務及び休憩打刻機能
- 日付別勤怠情報取得
- ユーザー一覧 ( 勤務状況 )
- ユーザー別勤怠情報取得

## 使用技術 ( 実行環境 )
- Docker 26.1.4
- Laravel 8.x
- php 7.4.9-fpm
- mysql 8.0.26
- mailcatcher ( メール認証機能確認用 )

## 特徴
- リアルタイムでの打刻記録
- 休憩時間の追跡
- 日別の出勤データのフィルタリング
- ユーザーフレンドリーなインターフェース

## テーブル設計
![スクリーンショット_3-8-2024_191053_](https://github.com/user-attachments/assets/d9e379aa-1519-40ec-9827-9dad83b0172b)

## ER図
![er](https://github.com/user-attachments/assets/69e8d0a2-b269-45a4-93b0-349661ff5e3c)

## 環境構築

### Dockerビルド

1. ```bash 
   git clone git@github.com:sakanadaketabetetai/attendance.git
   ```
2. DockerDesktopアプリを立ち上げる
3. docker-compose up -d --build


### Laravel環境構築

1. PHPコンテナにアクセス:
    ```bash
    docker-compose exec php bash
    ```
2. 依存関係をインストールします:
    ```bash
    composer install
    ```
3. 環境変数ファイルをコピーします:
    ```bash
    cp .env.example .env
    ```
4. .envに以下の環境変数を追加
    Mysqlに関する設定
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass
    ```
    メールに関する設定
    ※下の変数設定はMailCatcherを使用する場合の設定であり、自身のメールアドレスを使用する場合は、必要に応じて設定値を変更する
    ```bash
    MAIL_MAILER=smtp
    MAIL_HOST=mailcatcher  //自身のメールサーバーを入力 
    MAIL_PORT=1025 //使用するポートを入力
    MAIL_USERNAME=null //自身のメールアドレス
    MAIL_PASSWORD=null //自身のメールサーバーにアクセスするパスワード
    MAIL_ENCRYPTION=null //ssl
    MAIL_FROM_ADDRESS=no-reply@example.com //自身のメールアドレス
    MAIL_FROM_NAME="${APP_NAME}"
    ```
    APP環境
    ```bash
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=　     //php artisan key:generate実行時に自動で生成される
    APP_DEBUG=true
    APP_URL=http://localhost //AWS ec2インスタンスにデプロイする場合、AWSパブリックIPv4アドレスを入力
    ```
    
5. アプリケーションキーを生成します:
    ```bash
    php artisan key:generate
    ```
6. マイグレーションを実行します:
    ```bash
    php artisan migrate
    ```


## 基本的な使い方


1. ログインしてダッシュボードにアクセスします。

2. 「勤務開始」をクリックして、勤務を開始します。

3. 「勤務終了」をクリックして、勤務を終了します。

4. 「休憩開始」をクリックして、休憩を開始します。

5. 「休憩終了」をクリックして、休憩を終了します。

6. 「日付一覧」をクリックすると、日付別の勤怠情報を閲覧できます。

7. 「ユーザー一覧」をクリックすると、ユーザー一覧ページに移動し、ユーザーごと
　　 の勤怠情報を閲覧できます。

8.  会員登録する場合は、「氏名」、「メールアドレス」、「パスワード」を入力し
　  入力したメールアドレスに確認メールが送信されます。

