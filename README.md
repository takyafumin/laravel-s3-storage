LaravelからS3ストレージ(minIO)を利用するサンプル
====================


<!-- @import "[TOC]" {cmd="toc" depthFrom=1 depthTo=6 orderedList=false} -->

<!-- code_chunk_output -->

- [環境](#環境)
- [使い方](#使い方)
- [機能](#機能)
  - [アプリケーション](#アプリケーション)
  - [開発ツール](#開発ツール)

<!-- /code_chunk_output -->

## 環境

- Laravel9
- php8.1
- MySQL8

## 使い方

```bash
# リポジトリをcloneしてフォルダに入る
cd laravel-s3-storage/application

# 設定ファイルコピー
cp .env.example .env

# composerライブラリインストール
docker run --rm --pull=always -v "$(pwd)":/opt -w /opt laravelsail/php81-composer:latest bash -c "composer install"
docker rmi laravelsail/php81-composer:latest

# コンテナbuild & 起動
./vendor/bin/sail build
./vendor/bin/sail up -d

# npmライブラリインストール
./vendor/bin/sail npm ci

# リソースビルド
./vendor/bin/sail npm run build

# ide-helperファイル作成
./vendor/bin/sail artisan ide-helper:generate

# DBマイグレーション
./vendor/bin/sail artisan migrate --seed
```

上記操作後、minIOの管理画面から以下のバケットを作成してください

- Bucket: testbucket
  - path: /upload

## 機能

### アプリケーション

|      機能      |            URL             |
| -------------- | -------------------------- |
| TOPページ      | http://localhost/          |
| ダッシュボード | http://localhost/dashboard |
| S3 HOME        | http://localhost/s3        |

* ログインアカウント
    - admin@example.com / password
### 開発ツール

|  機能   |          URL           |      認証情報       |
| ------- | ---------------------- | ------------------- |
| adminer | http://localhost:8080/ | mysql / lara / lara |
| mailhog | http://localhost:8025/ | -                   |
| minIO   | http://localhost:9001/ | admin / passowrd    |
