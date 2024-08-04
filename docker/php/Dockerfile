FROM php:7.4.9-fpm

#タイムゾーンの設定
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
  && echo "Asia/Tokyo" > /etc/timezone

COPY php.ini /usr/local/etc/php/

# 必要なパッケージのインストールとPHP拡張モジュールのインストール
RUN apt-get update && apt-get install -y \
  default-mysql-client \
  zlib1g-dev \
  libzip-dev \
  unzip \
  cron \
  supervisor \
  && docker-php-ext-install pdo_mysql zip

# PHP 設定ファイルをコピー
COPY php.ini /usr/local/etc/php/

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

# crontabを登録
RUN crontab /etc/cron.d/laravel-cron

# supervisordの設定ファイルをコピー
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# supervisordを起動
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]