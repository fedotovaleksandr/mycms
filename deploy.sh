#!/usr/bin/env bash
php yii cache/flush-all
bower i
composer install
php yii asset/compress
php yii cache/flush-all