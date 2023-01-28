#!/bin/bash

# color codes.
red_echo () { echo "$(tput setaf 9)$1"; }
die() { echo "$*" 1>&2 ; exit 1; }

# check if vendor installed
if [ ! -d "vendor/" ]
then
    red_echo "Build-error: vendor not found, please install composer"
    die
fi

clear
cd public/ 
sudo systemctl start mysql
sudo systemctl --no-pager status mysql
sudo php -S localhost:80