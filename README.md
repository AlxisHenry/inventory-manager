# Inventory manager :office:

## Table of contents
1. [What is it ?](#what-is-it-)
2. [How to use it ?](#how-to-use-it-)
3. [Technologies](#technologies)
4. [Authors](#authors)

## What is it ?

This is my first web project. It's a simple inventory manager made for my first internship. It's a very simple interface to manage the inventory of a company. It's made with PHP, HTML, CSS and MySQL.

## How to use it ?

To use it you only need to clone and configure the database.

```bash
$ git clone https://github.com/AlxisHenry/inventory-manager.git
$ cd inventory-manager
```

Then you need to create the database by importing `inventory_manager.sql`.

```bash
$ mysql -u <user> -p
$ source inventory_manager.sql
```

Next you need to configure the database connection in `configuration\database-connexion.php`.

```php
$host = "localhost";
$dblogin = "<username>";
$dbpassword = "<password>";
```

Finally you can start the server.

```bash
$ php -S localhost:8000
```

## Technologies

![](https://img.shields.io/badge/php-%23121011.svg?style=for-the-badge&logo=php&color=20232a)
![](https://img.shields.io/badge/mysql-%23121011.svg?style=for-the-badge&logo=mysql&color=20232a)
![](https://img.shields.io/badge/javascript-%2523121011.svg?style=for-the-badge&logo=javascript&color=20232a)

## Authors

- [@AlxisHenry](https://github.com/AlxisHenry)
