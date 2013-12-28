# Skulder
Keep track of two persons' shared expenses.


# Installation

## Setup database
    CREATE TABLE `debt` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `sum` int(11) unsigned DEFAULT NULL,
      `date` date DEFAULT NULL,
      `deleted` tinyint(1) DEFAULT NULL,
      `share` double DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

## Create settings
Add the file `www/library/settings.php` with the following content and set settings accordingly. Remember, there can only be two users. Their names can be of any string though (including Swedish letters).

    <?php
    $settings = array(
        'db' => array(
            'host' => 'localhost',
            'dbname' => '',
            'username' => '',
            'password' => ''
        ),
        'users' => array(
            '',
            ''
        )
    );

## Setup vhost
Point your vhost to `www/public/index.php` and you're all set!


# Changelog

**0.1.0**

First version
