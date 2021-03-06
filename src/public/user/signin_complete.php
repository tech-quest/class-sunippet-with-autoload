<?php
require_once __DIR__ . '/../../app/Lib/pdoInit.php';
require_once __DIR__ . '/../../app/Lib/findUserByMail.php';
require_once __DIR__ . '/../../app/Lib/redirect.php';
// require_once __DIR__ . '/../../app/Lib/Session.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Lib\Session;

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError('パスワードとメールアドレスを入力してください');
    redirect('./signin.php');
}

$users = findUserByMail($mail);

if (!password_verify($password, $users['password'])) {
    $session->appendError('メールアドレスまたは<br />パスワードが違います');
    redirect('./signin.php');
}

$formInputs = [
    'userId' => $users['id'],
    'userName' => $users['user_name'],
];
$session->setFormInputs($formInputs);
redirect('../index.php');
