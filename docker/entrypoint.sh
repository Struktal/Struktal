#!/bin/sh

env > /etc/environment

php-fpm83
nginx
crond

tail -f /dev/null
