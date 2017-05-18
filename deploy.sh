#!/usr/bin/env bash
bower i --allow-root
composer install
php yii asset/compress
php yii cache/flush-all