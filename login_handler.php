<?php
require_once 'config.php';
require_once 'User.php';

echo '<pre>';

var_dump($_POST);

$user = new User();
$result = $user->login($_POST['username'], $_POST['password']);

var_dump($result);

exit;
