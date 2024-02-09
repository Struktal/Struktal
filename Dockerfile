FROM ubuntu:22.04

# Install dependencies
RUN apt update -y && apt upgrade -y
RUN apt install -y vim
RUN apt install -y git
RUN apt install -y curl

RUN apt install -y docker.io

RUN apt install -y nginx

ENV DEBIAN_FRONTEND noninteractive
ENV DEBCONF_NONINTERACTIVE_SEEN true

RUN apt install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php

RUN apt-get install -y php8.2-fpm
RUN apt install -y php8.2-mysql
RUN apt install -y php8.2-curl
RUN apt install -y php8.2-gd
RUN apt install -y php8.2-intl
RUN apt install -y php8.2-mbstring

RUN apt install -y composer

# Copy files to image
COPY . /app
COPY ./docker/nginx-config /etc/nginx
COPY ./docker/startup.sh /app
RUN chmod +x /app/startup.sh

RUN cd /app && composer install --no-dev --no-interaction

EXPOSE 80
ENTRYPOINT ["/app/startup.sh"]
