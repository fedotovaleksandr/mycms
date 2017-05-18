#!/usr/bin/env bash
docker-compose exec db mysql ifmo < /docker-entrypoint-initdb.d/ifmo.sql