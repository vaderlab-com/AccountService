#!/usr/bin/env bash

cd /source

ENV=$1

if [ ! "$1" ]; then
    ENV=dev
fi

yarn run encore $ENV