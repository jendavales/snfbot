# SNFBOT

Basic application to test my "mini-framework"

## Requirements
- PHP 7.4
- MySQL

## Setup
I personally use xampp, but with enough patience any apache can be used

Database connection needs to be setup in *config/parameters.php*

After database is setup, run migrations

    php migrations.php all seed

- all runs through all table migrations
- seed puts fake data to each table

In xampp application is accessible from *localhost/snfbot/*

Seeded data contain account with credentials

    Login: jenda.vales@seznam.cz
    Password: asdasd
