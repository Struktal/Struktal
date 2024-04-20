FROM ubuntu:22.04

# Install util packages
RUN apt update -y && apt upgrade -y
RUN apt install -y vim
RUN apt install -y git
RUN apt install -y curl

RUN apt install -y docker.io

# Install nginx webserver
RUN apt install -y nginx

ENV DEBIAN_FRONTEND noninteractive
ENV DEBCONF_NONINTERACTIVE_SEEN true

# Prepare PHP installation
RUN apt install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php

# Install PHP FPM and extensions
RUN apt-get install -y php8.2-fpm
RUN apt install -y php8.2-mysql
RUN apt install -y php8.2-curl
RUN apt install -y php8.2-gd
RUN apt install -y php8.2-intl
RUN apt install -y php8.2-mbstring

# Install dependency manager
RUN apt install -y composer

# Install cron
RUN apt install -y cron

# Copy application files
COPY . /app
RUN chown -R www-data:www-data /app

# Copy nginx configuration files
COPY ./docker/nginx-config /etc/nginx

# Setup cronjobs
RUN crontab -u www-data /app/project/cronjobs/.crontab

# Copy entrypoint script
COPY ./docker/entrypoint.sh /app
RUN chmod +x /app/entrypoint.sh

# Install dependencies
RUN cd /app && composer install --no-dev --no-interaction

EXPOSE 80
ENTRYPOINT ["/app/entrypoint.sh"]
