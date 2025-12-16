<?php
require_once 'config.php';

$db = new Database();

$db->query("DELETE FROM user_information");
$db->query("DELETE FROM serial_number");

echo "DB RESET DONE";
