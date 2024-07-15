FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

# RUN apt update \
#   && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
#   && docker-php-ext-install pdo_mysql zip

  # 必要なパッケージのインストールとPHP拡張モジュールのインストール
  RUN apt-get update && apt-get install -y \
  default-mysql-client \
  zlib1g-dev \
  libzip-dev \
  unzip \
  cron \
  && docker-php-ext-install pdo_mysql zip

  WORKDIR /var/www

  RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update
  # crontabファイルをコピー
  COPY crontab /etc/cron.d/laravel-cron

  # crontabファイルのパーミッションを設定
  RUN chmod 0644 /etc/cron.d/laravel-cron

  # cronログファイルを作成
  RUN touch /var/log/cron.log

  # cronを開始し、cronログを表示
  CMD ["sh", "-c", "php-fpm -y /usr/local/etc/php-fpm.conf && cron && tail -f /var/log/cron.log"]

