<?php
require 'vendor/autoload.php';
require 'system/bootstrap.php';
$db = \Config\Database::connect();
print_r($db->getFieldNames('commission_reports'));
unlink(__FILE__);
