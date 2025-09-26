#!/bin/bash

##
# Application path.
##
pwd_path=$(pwd)

##
# Install application.
##
cp $pwd_path/.env.example $pwd_path/.env
/usr/local/bin/composer update

##
# Install hosting directory structure.
##
$pwd_path/appcli cli:install
  
##
# Generate application key
##
php artisan key:generate

##
# Set database connection to database
##
touch $pwd_path/../hosting/config/database.sqlite
echo "DB_CONNECTION=sqlite" >> $pwd_path/.env
echo "DB_DATABASE=$pwd_path/../hosting/config/database.sqlite" >> $pwd_path/.env

##
#  artisan table creation 
##
php artisan session:table
php artisan migrate

##
#  Set up default site
##
php artisan cli:site:creation "examples.com"
php artisan cli:site:config "examples.com" 