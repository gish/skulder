<?php
require_once('../library/inc/NiceDog.php');
require_once('../library/inc/redbean/rb.php');
require_once('../library/inc/FlashMessenger.php');

require_once('../library/settings.php');

require_once('../library/inc/controller.php');
require_once('../library/controllers/index.php');
require_once('../library/controllers/debt.php');
require_once('../library/controllers/debts.php');
require_once('../library/controllers/own.php');

require_once('../library/routes.php');

date_default_timezone_set('Europe/Berlin');

R::setup(
    "mysql:host={$settings['db']['host']};dbname={$settings['db']['dbname']}",
    $settings['db']['username'],
    $settings['db']['password']
);

session_start();
