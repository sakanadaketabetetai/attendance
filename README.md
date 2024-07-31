# Atte(勤怠管理システム)

## 概要

このプロジェクトは、従業員の出退勤を管理するためのシンプルで使いやすいアプリケーションです。従業員の打刻、休憩時間の管理、そして出勤データのフィルタリングを容易に行うことができます。

## 特徴

- リアルタイムでの打刻記録
- 休憩時間の追跡
- 日別の出勤データのフィルタリング
- ユーザーフレンドリーなインターフェース

## 環境構築

### Dockerビルド

1. ```bash 
   git clone git@github.com:sakanadaketabetetai/attendance.git
   ```
2. DockerDesktopアプリを立ち上げる
3. docker-compose up -d --build



### 前提条件

- PHP 7.4以上
- Composer
- MySQL

### インストール手順

1. リポジトリをクローンします:
    ```bash
    git clone git@github.com:sakanadaketabetetai/attendance.git
    ```
2. 依存関係をインストールします:
    ```bash
    composer install
    ```
3. 環境変数ファイルをコピーします:
    ```bash
    cp .env.example .env
    ```
4. アプリケーションキーを生成します:
    ```bash
    php artisan key:generate
    ```
5. データベースを設定し、マイグレーションを実行します:
    ```bash
    php artisan migrate
    ```

## 使い方

### 基本的な使い方

1. ログインしてダッシュボードにアクセスします。
2. 「出勤」をクリックして打刻を開始します。
3. 「退勤」をクリックして打刻を終了します。

### 詳細な使い方

- 各従業員の詳細な出勤情報を表示する
- 出勤データをCSV形式でエクスポートする

## 貢献

1. フォークします
2. フィーチャーブランチを作成します (`git checkout -b feature/your-feature`)
3. コミットします (`git commit -am 'Add some feature'`)
4. プッシュします (`git push origin feature/your-feature`)
5. プルリクエストを作成します

## ライセンス

このプロジェクトはMITライセンスの下でライセンスされています。詳細についてはLICENSEファイルを参照してください。
