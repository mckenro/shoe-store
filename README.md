# _Shoe Store - Week 4 Epicodus Individual Project_

#### _Starting template for php projects, March, 2017_

#### By _**Rob McKenzie**_

## Description

_Starting files and directory structure for php projects. See the composer.json file for project dependencies._

## Setup/Installation Requirements

* _Download or clone project files_
* _Run Composer Install or Composer Update in terminal_
* _Update Class names and Test names as appropriate_

## Specs (include project specs below)
* _User can create "brands" that are assigned to a shoe "store"._
* _User can view a store to see all the "brands" that the "store" carries._
* _User can view a specific "brand" and see all the "stores" that carry that "brand"._
* _User can create, read, update, and delete "brands" and "stores" including the ability to perform these operations on all and singular "stores" and "brands"_

## SQL Commands for the databases
* _CREATE DATABASE shoes;_
* _USE shoes;_
* _CREATE TABLE stores (id serial PRIMARY KEY, store_name VARCHAR (255));_
* _CREATE TABLE brands (id serial PRIMARY KEY, brand_name VARCHAR (255));_
* _CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id INT, store_id INT);_
* _Use phpmyadmin to create a copy called shoes_test_

## Known Bugs

_No known bugs,_

## Support and contact details

_If you run into any issues or have questions, ideas or concerns, please contact Rob at mckenro@gmail.com_

## Technologies Used
* _Bootstrap 3.3.7_
* _JQuery 3.2.0_
* _Silex 1.1_
* _Twig 1.0_
* _PHPUnit 4.5.*_

### License

*This project is licensed under the MIT license*

Copyright (c) 2017 **_Rob McKenzie_**
