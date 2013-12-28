<?php
require_once('../library/inc/NiceDog.php');
require_once('../library/inc/redbean/rb.php');
require_once('../library/inc/FlashMessenger.php');

require_once('../library/inc/controller.php');
require_once('../library/controllers/index.php');
require_once('../library/controllers/debt.php');
require_once('../library/controllers/debts.php');
require_once('../library/controllers/own.php');

require_once('../library/routes.php');

require_once('../library/settings.php');

date_default_timezone_set('Europe/Berlin');

R::setup(
    "mysql:host={$db_settings['host']};dbname={$db_settings['dbname']}",
    $db_settings['username'],
    $db_settings['password']
);

session_start();
