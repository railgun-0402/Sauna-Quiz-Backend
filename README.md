# 共用アカウント

```
ssfamins@gmail.com
D$2qh#F+&!hR
```

# 環境構築

Gitクローン
```bash
git clone https://github.com/ys0827/sauna-quiz.git
```

プロジェクトディレクトリ直下で以下コマンドを実行して環境変数ファイルを作成
```
echo -e "MINIO_ROOT_USER=minioadmin\nMINIO_ROOT_PASSWORD=minioadmin" >> .env
```

Laravelインストール
```bash
make install
```

コンテナ起動
```bash
make up
```

JS,CSSコンパイル
```bash
docker-compose exec app bash
npm install && npm run dev
```

vueを編集都度コンパイルするコマンド
```bash
docker-compose exec app npm run watch-poll
```

既存テーブルのdropとテストデータシード
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

キャッシュ関連全クリア
```bash
docker-compose exec app php artisan optimize:clear
```

他ブランチをマージしたらcomposer updateとキャッシュクリアする
```bash
docker-compose exec app bash
COMPOSER_PROCESS_TIMEOUT=0 COMPOSER_MEMORY_LIMIT=-1 composer update
php artisan optimize:clear
```

単体テスト
```bash
docker-compose exec app ./vendor/phpunit/phpunit/phpunit ./tests/path/to/file
```

公開ページ：http://localhost

minio：http://localhost:9001/

---

# docker-laravel 🐳

<p align="center">
    <img src="https://user-images.githubusercontent.com/35098175/145682384-0f531ede-96e0-44c3-a35e-32494bd9af42.png" alt="docker-laravel">
</p>
<p align="center">
    <img src="https://github.com/ucan-lab/docker-laravel/actions/workflows/laravel-create-project.yml/badge.svg" alt="Test laravel-create-project.yml">
    <img src="https://github.com/ucan-lab/docker-laravel/actions/workflows/laravel-git-clone.yml/badge.svg" alt="Test laravel-git-clone.yml">
    <img src="https://img.shields.io/github/license/ucan-lab/docker-laravel" alt="License">
</p>

## Introduction

Build a simple laravel development environment with docker-compose. Compatible with Windows(WSL2), macOS(M1) and Linux.

## Usage

### Laravel install

1. Click [Use this template](https://github.com/ucan-lab/docker-laravel/generate)
2. Git clone & change directory
3. Execute the following command

```bash
$ mkdir -p src
$ docker compose build
$ docker compose up -d
$ docker compose exec app composer create-project --prefer-dist laravel/laravel:^8.0 .
$ docker compose exec app php artisan key:generate
$ docker compose exec app php artisan storage:link
$ docker compose exec app chmod -R 777 storage bootstrap/cache
$ docker compose exec app php artisan migrate
```

http://localhost

### Laravel setup

1. Git clone & change directory
2. Execute the following command

```bash
$ make install
```

http://localhost

## Tips

- Read this [Makefile](https://github.com/ucan-lab/docker-laravel/blob/main/Makefile).
- Read this [Wiki](https://github.com/ucan-lab/docker-laravel/wiki).

## Container structures

```bash
├── app
├── web
└── db
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):8.1-fpm-bullseye
  - [composer](https://hub.docker.com/_/composer):2.2

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.22

### db container

- Base image
  - [mysql/mysql-server](https://hub.docker.com/r/mysql/mysql-server):8.0

### mailhog container

- Base image
  - [mailhog/mailhog](https://hub.docker.com/r/mailhog/mailhog)
